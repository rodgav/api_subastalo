<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\Provincias;
use Illuminate\Http\Request;

class ProvinciasController extends Controller {
    public function read(Request $request) {
        //recuperamos idProvincia
        $idDepartamento = $request->query('idDepartamento');
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            if (!is_null($idDepartamento)) {
                $provincias = Provincias::query()->where('id_departmento', '=', $idDepartamento)
                    ->orderBy('nombre', 'asc')
                    ->get();
            } else {
                return response()->json(array('locationSubasta' => null, 'status' => 'error', 'code' => 400, 'message' => 'Faltan datos'), 200);
            }
            return response()->json(array('provincias' => $provincias, 'status' => 'success', 'message' => 'Provincias encontradas', 'code' => 200), 200);
        } else {
            return response()->json($checkToken, 200);
        }
    }
}
