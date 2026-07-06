<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ObjResponse;
use App\Models\VoucherRequesterView;
use App\Models\EmployeeDetails;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoucherRequesterController extends Controller
{
   /**
    * Mostrar lista de solicitadores de vales activos del
    * uniendo con roles.
    *
    * @return \Illuminate\Http\Response $response
    */
   public function index(Response $response)
   {
      $response->data = ObjResponse::DefaultResponse();
      try {
         $list = VoucherRequesterView::all();

         $response->data = ObjResponse::CorrectResponse();
         $response->data["message"] = 'peticion satisfactoria | lista de solicitadores de vales.';
         $response->data["alert_text"] = "solicitadores de vales encontrados";
         $response->data["result"] = $list;
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
         $list = VoucherRequesterView::select('user_id as id', DB::raw("CONCAT(department,' - ', full_name) as label"))
            ->orderBy('department', 'asc')->get();
         $response->data = ObjResponse::CorrectResponse();
         $response->data["message"] = 'peticion satisfactoria | lista de solicitadores de vales.';
         $response->data["alert_text"] = "solicitadores de vales encontrados";
         $response->data["result"] = $list;
         $response->data["toast"] = false;
      } catch (\Exception $ex) {
         $response->data = ObjResponse::CatchResponse($ex->getMessage());
      }
      return response()->json($response, $response->data["status_code"]);
   }

   /**
    * Crear o Actualizar solicitador de vales.
    *
    * @return \Illuminate\Http\Response $response
    */
   public function createOrUpdate($user_id, $request)
   {
      try {
         $user = User::find($user_id);
         if (!$user) throw new \Exception("Usuario no encontrado");

         $details = EmployeeDetails::where('gpc_employee_id', $user->gpc_employee_id)->first();
         if (!$details) $details = new EmployeeDetails();

         $details->gpc_employee_id = $user->gpc_employee_id;
         if ($request->community_id) $details->community_id = $request->community_id;
         if ($request->street) $details->street = $request->street;
         if ($request->num_ext) $details->num_ext = $request->num_ext;
         if ($request->num_int) $details->num_int = $request->num_int;

         $details->save();

         return $details;
      } catch (\Exception $ex) {
         error_log("Hubo un error al crear o actualizar el solicitador de vales -> " . $ex->getMessage());
         echo "Hubo un error al crear o actualizar el solicitador de vales -> " . $ex->getMessage();
      }
   }


   /**
    * Mostrar solicitador de vales.
    *
    * @param   int $id
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response $response
    */
   public function show(Request $request, Int $id, Response $response)
   {
      $response->data = ObjResponse::DefaultResponse();
      try {
         // echo "el id: $request->id";
         // $user = VoucherRequesterView::where('user_id', $request->user_id)
         $user = VoucherRequesterView::find($id);

         $response->data = ObjResponse::CorrectResponse();
         $response->data["message"] = 'peticion satisfactoria | solicitador de vales encontrado.';
         $response->data["alert_text"] = "VoucherRequester encontrado";
         $response->data["result"] = $user;
      } catch (\Exception $ex) {
         $response = ObjResponse::CatchResponse($ex->getMessage());
      }
      return response()->json($response, $response->data["status_code"]);
   }


   public function validateAvailableData($cellphone = null, $employee_code, $id)
   {
      $checkAvailable = new UserController();
      // #VALIDACION DE DATOS REPETIDOS
      if ($cellphone != null) {
         $duplicate = $checkAvailable->checkAvailableData('voucher_requesters', 'cellphone', $cellphone, 'El número telefónico', 'cellphone', $id, "users");
         if ($duplicate["result"] == true) return $duplicate;
      }

      $duplicate = $checkAvailable->checkAvailableData('voucher_requesters', 'employee_code', $employee_code, 'El empleado (número de nómina) ya ha sido registrado', 'employee_code', $id, "users");
      if ($duplicate["result"] == true) return $duplicate;
      return array("result" => false);
   }


   // private function ImageUp($request, $requestFile, $id, $poxFix, $create, $nameFake)
   // {
   //    $dir_path = "GPCenter/voucherRequesters";
   //    $dir = public_path($dir_path);
   //    $img_name = "";
   //    if ($request->hasFile($requestFile)) {
   //       $img_file = $request->file($requestFile);
   //       $instance = new UserController();
   //       $img_name = $instance->ImgUpload($img_file, $dir, $dir_path, "$id-$poxFix");
   //    } else {
   //       if ($create) $img_name = "$dir_path/$nameFake.png";
   //    }
   //    return $img_name;
   // }
}
