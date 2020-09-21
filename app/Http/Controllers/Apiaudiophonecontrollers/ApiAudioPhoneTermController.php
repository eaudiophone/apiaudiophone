<?php

namespace App\Http\Controllers\Apiaudiophonecontrollers;

use App\Apiaudiophonemodels\ApiAudiophoneTerm;
use App\Apiaudiophonemodels\ApiAudiophoneUser;
use App\Apiaudiophonemodels\ApiAudiophoneService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ApiAudioPhoneTermController extends Controller
{
	
	/**
	 *
	 * show ApiaudiophoneTerm instance.
	 *
	 * @param $id_apiaudiophoneusers
	 * @param \Illuminate\Http\Response 
    */
    public function showApiAudiophoneTerm(Request $request, $id_apiaudiophoneusers = null)
    {

    	//::::: Validación del Request ::::://
    	
    	$this->validate($request, [

        	'id_apiaudiophoneservices' => 'required|numeric'
    	]);


    	//$datos_del_usuario = Auth::user();

    	//dd($datos_del_usuario->oauth_acces_token->expires_at);

	    /*$datos_del_usuario_serializados = serialize($datos_del_usuario);


	    $datos_del_usuario_no_serializados = (array) unserialize($datos_del_usuario_serializados);


	    $arrayKey = array_keys($datos_del_usuario_no_serializados);

	    dd($arrayKey);

	    $prueba = $datos_del_usuario_no_serializados->original;

	    dd($prueba);*/

	    //dd($datos_del_usuario_no_serializados);

    	$servicio_data = $request->all();

		//::::: BUSCAMOS USUARIO EN LA BD ::::://

		$audiophoneuserterm = ApiAudiophoneUser::findOrFail($id_apiaudiophoneusers);

		//::::: VALIDAMOS QUE EL USUARIO ESTÉ ACTIVO PARA HACER LA CONSULTA ::::://

		switch($audiophoneuserterm->apiaudiophoneusers_status){

			case false:

				return response()->json([

		    		'ok' => true,
		    		'status' => 401,
		            'apiaudiophoneusermessage' => 'Usuario No Autorizado, Inactivo',
		    		'apiaudiophoneuser_status' => $audiophoneuserterm->apiaudiophoneusers_status, 
		    		'apiaudiophoneusers_fullname' => $audiophoneuserterm->apiaudiophoneusers_fullname
	    		]);
	    		
	    		break;
	    	case true:

	    		//::::: OBTENEMOS EL ID DEL SERVICIO DEL REQUEST::::://
				
				$servicio_nro = $servicio_data['id_apiaudiophoneservices'];

				//::::: OBTENEMOS EL ULTIMO REGISTRO DEL SERVICIO CONFIGURADO ::::://

				$apiaudiophonetermshowdata = ApiAudiophoneTerm::where('id_apiaudiophoneservices', $servicio_nro)->get()->last();

				//::::: TRANSFORMAMOS LOS DIAS DEL EVENTO EN UN ARREGLO ::::://

				$days_events_array = $this->string_to_array($apiaudiophonetermshowdata->apiaudiophoneterms_daysevents);

				 //::::: BUSCAMOS EL PRIMER REGISTRO DE TERMS QUE COINCIDA CON EL ID DEL SERVICIO DEL REQUEST, SOLO PARA OBTENER EL NOMBRE DEL SERVICIO EN LA INSTRUC 71 ::::://		

    			$term_data = ApiAudiophoneTerm::where('id_apiaudiophoneservices', $servicio_nro)->first();
	
    			//::::: ACCESAMOS AL NOMBRE DEL SERVICIO POR MEDIO DE RELACIONES ELOQUENT DE ESTA FORMA ::::://

    			$nombre_servicio = $term_data->apiaudiophoneservice->apiaudiophoneservices_name;    		

				return response()->json([

					'ok' => true, 
					'status' => 200,
					'apiaudiophoneterm_mesaage' => 'ultima configuración del evento',
					'apiaudiophoneservices_name' => $nombre_servicio,
					'days_events_array' => $days_events_array, 
					'apiaudiophonetermshowdata' => $apiaudiophonetermshowdata
										
				]);

				break;
			default:
			
			return response()->json([

				'ok' => true, 
				'status' => 400,
				'apiaudiophoneterm_mesaage' => 'Se requiere el ID del usuario en el URI'
			]);
		}
    }

    /**
	 *
	 * store ApiaudiophoneTerm instance.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Illuminate\Http\Response 
    */
    public function storeApiAudiophoneTerm(Request $request, $id_apiaudiophoneusers)
    {

    	//::::: Validación del Request ::::://
    	
    	$this->validate($request, [

    		'id_apiaudiophoneservices' => 'required|numeric',
        	'apiaudiophoneterms_quantityeventsweekly' => 'required|numeric',
        	'apiaudiophoneterms_quantityeventsmonthly' => 'required|numeric',
        	'apiaudiophoneterms_rankevents' => 'required|string|max:65',
        	'apiaudiophoneterms_daysevents' => 'array',
        	'apiaudiophoneterms_daysevents.*' => 'alpha',
        	'apiaudiophoneterms_begintime' => 'required|date_format:H:i',
        	'apiaudiophoneterms_finaltime' => 'required|date_format:H:i'
    	]);
    	
    	$apiaudiophonetermdata = $request->all();

    
    	//:::: BUSCAMOS EL NOMBRE DEL SERVICIO PARA DEVOLVERLO AL FRONT :::://
				 
		$service_name = ApiAudiophoneService::findOrFail($request->input('id_apiaudiophoneservices'));

    	
    	//::::: CONTAMOS LOS DIAS QUE TIENE EL ARREGLO DE DÍAS :::::://

    	$cantidad_dias = count($request->input('apiaudiophoneterms_daysevents'));
    	
    	
    	//::::: OBTENEMOS EL ID DEL USUARIO QUE ACTUALIZARÁ EL TERM ::::::://

    	$audiophoneuserterm = ApiAudiophoneUser::findOrFail($id_apiaudiophoneusers);

    	$user_status = $audiophoneuserterm->apiaudiophoneusers_status;

    
    	//::::: VALIDAMOS QUE EL USUARIO EXISTA EN LA BD ::::://

    	if($user_status == true)
    	{
    	
			$apiaudiophonetermnew = new ApiAudiophoneTerm;

			$apiaudiophonetermnew->id_apiaudiophoneusers = $id_apiaudiophoneusers;
			$apiaudiophonetermnew->id_apiaudiophoneservices = $apiaudiophonetermdata['id_apiaudiophoneservices'];
			$apiaudiophonetermnew->apiaudiophoneterms_quantityeventsweekly = $apiaudiophonetermdata['apiaudiophoneterms_quantityeventsweekly'];
			$apiaudiophonetermnew->apiaudiophoneterms_quantityeventsmonthly = $apiaudiophonetermdata['apiaudiophoneterms_quantityeventsmonthly'];
			$apiaudiophonetermnew->apiaudiophoneterms_rankevents = $apiaudiophonetermdata['apiaudiophoneterms_rankevents'];
			$apiaudiophonetermnew->apiaudiophoneterms_begintime = $apiaudiophonetermdata['apiaudiophoneterms_begintime'];
			$apiaudiophonetermnew->apiaudiophoneterms_finaltime = $apiaudiophonetermdata['apiaudiophoneterms_finaltime'];

			switch($cantidad_dias){

				case(1):

					$apiaudiophonetermnew->apiaudiophoneterms_daysevents = $request->input('apiaudiophoneterms_daysevents.0');
					
					break;
				case(2):

					$apiaudiophonetermnew->apiaudiophoneterms_daysevents = $request->input('apiaudiophoneterms_daysevents.0').', '.$request->input('apiaudiophoneterms_daysevents.1');
					
					break;
				case(3):

					$apiaudiophonetermnew->apiaudiophoneterms_daysevents = $request->input('apiaudiophoneterms_daysevents.0').', '.$request->input('apiaudiophoneterms_daysevents.1').', '.$request->input('apiaudiophoneterms_daysevents.2');

					break;
				case(4):

					$apiaudiophonetermnew->apiaudiophoneterms_daysevents = $request->input('apiaudiophoneterms_daysevents.0').', '.$request->input('apiaudiophoneterms_daysevents.1').', '.$request->input('apiaudiophoneterms_daysevents.2').', '.$request->input('apiaudiophoneterms_daysevents.3');

					break;
				case(5):

					$apiaudiophonetermnew->apiaudiophoneterms_daysevents = $request->input('apiaudiophoneterms_daysevents.0').', '.$request->input('apiaudiophoneterms_daysevents.1').', '.$request->input('apiaudiophoneterms_daysevents.2').', '.$request->input('apiaudiophoneterms_daysevents.3').', '.$request->input('apiaudiophoneterms_daysevents.4');

					break;
				case(6):

					$apiaudiophonetermnew->apiaudiophoneterms_daysevents = $request->input('apiaudiophoneterms_daysevents.0').', '.$request->input('apiaudiophoneterms_daysevents.1').', '.$request->input('apiaudiophoneterms_daysevents.2').', '.$request->input('apiaudiophoneterms_daysevents.3').', '.$request->input('apiaudiophoneterms_daysevents.4').', '.$request->input('apiaudiophoneterms_daysevents.5');

					break;
				case(7):

					$apiaudiophonetermnew->apiaudiophoneterms_daysevents = $request->input('apiaudiophoneterms_daysevents.0').', '.$request->input('apiaudiophoneterms_daysevents.1').', '.$request->input('apiaudiophoneterms_daysevents.2').', '.$request->input('apiaudiophoneterms_daysevents.3').', '.$request->input('apiaudiophoneterms_daysevents.4').', '.$request->input('apiaudiophoneterms_daysevents.5').', '.$request->input('apiaudiophoneterms_daysevents.6');

					break;
				default:

				$apiaudiophonetermnew->apiaudiophoneterms_daysevents = null;
			}


			//::::: TRANSFORMAMOS LOS DIAS DEL EVENTO EN UN ARREGLO ::::://

			$days_events_array = $this->string_to_array($apiaudiophonetermnew->apiaudiophoneterms_daysevents);

			$apiaudiophonetermnew->save();

			return response()->json([

				'ok' => true, 
				'status' => 201,
				'apiaudiophoneterm_mesaage' => 'Dias de Servicio Cargados Exitosamente',
				'apiaudiophoneservices_name' => $service_name->apiaudiophoneservices_name,
				'days_events_array' => $days_events_array,
				'apiaudiophonetermnew' => $apiaudiophonetermnew
			]);
		}else{

			return response()->json([

	    		'ok' => true,
	    		'status' => 401,
	            'apiaudiophoneusermessage' => 'Usuario No Autorizado, Inactivo',
	    		'apiaudiophoneuser_status' => $audiophoneuserterm->apiaudiophoneusers_status, 
	    		'apiaudiophoneusers_fullname' => $audiophoneuserterm->apiaudiophoneusers_fullname
    		]);			
		}
   	}	

    /**
	 *
	 * update ApiaudiophoneTerm instance.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Illuminate\Http\Response 
    */
    public function updateApiAudiophoneTerm(Request $request, $id_apiaudiophoneusers)
    {

    	//::::: Validación del Request ::::://
    	
    	$this->validate($request, [

    		'id_apiaudiophoneservices' => 'required|numeric',
    		'apiaudiophoneterms_id' => 'required|numeric',
        	'apiaudiophoneterms_quantityeventsweekly' => 'required|numeric',
        	'apiaudiophoneterms_quantityeventsmonthly' => 'required|numeric',
        	'apiaudiophoneterms_rankevents' => 'required|string|max:65',
        	'apiaudiophoneterms_daysevents' => 'array',
        	'apiaudiophoneterms_daysevents.*' => 'alpha',
        	'apiaudiophoneterms_begintime' => 'required|date_format:H:i',
        	'apiaudiophoneterms_finaltime' => 'required|date_format:H:i'
    	]);

    	
    	//::::: OBTENEMOS EL ID DEL TERM QUE SE ACTUALIZARA ::::://

    	$apiaudiophonetermdata = $request->all();

    	$id_term_request = $apiaudiophonetermdata['apiaudiophoneterms_id'];

    	
    	//::::: BUSCAMOS EL PRIMER REGISTRO DE TERMS QUE COINCIDA CON EL ID DEL SERVICIO DEL REQUEST, SOLO PARA OBTENER EL NOMBRE DEL SERVICIO EN LA INSTRUC 260 ::::://	

    	$term_data = ApiAudiophoneTerm::where('id_apiaudiophoneservices', $request->input('id_apiaudiophoneservices'))->first();
	
    	
    	//::::: ACCESAMOS AL NOMBRE DEL SERVICIO POR MEDIO DE RELACIONES ELOQUENT DE ESTA FORMA ::::://

    	$nombre_servicio = $term_data->apiaudiophoneservice->apiaudiophoneservices_name;

    	
    	//::::: OBTENEMOS EL ID DEL TERM DEL MODELO A ACTUALIZAR ::::::://

    	$audiophonetermregister = ApiAudiophoneTerm::findOrFail($id_term_request);

    	$id_term_table = $audiophonetermregister->apiaudiophoneterms_id;

    	
    	//::::: OBTENEMOS EL STATUS DEL USUARIO QUE ACTUALIZARÁ EL TERM ::::::://

    	$audiophoneuserterm = ApiAudiophoneUser::findOrFail($id_apiaudiophoneusers);

    	$user_status = $audiophoneuserterm->apiaudiophoneusers_status;


    	//::::: CONTAMOS LOS DIAS INCLUIDOS EN EL ARREGLO ::::://

    	$cantidad_dias = count($request->input('apiaudiophoneterms_daysevents'));
    	

    	//::::: VALIDAMOS QUE EL USUARIO ESTÉ ACTIVO Y QUE EL TERMINO A ACTUALIZAR SEA EL CORRECTO PARA PROCEDER ::::://
	
    	if(($user_status == true) && ($id_term_request == $id_term_table))
    	{

    		$audiophonetermregister->id_apiaudiophoneusers = $id_apiaudiophoneusers;
    		$audiophonetermregister->id_apiaudiophoneservices = $apiaudiophonetermdata['id_apiaudiophoneservices'];
    		$audiophonetermregister->apiaudiophoneterms_quantityeventsweekly = $apiaudiophonetermdata['apiaudiophoneterms_quantityeventsweekly'];
    		$audiophonetermregister->apiaudiophoneterms_quantityeventsmonthly = $apiaudiophonetermdata['apiaudiophoneterms_quantityeventsmonthly'];
    		$audiophonetermregister->apiaudiophoneterms_rankevents = $apiaudiophonetermdata['apiaudiophoneterms_rankevents'];
    		$audiophonetermregister->apiaudiophoneterms_begintime = $apiaudiophonetermdata['apiaudiophoneterms_begintime'];
    		$audiophonetermregister->apiaudiophoneterms_finaltime = $apiaudiophonetermdata['apiaudiophoneterms_finaltime'];

    		switch($cantidad_dias){

				case(1):

					$audiophonetermregister->apiaudiophoneterms_daysevents = $request->input('apiaudiophoneterms_daysevents.0');
					
					break;
				case(2):

					$audiophonetermregister->apiaudiophoneterms_daysevents = $request->input('apiaudiophoneterms_daysevents.0').', '.$request->input('apiaudiophoneterms_daysevents.1');
					
					break;
				case(3):

					$audiophonetermregister->apiaudiophoneterms_daysevents = $request->input('apiaudiophoneterms_daysevents.0').', '.$request->input('apiaudiophoneterms_daysevents.1').', '.$request->input('apiaudiophoneterms_daysevents.2');

					break;
				case(4):

					$audiophonetermregister->apiaudiophoneterms_daysevents = $request->input('apiaudiophoneterms_daysevents.0').', '.$request->input('apiaudiophoneterms_daysevents.1').', '.$request->input('apiaudiophoneterms_daysevents.2').', '.$request->input('apiaudiophoneterms_daysevents.3');

					break;
				case(5):

					$audiophonetermregister->apiaudiophoneterms_daysevents = $request->input('apiaudiophoneterms_daysevents.0').', '.$request->input('apiaudiophoneterms_daysevents.1').', '.$request->input('apiaudiophoneterms_daysevents.2').', '.$request->input('apiaudiophoneterms_daysevents.3').', '.$request->input('apiaudiophoneterms_daysevents.4');

					break;
				case(6):

					$audiophonetermregister->apiaudiophoneterms_daysevents = $request->input('apiaudiophoneterms_daysevents.0').', '.$request->input('apiaudiophoneterms_daysevents.1').', '.$request->input('apiaudiophoneterms_daysevents.2').', '.$request->input('apiaudiophoneterms_daysevents.3').', '.$request->input('apiaudiophoneterms_daysevents.4').', '.$request->input('apiaudiophoneterms_daysevents.5');

					break;
				case(7):

					$audiophonetermregister->apiaudiophoneterms_daysevents = $request->input('apiaudiophoneterms_daysevents.0').', '.$request->input('apiaudiophoneterms_daysevents.1').', '.$request->input('apiaudiophoneterms_daysevents.2').', '.$request->input('apiaudiophoneterms_daysevents.3').', '.$request->input('apiaudiophoneterms_daysevents.4').', '.$request->input('apiaudiophoneterms_daysevents.5').', '.$request->input('apiaudiophoneterms_daysevents.6');

					break;
				default:

				$audiophonetermregister->apiaudiophoneterms_daysevents = null;
			}

			//::::: TRANSFORMAMOS LOS DIAS DEL EVENTO EN UN ARREGLO ::::://

			$days_events_array = $this->string_to_array($audiophonetermregister->apiaudiophoneterms_daysevents);

			$audiophonetermregister->update();

	    	return response()->json([

	    		'ok' => true,
	    		'status' => 201,
	            'apiaudiophoneusermessage' => 'Condiciones del Evento Actualizadas Exitosamente',
	            'apiaudiophoneservices_name' => $nombre_servicio,
	            'days_events_array' => $days_events_array,
	    		'apiaudiophonetermupdate' => $audiophonetermregister
	    	]);
		}else{


			return response()->json([

				'ok' => true, 
				'status' => 401,
				'apiaudiophoneterm_mesaage' => 'Usuario no Autorizado, Inactivo', 
				'apiaudiophoneuser_status' => $audiophoneuserterm->apiaudiophoneusers_status, 
		    	'apiaudiophoneusers_fullname' => $audiophoneuserterm->apiaudiophoneusers_fullname
			]);
		}		
    }


    /**
     * delete ApiaudiophoneTerm instance.
	 *
	 * @param $id_apiaudiophoneusers
	 * @param \Illuminate\Http\Response
     */
    public function destroyApiAudiophoneTerm ($id_apiaudiophoneusers)
    {

    	$apiaudiophoneuserterm = ApiAudiophoneUser::findOrFail($id_apiaudiophoneusers);

    	$user_status = $apiaudiophoneuserterm->apiaudiophoneusers_status;


    	switch($user_status){


    		case false:

    			return response()->json([

		    		'ok' => true,
		    		'status' => 401,
		    		'audiophonetermdelete' => 'No se pudo eliminar el registro, Usuario Inactivo'
	    		]);
    		break;

    		case true:

    			//:::: OBTENEMOS ULTIMO REGISTRO DE LA BASE DE DATOS Y LO ELIMINAMOS ::::://

    			$apiaudiophonetermdelete = ApiAudiophoneTerm::all()->last();

    			$apiaudiophonetermdelete->delete();

    			//OBTENEMOS LA ULTIMA CONFIGURACIÓN DE LA BASE DE DATOS Y LA DEVOLVEMOS A LA VISTA :::://

    			$termconfiguration_last = ApiAudiophoneTerm::all()->last();

    			return response()->json([

		    		'ok' => true,
		    		'status' => 200,
		    		'apiaudiophonetermdelete' => 'Término Eliminado Satisfactoriamente, se activa ultima configuración del evento',
		    		'termconfiguration_last' => $termconfiguration_last
	    		]);
    		break;

    		default:

    		return response()->json([

				'ok' => true, 
				'status' => 400,
				'apiaudiophoneterm_mesaage' => 'Se requiere el ID del usuario en el URI'
			]);
    	}    	
    }


    /* 
     * utilizamos list para albergar el valor de la hora en la variable hour 
     * y los minutos en la variable minutes y después sumamos los segundos habiendo hecho
     * la conversion para obtener los egundos totales.
     * esta funcion no será usada de momento por lo que se deja en caso de necesitarla
    */
    public function huors_to_seconds($event_hour)
    {
       
    	list($hour, $minutes) = explode(':', $event_hour);

    	$total_seconds = ($hour * 3600) + ($minutes * 60);

    	return $total_seconds;
    }

    /*  
     * Funcion que transforma los días de eventos en un arreglo
    */

    public function string_to_array($string_days_events){

    	return explode(',', $string_days_events);

    }


    //:::::::: PENDIENTE MANEJAR UNA TABLA DE LOGS DE ACCIONES DE USUARIOS PARA AUDITORIA DE SEGURIDAD ::::::::::://
    //:::::::: ENDPOINT UPDATE NO FUNCIONAL HASTA UNA SIGUIENTE FASE PERO ESTA LISTO :::::::::::: //
}
