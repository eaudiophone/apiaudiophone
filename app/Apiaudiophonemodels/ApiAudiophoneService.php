<?php

namespace App\Apiaudiophonemodels;

use Illuminate\Database\Eloquent\Model;
use App\Apiaudiophonemodels\ApiAudiophoneUser;
use App\Apiaudiophonemodels\ApiAudiophoneTerm;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiAudiophoneService extends Model
{
    
    use SoftDeletes;

   /**
    * The attributes should be mutatedto dates
    *
    * @var array
    */
    protected $dates = [
        'deleted_at'
    ];


    protected $table = 'apiaudiophoneservices';

    protected $primaryKey = 'apiaudiophoneservices_id';


	/**
     * The attributes that are mass assignable.
	 *
	 * @var array
	 */
    protected $fillable = [

        'apiaudiophoneservices_name',
        'apiaudiophoneservices_description',
    ];


    //::::: UN SERVICIO TIENE VARIOS TERMINOS ::::://

    public function apiaudiophoneterm()
    {

    	return $this->hasMany(ApiAudiophoneTerm::class, 'id_apiaudiophoneservices', 'apiaudiophoneservices_id');
    }
}