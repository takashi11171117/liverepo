<?php

namespace App\Http\Controllers\Oauth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class TwitterController extends Controller {
    public function redirect() {
        $url = Socialite::driver('twitter')->redirect()->getTargetUrl();

        return response()->json(['redirect_url' => $url]);
    }
}
