<?php

namespace App\Http\Controllers\Apiaudiophonecontrollers;

use App\Apiaudiophonemodels\ApiAudiophoneUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;


class ApiAudiophoneUserController extends Controller
{
    /**
     * new store ApiAudiophoneUser instance.
     *
     * @param \Illuminate\Http\Request $request
     *@return \Illuminate\Http\Response
     */
    public function storeApiAudiophoneUser(Request $request)
    {

    	dd($request->all());

    	//$apiaudiophoneuserdata = $request->all();

    	//$fecha = Carbon::now('America/Caracas')->format('Y-m-d H:i:s');

    	//$apiaudiophoneusernew = ApiAudiophoneUser::create(['apiaudiophoneusernew' => $apiaudiophoneuserdata]);

    	//$apiaudiophoneusernew = new ApiAudiophoneUser;

    	//$apiaudiophoneusernew->apiaudiophoneusers_fullname = $apiaudiophoneuserdata['apiaudiophoneusers_fullname'];
      //  $apiaudiophoneusernew->apiaudiophoneusers_email = $apiaudiophoneuserdata['apiaudiophoneusers_email'];
       // $apiaudiophoneusernew->apiaudiophoneusers_password = $apiaudiophoneuserdata['apiaudiophoneusers_password'];
        //$apiaudiophoneuser->apiaudiophoneusers_role = 'USER_ROLE';
        //$audiophoneuser->created_at = $fecha;

        //app('hash')->make('123')

       // $apiaudiophoneusernew->save();


    	/*return response()->json([

    		'ok' => true,
    		'status' => 201,
    		'apiaudiophoneusernew' => $apiaudiophoneusernew
    	]);*/
    }
}