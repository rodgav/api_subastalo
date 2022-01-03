<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\Departamentos;
use Illuminate\Http\Request;

class DepartamentosController extends Controller {
    public function read(Request $request) {
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            $departamentos = Departamentos::query()
                ->orderBy('nombre', 'asc')
                ->get();
            return response()->json(array('departamentos' => $departamentos, 'status' => 'success', 'message' => 'Departamentos encontrados', 'code' => 200), 200);
        } else {
            return response()->json($checkToken, 200);
        }
    }
}
