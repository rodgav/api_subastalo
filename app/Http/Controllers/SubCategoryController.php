<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller {

    public function create(Request $request) {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $idCategory = (!is_null($json) && isset($params->idCategory)) ? $params->idCategory : null;
        $name = (!is_null($json) && isset($params->name)) ? $params->name : null;
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            if (!is_null($idCategory) && !is_null($name)) {
                $subCategory = new SubCategory();
                $subCategory->idCategory = $idCategory;
                $subCategory->name = $name;
                $subCategory->save();
                return response()->json(array('sub_category' => $subCategory, 'status' => 'success', 'message' => 'Sub-categoria creado', 'code' => 200), 200);
            } else {
                return response()->json(array('sub_category' => null, 'status' => 'error', 'code' => 400, 'message' => 'Faltan datos'), 200);
            }
        } else {
            return response()->json($checkToken, 200);
        }
    }

    public function read(Request $request) {
        //recuperamos idCategory
        $idCategory = $request->query('idCategory');
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            $subCategorys = SubCategory::query()->where('idCategory', '=', $idCategory)
                ->orderBy('name', 'asc')
                ->get();
            return response()->json(array('sub_categorys' => $subCategorys, 'status' => 'success', 'message' => 'Sub-categorias encontrados', 'code' => 200), 200);
        } else {
            return response()->json($checkToken, 200);
        }
    }
}
