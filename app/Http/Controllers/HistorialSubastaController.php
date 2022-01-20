<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\HistorialSubasta;
use Illuminate\Http\Request;

class HistorialSubastaController extends Controller
{
    public function read(Request $request) {
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            $decode = $jwtAuth->decode($token);
            if (!is_null($decode)) {
                $subasta = HistorialSubasta::with('subasta')
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
}
