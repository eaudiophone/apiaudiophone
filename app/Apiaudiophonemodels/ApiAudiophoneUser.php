<?php

namespace App\Apiaudiophonemodels;

//use Illuminate\Auth\Authenticatable;
//use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
//use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use Laravel\Lumen\Auth\Authorizable;

class ApiAudiophoneUser extends Model //implements AuthenticatableContract, AuthorizableContract
{
    //use Authenticatable, Authorizable;
    use SoftDeletes;

    /**
    * The attributes should be mutatedto dates
    *
    *@var array
    */
    protected $dates = [
        'deleted_at'
    ];

    protected $table = 'apiaudiophoneusers';

    protected $primaryKey = 'apiaudiophoneusers_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'apiaudiophoneusers_fullname',
        'apiaudiophoneusers_email',
        'apiaudiophoneusers_password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'apiaudiophoneusers_password'
    ];

    /*Relationships

    public function apiaudiophonemeeting(){

        return $this->hasMany(ApiAudiophoneMeeting::class);
    }

    public function apiaudiophonebudget(){

        return $this->hasMany(ApiAudiophoneBudget::class);
    }*/
}