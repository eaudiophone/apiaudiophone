<?php

namespace App\Apiaudiophonemodels;

use Illuminate\Database\Eloquent\Model;
use App\Apiaudiophonemodels\ApiAudiophoneUser;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiAudiophoneTerm extends Model
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


    protected $table = 'apiaudiophoneterms';

    protected $primaryKey = 'apiaudiophoneterms_id';


	/**
     * The attributes that are mass assignable.
	 *
	 * @var array
	 */
    protected $fillable = [

        'apiaudiophoneterms_quantityeventsweekly',
        'apiaudiophoneterms_quantityeventsmonthly',
        'apiaudiophoneterms_rankevents',
        'apiaudiophoneterms_daysevents',
        'apiaudiophoneterms_begintime',
        'apiaudiophoneterms_finaltime'
    ];


    public function apiaudiophoneuser()
    {

    	return $this->belongsTo(ApiAudiophoneUser::class, 'apiaudiophoneusers_id');
    }


}
