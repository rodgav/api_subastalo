<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\LocationSubasta;
use Illuminate\Http\Request;

class LocationSubastaController extends Controller {
    public function create(Request $request) {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $idSubasta = (!is_null($json) && isset($params->idSubasta)) ? $params->idSubasta : null;
        $idDistrite = (!is_null($json) && isset($params->idDistrite)) ? $params->idDistrite : null;
        $date = (!is_null($json) && isset($params->date)) ? $params->date : null;
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            if (!is_null($idSubasta) && !is_null($idDistrite) && !is_null($date)) {
                $locationSubasta = new LocationSubasta();
                $locationSubasta->idSubasta = $idSubasta;
                $locationSubasta->idDistrite = $idDistrite;
                $locationSubasta->date = $date;
                $locationSubasta->save();
                return response()->json(array('locationSubasta' => $locationSubasta, 'status' => 'success', 'message' => 'Location Subasta creada', 'code' => 200), 200);
            } else {
                return response()->json(array('locationSubasta' => null, 'status' => 'error', 'code' => 400, 'message' => 'Faltan datos'), 200);
            }
        } else {
            return response()->json($checkToken, 200);
        }
    }

    public function read(Request $request) {
        //recuperamos idSubasta
        $idSubasta = $request->query('idSubasta');
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            if (!is_null($idSubasta)) {
                $locationSubasta = LocationSubasta::query()
                    ->where('idSubasta', '=', $idSubasta)
                    ->orderBy('created_at', 'desc')
                    ->get();
                return response()->json(array('locationSubasta' => $locationSubasta, 'status' => 'success', 'message' => 'Localización subastas encontradas', 'code' => 200), 200);
            } else {
                return response()->json(array('locationSubasta' => null, 'status' => 'error', 'code' => 400, 'message' => 'Faltan datos'), 200);
            }
        } else {
            return response()->json($checkToken, 200);
        }
    }
}
