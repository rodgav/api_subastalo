<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\Subasta;
use Illuminate\Http\Request;

class SubastaController extends Controller {
    public function create(Request $request) {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $idCategory = (!is_null($json) && isset($params->idCategory)) ? $params->idCategory : null;
        $idTypeSubasta = (!is_null($json) && isset($params->idTypeSubasta)) ? $params->idTypeSubasta : null;
        $idHoraSubasta = (!is_null($json) && isset($params->idHoraSubasta)) ? $params->idHoraSubasta : null;
        $idStateSubasta = (!is_null($json) && isset($params->idStateSubasta)) ? $params->idStateSubasta : null;
        $title = (!is_null($json) && isset($params->title)) ? $params->title : null;
        $price = (!is_null($json) && isset($params->price)) ? $params->price : null;
        $date = (!is_null($json) && isset($params->date)) ? $params->date : null;
        $brand = (!is_null($json) && isset($params->brand)) ? $params->brand : null;
        $model = (!is_null($json) && isset($params->model)) ? $params->model : null;
        $year = (!is_null($json) && isset($params->year)) ? $params->year : null;
        $mileage = (!is_null($json) && isset($params->mileage)) ? $params->mileage : null;
        $fuel = (!is_null($json) && isset($params->fuel)) ? $params->fuel : null;
        $details = (!is_null($json) && isset($params->details)) ? $params->details : null;
        $salient = (!is_null($json) && isset($params->salient)) ? $params->salient : null;
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            if (!is_null($idCategory) && !is_null($idTypeSubasta) && !is_null($idHoraSubasta) && !is_null($idStateSubasta)
                && !is_null($title) && !is_null($price) && !is_null($date) && !is_null($brand) && !is_null($model) &&
                !is_null($year) && !is_null($mileage) && !is_null($fuel) && !is_null($details) && !is_null($salient)) {
                $subasta = new Subasta();
                $subasta->idCategory = $idCategory;
                $subasta->idTypeSubasta = $idTypeSubasta;
                $subasta->idHoraSubasta = $idHoraSubasta;
                $subasta->idStateSubasta = $idStateSubasta;
                $subasta->title = $title;
                $subasta->price = $price;
                $subasta->date = $date;
                $subasta->brand = $brand;
                $subasta->model = $model;
                $subasta->year = $year;
                $subasta->mileage = $mileage;
                $subasta->fuel = $fuel;
                $subasta->details = $details;
                $subasta->salient = $salient;
                $subasta->save();
                return response()->json(array('subasta' => $subasta, 'status' => 'success', 'message' => 'Subasta creada', 'code' => 200), 200);
            } else {
                return response()->json(array('subasta' => null, 'status' => 'error', 'code' => 400, 'message' => 'Faltan datos '), 200);
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
            $subasta = Subasta::query()
                ->orderBy('created_at', 'desc')
                ->get();
            return response()->json(array('subasta' => $subasta, 'status' => 'success', 'message' => 'Subasta encontrados', 'code' => 200), 200);
        } else {
            return response()->json($checkToken, 200);
        }
    }

    public function updateState(Request $request, $id) {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $idStateSubasta = (!is_null($json) && isset($params->idStateSubasta)) ? $params->idStateSubasta : null;
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            if (!is_null($idStateSubasta)) {
                $subasta = Subasta::query()->where('id', $id)->update(['idStateSubasta' => $idStateSubasta]);
                if ($subasta) {
                    return response()->json(array('subasta' => $subasta, 'status' => 'success', 'message' => 'Estado de subasta actualizada', 'code' => 200), 200);
                } else {
                    return response()->json(array('subasta' => null, 'status' => 'error', 'code' => 400, 'message' => 'No se pudo actualizar el estado de la subasta'), 200);
                }
            } else {
                return response()->json(array('subasta' => null, 'status' => 'error', 'code' => 400, 'message' => 'Faltan datos'), 200);
            }
        } else {
            return response()->json($checkToken, 200);
        }
    }
}
