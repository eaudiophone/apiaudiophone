<?php

namespace App\Http\Controllers\Apiaudiophonecontrollers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Apiaudiophonemodels\ApiAudiophoneUser;
use App\Apiaudiophonemodels\ApiAudiophoneBalance;
use App\Apiaudiophonemodels\ApiAudiophoneClient;
use App\Traits\ApiResponserTrait;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class ApiAudioPhoneClientController extends Controller
{
    use ApiResponserTrait;


    /**
     * show ApiAudiophoneClient Instance 
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response 
    */
    public function showApiAudiophoneClient(Request $request, $id_apiaudiophoneusers = null){


        //::: Validación del Request :::://

        $this->validate($request, [

            'stringsearch' => 'string'
        ]);


        // :::: Obtenemos la información del request :::: //

        $client_data_show = $request->all();

        // :::: Obtenemos el numero de elementos del arreglo :::: //

        $parameters_total = count($client_data_show);

        // :::: Contamos los registros de la tabla de clientes :::: //

        $client_count_bd = ApiAudiophoneClient::count();

        // :::: Obtenemos el rol del usuario que hace la consulta :::: //

        $user = ApiAudiophoneUser::userclient($id_apiaudiophoneusers)->first();

        $user_rol = $user->apiaudiophoneusers_role;

        // :::: Numero de registros por página :::: //

        $num_pag = 5;


        //dd($num_pag);


        if($user_rol == 'ADMIN_ROLE'){

            //dd($num_pag);

            switch($client_count_bd){

                case(0):

                    return $this->errorResponse('No existen Clientes, debe crearlos', 404);
                    
                    break;
                default:

                // :::: Búsqueda con cadena vacía sin espacio :::: //

                if(($parameters_total == 1) && (key($client_data_show) == 'stringsearch')){

                    // :::: Obtenemos el valor de la cadena de búsqueda :::: //

                    $chain = $client_data_show['stringsearch'];

                    // :::: Búsqueda cadena sin espacio :::: //
                    if(ctype_space($chain) == false){

                        $clients_resutls = ApiAudiophoneClient::where('apiaudiophoneclients_name', 'like', '%'.$chain.'%')->paginate($num_pag);

                        return $this->successResponseApiaudiophoneClientShow(true, 200, $clients_resutls);

                        // :::: Búsqueda cadena con espacio :::: //
                    }elseif(ctype_space($chain) == true){

                        $clients_resutls = ApiAudiophoneClient::where('apiaudiophoneclients_name', 'like', '%'.$chain.'%')->paginate($num_pag);

                        return $this->successResponseApiaudiophoneClientShow(true, 200, $clients_resutls);
                    
                        // :::: Búsqueda con cadena vacía :::: //
                    }else{

                        $clients_resutls = ApiAudiophoneClient::paginate($num_pag);

                        return $this->successResponseApiaudiophoneClientShow(true, 200, $clients_resutls);
                    }
                }elseif($parameters_total == 0){

                    $clients_resutls = ApiAudiophoneClient::paginate($num_pag);

                    return $this->successResponseApiaudiophoneClientShow(true, 200, $clients_resutls);
                }
            }
        }else{

            dd('error');
            return $this->errorResponse('Usuario no autorizado para consultar Clientes', 401);
        }
    }

    /**
     * store ApiAudiophoneClient Instance 
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response 
    */
    public function storeApiAudiophoneClient(Request $request, $id_apiaudiophoneusers = null){

        // :::: Validación del Request :::: //

        $this->validate($request, [

            'apiaudiophoneclients_name' => 'required|string|min:1|max:60',
            'apiaudiophoneclients_ident' => 'required|numeric',
            'apiaudiophoneclients_phone' => 'required|string|min:1|max:60'
        ]);

        
        // :::: Obtenemos los datos provenientes del request :::: //

        $client_data_store = $request->all();

        // :::: Obtenemos el rol de usuario :::: //

        $user = ApiAudiophoneUser::userclient($id_apiaudiophoneusers)->first();

        $user_rol = $user->apiaudiophoneusers_role;

        // :::: Procedemos a actualizar el cliente :::: //

        switch($user_rol){


            case('USER_ROLE'):

                return $this->errorResponse('Usuario no autorizado para crear Clientes', 401);
            break;

            case('ADMIN_ROLE'):

                $apiaudiophoneclientnew = new ApiAudiophoneClient;

                $apiaudiophoneclientnew->id_apiaudiophoneusers = $id_apiaudiophoneusers;
                $apiaudiophoneclientnew->apiaudiophoneclients_name = $client_data_store['apiaudiophoneclients_name'];
                $apiaudiophoneclientnew->apiaudiophoneclients_ident = $client_data_store['apiaudiophoneclients_ident'];
                $apiaudiophoneclientnew->apiaudiophoneclients_phone = $client_data_store['apiaudiophoneclients_phone'];

                $apiaudiophoneclientnew->save();

                return $this->successResponseApiaudiophoneClientStore(true, 200, 'Cliente creado Satisfactoriamente', $apiaudiophoneclientnew);
            break;

            default:

            return $this->errorResponse('Metodo no Permitido', 405);
        }
    }

    /**
     * update ApiAudiophoneClient Instance 
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response 
    */
    public function updateApiAudiophoneClient(Request $request, $id_apiaudiophoneusers = null){


        // :::: Validación del Request :::: //

        $this->validate($request, [

            'apiaudiophoneclients_id' => 'required|numeric',
            'apiaudiophoneclients_name' => 'required|string|min:1|max:60',
            'apiaudiophoneclients_ident' => 'required|numeric',
            'apiaudiophoneclients_phone' => 'required|string|min:1|max:60'
        ]);


        // :::: Obtenemos los datos provenientes del request y el id del cliente a actualizar :::: //

        $client_data_update = $request->all();

        $client_update_id = $client_data_update['apiaudiophoneclients_id'];

        // :::: Obtenemos el rol de usuario :::: //

        $user = ApiAudiophoneUser::userclient($id_apiaudiophoneusers)->first();

        $user_rol = $user->apiaudiophoneusers_role;    

        // :::: Procedemos a actualizar el cliente :::: //

        switch($user_rol){

            case('USER_ROLE'):

                return $this->errorResponse('Usuario no autorizado para actualizar Clientes', 401);
            break;

            case('ADMIN_ROLE'):

                // :::: Obtenemos el cliente a actualizar :::: //

                $apiaudiophoneclientupdate = ApiAudiophoneClient::findOrFail($client_update_id);

                $apiaudiophoneclientupdate->id_apiaudiophoneusers = $id_apiaudiophoneusers;
                $apiaudiophoneclientupdate->apiaudiophoneclients_name = $client_data_update['apiaudiophoneclients_name'];
                $apiaudiophoneclientupdate->apiaudiophoneclients_ident = $client_data_update['apiaudiophoneclients_ident'];
                $apiaudiophoneclientupdate->apiaudiophoneclients_phone = $client_data_update['apiaudiophoneclients_phone'];

                $apiaudiophoneclientupdate->update();

                return $this->successResponseApiaudiophoneClientUpdate(true, 200, 'Cliente actualizdo Satisfactoriamente', $apiaudiophoneclientupdate);
            break;

            default:

            return $this->errorResponse('Método no Permitido', 405);
        }
    }

    /**
     * destroy ApiAudiophoneClient Instance 
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response 
    */
    public function destroyApiAudiophoneClient(Request $request, $id_apiaudiophoneusers){

        // :::: Validación del Request :::: //

        $this->validate($request, [

            'apiaudiophoneclients_id' => 'required|numeric'
        ]);


        // :::: Obtenemos los datos provenientes del request y el id del cliente a eliminar :::: //

        $client_data_delete = $request->all();

        $client_delete_id = $client_data_delete['apiaudiophoneclients_id'];

        // :::: Obtenemos el rol de usuario :::: //

        $user = ApiAudiophoneUser::userclient($id_apiaudiophoneusers)->first();

        $user_rol = $user->apiaudiophoneusers_role;

        // :::: Procedemos a eliminar el cliente :::: //

        switch($user_rol){

            case('USER_ROLE'):

                return $this->errorResponse('Usuario no autorizado para actualizar Clientes', 401);
            break;

            case('ADMIN_ROLE'):

                // :::: Obtenemos el cliente a eliminar :::: //

                $apiaudiophoneclientdelete = ApiAudiophoneClient::findOrFail($client_delete_id);

                $apiaudiophoneclientdelete->delete();

                return $this->errorResponseApiaudiophonClientDestroy(true, 200, 'Cliente eliminado Satisfactoriamente');
            break;

            default:

            return $this->errorResponse('Método no Permitido', 405);
        }
    }
}
