<?php

namespace App\Http\Controllers\Oauth;

use App\Http\Controllers\Controller;
use App\Services\TwitterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TwitterController extends Controller {
    /**
     * @var TwitterService
     */
    protected $twitterService;
    /**
     * @param  TwitterService  $socialiteHandler
     * @return void
     */
    public function __construct(TwitterService $twitterService)
    {
        $this->middleware('session');
        $this->twitterService = $twitterService;
    }
    /**
     * @return JsonResponse
     */
    public function redirect(): JsonResponse
    {
        return response()->json([
            'redirect_url' => $this->twitterService->getRedirectToTwitterUrl(),
        ]);
    }
    /**
     * @return JsonResponse
     */
    public function callback(): JsonResponse
    {
        return $this->twitterService->handleTwitterCallback();
    }
}
