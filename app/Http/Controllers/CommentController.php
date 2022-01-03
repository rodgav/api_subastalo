<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller {
    public function create(Request $request) {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $idUser = (!is_null($json) && isset($params->idUser)) ? $params->idUser : null;
        $comment = (!is_null($json) && isset($params->comment)) ? $params->comment : null;
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            if (!is_null($idUser) && !is_null($comment)) {
                $comment1 = new Comment();
                $comment1->idUser = $idUser;
                $comment1->comment = $comment;
                $comment1->save();
                return response()->json(array('comment' => $comment1, 'status' => 'success', 'message' => 'Comentario creado', 'code' => 200), 200);
            } else {
                return response()->json(array('comment' => null, 'status' => 'error', 'code' => 400, 'message' => 'Faltan datos'), 200);
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
            $comments = Comment::query()
                ->orderBy('created_at', 'desc')
                ->get();
            return response()->json(array('comments' => $comments, 'status' => 'success', 'message' => 'Comentarios encontrados', 'code' => 200), 200);
        } else {
            return response()->json($checkToken, 200);
        }
    }
}
