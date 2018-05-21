<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehiculo;
use App\Fabricante;

class VehiculoController extends Controller
{
    public function index(){
        return response()->json(['datos'=>Vehiculo::all()],200);
    }
    public function show($serie){
        $vehiculo = Vehiculo::find($serie);
        if($vehiculo)
            return response()->json(['datos'=>$vehiculo],200);
        else
            return response()->json(['error'=>'No se encontro el vehiculo con la serie '.$serie],404);
    }
    public function store(Request $request){
        if(!$request->get('color') || !$request->get('cilindraje') || !$request->get('potencia') || !$request->get('peso') || !$request->get('fabricante_id'))
            return response()->json(['error'=>'No se pudo crear el vehiculo, argumentos incorrectos.'],422);
        $fabricante = Fabricante::find($request->get('fabricante_id'));
        if($fabricante){
            Vehiculo::create($request->all());
            return response()->json(['mensaje'=>'Vehiculo creado correctamente.'],200);
        }
        return response()->json(['error'=>'El fabricante '.$request->get('fabricante_id').' no existe']);    
    }
    public function update(Request $request,$serie){
        $vehiculo = Vehiculo::find($serie);
        if($vehiculo){
            $color = $request->get('color');
            $cilindraje = $request->get('cilindraje');
            $potencia = $request->get('potencia');
            $peso = $request->get('peso');
            $fabricante_id = $request->get('fabricante_id');
            $metodo = $request->method();
            if($metodo == 'PATCH'){
                $algun_cambio = false;
                if($color && $color != ''){
                    $vehiculo->color = $color;
                    $algun_cambio = true;
                }
                if($cilindraje && $cilindraje != ''){
                    $vehiculo->cilindraje = $cilindraje; 
                    $algun_cambio = true; 
                }
                if($potencia && $potencia != ''){
                    $vehiculo->potencia = $potencia;
                    $algun_cambio = true;
                }
                if($peso && $peso != ''){
                    $vehiculo->peso = $peso;
                    $algun_cambio = true;
                }
                if($fabricante_id && $fabricante_id != ''){
                    if(!Fabricante::find($fabricante_id))
                        return response()->json(['error','No se encontro el Fabricante '.$fabricante_id]);
                    $fabricante->fabricante_id = $fabricante_id;
                }
                if($algun_cambio){
                   $vehiculo->save();
                   return response()->json(['mensaje'=>'Vehiculo '.$serie.' actualizado correctamente.'],200); 
                }
                return response()->json(['error'=>'Atributos invalidos.'],422);
            }
            if($color && $cilindraje && $potencia && $peso && $fabricante_id){
                if(!Fabricante::find($fabricante_id))
                    return response()->json(['error'=>'No se encontro el Fabricante '.$fabricante_id],422);
                $vehiculo->color = $color;
                $vehiculo->cilindraje = $cilindraje;
                $vehiculo->potencia = $potencia;
                $vehiculo->peso = $peso;
                $vehiculo->fabricante_id = $fabricante_id;
                $vehiculo->save();
                return response()->json(['mensaje'=>'Vehiculo '.$serie.' actualizado correctamente.'],200);
            }
            return response()->json(['error'=>'Atributos invalidos.'],422);
        }
        return response()->json(['error'=>'No se encontro el vehiculo '.$serie],402);
    }

    public function destroy($serie){
        $vehiculo = Vehiculo::find($serie);
        if(!$vehiculo)
            return response()->json(['error'=>'No se encontro el vehiculo '.$serie],422);
        $vehiculo->delete();
        return response()->json(['mensaje'=>'El vehiculo '.$serie.' fue eliminad exitosamente. '],200);
    }
}
