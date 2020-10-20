<?php

namespace App\Http\Controllers\Apiaudiophonecontrollers;

use App\Traits\ApiResponserTrait;
use App\Apiaudiophonemodels\ApiAudiophoneTerm;
use App\Apiaudiophonemodels\ApiAudiophoneUser;
use App\Apiaudiophonemodels\ApiAudiophoneService;
use App\Apiaudiophonemodels\ApiAudiophonEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ApiAudioPhonEventController extends Controller
{
    
    use ApiResponserTrait;

    /**
     * Display the specified resource.
     *
     * @param  \App\Apiaudiophonemodels\ApiAudiophonEvent  $apiAudiophonEvent
     * @return \Illuminate\Http\Response
     */
    public function showApiAudiophonEvent(Request $request, $id_apiaudiophoneusers = null)
    {

        //::::: METODO PARA DEVOLVER LOS EVENTOS REALIZADOS POR EL USUARIO, DEVUELVE LOS ULTIMOS 5 EVENTOS CREADOS POR EL USUARIO :::::// 

        $bdevent_total = ApiAudiophonEvent::count();

        if($bdevent_total > 0){
        	
        	$event_by_user = ApiAudiophonEvent::where('id_apiaudiophoneusers', $id_apiaudiophoneusers)->latest()->take(5)->get();

        	return $this->successResponseApiaudiophonEventShow(true, 200,  $event_by_user);
        }else{

        	return $this->errorResponse('Sin registros de Eventos en ApiaudiophonEvent, debes crearlo', 404);
        }
    }


    /**
     * Display the service name and last id term.
     *
     * @param  \App\Apiaudiophonemodels\ApiAudiophonEvent  $apiAudiophonEvent
     * @return \Illuminate\Http\Response
     */
    public function createApiAudiophonEvent($id_apiaudiophoneusers = null)
    {
        
        // USAMOS EL CREATE PARA MANDAR A LA VISTA EL ID DEL TERM Y EL NOMBRE DEL SERVICIO DE ESE TERM

        $bdterm_total = ApiAudiophoneTerm::count();

        if($bdterm_total > 0){

        	$last_conf_service_uno = ApiAudiophoneTerm::where('id_apiaudiophoneservices', 1)->get()->last();

        	$last_conf_service_dos = ApiAudiophoneTerm::where('id_apiaudiophoneservices', 2)->get()->last();

        	$id_last_conf_service_uno = $last_conf_service_uno->apiaudiophoneterms_id;

        	$id_last_conf_service_dos = $last_conf_service_dos->apiaudiophoneterms_id;

        	$nombre_servicio_uno = $last_conf_service_uno->apiaudiophoneservice->apiaudiophoneservices_name;

        	$nombre_servicio_dos = $last_conf_service_dos->apiaudiophoneservice->apiaudiophoneservices_name;

        	return $this->successResponseApiaudiophonEventCreate(true, 200, 'ID terms ultima configuracion', $id_last_conf_service_uno, $nombre_servicio_uno, $id_last_conf_service_dos, $nombre_servicio_dos);

        }else{

        	return $this->errorResponse('Sin registros de Terms en Apiaudiophoneterms, debes crearlo', 404);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param $id_apiaudiophoneusers
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeApiAudiophonEvent(Request $request, $id_apiaudiophoneusers = null)
    {        

        //::::: Validación del Request ::::://
        
        $this->validate($request, [

            'id_apiaudiophoneservices' => 'required|numeric',
            'id_apiaudiophoneterms' => 'required|numeric',
            'apiaudiophonevents_title' => 'required|string|max:120',
            'apiaudiophonevents_address' => 'string|max:120',
            'apiaudiophonevents_description' => 'required|string|max:120',
            'apiaudiophonevents_date' => 'required|date_format:Y-m-d',
            'apiaudiophonevents_begintime' => 'required|date_format:H:i',
            'apiaudiophonevents_finaltime' => 'required|date_format:H:i',
            'apiaudiophonevents_totalhours' => 'required|date_format:H:i'
        ]);

        //:::: CAPTURAMOS EL REQUEST :::://

        $apiaudiophoneventdata = $request->all();


    	//:::: BUSCAMOS EL NOMBRE DEL SERVICIO DE ACUERDO AL ID_SERVICES DEL REQUEST ::::://

    	$apiaudiophonevent_service_name = $this->service_name($apiaudiophoneventdata['id_apiaudiophoneservices']);

    
    	//:::: OBTENER BEGIN TIME DE LA ULTIMA CONFIGURACION DEL TERM DE ACUERDO AL ID DEL TERM :::://

    	$btime = $this->begin_time_last_configuration($apiaudiophoneventdata['id_apiaudiophoneterms']);
    	
    
    	//:::: OBTENER FINAL TIME DE LA ULTIMA COMFIGURACION DEL TERM DE ACUERDO AL ID DEL TERM :::://

    	$ftime = $this->final_time_last_configuration($apiaudiophoneventdata['id_apiaudiophoneterms']);
    

    	//:::: OBTENER LOS DIAS PERMITIDOS DE LA ULTIMA CONFIGURACION DEL TERM DE ACUERDO AL ID DEL TERM ::::://

		$apiaudiophoneterm_day = $this->days_event_term($apiaudiophoneventdata['id_apiaudiophoneterms']);

		//:::: TRANSFORMAMOS EN STRING EL ARREGLO DE DIAS PARA MANDARLO DE VUELTA EN LA VALIDACIÓN ::::://    	

		$apiaudiophoneterm_day_str = implode(',', $apiaudiophoneterm_day);


    	//::::: CONTAMOS CANTIDAD DE DÍAS CONFIGURADOS EN EL TERM ::::://	

    	$quantity_days = count($apiaudiophoneterm_day);


    	//::::: OBTENEMOS EL RANGO DE DÍAS CONFIGURADO EN EL TERM ::::://

    	$rank_event = $this->rank_day_last_configuration($apiaudiophoneventdata['id_apiaudiophoneterms']);
    	

    	//::::: OBTENEMOS EL DÍA DE LA SEMANA DE ACUERDO A LA FECHA DEL REQUEST ::::://

	    $week_day_event_date = $this->day_week($apiaudiophoneventdata['apiaudiophonevents_date']);


	    //::::: OBTENEMOS LA CANTIDAD DE DIAS SEMANALES CONFIGURADOS PARA EL EVENTO ::::://

	    $quantity_events_weekly = $this->quantity_weekly_day_last_configuration($apiaudiophoneventdata['id_apiaudiophoneterms']);
  

	    //::::: OBTENEMOS LA CANTIDAD DE DIAS MENSUALES CONFIGURADOS PARA EL EVENTO ::::://

	    $quantity_events_monthly = $this->quantity_monthly_day_last_configuration($apiaudiophoneventdata['id_apiaudiophoneterms']);


	    //:::: CREAMOS UNA INSTANCIA DEL APIAUDIOPHONEVENT :::://

    	$apiaudiophoneventnew = new ApiAudiophonEvent;

		
		$apiaudiophoneventnew->id_apiaudiophoneusers = $id_apiaudiophoneusers;
		$apiaudiophoneventnew->id_apiaudiophoneservices = $apiaudiophoneventdata['id_apiaudiophoneservices'];
		$apiaudiophoneventnew->id_apiaudiophoneterms = $apiaudiophoneventdata['id_apiaudiophoneterms'];		    	
    	$apiaudiophoneventnew->apiaudiophonevents_title = $apiaudiophoneventdata['apiaudiophonevents_title'];
    	$apiaudiophoneventnew->apiaudiophonevents_address = $apiaudiophoneventdata['apiaudiophonevents_address'];
    	$apiaudiophoneventnew->apiaudiophonevents_description = $apiaudiophoneventdata['apiaudiophonevents_description'];
    	$apiaudiophoneventnew->apiaudiophonevents_totalhours = $apiaudiophoneventdata['apiaudiophonevents_totalhours'];

    	
    	//:::: VALIDACION PARA ALMACENAR EL BEGIN TIME DEL EVENTO, DEBE SER MAYOR A LA DEL TERM :::://

    	if(($apiaudiophoneventdata['apiaudiophonevents_begintime']) >= $btime){

    		
    		$apiaudiophoneventnew->apiaudiophonevents_begintime = $apiaudiophoneventdata['apiaudiophonevents_begintime'];
    	}else{

    		return $this->errorResponse('Hora de Inicio debe ser mayor o igual a la(s):'.$btime, 400);
    	}

		//:::: VALIDACION PARA ALMACENAR EL FINAL TIME DEL EVENTO, DEBE SER MENOR A LA DEL TERM :::://

    	if(($apiaudiophoneventdata['apiaudiophonevents_finaltime']) <= $ftime){

    		
    		$apiaudiophoneventnew->apiaudiophonevents_finaltime = $apiaudiophoneventdata['apiaudiophonevents_finaltime'];
    	}else{

    		return $this->errorResponse('Hora de Finalizacion debe ser menor o igual a la(s):'.$ftime, 400);
    	}

    	//:::: APLICA LOGICA DE VALIDACION PARA ALMACENAR EL DATE DEL EVENTO, DEBE COINCIDIR CON LOS DIAS DEL TERM :::://


    	switch($rank_event){

    		case('5-days'):

    			if(($week_day_event_date != 'sabado') && ($week_day_event_date != 'domingo')){

					$apiaudiophoneventnew->apiaudiophonevents_date = $apiaudiophoneventdata['apiaudiophonevents_date'];    				
    			}else{

    				return $this->errorResponse('Los dias permitidos son de lunea a viernes', 400);
    			}
    			
    			break;
    		case('range'):

    			if(in_array($week_day_event_date, $apiaudiophoneterm_day)){


    				$apiaudiophoneventnew->apiaudiophonevents_date = $apiaudiophoneventdata['apiaudiophonevents_date'];
    			}else{


    				return $this->errorResponse('Los dias permitidos son: '.$apiaudiophoneterm_day_str, 400);
    			}
    			break;
    		default:
    		
    		$apiaudiophoneventnew->apiaudiophonevents_date = $apiaudiophoneventdata['apiaudiophonevents_date'];
    	}

    	$apiaudiophoneventnew->save();

    	return $this->successResponseApiaudiophonEventStore(true, 201, 'Evento Creado Exitosamente', $apiaudiophonevent_service_name, $apiaudiophoneventnew);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param $id_apiaudiophoneusers
     * @param \Illuminate\Http\Request $request 
     * @return \Illuminate\Http\Response
     */
    public function updateApiAudiophonEvent(Request $request, $id_apiaudiophoneusers)
    {

        //::::: Validación del Request ::::://
        
        $this->validate($request, [

            'id_apiaudiophoneservices' => 'required|numeric',
            'id_apiaudiophoneterms' => 'required|numeric',
            'apiaudiophonevents_id' => 'required|numeric',
            'apiaudiophonevents_title' => 'required|string|max:120',
            'apiaudiophonevents_address' => 'string|max:120',
            'apiaudiophonevents_description' => 'required|string|max:120',
            'apiaudiophonevents_date' => 'required|date_format:Y-m-d',
            'apiaudiophonevents_begintime' => 'required|date_format:H:i',
            'apiaudiophonevents_finaltime' => 'required|date_format:H:i',
            'apiaudiophonevents_totalhours' => 'required|date_format:H:i'
        ]);

        //:::: CAPTURAMOS EL REQUEST :::://

        $apiaudiophoneventdata_upd = $request->all();


    	//:::: BUSCAMOS EL NOMBRE DEL SERVICIO DE ACUERDO AL ID_SERVICES DEL REQUEST ::::://

    	$apiaudiophonevent_service_name = $this->service_name($apiaudiophoneventdata_upd['id_apiaudiophoneservices']);

    
    	//:::: OBTENER BEGIN TIME DE LA ULTIMA CONFIGURACION DEL TERM DE ACUERDO AL ID DEL TERM :::://

    	$btime = $this->begin_time_last_configuration($apiaudiophoneventdata_upd['id_apiaudiophoneterms']);
    	
    
    	//:::: OBTENER FINAL TIME DE LA ULTIMA COMFIGURACION DEL TERM DE ACUERDO AL ID DEL TERM :::://

    	$ftime = $this->final_time_last_configuration($apiaudiophoneventdata_upd['id_apiaudiophoneterms']);
    

    	//:::: OBTENER LOS DIAS PERMITIDOS DE LA ULTIMA CONFIGURACION DEL TERM DE ACUERDO AL ID DEL TERM ::::://

		$apiaudiophoneterm_day = $this->days_event_term($apiaudiophoneventdata_upd['id_apiaudiophoneterms']);


		//:::: TRANSFORMAMOS EN STRING EL ARREGLO DE DIAS PARA MANDARLO DE VUELTA EN LA VALIDACIÓN - RESPONSES ::::://    	

		$apiaudiophoneterm_day_str = implode(',', $apiaudiophoneterm_day);

    	//::::: CONTAMOS CANTIDAD DE DÍAS CONFIGURADOS EN EL TERM ::::://	

    	$quantity_days = count($apiaudiophoneterm_day);


    	//::::: OBTENEMOS EL RANGO DE DÍAS CONFIGURADO EN EL TERM ::::://

    	$rank_event = $this->rank_day_last_configuration($apiaudiophoneventdata_upd['id_apiaudiophoneterms']);
    	

    	//::::: OBTENEMOS EL DÍA DE LA SEMANA DE ACUERDO A LA FECHA DEL REQUEST ::::://

	    $week_day_event_date = $this->day_week($apiaudiophoneventdata_upd['apiaudiophonevents_date']);


	    //::::: OBTENEMOS LA CANTIDAD DE DIAS SEMANALES CONFIGURADOS PARA EL EVENTO ::::://

	    $quantity_events_weekly = $this->quantity_weekly_day_last_configuration($apiaudiophoneventdata_upd['id_apiaudiophoneterms']);
  

	    //::::: OBTENEMOS LA CANTIDAD DE DIAS MENSUALES CONFIGURADOS PARA EL EVENTO ::::://

	    $quantity_events_monthly = $this->quantity_monthly_day_last_configuration($apiaudiophoneventdata_upd['id_apiaudiophoneterms']);


	    //:::: OBTENEMOS LA INSTANCIA DEL APIAUDIOPHONEVENT A ACTUALIZAR :::://

    	$apiaudiophoneventupdate = ApiAudiophonEvent::findOrFail($apiaudiophoneventdata_upd['apiaudiophonevents_id']);

		
		$apiaudiophoneventupdate->id_apiaudiophoneusers = $id_apiaudiophoneusers;
		$apiaudiophoneventupdate->id_apiaudiophoneservices = $apiaudiophoneventdata_upd['id_apiaudiophoneservices'];
		$apiaudiophoneventupdate->id_apiaudiophoneterms = $apiaudiophoneventdata_upd['id_apiaudiophoneterms'];		    	
    	$apiaudiophoneventupdate->apiaudiophonevents_title = $apiaudiophoneventdata_upd['apiaudiophonevents_title'];
    	$apiaudiophoneventupdate->apiaudiophonevents_address = $apiaudiophoneventdata_upd['apiaudiophonevents_address'];
    	$apiaudiophoneventupdate->apiaudiophonevents_description = $apiaudiophoneventdata_upd['apiaudiophonevents_description'];
    	$apiaudiophoneventupdate->apiaudiophonevents_totalhours = $apiaudiophoneventdata_upd['apiaudiophonevents_totalhours'];

    	
    	//:::: VALIDACION PARA ACTUALIZAR EL BEGIN TIME DEL EVENTO, DEBE SER MAYOR A LA DEL TERM :::://

    	if(($apiaudiophoneventdata_upd['apiaudiophonevents_begintime']) >= $btime){

    		
    		$apiaudiophoneventupdate->apiaudiophonevents_begintime = $apiaudiophoneventdata_upd['apiaudiophonevents_begintime'];
    	}else{

    		return $this->errorResponse('Hora de Inicio debe ser mayor o igual a la(s):'.$btime, 400);
    	}

		//:::: VALIDACION PARA ACTUALIZAR EL FINAL TIME DEL EVENTO, DEBE SER MENOR A LA DEL TERM :::://

    	if(($apiaudiophoneventdata_upd['apiaudiophonevents_finaltime']) <= $ftime){

    		
    		$apiaudiophoneventupdate->apiaudiophonevents_finaltime = $apiaudiophoneventdata_upd['apiaudiophonevents_finaltime'];
    	}else{

    		return $this->errorResponse('Hora de Finalizacion debe ser menor o igual a la(s):'.$ftime, 400);
    	}

    	//:::: APLICA LOGICA DE VALIDACION PARA ACTUALIZAR EL DATE DEL EVENTO, DEBE COINCIDIR CON LOS DIAS DEL TERM :::://


    	switch($rank_event){

    		case('5-days'):

    			if(($week_day_event_date != 'sabado') && ($week_day_event_date != 'domingo')){

					$apiaudiophoneventupdate->apiaudiophonevents_date = $apiaudiophoneventdata_upd['apiaudiophonevents_date'];    				
    			}else{

    				return $this->errorResponse('Los dias permitidos son de lunea a viernes', 400);
    			}
    			
    			break;
    		case('range'):

    			if(in_array($week_day_event_date, $apiaudiophoneterm_day)){

    				$apiaudiophoneventupdate->apiaudiophonevents_date = $apiaudiophoneventdata_upd['apiaudiophonevents_date'];
    			}else{

    				return $this->errorResponse('Los dias permitidos son: '.$apiaudiophoneterm_day_str, 400);
    			}
    			break;
    		default:
    			$apiaudiophoneventupdate->apiaudiophonevents_date = $apiaudiophoneventdata_upd['apiaudiophonevents_date'];
    	}

    	$apiaudiophoneventupdate->update();

    	return $this->successResponseApiaudiophonEventUpdate(true, 201, 'Evento Actualizado Exitosamente', $apiaudiophonevent_service_name, $apiaudiophoneventupdate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id_apiaudiophoneusers
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroyApiAudiophonEvent(Request $request, $id_apiaudiophoneusers)
    {
        
    	//::::: Validación del Request ::::://
        
        $this->validate($request, [

            'apiaudiophonevents_id' => 'required|numeric'
        ]);


        $id_event = $request->input('apiaudiophonevents_id');

        $apiaudiophoneuserevent = ApiAudiophoneUser::findOrFail($id_apiaudiophoneusers);

    	$user_status = $apiaudiophoneuserevent->apiaudiophoneusers_status;


    	switch($user_status){


    		case false:


    			return $this->errorResponse('No se pudo eliminar el registro, Usuario Inactivo', 401);
    		break;

    		case true:

    			//:::: OBTENEMOS ULTIMO REGISTRO DE LA BASE DE DATOS Y LO ELIMINAMOS ::::://

    			$apiaudiophoneventdelete = ApiAudiophonEvent::findOrFail($id_event);

    			$apiaudiophoneventdelete->delete();
    			
    			return $this->errorResponseApiaudiophonEventDestroy(true, 200, 'Evento eliminado Satisfactoriamente');    			
    		break;

    		default:

    		return $this->errorResponse('Peticion mal realizada en la URL, incluir ID del usuario', 400);
    	}
    }

    /*  
     * Funcion que transforma los días de eventos en un arreglo
    */
    public function string_to_array($string_days_events)
    {

    	return explode(', ', $string_days_events);
    }


    /*  
     * Funcion que recibe la fecha numerica y te devuelve el dia de la semana
    */
    public function day_week($string_fecha){

    	//necesitamos llegar al indice 7 en el arreglo de días para que tome como ultimo dia de la semana el valor 'domingo'
    	//de lo contrario dará un mensaje de error porque la funcion strtotime maneja como ultimo dia de la semana el indice 7
    	//el indice 0 lo podemos llebar con cualquier valor en este caso le dejamos domingo...

    	$dias_semana = ['domingo','lunes','martes','miercoles','jueves','viernes','sabado','domingo'];

    	$dia_correspondiente = $dias_semana[date('N', strtotime($string_fecha))];

    	return $dia_correspondiente;
    }

	
    /*  
     * Funcion que devuelve el nombre del servicio partiendo de un scope en el modelo service
    */
    public function service_name($id_service){

    	
    	$apiaudiophonevent_query = ApiAudiophoneService::servicename($id_service)->first();

    	$service_name = $apiaudiophonevent_query->apiaudiophoneservices_name;

    	return $service_name;
    }


    /*  
     * Funcion que a traves del ID term devuelve los dias de eventos configurados en el terms
    */
    public function days_event_term($id_term){

    	
    	$apiaudiophoneterm_day_event = ApiAudiophoneTerm::where('apiaudiophoneterms_id', $id_term)->first();

    	$term_days_event = $apiaudiophoneterm_day_event->apiaudiophoneterms_daysevents;

    	$daysevent_term_array = $this->string_to_array($term_days_event);

    	return $daysevent_term_array;

    }

	/*  
     * Funcion que a traves del ID term y devuelve el begin time configurado en el term
    */
    public function begin_time_last_configuration($id_term){

    	
    	$apiaudiophonetermbtime = ApiAudiophoneTerm::where('apiaudiophoneterms_id', $id_term)->first();

    	$initime = $apiaudiophonetermbtime->apiaudiophoneterms_begintime;

    	list($hour, $minutes) = explode(':', $initime);

    	return $hour.':'.$minutes;
    }

    /*  
     * Funcion que a traves del ID term y devuelve el final time configurado en el term
    */
    public function final_time_last_configuration($id_term){

    	
    	$apiaudiophonetermftime = ApiAudiophoneTerm::where('apiaudiophoneterms_id', $id_term)->first();

    	$fintime = $apiaudiophonetermftime->apiaudiophoneterms_finaltime;

    	list($hour, $minutes) = explode(':', $fintime);

    	return $hour.':'.$minutes;
    }

    /*  
     * Funcion que a traves del ID term y devuelve el rango de días configurado en el term
    */
    public function rank_day_last_configuration($id_term){

    	
    	$apiaudiophoneterm_rday = ApiAudiophoneTerm::where('apiaudiophoneterms_id', $id_term)->first();

    	$rankday = $apiaudiophoneterm_rday->apiaudiophoneterms_rankevents;

    	return $rankday;
    }

    /*  
     * Funcion que a traves del ID term y devuelve cantidad de eventos semanales configurado en el term
    */
    public function quantity_weekly_day_last_configuration($id_term){

    	
    	$apiaudiophoneterm_day_weeekly = ApiAudiophoneTerm::where('apiaudiophoneterms_id', $id_term)->first();

    	$qweeklyday = $apiaudiophoneterm_day_weeekly->apiaudiophoneterms_quantityeventsweekly;

    	return $qweeklyday;
    }


    /*  
     * Funcion que a traves del ID term y devuelve cantidad de eventos mensuales configurados en el term
    */
    public function quantity_monthly_day_last_configuration($id_term){

    	
    	$apiaudiophoneterm_day_monthly = ApiAudiophoneTerm::where('apiaudiophoneterms_id', $id_term)->first();

    	$qwmonthlyday = $apiaudiophoneterm_day_monthly->apiaudiophoneterms_quantityeventsmonthly;

    	return $qwmonthlyday;
    }
}
