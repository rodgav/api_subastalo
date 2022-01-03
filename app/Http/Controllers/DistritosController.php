<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\Distritos;
use Illuminate\Http\Request;

class DistritosController extends Controller {

    public function read(Request $request) {
        //recuperamos idProvincia
        $idProvincia = $request->query('idProvincia');
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            $distritos = Distritos::query()->where('id_provincia', '=', $idProvincia)
                ->orderBy('nombre', 'asc')
                ->get();
            return response()->json(array('distritos' => $distritos, 'status' => 'success', 'message' => 'Distritos encontrados', 'code' => 200), 200);
        } else {
            return response()->json($checkToken, 200);
        }
    }

    public function readAll(Request $request) {
        //recuperamos idDistrito
        $idDistrito = $request->query('idDistrito');
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
        $distritosAll = Distritos::query()
            ->join('provincias', 'provincias.id', '=', 'distritos.id_provincia')
            ->join('departamentos', 'departamentos.id', '=', 'provincias.id_departmento')
            ->where('distritos.id', '=', $idDistrito)
            ->select('distritos.nombre as distrito', 'provincias.nombre as provincia', 'departamentos.nombre as departamento',)
            ->get();
        return response()->json(array('distritosAll' => $distritosAll, 'status' => 'success', 'message' => 'Distritos encontrados', 'code' => 200), 200);
        } else {
            return response()->json($checkToken, 200);
         }
    }
}
