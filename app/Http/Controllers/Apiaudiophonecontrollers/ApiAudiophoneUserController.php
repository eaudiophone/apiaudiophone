<?php

namespace App\Http\Controllers\Apiaudiophonecontrollers;

use App\Apiaudiophonemodels\ApiAudiophoneUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;


class ApiAudiophoneUserController extends Controller
{

	/**
     *  show ApiAudiophoneUser instance.
     *
     * @param \Illuminate\Http\Request $request
     *@return \Illuminate\Http\Response
     */
    public function showApiAudiophoneUser(Request $request)
    {
    	// :::::: Validacion del request ::::::
    	$this->validate($request, [

    		'start' => 'numeric',
    		'end' => 'numeric',
            'stringsearch' => 'string'
    	]);

    	// :::::: Total de elementos del Request ::::::
    	$parameterstotal = count($request->all());

    	// :::::: Obtenemos total de usuarios registrados ::::::
    	$bduserstotal = ApiAudiophoneUser::count();

        // :::::: Cuando se realiza una consulta por string search
        if(($parameterstotal > 0 && $parameterstotal < 2) && ($bduserstotal > 0) && ($request->stringsearch)){

            //obtenemos string de consulta
            $stringsearch = $request->input('stringsearch');

            if(empty($stringsearch)){

                $apiaudiophoneuserdata = ApiAudiophoneUser::select('apiaudiophoneusers_id','apiaudiophoneusers_fullname', 'apiaudiophoneusers_email', 'apiaudiophoneusers_role', 'created_at')
                ->whereBetween('apiaudiophoneusers_id', [1, 5])
                ->orderBy('apiaudiophoneusers_id', 'desc')
                ->get();

               return response()->json([

                'ok' => true,
                'status' => 200,
                'bduserstotal' => $bduserstotal,
                'apiaudiophoneuserdata' => $apiaudiophoneuserdata
                ]);
            }else{

                //Contamos la cantidad de usuarios que se generan en la consulta por like para paginación en front
                $apiaudiophoneusercount = DB::table('apiaudiophoneusers')
                ->where('apiaudiophoneusers_fullname', 'like', '%'.$stringsearch.'%')
                ->orWhere('apiaudiophoneusers_email', 'like', '%'.$stringsearch.'%')
                ->count();

                //Consultamos en la base de datos cuando hacemos busqueda por string y capturamos la data
                $apiaudiophoneuserdata = ApiAudiophoneUser::select('apiaudiophoneusers_id','apiaudiophoneusers_fullname', 'apiaudiophoneusers_email', 'apiaudiophoneusers_role', 'created_at')
                ->where('apiaudiophoneusers_fullname', 'like', '%'.$stringsearch.'%')
                ->orWhere('apiaudiophoneusers_email', 'like', '%'.$stringsearch.'%')
                ->get();

               return response()->json([

                'ok' => true,
                'status' => 200,
                'bduserstotal' => $bduserstotal,
                'apiaudiophoneusercount' => $apiaudiophoneusercount,
                'apiaudiophoneuserdata' => $apiaudiophoneuserdata
                ]);
            }
    	// :::::: Cuando hay dos parametros en el request y existan usuarios en la base de datos
    	}elseif(($parameterstotal > 0 && $parameterstotal < 3) && $bduserstotal > 0){

    		//Obtenemos inicio y fin de la consulta
    		$start = $request->input('start');
    		$end = $request->input('end');

    		//Si los parametros vienen en cero o nulos hacemos consulta de los primeros 5
    		if((empty($start)) && (empty($end))){

	    		//Consultamos en la base de datos cuando el request no manda parametros (primera consulta)
	    		$apiaudiophoneuserdata = ApiAudiophoneUser::select('apiaudiophoneusers_id','apiaudiophoneusers_fullname', 'apiaudiophoneusers_email', 'apiaudiophoneusers_role', 'created_at')
	    		->whereBetween('apiaudiophoneusers_id', [1, 5])
	    		->orderBy('apiaudiophoneusers_id', 'desc')
	    		->get();
    		}else{

	    		//Consultamos usuarios en la base de datos para mandarlos a la vista
	    		$apiaudiophoneuserdata = ApiAudiophoneUser::select('apiaudiophoneusers_id', 'apiaudiophoneusers_fullname', 'apiaudiophoneusers_email', 'apiaudiophoneusers_role', 'created_at')
	    		->whereBetween('apiaudiophoneusers_id', [$start, $end])
	    		->orderBy('apiaudiophoneusers_id', 'desc')
	    		->get();
	    	}

    		//Retornamos Json con la consulta realizada, total paginacion 3(version de prueba)
    		return response()->json([

    			'ok' => true,
    			'status' => 200,
    			'bduserstotal' => $bduserstotal,
    			'apiaudiophoneuserdata' => $apiaudiophoneuserdata
    		]);

    		// :::: Cuando no hay parametros de consulta y existen usuarios en la BD :::::
    	}elseif($parameterstotal == 0 && $bduserstotal > 0){

    		//Consultamos en la base de datos cuando el request no manda parametros (primera consulta)
    		$apiaudiophoneuserdata = ApiAudiophoneUser::select('apiaudiophoneusers_id', 'apiaudiophoneusers_fullname', 'apiaudiophoneusers_email', 'apiaudiophoneusers_role', 'created_at')
    		->whereBetween('apiaudiophoneusers_id', [1, 5])
    		->orderBy('apiaudiophoneusers_id', 'desc')
    		->get();

    		//Retornamos Json con la consulta realizada, total paginacion 5
    		return response()->json([

    			'ok' => true,
    			'status' => 200,
    			'bduserstotal' => $bduserstotal,
    			'apiaudiophoneuserdata' => $apiaudiophoneuserdata
    		]);

    		//Cuando hay parametros de consulta pero no hay usuarios en la base de datos
    	}elseif(($parameterstotal > 0 && $parameterstotal < 3) && $bduserstotal == 0){

    		//Retornamos Json con mensaje de error
    		return response()->json([

    			'ok' => true,
    			'status' => 404,
    			'bduserstotal' => $bduserstotal,
    			'apiaudiophoneusermessage' => 'No existen usuarios registrados en la base de datos'
    		]);

    		//Cuando no hay parametros ni usuarios en la base de datos
    	}else{

    		//Retornamos Json con mensaje de error
    		return response()->json([

    			'ok' => true,
    			'status' => 400,
    			'bduserstotal' => $bduserstotal,
    			'apiaudiophoneusermessage' => 'Ha realizado una peticion incorrecta'
    		]);
    	}
    }

