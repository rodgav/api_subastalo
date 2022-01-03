<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\TypePay;
use Illuminate\Http\Request;

class TypePayController extends Controller
{
    public function read(Request $request) {
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            $typePay = TypePay::query()
                ->get();
            return response()->json(array('typePay' => $typePay, 'status' => 'success', 'message' => 'Tipos de pago encontrados', 'code' => 200), 200);
        } else {
            return response()->json($checkToken, 200);
        }
    }
}
