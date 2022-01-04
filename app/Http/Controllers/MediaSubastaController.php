<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\MediaSubasta;
use Illuminate\Http\Request;

class MediaSubastaController extends Controller {
    public function create(Request $request) {
        //$json = $request->input('json', null);
        //$params = json_decode($json);
        //$idSubasta = (!is_null($json) && isset($params->idSubasta)) ? $params->idSubasta : null;
        $idSubasta   = $request->post('idSubasta');
        //$videoUlr = (!is_null($json) && isset($params->videoUrl)) ? $params->videoUrl : null;
        $videoUrl   = $request->post('videoUrl');
        //$imageUrl1 = $request->file('image1')->getClientOriginalName();
        $image1 = base64_decode($request->post('image1'));
        $path1 = $request->file('image1')->store('public/images');
        //$imageUrl2 = $request->file('image2')->getClientOriginalName();
        $path2 = $request->file('image2')->store('public/images');
        //$imageUrl3 = $request->file('image3')->getClientOriginalName();
        $path3 = $request->file('image3')->store('public/images');
        //$imageUrl4 = $request->file('image4')->getClientOriginalName();
        $path4 = $request->file('image4')->store('public/images');
        //$imageUrl5 = $request->file('image5')->getClientOriginalName();
        $path5 = $request->file('image5')->store('public/images');
        //$imageUrl6 = $request->file('image6')->getClientOriginalName();
        $path6 = $request->file('image6')->store('public/images');
        //$imageUrl7 = $request->file('image7')->getClientOriginalName();
        $path7 = $request->file('image7')->store('public/images');
        //$imageUrl8 = $request->file('image8')->getClientOriginalName();
        $path8 = $request->file('image8')->store('public/images');
        //$imageUrl9 = $request->file('image9')->getClientOriginalName();
        $path9 = $request->file('image9')->store('public/images');
        //$imageUrl10 = $request->file('image10')->getClientOriginalName();
        $path10 = $request->file('image10')->store('public/images');
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            if (!is_null($path1) && !is_null($path2) && !is_null($path3) && !is_null($path4) &&
                !is_null($path5) && !is_null($path6) && !is_null($path7) && !is_null($path8) &&
                !is_null($path9) && !is_null($path10) && !is_null($idSubasta) && !is_null($videoUrl)) {
                $mediaSubasta = new MediaSubasta();
                $mediaSubasta->idSubasta = $idSubasta;
                $mediaSubasta->imageUrl1 = $path1;
                $mediaSubasta->imageUrl2 = $path2;
                $mediaSubasta->imageUrl3 = $path3;
                $mediaSubasta->imageUrl4 = $path4;
                $mediaSubasta->imageUrl5 = $path5;
                $mediaSubasta->imageUrl6 = $path6;
                $mediaSubasta->imageUrl7 = $path7;
                $mediaSubasta->imageUrl8 = $path8;
                $mediaSubasta->imageUrl9 = $path9;
                $mediaSubasta->imageUrl10 = $path10;
                $mediaSubasta->videoUrl = $videoUrl;
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
