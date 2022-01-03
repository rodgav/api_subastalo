<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\TypeSubasta;
use Illuminate\Http\Request;

class TypeSubastaController extends Controller
{
    public function read(Request $request) {
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            $typeSubasta = TypeSubasta::query()
                ->orderBy('created_at', 'desc')
                ->get();
            return response()->json(array('typeSubasta' => $typeSubasta, 'status' => 'success', 'message' => 'Tipos de subasta encontrados', 'code' => 200), 200);
        } else {
            return response()->json($checkToken, 200);
        }
    }
}
