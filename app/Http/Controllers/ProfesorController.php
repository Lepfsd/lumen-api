<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profesor;

class ProfesorController extends Controller
{
    
     public function __construct()
    {
      $this->middleware('oauth2', ['except' => ['index', 'show']]);
    } 

    public function index()
    {
      $profesores = Profesor::all();
      return $this->crearRespuesta($profesores, 200);
      
    }

    public function show($id)
    {
      $profesor = Profesor::find($id);

      if($profesor){
        return $this->crearRespuesta($profesor, 200);
      }
      else {
        return $this->crearRespuestaError('profesor no encontrado', 404);
      }
    }

    public function store(Request $request)
    {
      $this->validacion($request);
      Profesor::create($request->all());
      return $this->crearRespuesta('el profesor ha sido creado', 201);
    }

    public function update(Request $request, $profesor_id)
    {
      $profesor = Profesor::find($profesor_id);
      if($profesor){
        $this->validacion($request);
        $nombre = $request->get('nombre');
        $direccion = $request->get('direccion');
        $telefono = $request-> get('telefono');
        $profesion = $request->get('profesion');
        $profesor->nombre = $nombre;
        $profesor->direccion = $direccion;
        $profesor->telefono = $telefono;
        $profesor->profesion = $profesion;
        $profesor->save();
        return $this->crearRespuesta("el profesor $profesor->id ha sido editado", 200); 
      }
      return $this->crearRespuestaError('el id especificado no se encuentra', 404);
    }

    public function destroy($profesor_id)
    {
      $profesor = Profesor::find($profesor_id);
      if($profesor){
        if(sizeof($profesor->cursos) > 0){
          return $this->createRespuestaError('el prof tiene cursos asociados', 409);
        }
        $profesor->delete();
        return $this->crearRespuesta('el profesor ha sido eliminado', 200);
      }
      return $this->createRespuestaError('el prof no existe', 404);
    }

    public function validacion($request)
    {
      $reglas = [
        'nombre' => 'required',
        'direccion' => 'required',
        'telefono' => 'required|numeric',
        'profesion' => 'required|in:ingenieria,matematica,fisica',
      ];
      $this->validate($request, $reglas);
    }
}