    /**
     * new store ApiAudiophoneUser instance.
     *
     * @param \Illuminate\Http\Request $request
     *@return \Illuminate\Http\Response
     */
    public function storeApiAudiophoneUser(Request $request)
    {

        $this->validate($request, [

            'apiaudiophoneusers_fullname' => 'required|string|max:60',
            'apiaudiophoneusers_email' => 'required|email|unique:apiaudiophoneusers,apiaudiophoneusers_email',
            'apiaudiophoneusers_password' => 'required|string'
        ]);

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

        $this->validate($request, [

            'apiaudiophoneusers_fullname' => 'required|string|max:60',
            'apiaudiophoneusers_email' => 'required|email|unique:apiaudiophoneusers,apiaudiophoneusers_email,'.$request->apiaudiophoneusers_id.',apiaudiophoneusers_id',
            'apiaudiophoneusers_password' => 'string'
        ]);

    	$apiaudiophoneuserdata = $request->all();

    	$apiaudiophoneuserupdate = ApiAudiophoneUser::findOrFail($apiaudiophoneusers_id);

        if($request->apiaudiophoneusers_password){

            $apiaudiophoneuserupdate->apiaudiophoneusers_fullname = $apiaudiophoneuserdata['apiaudiophoneusers_fullname'];
            $apiaudiophoneuserupdate->apiaudiophoneusers_email = $apiaudiophoneuserdata['apiaudiophoneusers_email'];
            $apiaudiophoneuserupdate->apiaudiophoneusers_password = app('hash')->make($apiaudiophoneuserdata['apiaudiophoneusers_password']);
        }else{

            //Nos aseguramos que el password sea eliminado del arreglo antes de actualizar
            unset($apiaudiophoneuserdata['apiaudiophoneusers_password']);

            $apiaudiophoneuserupdate->apiaudiophoneusers_fullname = $apiaudiophoneuserdata['apiaudiophoneusers_fullname'];
            $apiaudiophoneuserupdate->apiaudiophoneusers_email = $apiaudiophoneuserdata['apiaudiophoneusers_email'];
            $apiaudiophoneuserupdate->apiaudiophoneusers_role = $apiaudiophoneuserdata['apiaudiophoneusers_role'];
        }

       $apiaudiophoneuserupdate->update($apiaudiophoneuserdata);

    	return response()->json([

    		'ok' => true,
    		'status' => 200,
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

