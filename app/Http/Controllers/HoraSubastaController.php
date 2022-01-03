<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\HoraSubasta;
use Illuminate\Http\Request;

class HoraSubastaController extends Controller
{
    public function read(Request $request) {
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            $horasSubasta = HoraSubasta::query()
                ->orderBy('id', 'asc')
                ->get();
            return response()->json(array('horasSubasta' => $horasSubasta, 'status' => 'success', 'message' => 'Horas subastas encontradas', 'code' => 200), 200);
        } else {
            return response()->json($checkToken, 200);
        }
    }
}
