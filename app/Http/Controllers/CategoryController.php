<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use SebastianBergmann\Type\Exception;

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

    public function create(Request $request) {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $name = (!is_null($json) && isset($params->name)) ? $params->name : null;
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            if (!is_null($name)) {
                $category = new Category();
                $category->name = $name;
                $category->save();
                return response()->json(array('category' => $category, 'status' => 'success', 'message' => 'Categoria creada', 'code' => 200), 200);
            } else {
                return response()->json(array('category' => null, 'status' => 'error', 'code' => 400, 'message' => 'Faltan datos'), 200);
            }
        } else {
            return response()->json($checkToken, 200);
        }
    }

    public function delete(Request $request, $id) {
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            $category = Category::query()->find($id);
            if (is_object($category)) {
                try {
                    $category->delete();
                    return response()->json(array('category' => $category, 'status' => 'success', 'message' => 'Categoria eliminada', 'code' => 200), 200);
                } catch (QueryException $e) {
                    return response()->json(array('category' => null, 'status' => 'success', 'message' => 'Categoria no eliminada por tener sub-categorias', 'code' => 400), 200);
                }
            } else {
                return response()->json(array('category' => null, 'status' => 'success', 'message' => 'Categoria no eliminada', 'code' => 400), 200);
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
                $category = Category::query()->where('id', $id)->update(['name' => $name]);
                if ($category) {
                    return response()->json(array('category' => $category, 'status' => 'success', 'message' => 'Categoria actualizada', 'code' => 200), 200);
                } else {
                    return response()->json(array('category' => null, 'status' => 'error', 'code' => 400, 'message' => 'No se pudo actualizar la categoria'), 200);
                }
            } else {
                return response()->json(array('category' => null, 'status' => 'error', 'code' => 400, 'message' => 'Faltan datos'), 200);
            }
        } else {
            return response()->json($checkToken, 200);
        }
    }
}
