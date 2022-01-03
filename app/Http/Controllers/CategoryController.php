<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller {
    public function read(Request $request) {
        $categorys = Category::with('subCategorys')->get();
        return response()->json(array('categorys' => $categorys, 'status' => 'success', 'message' => 'Categorias encontradas', 'code' => 200), 200);
        /*$token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {

            $categorys = Category::query()
                ->orderBy('created_at', 'desc')
                ->get();
            return response()->json(array('categorys' => $categorys, 'status' => 'success', 'message' => 'Categorias encontradas', 'code' => 200), 200);
        } else {
            return response()->json($checkToken, 200);
        }*/
    }
}
