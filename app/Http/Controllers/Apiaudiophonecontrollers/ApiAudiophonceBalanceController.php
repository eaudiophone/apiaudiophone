<?php

namespace App\Http\Controllers\ApiAudiophonecontrollers;

use App\Apiaudiophonemodels\ApiAudiophoneUser;
use App\Apiaudiophonemodels\ApiAudiophoneClient;
use App\Apiaudiophonemodels\ApiAudiophoneBalance;
use App\Traits\ApiResponserTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ApiAudiophonceBalanceController extends Controller
{
    
    use ApiResponserTrait;

    /**
     * show ApiAudiophoneBalance Instance 
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response 
    */
    public function showApiaudiophoneBalance(Request $request, $id_apiaudiophoneusers = null){

       // :::: Validación del Request :::: //

        $this->validate($request, [

            'id_apiaudiophoneclients' => 'numeric|required',
            'stringsearch' => 'string|min:0|max:60',
            'start' => 'numeric' 
        ]);

       // :::: Obtenemos los valores del request :::: //

        $balance_data_show = $request->all();

        // :::: Obtenemos el numero de parámetros del arreglo :::: //

        $parameters_total = count($balance_data_show);

        // :::: Obtenemos el id del cliente :::: //

        $id_client_request = $balance_data_show['id_apiaudiophoneclients'];

        // :::: Obtenemos las keys del arreglo de parámetros de entrada :::: //

        $keys_balance_data_show = $this->arrayKeysRequest($balance_data_show);

        // :::: Obtenemos la cantidad de registros contables general :::: //

        $bdbalancetotal = ApiAudiophoneBalance::count();

        // :::: Obtenemos la cantidad de registros contables por cliente:::: //

        $count_balance_client = ApiAudiophoneBalance::where('id_apiaudiophoneclients', $id_client_request)->count();        

        // :::: Obtenemos el rol del usuario :::: //

        $user = ApiAudiophoneUser::userbalance($id_apiaudiophoneusers)->first();

        $user_role = $user->apiaudiophoneusers_role;

        // :::: asignamos la cantidad de registros por pagina :::: //

        $num_pag = 5;


        if($user_role == 'ADMIN_ROLE'){


           switch($count_balance_client)
           {
                // :::: Cuando no existen registros contables para ese cliente :::: //
                case 0:

                  return $this->errorResponse('No existen registros contables para el cliente', 404);
                break;
                default:

                // :::: Cuando es la primera consulta, solo viene el id del cliente :::: //
                if(($parameters_total == 1) && ($keys_balance_data_show[0] == 'id_apiaudiophoneclients')){

                    $balance_results = ApiAudiophoneBalance::where('id_apiaudiophoneclients', $id_client_request)
                    ->skip(0)->take($num_pag)
                    ->orderBy('apiaudiophonebalances_id', 'desc')
                    ->get();

                    return $this->successResponseApiaudiophoneBalanceShow(true, 200, $bdbalancetotal, $count_balance_client, $balance_results);

                // :::: Cuando se hace búsqueda por stringsearch, id cliente requerido :::: //
                }elseif(($parameters_total == 2) && ($keys_balance_data_show[0] == 'id_apiaudiophoneclients') && ($keys_balance_data_show[1] == 'stringsearch')){

                    // :::: Obtenemos valor de la cadena :::: //
                    $chain = $balance_data_show['stringsearch'];

                    // :::: Cuando hay cadena con o sin espacio, primera búsqueda con stringsearch :::: //
                    if(((ctype_space($chain) == true) && ($chain)) || ((ctype_space($chain) == false) && ($chain))){


                        $balance_results = ApiAudiophoneBalance::where(['id_apiaudiophoneclients', $id_client_request], ['apiaudiophonebalances_desc', 'like', '%'.$chain.'%'])
                        ->orWhere(['id_apiaudiophoneclients', $id_client_request], ['apiaudiophonebalances_date', 'like', '%'.$chain.'%'])
                        ->skip(0)->take($num_pag)
                        ->orderBy('apiaudiophonebalances_id', 'desc')
                        ->get();

                        $balance_results_count = count($balance_results); 
                        
                        return $this->successResponseApiaudiophoneBalanceCount(true, 200, $bdbalancetotal, $balance_results_count, $balance_results);                        
                    // :::: Cuando no hay cadena:::: // 
                    }else{

                        $balance_results = ApiAudiophoneBalance::where('id_apiaudiophoneclients', $id_client_request)
                        ->skip(0)->take($num_pag)
                        ->orderBy('apiaudiophonebalances_id', 'desc')
                        ->get();

                        return $this->successResponseApiaudiophoneBalanceShow(true, 200, $bdbalancetotal, $balance_results);
                    }
                // :::: Cuando se hace búsqueda por paginación :::: // 
                }elseif(($parameters_total == 2) && ($keys_balance_data_show[0] == 'id_apiaudiophoneclients') && ($keys_balance_data_show[1] == 'start')){

                    // :::: Obtenemos valor del start :::: //
                    $start = $balance_data_show['start'] - 1;

                    // :::: Cuando no hay parámetro start :::: //
                    if(!($start)){

                        $balance_results = ApiAudiophoneBalance::where('id_apiaudiophoneclients', $id_client_request)
                        ->skip(0)->take($num_pag)
                        ->orderBy('apiaudiophonebalances_id', 'desc')
                        ->get();

                        return $this->successResponseApiaudiophoneBalanceShow(true, 200, $bdbalancetotal, $balance_results);
                    // :::: Cuando hay parámetro start :::: // 
                    }else{

                        $balance_results = ApiAudiophoneBalance::where('id_apiaudiophoneclients', $id_client_request)
                        ->skip($start)->take($num_pag)
                        ->orderBy('apiaudiophonebalances_id', 'desc')
                        ->get();

                        return $this->successResponseApiaudiophoneBalanceShow(true, 200, $bdbalancetotal, $balance_results);
                    }
                // :::: Cuando se hace búsqueda por stringsarch y por parámetro de búsqueda :::: //
                }elseif(($parameters_total == 3) && ($keys_balance_data_show[0] == 'id_apiaudiophoneclients') && ($keys_balance_data_show[1] == 'stringsearch') && ($keys_balance_data_show[1] == 'start')){


                    // :::: Obtenemos valor del request :::: //
                    $chain = $balance_data_show['stringsearch'];
                    $start = $balance_data_show['start'] - 1;

                    // :::: Cuando hay cadena con o sin espacio sin parámetro start de inicio :::: //
                    if(((ctype_space($chain) == true) && !($start)) || ((ctype_space($chain) == false) && !($start))){


                        $balance_results = ApiAudiophoneBalance::where(['id_apiaudiophoneclients', $id_client_request], ['apiaudiophonebalances_desc', 'like', '%'.$chain.'%'])
                        ->orWhere(['id_apiaudiophoneclients', $id_client_request], ['apiaudiophonebalances_date', 'like', '%'.$chain.'%'])
                        ->skip(0)->take($num_pag)
                        ->orderBy('apiaudiophonebalances_id', 'desc')
                        ->get();

                        $balance_results_count = count($balance_results);
                        
                        return $this->successResponseApiaudiophoneBalanceCount(true, 200, $bdbalancetotal, $balance_results_count, $balance_results);

                    // :::: Cuando hay cadena con o sin espacio con parámetro start de inicio :::: //       
                    }elseif(((ctype_space($chain) == true) && ($start)) || ((ctype_space($chain) == false) && ($start))){


                        $balance_results = ApiAudiophoneBalance::where(['id_apiaudiophoneclients', $id_client_request], ['apiaudiophonebalances_desc', 'like', '%'.$chain.'%'])
                        ->orWhere(['id_apiaudiophoneclients', $id_client_request], ['apiaudiophonebalances_date', 'like', '%'.$chain.'%'])
                        ->skip($start)->take($num_pag)
                        ->orderBy('apiaudiophonebalances_id', 'desc')
                        ->get();

                        $balance_results_count = count($balance_results);
                        
                        return $this->successResponseApiaudiophoneBalanceCount(true, 200, $bdbalancetotal, $balance_results_count, $balance_results);

                    // :::: Cuando hay el stringsearch y el start están vacíos :::: //
                    }else{

                        $balance_results = ApiAudiophoneBalance::where('id_apiaudiophoneclients', $id_client_request)
                        ->skip(0)->take($num_pag)
                        ->orderBy('apiaudiophonebalances_id', 'desc')
                        ->get();

                        return $this->successResponseApiaudiophoneBalanceShow(true, 200, $bdbalancetotal, $count_balance_client, $balance_results);
                    }
                // :::: si no vienen parámetros de consulta adicionales al ID del cliente :::: //  
                }else{

                    $balance_results = ApiAudiophoneBalance::where('id_apiaudiophoneclients', $id_client_request)
                    ->skip(0)->take($num_pag)
                    ->orderBy('apiaudiophonebalances_id', 'desc')
                    ->get();

                    return $this->successResponseApiaudiophoneBalanceShow(true, 200, $bdbalancetotal, $count_balance_client, $balance_results);
                }
            }
        }else{

            return $this->errorResponse('Usuario no autorizado para consultar registros contables', 401);
        }
    }

    /**
     * create ApiAudiophoneBalance Instance 
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response 
    */
    public function createApiaudiophoneBalance(Request $request, $id_apiaudiophoneusers = null){

        // :::: Validación del Request :::: //

        $this->validate($request, [

            'id_apiaudiophoneclients' => 'numeric|required'
        ]);

        // :::: Obtenemos el ID del cliente :::: //

        $id_client_request = $request['id_apiaudiophoneclients'];
        
        // :::: Obtenemos la cantidad de registros contables general :::: //

        $bdbalancetotal = ApiAudiophoneBalance::count();

        // :::: Obtenemos la cantidad de registros de balance por usuario :::: //

        $count_balance_client = ApiAudiophoneBalance::where('id_apiaudiophoneclients', $id_client_request)->count();

        // :::: Obtenemos el rol del usuario :::: //

        $user = ApiAudiophoneUser::userbalance($id_apiaudiophoneusers)->first();

        $user_role = $user->apiaudiophoneusers_role;

        // ::: Asignamos el numero de páginas a consultar :::: //

        $num_pag = 5;


        // :::: GESTIONAMOS LA CONSULTA CORRESPONDIENTE :::: //

        if($user_role == 'ADMIN_ROLE'){

            switch($count_balance_client){

                case 0:

                    return $this->errorResponse('No existen registros contables para el cliente', 404);
                break
                
                default:

                // :::: Consultamos registros creados para ese cliente :::: //

                $data_balance_create = ApiAudiophoneBalance::where('id_apiaudiophoneclients', $id_client_request)
                ->skip(0)->take($num_pag)
                ->get();

                $data_balance_create_count = count($data_balance_create);

                return $this->successResponseApiaudiophoneBalanceCreate(true, 200, $bdbalancetotal, $data_balance_create_count, $data_balance_create);
            }
        }else{

            return $this->errorResponse('Usuario no autorizado para consultar Clientes', 401);
        }
    }


    /**
     * store ApiAudiophoneBalance Instance 
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response 
    */
    public function storeApiaudiophoneBalance(Request $request, $id_apiaudiophoneusers = null){

        // :::: Validación del Request :::: //

        $this->validate($request, [

            'id_apiaudiophoneclients' => 'required|numeric',
            'apiaudiophonebalances_date' => 'string|min:0|max:60',
            'apiaudiophonebalances_desc' => 'required|string|min:0|max:60',
            'apiaudiophonebalances_horlab' => 'required|numeric',
            'apiaudiophonebalances_tarif' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'apiaudiophonebalances_debe' => 'numeric|regex:/^\d+(\.\d{1,2})?$/',
            'apiaudiophonebalances_haber' => 'numeric|regex:/^\d+(\.\d{1,2})?$/',
            'apiaudiophonebalances_total' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
        ]);

        // :::: Obtenemos los datos provenientes del request :::: //

        $balance_data_store = $request->all();

        // :::: Obtenemos el rol de usuario :::: //

        $user = ApiAudiophoneUser::userbalance($id_apiaudiophoneusers)->first();

        $user_role = $user->apiaudiophoneusers_role;

        // :::: Procedemos a actualizar el cliente :::: //

        switch($user_rol){


            case('USER_ROLE'):

                return $this->errorResponse('Usuario no autorizado para crear Balances', 401);
            break;

            case('ADMIN_ROLE'):

                $apiaudiophonebalancenew = new ApiAudiophoneBalance;

                $apiaudiophonebalancenew->id_apiaudiophoneusers = $id_apiaudiophoneusers;
                $apiaudiophonebalancenew->id_apiaudiophoneclients = $balance_data_store['id_apiaudiophoneclients'];
                $apiaudiophonebalancenew->apiaudiophonebalances_date = $balance_data_store['apiaudiophonebalances_date'];
                $apiaudiophonebalancenew->apiaudiophonebalances_desc = $balance_data_store['apiaudiophonebalances_desc'];
                $apiaudiophonebalancenew->apiaudiophonebalances_tarif = $balance_data_store['apiaudiophonebalances_tarif'];
                $apiaudiophonebalancenew->apiaudiophonebalances_debe = $balance_data_store['apiaudiophonebalances_debe'];
                $apiaudiophonebalancenew->apiaudiophonebalances_haber = $balance_data_store['apiaudiophonebalances_haber'];
                $apiaudiophonebalancenew->apiaudiophonebalances_total = $balance_data_store['apiaudiophonebalances_total'];

                $apiaudiophonebalancenew->save();

                return $this->successResponseApiaudiophoneBalanceStore(true, 201, 'Balance creado Satisfactoriamente', $apiaudiophonebalancenew);
            break;

            default:

            return $this->errorResponse('Metodo no Permitido', 405);
        }
    }


    /**
     * update ApiAudiophoneBalance Instance 
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response 
    */
    public function updateApiaudiophoneBalance(Request $request, $id_apiaudiophoneusers = null){

        // :::: Validación del Request :::: //

        $this->validate($request, [

            'id_apiaudiophoneclients' => 'required|numeric',
            'apiaudiophonebalances_id' => 'required|numeric',
            'apiaudiophonebalances_date' => 'string|min:0|max:60',
            'apiaudiophonebalances_desc' => 'required|string|min:0|max:60',
            'apiaudiophonebalances_horlab' => 'required|numeric',
            'apiaudiophonebalances_tarif' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'apiaudiophonebalances_debe' => 'numeric|regex:/^\d+(\.\d{1,2})?$/',
            'apiaudiophonebalances_haber' => 'numeric|regex:/^\d+(\.\d{1,2})?$/',
            'apiaudiophonebalances_total' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
        ]);

        // :::: Obtenemos los datos provenientes del request :::: //

        $balance_data_update = $request->all();

        // :::: Obtenemos el ID del balance a actualizar :::: //

        $balance_id_update = $request['apiaudiophonebalances_id'];

        // :::: Obtenemos el rol de usuario :::: //

        $user = ApiAudiophoneUser::userbalance($id_apiaudiophoneusers)->first();

        $user_role = $user->apiaudiophoneusers_role;

        // :::: Procedemos a actualizar el cliente :::: //

        switch($user_rol){


            case('USER_ROLE'):

                return $this->errorResponse('Usuario no autorizado para actualizar Balances', 401);
            break;

            case('ADMIN_ROLE'):

                $apiaudiophonebalanceupdate = ApiAudiophoneBalance::findOrFail($balance_id_update);

                $apiaudiophonebalanceupdate->id_apiaudiophoneusers = $id_apiaudiophoneusers;
                $apiaudiophonebalanceupdate->id_apiaudiophoneclients = $balance_data_update['id_apiaudiophoneclients'];
                $apiaudiophonebalanceupdate->apiaudiophonebalances_date = $balance_data_update['apiaudiophonebalances_date'];
                $apiaudiophonebalanceupdate->apiaudiophonebalances_desc = $balance_data_update['apiaudiophonebalances_desc'];
                $apiaudiophonebalanceupdate->apiaudiophonebalances_tarif = $balance_data_update['apiaudiophonebalances_tarif'];
                $apiaudiophonebalanceupdate->apiaudiophonebalances_debe = $balance_data_update['apiaudiophonebalances_debe'];
                $apiaudiophonebalanceupdate->apiaudiophonebalances_haber = $balance_data_update['apiaudiophonebalances_haber'];
                $apiaudiophonebalanceupdate->apiaudiophonebalances_total = $balance_data_update['apiaudiophonebalances_total'];

                $apiaudiophonebalancenew->update();

                return $this->successResponseApiaudiophoneBalanceStore(true, 201, 'Balance actualizado Satisfactoriamente', $apiaudiophonebalanceupdate);
            break;

            default:

            return $this->errorResponse('Metodo no Permitido', 405);
        }
    }



    /**
     * destroy ApiAudiophoneBalance Instance 
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response 
    */
    public function destroyApiaudiophoneBalance(Request $request, $id_apiaudiophoneusers = null){
        
        // :::: Validación del Request :::: //

        $this->validate($request, [

            'apiaudiophonebalances_id' => 'required|numeric'
        ]);


        // :::: Obtenemos los datos provenientes del request y el id del cliente a eliminar :::: //

        $balance_data_delete = $request->all();

        // :::: Obtenemos el ID del balance a eliminar de las consultas :::: //

        $balance_delete_id = $balance_data_delete['apiaudiophonebalances_id'];

        // :::: Obtenemos el rol de usuario :::: //

        $user = ApiAudiophoneUser::userclient($id_apiaudiophoneusers)->first();

        $user_rol = $user->apiaudiophoneusers_role;

        // :::: Procedemos a eliminar el cliente :::: //

        switch($user_rol){

            case('USER_ROLE'):

                return $this->errorResponse('Usuario no autorizado para eliminar Balances', 401);
            break;

            case('ADMIN_ROLE'):

                // :::: Obtenemos el cliente a eliminar :::: //

                $apiaudiophonebalancetdelete = ApiAudiophoneBalance::findOrFail($balance_delete_id);

                $apiaudiophonebalancedelete->delete();

                return $this->errorResponseApiaudiophonBalanceDestroy(true, 200, 'Balance eliminado Satisfactoriamente');
            break;

            default:

            return $this->errorResponse('Método no Permitido', 405);
        }
    }


    // :::: Función que devuelve las llaves de un arreglo :::: //

    public function arrayKeysRequest(array $request_array){


        $array_keys = array_keys($request_array);

        return $array_keys;
    }
}
