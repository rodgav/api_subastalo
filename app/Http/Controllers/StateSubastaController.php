<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\StateSubasta;
use Illuminate\Http\Request;

class StateSubastaController extends Controller
{
    public function read(Request $request) {
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            $stateSubasta = StateSubasta::query()
                ->orderBy('created_at', 'desc')
                ->get();
            return response()->json(array('stateSubasta' => $stateSubasta, 'status' => 'success', 'message' => 'Estados de subasta encontrados', 'code' => 200), 200);
        } else {
            return response()->json($checkToken, 200);
        }
    }
}
