<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller {
    public function read(Request $request) {
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            $roles = Role::query()
                ->orderBy('created_at', 'desc')
                ->get();
            return response()->json(array('roles' => $roles, 'status' => 'success', 'message' => 'Roles encontrados', 'code' => 200), 200);
        } else {
            return response()->json($checkToken, 200);
        }
    }
}
