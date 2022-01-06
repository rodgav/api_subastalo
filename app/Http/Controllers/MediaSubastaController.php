<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\MediaSubasta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class MediaSubastaController extends Controller {
    public function create(Request $request) {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $idSubasta = (!is_null($json) && isset($params->idSubasta)) ? $params->idSubasta : null;
        $videoUrl = (!is_null($json) && isset($params->videoUrl)) ? $params->videoUrl : null;
        $image1 = (!is_null($json) && isset($params->image1)) ? $params->image1 : null;
        $image2 = (!is_null($json) && isset($params->image2)) ? $params->image2 : null;
        $image3 = (!is_null($json) && isset($params->image3)) ? $params->image3 : null;
        $image4 = (!is_null($json) && isset($params->image4)) ? $params->image4 : null;
        $image5 = (!is_null($json) && isset($params->image5)) ? $params->image5 : null;
        $image6 = (!is_null($json) && isset($params->image6)) ? $params->image6 : null;
        $image7 = (!is_null($json) && isset($params->image7)) ? $params->image7 : null;
        $image8 = (!is_null($json) && isset($params->image8)) ? $params->image8 : null;
        $image9 = (!is_null($json) && isset($params->image9)) ? $params->image9 : null;
        $image10 = (!is_null($json) && isset($params->image10)) ? $params->image10 : null;
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            if (!is_null($image1) && !is_null($image2) && !is_null($image3) && !is_null($image4) &&
                !is_null($image5) && !is_null($image6) && !is_null($image7) && !is_null($image8) &&
                !is_null($image9) && !is_null($image10) && !is_null($idSubasta) && !is_null($videoUrl)) {
                file_put_contents(public_path() . '/uploads/image0-' . $idSubasta . '.png', base64_decode($image1));
                file_put_contents(public_path() . '/uploads/image1-' . $idSubasta . '.png', base64_decode($image2));
                file_put_contents(public_path() . '/uploads/image2-' . $idSubasta . '.png', base64_decode($image3));
                file_put_contents(public_path() . '/uploads/image3-' . $idSubasta . '.png', base64_decode($image4));
                file_put_contents(public_path() . '/uploads/image4-' . $idSubasta . '.png', base64_decode($image5));
                file_put_contents(public_path() . '/uploads/image5-' . $idSubasta . '.png', base64_decode($image6));
                file_put_contents(public_path() . '/uploads/image6-' . $idSubasta . '.png', base64_decode($image7));
                file_put_contents(public_path() . '/uploads/image7-' . $idSubasta . '.png', base64_decode($image8));
                file_put_contents(public_path() . '/uploads/image8-' . $idSubasta . '.png', base64_decode($image9));
                file_put_contents(public_path() . '/uploads/image9-' . $idSubasta . '.png', base64_decode($image10));

                $mediaSubasta = new MediaSubasta();
                $mediaSubasta->idSubasta = $idSubasta;
                $mediaSubasta->imageUrl1 = 'image0-' . $idSubasta . '.png';
                $mediaSubasta->imageUrl2 = 'image1-' . $idSubasta . '.png';
                $mediaSubasta->imageUrl3 = 'image2-' . $idSubasta . '.png';
                $mediaSubasta->imageUrl4 = 'image3-' . $idSubasta . '.png';
                $mediaSubasta->imageUrl5 = 'image4-' . $idSubasta . '.png';
                $mediaSubasta->imageUrl6 = 'image5-' . $idSubasta . '.png';
                $mediaSubasta->imageUrl7 = 'image6-' . $idSubasta . '.png';
                $mediaSubasta->imageUrl8 = 'image7-' . $idSubasta . '.png';
                $mediaSubasta->imageUrl9 = 'image8-' . $idSubasta . '.png';
                $mediaSubasta->imageUrl10 = 'image9-' . $idSubasta . '.png';
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
                return response()->json(array('mediaSubasta' => null, 'status' => 'error', 'code' => 400, 'message' => 'Faltan datos'), 200);
            }
        } else {
            return response()->json($checkToken, 200);
        }
    }
}
