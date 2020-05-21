<?php

namespace App\Apiaudiophonemodels;

use Illuminate\Auth\Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Support\Facades\Hash;

class ApiAudiophoneUser extends Model implements AuthenticatableContract, AuthorizableContract
{
    use HasApiTokens, Authenticatable, Authorizable, SoftDeletes;

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

    /**
     * Funcion para validar  que el username corresponda al campo apioaudiophoneusers_email
     * para el request del token.
     *
     * @param  string  $username
     * @return App\Apiaudiophonemodels
     */
    public function findForPassport($username)
    {

        return $this->where('apiaudiophoneusers_email', $username)->first();
    }

     /**
     * Funcion para validar que el hash del password que le pasamos por el request sea el mismo
     * que está almacenado en la base de datos.
     *
     * @param  string  $password
     * @return bool
     */
    public function validateForPassportPasswordGrant($password)
    {

        return Hash::check($password, $this->apiaudiophoneusers_password);
    }
}