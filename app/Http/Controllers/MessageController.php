<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller {
    public function create(Request $request) {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $idSender = (!is_null($json) && isset($params->idSender)) ? $params->idSender : null;
        $idReceiver = (!is_null($json) && isset($params->idReceiver)) ? $params->idReceiver : null;
        $title = (!is_null($json) && isset($params->title)) ? $params->title : null;
        $message = (!is_null($json) && isset($params->message)) ? $params->message : null;
        $state = (!is_null($json) && isset($params->state)) ? $params->state : null;
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            if (!is_null($idSender) && !is_null($idReceiver) && !is_null($title) && !is_null($message) && !is_null($state)) {
                $messages = new Message();
                $messages->idSender = $idSender;
                $messages->idReceiver = $idReceiver;
                $messages->title = $title;
                $messages->message = $message;
                $messages->state = $state;
                $messages->save();
                return response()->json(array('messages' => $messages, 'status' => 'success', 'message' => 'Mensaje creado', 'code' => 200), 200);
            } else {
                return response()->json(array('messages' => null, 'status' => 'error', 'code' => 400, 'message' => 'Faltan datos'), 200);
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
            $messages = Message::query()
                ->orderBy('created_at', 'desc')
                ->get();
            return response()->json(array('messages' => $messages, 'status' => 'success', 'message' => 'Mensajes encontrados', 'code' => 200), 200);
        } else {
            return response()->json($checkToken, 200);
        }
    }

    public function updateState(Request $request, $id) {
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            $messages = Message::query()->where('id', $id)->update(['state' => 1]);
            if ($messages) {
                return response()->json(array('messages' => $messages, 'status' => 'success', 'message' => 'Mensaje actualizado', 'code' => 200), 200);
            } else {
                return response()->json(array('messages' => null, 'status' => 'error', 'code' => 400, 'message' => 'No se pudo actualizar el estado del mensaje'), 200);
            }
        } else {
            return response()->json($checkToken, 200);
        }
    }
}
