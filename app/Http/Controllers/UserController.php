<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\TokenSession;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UserController extends Controller {
    public function logIn(Request $request) {
        $jwtAuth = new JwtAuth();
        //recibir datos
        $json = $request->input('json', null);
        $params = json_decode($json);
        $email = (!is_null($json) && isset($params->email)) ? $params->email : null;
        $password = (!is_null($json) && isset($params->password)) ? $params->password : null;
        if (!is_null($email) && !is_null($password)) {
            $singup = $jwtAuth->singup($email, $password);
            return response()->json($singup, 200);
        } else {
            return Response()->json(array('status' => 'error', 'message' => 'Faltan datos', 'code' => 400), 200);
        }
    }

    public function refresh(Request $request) {
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $refreshToken = $jwtAuth->refresh($token);
        return response()->json($refreshToken, 200);
    }

    public function logOut(Request $request) {
        $token = $request->header('Authorization', null);
        $tokenSess = TokenSession::query()->where('token', '=', $token)->delete();
        if ($tokenSess) {
            return Response()->json(array('status' => 'success', 'message' => 'Sesión cerrada satisfactoriamente', 'code' => 200), 200);
        } else {
            return Response()->json(array('status' => 'error', 'message' => 'No se pudo cerrar la sesión', 'code' => 400), 200);
        }
    }

    public function create(Request $request) {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $dni = (!is_null($json) && isset($params->dni)) ? $params->dni : null;
        $name = (!is_null($json) && isset($params->name)) ? $params->name : null;
        $email = (!is_null($json) && isset($params->email)) ? $params->email : null;
        $password = (!is_null($json) && isset($params->password)) ? $params->password : null;
        $idRole = (!is_null($json) && isset($params->idRole)) ? $params->idRole : null;
        //$token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        //$checkToken = $jwtAuth->checkToken($token);
        //if (is_null($checkToken)) {
        if (!is_null($dni) && !is_null($name) && !is_null($email) && !is_null($password) && !is_null($idRole)) {
            $user = new User();
            $user->dni = $dni;
            $user->name = $name;
            $user->email = $email;
            $user->password = $password;
            $user->idRole = $idRole;
            $user->save();
            $singup = $jwtAuth->singup($email, $password);
            return response()->json($singup, 200);
        } else {
            return response()->json(array('user' => null, 'status' => 'error', 'code' => 400, 'message' => 'Faltan datos'), 200);
        }
        //} else {
        //return response()->json($checkToken, 200);
        //}
    }

    public function createFull(Request $request) {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $idRole = (!is_null($json) && isset($params->idRole)) ? $params->idRole : null;
        $dni = (!is_null($json) && isset($params->dni)) ? $params->dni : null;
        $idGender = (!is_null($json) && isset($params->idGender)) ? $params->idGender : null;
        $idDistrite = (!is_null($json) && isset($params->idDistrite)) ? $params->idDistrite : null;
        $name = (!is_null($json) && isset($params->name)) ? $params->name : null;
        $email = (!is_null($json) && isset($params->email)) ? $params->email : null;
        $date_birth = (!is_null($json) && isset($params->date_birth)) ? $params->date_birth : null;
        $phone = (!is_null($json) && isset($params->phone)) ? $params->phone : null;
        $address = (!is_null($json) && isset($params->address)) ? $params->address : null;
        $password = (!is_null($json) && isset($params->password)) ? $params->password : null;
        $coins = (!is_null($json) && isset($params->coins)) ? $params->coins : null;
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            if (!is_null($idRole) && !is_null($dni) && !is_null($idGender) && !is_null($idDistrite) && !is_null($name) &&
                !is_null($email) && !is_null($date_birth) && !is_null($phone) && !is_null($address) &&
                !is_null($password) && !is_null($coins)) {
                $user = new User();
                $user->idRole = $idRole;
                $user->dni = $dni;
                $user->idGender = $idGender;
                $user->idDistrite = $idDistrite;
                $user->name = $name;
                $user->email = $email;
                $user->date_birth = $date_birth;
                $user->phone = $phone;
                $user->address = $address;
                $user->password = $password;
                $user->coins = $coins;
                $user->save();
                return response()->json(array('user' => $user, 'status' => 'success', 'message' => 'Usuario creado', 'code' => 200), 200);
            } else {
                return response()->json(array('user' => null, 'status' => 'error', 'code' => 400, 'message' => 'Faltan datos'), 200);
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
            $user = User::query()
                ->orderBy('created_at', 'desc')
                ->get();
            return response()->json(array('users' => $user, 'status' => 'success', 'message' => 'Usuarios encontrados', 'code' => 200), 200);
        } else {
            return response()->json($checkToken, 200);
        }
    }

    public function readAdmin(Request $request) {
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            $user = User::query()
                ->where('idRole', '=', 2)
                ->orderBy('created_at', 'desc')
                ->get();
            return response()->json(array('users' => $user, 'status' => 'success', 'message' => 'Administradores encontrados', 'code' => 200), 200);
        } else {
            return response()->json($checkToken, 200);
        }
    }

    public function readId(Request $request) {
        //recuperamos idUser
        $idUser = $request->query('idUser');
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            $user = User::query()->where('id', '=', $idUser)
                ->orderBy('created_at', 'desc')
                ->get();
            return response()->json(array('user' => $user, 'status' => 'success', 'message' => 'Usuario encontrado', 'code' => 200), 200);
        } else {
            return response()->json($checkToken, 200);
        }
    }

    public function update(Request $request, $id) {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $dni = (!is_null($json) && isset($params->dni)) ? $params->dni : null;
        $name = (!is_null($json) && isset($params->name)) ? $params->name : null;
        $email = (!is_null($json) && isset($params->email)) ? $params->email : null;
        $password = (!is_null($json) && isset($params->password)) ? $params->password : null;
        $idRole = (!is_null($json) && isset($params->idRole)) ? $params->idRole : null;
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            if (!is_null($dni) && !is_null($name) && !is_null($email) && !is_null($password) && !is_null($idRole)) {
                $user = User::query()->where('id', $id)->update(['dni' => $dni, 'name' => $name, 'email' => $email, 'password' => $password]);
                if ($user) {
                    return response()->json(array('user' => $user, 'status' => 'success', 'message' => 'Usuario actualizado', 'code' => 200), 200);
                } else {
                    return response()->json(array('user' => null, 'status' => 'error', 'code' => 400, 'message' => 'No se pudo actualizar el usuario'), 200);
                }
            } else {
                return response()->json(array('user' => null, 'status' => 'error', 'code' => 400, 'message' => 'Faltan datos'), 200);
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
            $user = User::query()->where('id', $id)->update(['active' => 0]);
            if ($user) {
                return response()->json(array('user' => $user, 'status' => 'success', 'message' => 'Usuario actualizado', 'code' => 200), 200);
            } else {
                return response()->json(array('user' => null, 'status' => 'error', 'code' => 400, 'message' => 'No se pudo actualizar el usuario'), 200);
            }
        } else {
            return response()->json($checkToken, 200);
        }
    }
}
