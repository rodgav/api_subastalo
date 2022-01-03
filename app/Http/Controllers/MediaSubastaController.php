<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\MediaSubasta;
use Illuminate\Http\Request;

class MediaSubastaController extends Controller {
    public function create(Request $request) {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $idSubasta = (!is_null($json) && isset($params->idSubasta)) ? $params->idSubasta : null;
        $imageUrl1 = (!is_null($json) && isset($params->imageUrl1)) ? $params->imageUrl1 : null;
        $imageUrl2 = (!is_null($json) && isset($params->imageUrl2)) ? $params->imageUrl2 : null;
        $imageUrl3 = (!is_null($json) && isset($params->imageUrl3)) ? $params->imageUrl3 : null;
        $imageUrl4 = (!is_null($json) && isset($params->imageUrl4)) ? $params->imageUrl4 : null;
        $imageUrl5 = (!is_null($json) && isset($params->imageUrl5)) ? $params->imageUrl5 : null;
        $imageUrl6 = (!is_null($json) && isset($params->imageUrl6)) ? $params->imageUrl6 : null;
        $imageUrl7 = (!is_null($json) && isset($params->imageUrl7)) ? $params->imageUrl7 : null;
        $imageUrl8 = (!is_null($json) && isset($params->imageUrl8)) ? $params->imageUrl8 : null;
        $imageUrl9 = (!is_null($json) && isset($params->imageUrl9)) ? $params->imageUrl9 : null;
        $imageUrl10 = (!is_null($json) && isset($params->imageUrl10)) ? $params->imageUrl10 : null;
        $videoUlr = (!is_null($json) && isset($params->videoUrl)) ? $params->videoUrl : null;
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            if (!is_null($idSubasta) && !is_null($imageUrl1) && !is_null($imageUrl2) && !is_null($imageUrl3) &&
                !is_null($imageUrl4) && !is_null($imageUrl5) && !is_null($imageUrl6) && !is_null($imageUrl7) &&
                !is_null($imageUrl8) && !is_null($imageUrl9) && !is_null($imageUrl10) && !is_null($videoUlr)) {
                $mediaSubasta = new MediaSubasta();
                $mediaSubasta->idSubasta = $idSubasta;
                $mediaSubasta->imageUrl1 = $imageUrl1;
                $mediaSubasta->imageUrl2 = $imageUrl2;
                $mediaSubasta->imageUrl3 = $imageUrl3;
                $mediaSubasta->imageUrl4 = $imageUrl4;
                $mediaSubasta->imageUrl5 = $imageUrl5;
                $mediaSubasta->imageUrl6 = $imageUrl6;
                $mediaSubasta->imageUrl7 = $imageUrl7;
                $mediaSubasta->imageUrl8 = $imageUrl8;
                $mediaSubasta->imageUrl9 = $imageUrl9;
                $mediaSubasta->imageUrl10 = $imageUrl10;
                $mediaSubasta->videoUlr = $videoUlr;
                $mediaSubasta->save();
                return response()->json(array('mediaSubasta' => $mediaSubasta, 'status' => 'success', 'message' => 'Media subasta creada', 'code' => 200), 200);
            } else {
                return response()->json(array('mediaSubasta' => null, 'status' => 'error', 'code' => 400, 'message' => 'Faltan datos'), 200);
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
                $mediaSubasta = MediaSubasta::query()
                    ->where('idSubasta', '=', $idSubasta)
                    ->orderBy('created_at', 'desc')
                    ->get();
                return response()->json(array('mediaSubasta' => $mediaSubasta, 'status' => 'success', 'message' => 'Media subastas encontradas', 'code' => 200), 200);
            } else {
                return response()->json(array('locationSubasta' => null, 'status' => 'error', 'code' => 400, 'message' => 'Faltan datos'), 200);
            }
        } else {
            return response()->json($checkToken, 200);
        }
    }
}
