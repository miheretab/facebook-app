<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'facebook_id', 'access_token',
    ];

    /**
     * This is to create new user row or update it if related facebook id is not active
     */
    public function addNew($input)
    {
        $check = static::where('facebook_id',$input['facebook_id'])->first();


        if(is_null($check)){
            return static::create($input);
        } else if(!$check->is_active) {
            //update user if not active before
            if(!empty($input)) {
                $check->name = $input['name'];
                $check->email = $input['email'];
                $check->access_token = $input['access_token'];
            }
            $check->is_active = true;
            $check->save();
        }


        return $check;
    }

    /**
     * This is to de active user with @facebookId
     */
    public function deActive($facebookId) {
        $userInstance = static::where('facebook_id',$facebookId)->first();
        $userInstance->is_active = false;
        $userInstance->save();
    }

    /**
     * This is to custom attribute for picture_url
     */
    public function getPictureUrlAttribute($value) {
        return 'https://graph.facebook.com/v3.0/'.$this->facebook_id.'/picture?type=normal';
    }

}
