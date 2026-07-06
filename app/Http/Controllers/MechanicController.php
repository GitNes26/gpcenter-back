<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDetails;
use App\Models\MechanicView;
use App\Models\ObjResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MechanicController extends Controller
{
    public function index(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $auth = Auth::user();
            $list = MechanicView::orderBy('full_name', 'desc');
            if ($auth->role_id > 1) $list = $list->where("active", true);
            $list = $list->get();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de mecanicos.';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    public function selectIndex(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = MechanicView::where('active', true)
                ->select('id as id', DB::raw("CONCAT(employee_code,' - ',full_name) as label"))
                ->orderBy('full_name', 'asc')->get();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | lista de mecanicos.';
            $response->data["alert_text"] = "mecanicos encontrados";
            $response->data["result"] = $list;
            $response->data["toast"] = false;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    public function createOrUpdate(Request $request, Response $response, Int $id = null)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $user = User::find($id);
            if (!$user) $user = new User();

            $user->username = $request->username;
            $user->email = $request->email;
            if (strlen($request->password) > 0) {
                $user->password = $request->password;
            }
            $user->role_id = 4;
            $user->gpc_employee_id = $request->gpc_employee_id;
            $user->save();

            $details = EmployeeDetails::where('gpc_employee_id', $user->gpc_employee_id)->first();
            if (!$details) $details = new EmployeeDetails();
            $details->gpc_employee_id = $user->gpc_employee_id;
            if ($request->license_number) $details->license_number = $request->license_number;
            if ($request->license_type) $details->license_type = $request->license_type;
            if ($request->license_due_date) $details->license_due_date = $request->license_due_date;
            $details->save();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = $id > 0 ? 'peticion satisfactoria | mecánico editado.' : 'peticion satisfactoria | mecánico registrado.';
            $response->data["alert_text"] = $id > 0 ? "Mecánico editado" : "Mecánico registrado";
        } catch (\Exception $ex) {
            error_log("Hubo un error al crear o actualizar el mecánico -> " . $ex->getMessage());
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    public function show(Request $request, Response $response, Int $id, bool $internal = false)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $mechanic = MechanicView::find($id);
            if ($internal) return $mechanic;

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | mecánico encontrado.';
            $response->data["result"] = $mechanic;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    public function delete(Response $response, Int $id)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            User::where('id', $id)->update([
                'active' => false,
                'deleted_at' => date('Y-m-d H:i:s')
            ]);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = "peticion satisfactoria | mecanico eliminado.";
            $response->data["alert_text"] = "Mecánico eliminado";
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    public function disEnable(Response $response, Int $id, string $active)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $description = $active === "reactivar" ? 'reactivado' : 'desactivado';
            User::where('id', $id)->update([
                'active' => $active === "reactivar" ? 1 : 0
            ]);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = "peticion satisfactoria | mecanico $description.";
            $response->data["alert_text"] = "Mecánico $description";
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    public function deleteMultiple(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $countDeleted = sizeof($request->ids);
            User::whereIn('id', $request->ids)->update([
                'active' => false,
                'deleted_at' => date('Y-m-d H:i:s'),
            ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = $countDeleted == 1 ? 'peticion satisfactoria | registro eliminado.' : "peticion satisfactoria | registros eliminados ($countDeleted).";
            $response->data["alert_text"] = $countDeleted == 1 ? 'Registro eliminado' : "Registros eliminados  ($countDeleted)";
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
}
