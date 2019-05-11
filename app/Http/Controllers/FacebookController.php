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
            $create['email'] = $user->getEmail();
            $create['facebook_id'] = $user->getId();
			var_dump($user);exit;
            $create['access_token'] = $user->getToken();

            $userModel = new User;
            $createdUser = $userModel->addNew($create);
            Auth::loginUsingId($createdUser->id);

            return redirect()->route('home');


        } catch (Exception $e) {

            return redirect('auth/facebook');

        }
    }

    public function handleFacebookDeauthCallback() {
        try {
            $user = Socialite::driver('facebook')->user();
            $facebookId = $user->getId();
            $userModel = new User;
            $createdUser = $userModel->deActive($facebookId);

        } catch (Exception $e) {

            return redirect('auth/facebook');

        }
    }
}