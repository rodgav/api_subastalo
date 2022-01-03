<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use App\Models\VendedorSubasta;
use Illuminate\Http\Request;

class VendedorSubastaController extends Controller {
    public function create(Request $request) {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $idSubasta = (!is_null($json) && isset($params->idSubasta)) ? $params->idSubasta : null;
        $nameVendedor = (!is_null($json) && isset($params->nameVendedor)) ? $params->nameVendedor : null;
        $companyVendedor = (!is_null($json) && isset($params->companyVendedor)) ? $params->companyVendedor : null;
        $emailVendedor = (!is_null($json) && isset($params->emailVendedor)) ? $params->emailVendedor : null;
        $address = (!is_null($json) && isset($params->address)) ? $params->address : null;
        $date = (!is_null($json) && isset($params->date)) ? $params->date : null;
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            if (!is_null($idSubasta) && !is_null($nameVendedor) && !is_null($companyVendedor) && !is_null($emailVendedor)
                && !is_null($address) && !is_null($date)) {
                $subasta = new VendedorSubasta();
                $subasta->idSubasta = $idSubasta;
                $subasta->nameVendedor = $nameVendedor;
                $subasta->companyVendedor = $companyVendedor;
                $subasta->emailVendedor = $emailVendedor;
                $subasta->address = $address;
                $subasta->date = $date;
                $subasta->save();
                return response()->json(array('subasta' => $subasta, 'status' => 'success', 'message' => 'Vendedor subasta creado', 'code' => 200), 200);
            } else {
                return response()->json(array('subasta' => null, 'status' => 'error', 'code' => 400, 'message' => 'Faltan datos'), 200);
            }
        } else {
            return response()->json($checkToken, 200);
        }
    }

    public function read(Request $request) {
        //recuperamos idSubasta
        $idSubasta = $request->query('idSubasta');
        $token = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if (is_null($checkToken)) {
            if (!is_null($idSubasta)) {
                $vendedorSubasta = VendedorSubasta::query()
                    ->where('idSubasta', '=', $idSubasta)
                    ->orderBy('created_at', 'desc')
                    ->get();
                return response()->json(array('vendedorSubasta' => $vendedorSubasta, 'status' => 'success', 'message' => 'Vendedor subasta encontrados', 'code' => 200), 200);
            } else {
                return response()->json(array('locationSubasta' => null, 'status' => 'error', 'code' => 400, 'message' => 'Faltan datos'), 200);
            }
        } else {
            return response()->json($checkToken, 200);
        }
    }
}
