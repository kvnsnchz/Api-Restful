<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fabricante;

class FabricanteVehiculoController extends Controller
{
    public function index($id){
        $fabricante = Fabricante::find($id);
        if($fabricante){
            $vehiculos = $fabricante->vehiculos;
            return response()->json(['datos'=>$vehiculos],200);
        }
        else
            return response()->json(['error'=>'No se encontro un fabricante con el id '.$id],404);
    }    
}
