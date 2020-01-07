<?php

namespace App\Http\Controllers;
use SoapClient;
use Illuminate\Http\Request;


class PruebaController extends Controller
{
    //
    public function index(){
        $cliente = new \SoapClient('http://ittools.tpsouth.corp/Service.svc?wsdl');
    
        $parametros = [
            'userLogin' => 'torresmariotti.5',
            'password' => 'Lm10lt94',
            'encoding' => 'UTF-8',
            'trace' => true
        ];
        
        $resultado = $cliente->ValidateCCMSUser($parametros)->ValidateCCMSUserResult;
        return $resultado;
    }
    

}
