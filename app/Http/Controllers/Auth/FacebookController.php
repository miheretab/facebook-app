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
            $create['access_token'] = $user->token;

            $userModel = new User;
            $createdUser = $userModel->addNew($create);
            Auth::loginUsingId($createdUser->id);

            return redirect()->route('home');


        } catch (Exception $e) {

            return redirect('auth/facebook');

        }
    }

    public function handleFacebookDeauthCallback(Request $request) {
        $signed_request = $request->input('signed_request');
        list($encodedSig, $payload) = explode('.', $signed_request, 2);

        $sig = base64_decode($encodedSig);
        $data = json_decode(base64_decode($payload), true);
        $facebookId = $data['user_id'];

        $userModel = new User;
        $createdUser = $userModel->deActive($facebookId);
    }
}