<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fabricante;

class FabricanteController extends Controller
{
    /**
     * Display a listing of the fabricantes.
     * 
     * @return Response
     */
    public function index(){
        return response()->json(['datos'=>Fabricante::all()],200);
    }
    public function show($id){
        $fabricante = Fabricante::find($id);
        if($fabricante)
            return response()->json(['datos'=>$fabricante],200);
        else
            return response()->json(['error'=>'No se encontro el fabricante con id '.$id],400);
    }
    public function store(Request $request){
        if(!$request->get('nombre') || !$request->get('telefono'))
            return response()->json(['error'=>'No se pudo crear el fabricante, argumentos incorrectos.'],422);
        Fabricante::create($request->all());
        return response()->json(['mensaje'=>'Fabricante creado correctamente.'],200);
    }
    public function update(Request $request,$id){
        $fabricante = Fabricante::find($id);
        if($fabricante){
            $nombre = $request->get('nombre');
            $telefono = $request->get('telefono');
            $metodo = $request->method();
            if($metodo == 'PATCH'){
                $algun_cambio = false;
                if($nombre && $nombre != ''){
                    $fabricante->nombre = $nombre;
                    $algun_cambio = true;
                }
                if($telefono && $telefono != ''){
                    $fabricante->telefono = $telefono; 
                    $algun_cambio = true; 
                }
                if($algun_cambio){
                   $fabricante->save();
                   return response()->json(['mensaje'=>'Fabricante '.$id.' actualizado correctamente.'],200); 
                }
                return response()->json(['error'=>'Atributos invalidos.'],422);
            }
            if($nombre && $telefono){
                $fabricante->nombre = $nombre;
                $fabricante->telefono = $telefono;
                $fabricante->save();
                return response()->json(['mensaje'=>'Fabricante '.$id.' actualizado correctamente.'],200);
            }
            return response()->json(['error'=>'Atributos invalidos.'],422);
        }
        return response()->json(['error'=>'No se encontro el fabricante '.$id],402);
    }
    public function destroy($id){
        $fabricante = Fabricante::find($id);
        if(!$fabricante)
            return response()->json(['error'=>'No se encontro el fabricante '.$id],422);
        if(sizeof($fabricante->vehiculos)>0)
            return response()->json(['error'=>'El fabricante '.$id.' posee vehiculos asociados a el, elimine primero estos vehiculos.'],422); 
        $fabricante->delete();
        return response()->json(['mensaje'=>'El fabricante '.$id.' fue eliminad exitosamente. '],200);
    }
}
