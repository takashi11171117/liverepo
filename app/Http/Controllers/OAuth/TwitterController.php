<?php

namespace App\Http\Controllers\Oauth;

use App\Http\Controllers\Controller;
use App\Services\SocialiteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TwitterController extends Controller {
    /**
     * @var SocialiteService
     */
    protected $socialiteService;
    /**
     * @param  SocialiteService  $socialiteHandler
     * @return void
     */
    public function __construct(SocialiteService $socialiteService)
    {
        $this->middleware('session');
        $this->socialiteService = $socialiteService;
    }
    /**
     * @return JsonResponse
     */
    public function redirect(): JsonResponse
    {
        return response()->json([
            'redirect_url' => $this->socialiteService->getRedirectToTwitterUrl(),
        ]);
    }
    /**
     * @return JsonResponse
     */
    public function callback(): JsonResponse
    {
        return $this->socialiteService->handleTwitterCallback();
    }
}
