<?php

namespace App\Http\Controllers\Apiaudiophonecontrollers;

use App\Traits\ApiResponserTrait;
use App\Apiaudiophonemodels\ApiAudiophoneUser;
use App\Apiaudiophonemodels\ApiAudiophoneItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ApiAudioPhoneItemController extends Controller
{
    use ApiResponserTrait;


    /**
	 * show ApiaudiophoneItems Instance	
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response 
	*/

	public function showApiaudiophoneItem(Request $request, $id_apiaudiophoneusers = null)
	{

		//:::: Validación del request :::://

		$this->validate($request, [

			'start' => 'numeric',
			'end'   => 'numeric',
			'stringsearch' => 'string'
		]);


		//:::: Capturamos el contenido del request :::://

		$item_data_show = $request->all();
		
		//:::: Contamos elementos del request :::://

		$parameters_total = count($item_data_show);

		//:::: Contamos los registros de la tabal Items :::://

		$bd_item_total = ApiAudiophoneItem::count();

		//:::: Obtenemos el usuario que gestiona el item y accedemos al rol:::://

		$user = ApiAudiophoneUser::itemuser($id_apiaudiophoneusers)->first();

		$user_item_rol = $user->apiaudiophoneusers_role;

		
		if($user_item_rol == 'ADMIN_ROLE'){

			switch($bd_item_total){

				case(0):

					return $this->errorResponse('No Existen Items, debe crearlos', 404);

					break;
				default:

				// :::: Aplicamos misma lógica del show user :::: //

				if(($parameters_total == 1) && (key($item_data_show) == 'stringsearch')){

					$chain = $item_data_show['stringsearch'];

					// :::: Cuando es la primera consulta, la cadena el request esta vacía y existen menos de 5 usuarios :::: //

					if(!($chain) && ($bd_item_total <= 5)){						
					
						$apiaudiophoneitemdata = ApiAudiophoneItem::select('apiaudiophoneitems_name', 'apiaudiophoneitems_description', 'apiaudiophoneitems_price')->oderBy('apiaudiophoneitems_id','asc')->get();

						return $this->successResponseApiaudiophoneItem(true, 200, $bd_item_total, $apiaudiophoneitemdata);

					// :::: Cuando es la primera consulta, la cadena el request esta vacía y existen mas de 5 usuarios :::: //

					}elseif(!($chain) && ($bd_item_total >= 5)){
							
						// :::: Eviamos los Items creados a la vista :::: //

						$apiaudiophoneitemdata = ApiAudiophoneItem::select('apiaudiophoneitems_name', 'apiaudiophoneitems_description', 'apiaudiophoneitems_price')->whereBetween('apiaudiophoneitems_id', [1, 5])->get();


						return $this->successResponseApiaudiophoneItem(true, 200, $bd_item_total, $apiaudiophoneitemdata);
					
					// :::: Cuando existe una busqueda por stringsearch asumimos que hay mas de 5 usuarios :::: //

					}else{
					
						// :::: Contamos los Elementos que se obtienen para busqueda stringsearch :::: //

						$apiaudiophoneitemdatacount = ApiAudiophoneItem::select('apiaudiophoneitems_name', 'apiaudiophoneitems_description', 'apiaudiophoneitems_price')->where('apiaudiophoneitems_name', 'like', '%'.$chain.'%')->orWhere('apiaudiophoneitems_description', 'like', '%'.$chain.'%')->count();

						// :::: Eviamos los Items creados a la vista :::: //

						$apiaudiophoneitemdata = ApiAudiophoneItem::select('apiaudiophoneitems_name', 'apiaudiophoneitems_description', 'apiaudiophoneitems_price')->where('apiaudiophoneitems_name', 'like', '%'.$chain.'%')->orWhere('apiaudiophoneitems_description', 'like', '%'.$chain.'%')->ordeBy('apiaudiophoneitems_id', 'asc')->get();


						return $this->successResponseApiaudiophoneItem(true, 200, $apiaudiophoneitemdatacount, $apiaudiophoneitemdata); 
					}


				}elseif($parameters_total == 2){

					// :::: Obtenemos las Key del request :::: //

					$keys_item_data_show = $this->arrayKeysRequest($item_data_show);

					// :::: Validamos que lo recibido por el Request sean los 

					if(($keys_item_data_show[0] == 'start') && ($keys_item_data_show[1] == 'end')){

						$start = $item_data_show['start'];
						$end = $item_data_show['end'];

						// :::: Cuando están vacíos los parametros de búsqueda, devuelve los primeros 5:::: //

						if(!($start) && !($end)){
						
							// :::: Eviamos los Items creados a la vista :::: //

							$apiaudiophoneitemdata = ApiAudiophoneItem::select('apiaudiophoneitems_name', 'apiaudiophoneitems_description', 'apiaudiophoneitems_price')->whereBetween('apiaudiophoneitems_id', [1, 5])->get();


							return $this->successResponseApiaudiophoneItem(true, 200, $bd_item_total, $apiaudiophoneitemdata);

							// :::: Cuando está vacío uno de los parametros de búsqueda, devuelve los primeros 5:::: //

						}elseif(!($start) || !($end)){
						
							// :::: Eviamos los Items creados a la vista :::: //

							$apiaudiophoneitemdata = ApiAudiophoneItem::select('apiaudiophoneitems_name', 'apiaudiophoneitems_description', 'apiaudiophoneitems_price')->whereBetween('apiaudiophoneitems_id', [1, 5])->get();


							return $this->successResponseApiaudiophoneItem(true, 200, $bd_item_total, $apiaudiophoneitemdata);
						}else{
						
							// :::: Eviamos los Items creados a la vista :::: //

							$apiaudiophoneitemdata = ApiAudiophoneItem::select('apiaudiophoneitems_name', 'apiaudiophoneitems_description', 'apiaudiophoneitems_price')->whereBetween('apiaudiophoneitems_id', [$start, $end])->get();

							return $this->successResponseApiaudiophoneItem(true, 200, $bd_item_total, $apiaudiophoneitemdata);
						}
					}else{
						return $this->errorResponse('Elementos del Request no Corresponden', 400);
					}
				}elseif($parameters_total == 0 || $parameters_total >= 3){


					return $this->errorResponse('Ha realizado una peticion incorrecta', 400);
				}
			}
		}else{

			return $this->errorResponse('Usuario no autorizado para consultar items', 401);
		}
	}


	/**
	 * store ApiaudiophoneItems Instance	
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response 
	*/

	public function storeApiaudiophoneItem(Request $request, $id_apiaudiophoneusers = null)
	{

		//:::: Validación del request :::://

		$this->validate($request, [

			'apiaudiophoneitems_name' => 'required|string|min:1|max:60',
			'apiaudiophoneitems_description' => 'required|string|min:1|max:60',
			'apiaudiophoneitems_price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
		]);

		
		// :::: obetenemos los datos provenientes del request :::: //

		$item_data_store = $request->all();

		//:::: Obtenemos el usuario que gestiona el item y accedemos al rol:::://

		$user = ApiAudiophoneUser::itemuser($id_apiaudiophoneusers)->first();

		$user_item_rol = $user->apiaudiophoneusers_role;

		
		if($user_item_rol == 'ADMIN_ROLE'){

			$apiaudiophoneitemnew = ApiAudiophoneItem::create([

				'id_apiaudiophoneusers' => $id_apiaudiophoneusers,
				'apiaudiophoneitems_name' => $item_data_store['apiaudiophoneitems_name'],
				'apiaudiophoneitems_description' => $item_data_store['apiaudiophoneitems_description'],
				'apiaudiophoneitems_price' => $item_data_store['apiaudiophoneitems_price']
			]);

			return $this->successResponseApiaudiophoneItemStore(true, 201, 'Item Creado Satisfactoriamente', $apiaudiophoneitemnew);

		}else{

			return $this->errorResponse('Usuario no autorizado para crear items', 401);
		}
	}


	/**
	 * update ApiaudiophoneItems Instance	
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response 
	*/

	public function updateApiaudiophoneItem(Request $request, $id_apiaudiophoneusers = null)
	{

		//:::: Validación del request :::://

		$this->validate($request, [

			'apiaudiophoneitems_id' => 'required|numeric',
			'apiaudiophoneitems_name' => 'required|string|min:1|max:60',
			'apiaudiophoneitems_description' => 'required|string|min:1|max:60',
			'apiaudiophoneitems_price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
		]);

		
		// :::: obetenemos los datos provenientes del request :::: //

		$item_data_update = $request->all();

		//:::: Obtenemos el usuario que gestiona el item y accedemos al rol:::://

		$user = ApiAudiophoneUser::itemuser($id_apiaudiophoneusers)->first();

		$user_item_rol = $user->apiaudiophoneusers_role;

		
		if($user_item_rol == 'ADMIN_ROLE'){


			$apiaudiophoneitemupdate = ApiAudiophoneItem::where('apiaudiophoneitems_id', $item_data_update['apiaudiophoneitems_id'])->update([

				'id_apiaudiophoneusers' => $id_apiaudiophoneusers,
				'apiaudiophoneitems_name' => $item_data_update['apiaudiophoneitems_name'],
				'apiaudiophoneitems_description' => $item_data_update['apiaudiophoneitems_description'],
				'apiaudiophoneitems_price' => $item_data_update['apiaudiophoneitems_price']
			]);


			$apiaudiophoneitemupdated = ApiAudiophoneItem::where('apiaudiophoneitems_id', $item_data_update['apiaudiophoneitems_id'])->first();


			return $this->successResponseApiaudiophoneItemUpdate(true, 201, 'Item Actualizdo Satisfactoriamente', $apiaudiophoneitemupdated);
		}else{

			return $this->errorResponse('Usuario no autorizado para actualizar items', 401);
		}
	}


	/**
	 * show ApiaudiophoneItems Instance	
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response 
	*/

	public function destroyApiaudiophoneItem(Request $request, $id_apiaudiophoneusers = null)
	{

		//:::: Validación del request :::://

		$this->validate($request, [

			'apiaudiophoneitems_id' => 'required|numeric'
		]);

		
		// :::: obetenemos los datos provenientes del request :::: //

		$item_data_destroy = $request->all();

		//:::: Obtenemos el usuario que gestiona el item y accedemos al rol:::://

		$user = ApiAudiophoneUser::itemuser($id_apiaudiophoneusers)->first();

		$user_item_rol = $user->apiaudiophoneusers_role;

		
		if($user_item_rol == 'ADMIN_ROLE'){


			$apiaudiophoneitemdelete = ApiAudiophoneItem::where('apiaudiophoneitems_id', $item_data_destroy['apiaudiophoneitems_id'])->delete();

			return $this->errorResponseApiaudiophoneItemDelete(true, 201, 'Item Eliminado Satisfactoriamente');
			
		}else{

			return $this->errorResponse('Usuario no autorizado para eliminar items', 401);
		}
	}


	// ::: Retorna Keys del Request :::: //

	public function arrayKeysRequest(array $request_array){


		$array_keys = array_keys($request_array);

		return $array_keys;
	}
}
