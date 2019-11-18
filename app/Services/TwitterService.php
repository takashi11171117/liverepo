<?php

namespace App\Services;

use App\Models\SocialAccount;
use App\Models\User;
use Abraham\TwitterOAuth\TwitterOAuth;
use App\Repositories\Contracts\SocialAccountRepository;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;
use App\Exceptions\EmailAlreadyExistsException;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\One\User as SocialiteOneUser;
use JWTAuth;

class TwitterService{
    /**
     * @return string
     */
    public function getRedirectToTwitterUrl(): string
    {
        $redirectResponse = Socialite::driver('twitter')->redirect();
        return $redirectResponse->getTargetUrl();
    }

    /**
     * @return JsonResponse
     */
    public function handleTwitterCallback(): JsonResponse
    {
        try {
            return response()->json($this->getCredentialsByTwitter());
        } catch (InvalidArgumentException $e) {
            return $this->errorJsonResponse('Twitterでの認証に失敗しました。');
        } catch (EmailAlreadyExistsException $e) {
            return $this->errorJsonResponse(
                "{$e->getEmail()} は既に使用されているEメールアドレスです。"
            );
        }
    }

    /**
     * @return array
     * @throws EmailAlreadyExistsException
     */
    protected function getCredentialsByTwitter(): array
    {
        $twitterUser = Socialite::driver('twitter')->user();
        $socialAccount = SocialAccount::firstOrNew([
            'provider'   => 'twitter',
            'account_id' => $twitterUser->getId(),
            'access_token' => $twitterUser->token,
            'access_token_secret' => $twitterUser->tokenSecret,
        ]);
        $user = $this->resolveUser($socialAccount, $twitterUser);

        $apiAccessToken = JWTAuth::fromUser($user);
        return [
            'token' => $apiAccessToken,
            'user' => $user,
        ];
    }

    /**
     * @param SocialAccount $socialAccount
     * @param SocialiteOneUser $twitterUser
     * @return User
     * @throws EmailAlreadyExistsException
     */
    protected function resolveUser(SocialAccount $socialAccount, SocialiteOneUser $twitterUser): User
    {
        if ($socialAccount->exists) {
            return User::find($socialAccount->getAttribute('user_id'));
        }
        if (User::where('email', $twitterUser->getEmail())->exists()) {
            throw new EmailAlreadyExistsException($twitterUser->getEmail());
        }
        $createdUser = User::create([
            'name'         => $twitterUser->getName(),
            'email'        => $twitterUser->getEmail(),
            'password'     => null,
        ]);
        $socialAccount->setAttribute('user_id', $createdUser->id);
        $socialAccount->save();
        return $createdUser;
    }

    /**
     * @param  string  $message
     * @return JsonResponse
     */
    protected function errorJsonResponse(string $message): JsonResponse
    {
        return response()->json(compact('message'), 400);
    }

    public function tweet()
    {
        $user = \Auth::user();
        $socialAccountRepository = app(SocialAccountRepository::class);
        $socialAccount = $socialAccountRepository->findWhereFirst('user_id', $user->id);

        $twitter_user = new TwitterOAuth(
            config('services.twitter.client_id'),
            config('services.twitter.client_secret'),
            $socialAccount->access_token,
            $socialAccount->access_token_secret
        );

        $twitter_user->post("statuses/update", [
            "status" => 'laravelからtwitter_apiでツイート'
        ]);
    }
}