<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\Page;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PageController extends Controller {
    public function create(Request $request) {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $title = (!is_null($json) && isset($params->title)) ? $params->title : null;
        $html = (!is_null($json) && isset($params->html)) ? $params->html : null;
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            if (!is_null($title) && !is_null($html)) {
                $page = new Page();
                $page->title = $title;
                $page->html = $html;
                $page->save();
                return response()->json(array('paginas' => $page, 'status' => 'success', 'message' => 'Page creada', 'code' => 200), 200);
            } else {
                return response()->json(array('paginas' => null, 'status' => 'error', 'code' => 400, 'message' => 'Faltan datos'), 200);
            }
        } else {
            return response()->json($checkToken, 200);
        }
    }

    public function read(Request $request) {
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            $page = Page::query()
                ->orderBy('created_at', 'desc')
                ->get();
            return response()->json(array('paginas' => $page, 'status' => 'success', 'message' => 'Paginas encontradas', 'code' => 200), 200);
        } else {
            return response()->json($checkToken, 200);
        }
    }

    public function delete(Request $request, $id) {
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            $page = Page::query()->find($id);
            if (is_object($page)) {
                try {
                    $page->delete();
                    return response()->json(array('page' => $page, 'status' => 'success', 'message' => 'Pagina eliminada', 'code' => 200), 200);
                } catch (QueryException $e) {
                    return response()->json(array('page' => null, 'status' => 'success', 'message' => 'Pagina no eliminada.', 'code' => 400), 200);
                }
            } else {
                return response()->json(array('page' => null, 'status' => 'success', 'message' => 'Pagina no eliminada', 'code' => 400), 200);
            }
        } else {
            return response()->json($checkToken, 200);
        }
    }

    public function update(Request $request, $id) {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $title = (!is_null($json) && isset($params->title)) ? $params->title : null;
        $html = (!is_null($json) && isset($params->html)) ? $params->html : null;
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            if (!is_null($title) && !is_null($html)) {
                $page = Page::query()->where('id', $id)->update(['title' => $title, 'html' => $html]);
                if ($page) {
                    return response()->json(array('page' => $page, 'status' => 'success', 'message' => 'Pagina actualizada', 'code' => 200), 200);
                } else {
                    return response()->json(array('page' => null, 'status' => 'error', 'code' => 400, 'message' => 'No se pudo actualizar la pagina'), 200);
                }
            } else {
                return response()->json(array('page' => null, 'status' => 'error', 'code' => 400, 'message' => 'Faltan datos'), 200);
            }
        } else {
            return response()->json($checkToken, 200);
        }
    }
}
