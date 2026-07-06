<?php

namespace App\Http\Controllers;

use App\Models\Departamento_GP;
use App\Models\Departamento_GPC;
use App\Models\DepartmentDirectors;
use App\Models\DirectorView;
use App\Models\Employee;
use App\Models\ObjResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepartmentDirectorsController extends Controller
{
    /**
     * Mostrar lista de departamentos activas.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function index(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $departamentos = Departamento_GPC::where('active', true)->get();

            // $departamentos->each(function ($departamento) {
            //     $departamento->director = DB::table('department_directors')
            //         ->join('vw_directors', 'department_directors.director_id', '=', 'vw_directors.id')
            //         ->where('department_directors.department_uuid', $departamento->id)
            //         ->where('department_directors.active', true)
            //         ->select('department_directors.id as relation_id', 'department_directors.active as relation_active', 'vw_directors.*')
            //         ->orderBy('department_directors.id', 'desc')
            //         ->first();
            // });

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de departamentos.';
            $response->data["result"] = $departamentos;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar listado para un selector.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function selectIndex(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = Departamento_GPC::where('active', true)->select('id as id', DB::raw("CONCAT(name,' ','(',organization_name,')') as label"))->orderBy('name', 'asc')->get();

            // $list = DepartmentDirectors::where('active', true)
            //     ->select('departments.id as id', 'departments.department as label')
            //     ->orderBy('departments.department', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de departamentos';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $msg = "DepartmentDirectorsController ~ selectIndex: " . $ex->getMessage();
            Log::error($msg);
            $response->data = ObjResponse::CatchResponse($msg);
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Crear una nueva relación departamento-director.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function create(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            // $duplicate = $this->validateAvailableData($request->department_uuid, $request->director_id, null);
            // if ($duplicate["result"] == true) {
            //     $response->data = $duplicate;
            //     return response()->json($response);
            // }
            #Obtener el ultimo registro del departamento y validar que no sea el mismo director.
            DB::beginTransaction();
            $lastRegister = $this->getLastRegisterByDepartmentId($request->department_uuid);
            if (!is_null($lastRegister)) {
                if ($lastRegister->director_id === $request->director_id) {
                    $response->data["alert_text"] = 'El director seleccionado es el director actual.';
                    $response->data["alert_icon"] = 'warning';
                    return response()->json($response);
                }
                $lastRegister = DepartmentDirectors::find($lastRegister->id);
                $lastRegister->active = false;
                $lastRegister->save();
            }


            $depDir = DepartmentDirectors::create([
                'department_uuid' => $request->department_uuid,
                'director_id' => $request->director_id,
            ]);

            DB::commit();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | relacion registrada.';
            $response->data["alert_text"] = 'Relación registrada';
        } catch (\Exception $ex) {
            DB::rollBack();
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar departamento.
     *
     * @param   int $department_uuid
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function show(Response $response, Int $department_uuid)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $depDir = Departamento_GPC::where('active', true)->where('id', $department_uuid)
                ->first();

            $depDir->director_id = null;
            $depDir->directors = [];
            $lastRegister = $this->getLastRegisterByDepartmentId($department_uuid);
            if (!is_null($lastRegister)) {
                $depDir->director_id = $lastRegister->director_id;

                $depDir->directors = DB::table('department_directors')
                    ->join('vw_directors', 'department_directors.director_id', '=', 'vw_directors.id')
                    ->where('department_directors.department_uuid', $lastRegister->department_uuid)
                    ->select('department_directors.id as relation_id', 'department_directors.active as relation_active', 'vw_directors.*')
                    ->orderBy('department_directors.id', 'desc')
                    ->get();
                $depDir = $depDir;
            }

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | departamento encontrado.';
            $response->data["result"] = $depDir;
        } catch (\Exception $ex) {
            $msg = "DepartmentDirectorsController ~ show ~ depDir: " . $ex->getMessage();
            Log::error($msg);
            $response->data = ObjResponse::CatchResponse($msg);
        }
        return response()->json($response, $response->data["status_code"]);
    }

    // /**
    //  * Actualizar departamento.
    //  *
    //  * @param  \Illuminate\Http\Request $request
    //  * @return \Illuminate\Http\Response $response
    //  */
    // public function update(Request $request, Response $response)
    // {
    //     $response->data = ObjResponse::DefaultResponse();
    //     try {
    //         // $duplicate = $this->validateAvailableData($request->department_uuid, $request->director_id, null);
    //         // if ($duplicate["result"] == true) {
    //         //     $response->data = $duplicate;
    //         //     return response()->json($response);
    //         // }
    //         #Obtener el ultimo registro del departamento y validar que no sea el mismo director.
    //         DB::beginTransaction();
    //         $lastRegister = $this->getLastRegisterByDepartmentId($request->department_uuid);
    //         if (!is_null($lastRegister)) {
    //             if ($lastRegister->director_id === $request->director_id) {
    //                 $response->data["alert_text"] = 'El director seleccionado es el director actual.';
    //                 $response->data["alert_icon"] = 'warning';
    //                 return response()->json($response);
    //             }
    //         }

    //         $lastRegister = DepartmentDirectors::find($lastRegister->id);
    //         $lastRegister->active = false;
    //         $lastRegister->save();

    //         $depDir = DepartmentDirectors::create([
    //             'department_uuid' => $request->department_uuid,
    //             'director_id' => $request->director_id,
    //         ]);

    //         DB::commit();
    //         $response->data = ObjResponse::CorrectResponse();
    //         $response->data["message"] = 'peticion satisfactoria | relacion registrada.';
    //         $response->data["alert_text"] = 'Relación registrada';
    //     } catch (\Exception $ex) {
    //         DB::rollBack();
    //         $response->data = ObjResponse::CatchResponse($ex->getMessage());
    //     }
    //     return response()->json($response, $response->data["status_code"]);
    // }
    // {
    //     $response->data = ObjResponse::DefaultResponse();
    //     try {
    //         $duplicate = $this->validateAvailableData($request->department_uuid, $request->director_id, $request->id);
    //         if ($duplicate["result"] == true) {
    //             $response->data = $duplicate;
    //             return response()->json($response);
    //         }

    //         $depDir = DepartmentDirectors::find($request->id)
    //             ->update([
    //                 'department' => $request->department,
    //                 'description' => $request->description,
    //             ]);

    //         $response->data = ObjResponse::CorrectResponse();
    //         $response->data["message"] = 'peticion satisfactoria | departamento actualizado.';
    //         $response->data["alert_text"] = 'Departamento actualizado';
    //     } catch (\Exception $ex) {
    //         $response->data = ObjResponse::CatchResponse($ex->getMessage());
    //     }
    //     return response()->json($response, $response->data["status_code"]);
    // }

    // /**
    //  * Eliminar (cambiar estado active=false) departamento.
    //  *
    //  * @param  int $id
    //  * @param  \Illuminate\Http\Request $request
    //  * @return \Illuminate\Http\Response $response
    //  */
    // public function destroy(Request $request, Response $response)
    // {
    //     $response->data = ObjResponse::DefaultResponse();
    //     try {
    //         DepartmentDirectors::find($request->id)
    //             ->update([
    //                 'active' => false,
    //                 'deleted_at' => date('Y-m-d H:i:s'),
    //             ]);
    //         $response->data = ObjResponse::CorrectResponse();
    //         $response->data["message"] = 'peticion satisfactoria | departamento eliminado.';
    //         $response->data["alert_text"] = 'Departamento eliminado';
    //     } catch (\Exception $ex) {
    //         $response->data = ObjResponse::CatchResponse($ex->getMessage());
    //     }
    //     return response()->json($response, $response->data["status_code"]);
    // }

    private function validateAvailableData($department_uuid, $director_id, $id)
    {
        #este codigo se pone en las funciones de registro y edicion
        /*  $duplicate = $this->validateAvailableData($request->username, $request->email, $request->id);
            if ($duplicate["result"] == true) {
                $response->data = $duplicate;
                return response()->json($response);
            }
        */

        // #VALIDACION DE DATOS REPETIDOS
        $duplicate = $this->checkAvailableData('department_directors', 'department_uuid', $department_uuid, 'El departamento', 'department_uuid', $id, null);
        if ($duplicate["result"] == true) return $duplicate;
        $duplicate = $this->checkAvailableData('department_directors', 'director_id', $director_id, 'El director ya ha sido vinculado a un departamento', 'director_id', $id, "users", true);
        if ($duplicate["result"] == true) return $duplicate;
        return array("result" => false);
    }


    private function getLastRegisterByDepartmentId($department_uuid)
    {
        $lastRegister = DepartmentDirectors::where('department_uuid', $department_uuid)->where('active', true)->orderBy('id', 'desc')->limit(1)->first();

        Log::info("DepartmentDirectorsControler ~ getLastRegisterByDepartmentId ~ lastRegister: " . json_encode($lastRegister));
        return $lastRegister;
    }
}
