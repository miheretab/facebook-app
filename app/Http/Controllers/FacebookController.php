<?php


namespace App\Http\Controllers\Auth;


use App\User;
use App\Http\Controllers\Controller;
use Socialite;
use Exception;
use Auth;
use Illuminate\Http\Request;


class FacebookController extends Controller
{


    public function redirectToFacebook() {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback() {
        try {
            $user = Socialite::driver('facebook')->user();
            $create['name'] = $user->getName();
            $create['facebook_id'] = $user->getId();

            var_dump($user);var_dump($create);exit;


        } catch (Exception $e) {

            return redirect('auth/facebook');

        }
    }

    public function handleFacebookDeauthCallback(Request $request) {
        var_dump($request);
    }
}