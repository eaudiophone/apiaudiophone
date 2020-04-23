<?php

namespace App\Http\Controllers\Apiaudiophonecontrollers;

use App\Apiaudiophonemodels\ApiAudiophoneUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;


class ApiAudiophoneUserController extends Controller
{

	/**
     * 5 y 11 para el programay opcion 14
     *  show ApiAudiophoneUser instance.
     *
     * @param \Illuminate\Http\Request $request
     *@return \Illuminate\Http\Response
     */
    public function showApiAudiophoneUser()
    {

    	$apiaudiophoneusershow = ApiAudiophoneUser::orderBY('apiaudiophoneusers_id', 'DESC')
    	->where('apiaudiophoneusers_status', '1')
    	->get();

    	return response()->json([

    		'ok' => true,
    		'status' => 200,
    		'apiaudiophoneusershow' => $apiaudiophoneusershow
    	]);
    }

    /**
      5 y 11 para el programay opcion 14
     * new store ApiAudiophoneUser instance.
     *
     * @param \Illuminate\Http\Request $request
     *@return \Illuminate\Http\Response
     */
    public function storeApiAudiophoneUser(Request $request)
    {

    	//dd($request->all());

    	$apiaudiophoneuserdata = $request->all();

    	$apiaudiophoneusernew = new ApiAudiophoneUser;

    	$apiaudiophoneusernew->apiaudiophoneusers_fullname = $apiaudiophoneuserdata['apiaudiophoneusers_fullname'];
        $apiaudiophoneusernew->apiaudiophoneusers_email = $apiaudiophoneuserdata['apiaudiophoneusers_email'];
        $apiaudiophoneusernew->apiaudiophoneusers_password = app('hash')->make($apiaudiophoneuserdata['apiaudiophoneusers_password']);

       $apiaudiophoneusernew->save();

    	return response()->json([

    		'ok' => true,
    		'status' => 201,
    		'apiaudiophoneusernew' => $apiaudiophoneusernew
    	]);
    }

    /**
     * update ApiAudiophoneUser instance.
     *
     * @param \Illuminate\Http\Request $request
     *@return \Illuminate\Http\Response
     */
    public function updateApiAudiophoneUser(Request $request, $apiaudiophoneusers_id)
    {

    	//dd($request->all());

    	$apiaudiophoneuserdata = $request->all();

    	$apiaudiophoneuserupdate = ApiAudiophoneUser::findOrFail($apiaudiophoneusers_id);

    	$apiaudiophoneuserupdate->apiaudiophoneusers_fullname = $apiaudiophoneuserdata['apiaudiophoneusers_fullname'];
        $apiaudiophoneuserupdate->apiaudiophoneusers_email = $apiaudiophoneuserdata['apiaudiophoneusers_email'];
        $apiaudiophoneuserupdate->apiaudiophoneusers_password = app('hash')->make($apiaudiophoneuserdata['apiaudiophoneusers_password']);
        $apiaudiophoneuserupdate->apiaudiophoneusers_role = $apiaudiophoneuserdata['apiaudiophoneusers_role'];
        $apiaudiophoneuserupdate->apiaudiophoneusers_status = $apiaudiophoneuserdata['apiaudiophoneusers_status'];

       $apiaudiophoneuserupdate->save();

    	return response()->json([

    		'ok' => true,
    		'status' => 201,
    		'apiaudiophoneuserupdate' => $apiaudiophoneuserupdate
    	]);
    }

	/**
     * update ApiAudiophoneUser instance.
     *
     * @param \Illuminate\Http\Request $request
     *@return \Illuminate\Http\Response
     */
    public function destroyApiAudiophoneUser(Request $request, $apiaudiophoneusers_id)
    {

       	$apiaudiophoneuserupdate = ApiAudiophoneUser::findOrFail($apiaudiophoneusers_id);

       	$apiaudiophoneuserupdate->delete();

    	return response()->json([

    		'ok' => true,
    		'status' => 200,
    		'apiaudiophoneuserdelete' => 'Usuario Eliminado Satisfactoriamente'
    	]);
    }
}

