<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\SubCategory;
use Illuminate\Database\QueryException;
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
    public function delete(Request $request, $id) {
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            $category = SubCategory::query()->find($id);
            if (is_object($category)) {
                try {
                    $category->delete();
                    return response()->json(array('sub_category' => $category, 'status' => 'success', 'message' => 'Sub-Categoria eliminada', 'code' => 200), 200);
                } catch (QueryException $e) {
                    return response()->json(array('sub_category' => null, 'status' => 'success', 'message' => 'Sub-Categoria no eliminada por tener sub-categorias', 'code' => 400), 200);
                }
            } else {
                return response()->json(array('sub_category' => null, 'status' => 'success', 'message' => 'Sub-Categoria no eliminada', 'code' => 400), 200);
            }
        } else {
            return response()->json($checkToken, 200);
        }
    }

    public function update(Request $request, $id) {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $name = (!is_null($json) && isset($params->name)) ? $params->name : null;
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            if (!is_null($name)) {
                $category = SubCategory::query()->where('id', $id)->update(['name' => $name]);
                if ($category) {
                    return response()->json(array('sub_category' => $category, 'status' => 'success', 'message' => 'Sub-Categoria actualizada', 'code' => 200), 200);
                } else {
                    return response()->json(array('sub_category' => null, 'status' => 'error', 'code' => 400, 'message' => 'No se pudo actualizar la sub-categoria'), 200);
                }
            } else {
                return response()->json(array('sub_category' => null, 'status' => 'error', 'code' => 400, 'message' => 'Faltan datos'), 200);
            }
        } else {
            return response()->json($checkToken, 200);
        }
    }
}
