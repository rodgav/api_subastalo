<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
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
}
