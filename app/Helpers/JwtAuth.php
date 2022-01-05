<?php

namespace App\Helpers;

use App\Models\TokenSession;
use App\Models\User;
use Firebase\JWT\JWT;

class JwtAuth {
    public $key;

    /**
     * JwtAuth constructor.
     * @param $key
     */
    public function __construct() {
        $this->key = 'esta-es-una-clave-secreta';
    }

    public function singup($email, $password) {
        $user = User::query()->where(array('email' => $email, 'password' => $password))->first();
        if (is_object($user)) {
            //generar token y devolverlo
            $token = array('id' => $user->id,
                'name' => $user->name,
                'role' => $user->idRole,
                'iat' => time(),
                'exp' => time() + (7 * 24 * 60 * 60));
            $jwt = JWT::encode($token, $this->key, 'HS256');
            $tokensSession = new TokenSession();
            $tokensSession->idUser = $user->id;
            $tokensSession->token = $jwt;
            $tokensSession->save();
            return array('status' => 'success', 'message' => 'Login correcto', 'code' => 200, 'jwt' => $jwt);
        } else {
            //devolver un error
            return array('status' => 'error', 'message' => 'Login ha fallado', 'code' => 400, 'jwt' => null);
        }
    }

    public function checkToken($jwt): ?array {
        try {
            $decode = JWT::decode($jwt, $this->key, array('HS256'));
            if (is_object($decode) && isset($decode->id)) {
                $token = TokenSession::query()->where(array('token' => $jwt))->first();
                if (!is_null($token)) {
                    $today = time();
                    if ($decode->exp <= $today) {
                        return array('status' => 'error', 'message' => 'Token expiro', 'code' => 400);
                    } else {
                        return null;
                    }
                } else {
                    return array('status' => 'error', 'message' => 'Token no encontrado', 'code' => 401);
                }
            } else {
                return array('status' => 'error', 'message' => 'Token invalido', 'code' => 401);
            }
        } catch (\UnexpectedValueException|\DomainException $e) {
            return array('status' => 'error', 'message' => 'Token invalido', 'code' => 401);
        }
    }

    public function refresh($jwt): array {
        try {
            $decode = JWT::decode($jwt, $this->key, array('HS256'));
            if (is_object($decode) && isset($decode->id)) {
                $token = TokenSession::query()->where(array('token' => $jwt))->first();
                if (!is_null($token)) {
                    $tokenRefresh = array('id' => $decode->id,
                        'name' => $decode->name,
                        'role' => $decode->role,
                        'iat' => time(),
                        'exp' => time() + (7 * 24 * 60 * 60));
                    $jwtRefresh = JWT::encode($tokenRefresh, $this->key, 'HS256');
                    TokenSession::query()->where(array('token' => $jwt))->update(['idUser' => $decode->id, 'token' => $jwtRefresh]);
                    return array('status' => 'success', 'message' => 'Token refrescado', 'code' => 200, 'jwt' => $jwtRefresh);
                } else {
                    return array('status' => 'error', 'message' => 'Token no encontrado', 'code' => 401, 'jwt' => null);
                }
            } else {
                return array('status' => 'error', 'message' => 'Token invalido', 'code' => 401, 'jwt' => null);

            }
        } catch (\UnexpectedValueException|\DomainException $e) {
            return array('status' => 'error', 'message' => 'Token invalido', 'code' => 401, 'jwt' => null);
        }
    }
    public function decode($jwt): ?object {
        try{
            return JWT::decode($jwt, $this->key, array('HS256'));
        }catch (\Exception $e){
            return null;
        }
    }
}
