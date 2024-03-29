<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\Campaign;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CampaignController extends Controller {
    public function create(Request $request) {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $name = (!is_null($json) && isset($params->name)) ? $params->name : null;
        $code = (!is_null($json) && isset($params->code)) ? $params->code : null;
        $amount = (!is_null($json) && isset($params->amount)) ? $params->amount : null;
        $dateStart = (!is_null($json) && isset($params->dateStart)) ? $params->dateStart : null;
        $dateFinish = (!is_null($json) && isset($params->dateFinish)) ? $params->dateFinish : null;
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            if (!is_null($name) && !is_null($code) && !is_null($amount) && !is_null($dateStart) && !is_null($dateFinish)) {
                $campaign = new Campaign();
                $campaign->name = $name;
                $campaign->code = $code;
                $campaign->amount = $amount;
                $campaign->dateStart = $dateStart;
                $campaign->dateFinish = $dateFinish;
                $campaign->save();
                return response()->json(array('campaign' => $campaign, 'status' => 'success', 'message' => 'Campaña creada', 'code' => 200), 200);
            } else {
                return response()->json(array('campaign' => null, 'status' => 'error', 'code' => 400, 'message' => 'Faltan datos'), 200);
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
            $campaigns = Campaign::query()
                ->orderBy('created_at', 'desc')
                ->get();
            return response()->json(array('campaigns' => $campaigns, 'status' => 'success', 'message' => 'Campañas encontradas', 'code' => 200), 200);
        } else {
            return response()->json($checkToken, 200);
        }
    }

    public function delete(Request $request, $id) {
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            $campana = Campaign::query()->find($id);
            if (is_object($campana)) {
                try {
                    $campana->delete();
                    return response()->json(array('campaign' => $campana, 'status' => 'success', 'message' => 'Campaña eliminada', 'code' => 200), 200);
                } catch (QueryException $e) {
                    return response()->json(array('campaign' => null, 'status' => 'success', 'message' => 'Campaña no eliminada.', 'code' => 400), 200);
                }
            } else {
                return response()->json(array('campaign' => null, 'status' => 'success', 'message' => 'Campaña no eliminada', 'code' => 400), 200);
            }
        } else {
            return response()->json($checkToken, 200);
        }
    }

    public function update(Request $request, $id) {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $name = (!is_null($json) && isset($params->name)) ? $params->name : null;
        $code = (!is_null($json) && isset($params->code)) ? $params->code : null;
        $amount = (!is_null($json) && isset($params->amount)) ? $params->amount : null;
        $dateStart = (!is_null($json) && isset($params->dateStart)) ? $params->dateStart : null;
        $dateFinish = (!is_null($json) && isset($params->dateFinish)) ? $params->dateFinish : null;
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            if (!is_null($name) && !is_null($code) && !is_null($amount) && !is_null($dateStart) && !is_null($dateFinish)) {
                $campana = Campaign::query()
                    ->where('id', $id)
                    ->update(['name' => $name, 'code' => $code, 'amount' => $amount, 'dateStart' => $dateStart, 'dateFinish' => $dateFinish]);
                if ($campana) {
                    return response()->json(array('campaign' => $campana, 'status' => 'success', 'message' => 'Campaña actualizada', 'code' => 200), 200);
                } else {
                    return response()->json(array('campaign' => null, 'status' => 'error', 'code' => 400, 'message' => 'No se pudo actualizar la campaña'), 200);
                }
            } else {
                return response()->json(array('campaign' => null, 'status' => 'error', 'code' => 400, 'message' => 'Faltan datos'), 200);
            }
        } else {
            return response()->json($checkToken, 200);
        }
    }
}
