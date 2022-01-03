<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\Gender;
use Illuminate\Http\Request;

class GenderController extends Controller {
    public function read(Request $request) {
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            $genders = Gender::query()
                ->get();
            return response()->json(array('generos' => $genders, 'status' => 'success', 'message' => 'Generos encontrados', 'code' => 200), 200);
        } else {
            return response()->json($checkToken, 200);
        }
    }
}
