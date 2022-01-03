<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\Pay;
use Illuminate\Http\Request;

class PayController extends Controller {
    public function create(Request $request) {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $idTypePay = (!is_null($json) && isset($params->idTypePay)) ? $params->idTypePay : null;
        $name = (!is_null($json) && isset($params->name)) ? $params->name : null;
        $image = (!is_null($json) && isset($params->image)) ? $params->image : null;
        $description = (!is_null($json) && isset($params->description)) ? $params->description : null;
        $date_finish = (!is_null($json) && isset($params->date_finish)) ? $params->date_finish : null;
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            if (!is_null($idTypePay) && !is_null($name) && !is_null($image) && !is_null($description) && !is_null($date_finish)) {
                $pay = new Pay();
                $pay->idTypePay = $idTypePay;
                $pay->name = $name;
                $pay->image = $image;
                $pay->description = $description;
                $pay->date_finish = $date_finish;
                $pay->save();
                return response()->json(array('pago' => $pay, 'status' => 'success', 'message' => 'Pago creada', 'code' => 200), 200);
            } else {
                return response()->json(array('pago' => null, 'status' => 'error', 'code' => 400, 'message' => 'Faltan datos'), 200);
            }
        } else {
            return response()->json($checkToken, 200);
        }
    }

    public function read(Request $request) {
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            $pay = Pay::query()
                ->orderBy('created_at', 'desc')
                ->get();
            return response()->json(array('pago' => $pay, 'status' => 'success', 'message' => 'Pagos encontrados', 'code' => 200), 200);
        } else {
            return response()->json($checkToken, 200);
        }
    }
}
