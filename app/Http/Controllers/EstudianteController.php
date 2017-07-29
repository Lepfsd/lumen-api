<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estudiante;

class EstudianteController extends Controller
{   

     public function __construct()
    {
      $this->middleware('oauth2', ['except' => ['index', 'show']]);
    }     
    
    public function index()
    {
      $estudiantes = Estudiante::all();
      return $this->crearRespuesta($estudiantes, 200);
      
    }

    public function show($id)
    {
      $estudiante = Estudiante::find($id);

      if($estudiante){
        return $this->crearRespuesta($estudiante, 200);
      }
      else {
        return $this->crearRespuestaError('estudiante no encontrado', 404);
      }
    }

    public function store(Request $request)
    {
      $this->validacion($request);
      Estudiante::create($request->all());
      return $this->crearRespuesta('el estudiante ha sido creado', 201);
    }

    public function update(Request $request, $estudiante_id)
    {
      $estudiante = Estudiante::find($estudiante_id);
      if($estudiante){
        $this->validacion($request);
        $nombre = $request->get('nombre');
        $direccion = $request->get('direccion');
        $telefono = $request-> get('telefono');
        $carrera = $request->get('carrera');
        $estudiante->nombre = $nombre;
        $estudiante->direccion = $direccion;
        $estudiante->telefono = $telefono;
        $estudiante->carrera = $carrera;
        $estudiante->save();
        return $this->crearRespuesta("el estudiante $estudiante->id ha sido editado", 200); 
      }
      return $this->crearRespuestaError('el id especificado no se encuentra', 404);
    }

    public function destroy($estudiante_id)
    {
      $estudiante = Estudiante::find($estudiante_id);
      if($estudiante){
        $estudiante->cursos()->sync([]);
        $estudiante->delete();
        return $this->crearRespuesta('el estudiante ha sido eliminado', 200);
      }
      return crearRespuestaError('no existe el estudiante con el id especificado', 404);
    }

    public function validacion($request)
    {
      $reglas = [
        'nombre' => 'required',
        'direccion' => 'required',
        'telefono' => 'required|numeric',
        'carrera' => 'required|in:ingenieria,matematica,fisica',
      ];
      $this->validate($request, $reglas);
    }
}