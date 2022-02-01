<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\FavoritaSubasta;
use Illuminate\Http\Request;

class FavoritaSubastaController extends Controller
{public function create(Request $request) {
    $json = $request->input('json', null);
    $params = json_decode($json);
    $idSubasta = (!is_null($json) && isset($params->idSubasta)) ? $params->idSubasta : null;
    $token = $request->header('Authorization', null);
    $jwtAuth = new JwtAuth();
    $checkToken = $jwtAuth->checkToken($token);
    if (is_null($checkToken)) {
        $decode = $jwtAuth->decode($token);
        if (!is_null($decode)) {
            if (!is_null($idSubasta)){
                $subasta = new FavoritaSubasta();
                $subasta->idUser = $decode->id;
                $subasta->idSubasta = $idSubasta;
                $subasta->save();
                return response()->json(array('subasta' => $subasta, 'status' => 'success', 'message' => 'Subasta creada', 'code' => 200), 200);
            }else{
                return response()->json(array('subasta' => null, 'status' => 'error', 'message' => 'Faltan datos', 'code' => 400), 200);
            }
        } else {
            return response()->json(array('subasta' => null, 'status' => 'error', 'message' => 'Decode error', 'code' => 400), 200);
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
            $decode = $jwtAuth->decode($token);
            if (!is_null($decode)) {
                $subasta = FavoritaSubasta::with('subasta')
                    ->where('idUser', '=', $decode->id)
                    ->orderBy('created_at', 'desc')->get();

                return response()->json(array('subasta' => $subasta, 'status' => 'success', 'message' => 'Subasta encontrados', 'code' => 200), 200);
            } else {
                return response()->json(array('subasta' => null, 'status' => 'success', 'message' => 'Decode error', 'code' => 200), 200);
            }
        } else {
            return response()->json($checkToken, 200);
        }
    }
    public function delete(Request $request, $id) {
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
                $subasta =  FavoritaSubasta::query()->find($id);
                if (is_object($subasta)) {
                    $subasta->delete();
                    return response()->json(array('subasta' => $subasta, 'status' => 'success', 'message' => 'Subasta eliminada', 'code' => 200), 200);
                } else {
                    return response()->json(array('subasta' => null, 'status' => 'success', 'message' => 'Subasta no eliminada', 'code' => 400), 200);
                }
        } else {
            return response()->json($checkToken, 200);
        }
    }
}
