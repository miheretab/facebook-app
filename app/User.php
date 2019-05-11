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

    public function addNew($input)
    {
        $check = static::where('facebook_id',$input['facebook_id'])->first();


        if(is_null($check)){
            return static::create($input);
        } else {
            $check->is_active = true;
            $check->save();
        }


        return $check;
    }

    public function deActive($facebookId) {
        $userInstance = static::where('facebook_id',$facebookId)->first();
        $userInstance->is_active = false;
        $userInstance->save();
    }

    public function getPictureUrlAttribute($value) {
        return 'https://graph.facebook.com/v3.0/'.$this->facebook_id.'/picture?type=normal';
    }

}
