<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profesor;
use App\Curso; 

class ProfesorCursoController extends Controller
{   

     public function __construct()
    {
      $this->middleware('oauth2', ['except' => ['index']]);
    } 
    
    public function index($profesor_id)
    {
      $profesor = Profesor::find($profesor_id);
      
      if($profesor){
        $cursos = $profesor->cursos;
        return $this->crearRespuesta($cursos, 200);
      }
      return $this->crearRespuestaError('No se puede encontrar el prof con el id', 404);   
    }

    public function store(Request $request, $profesor_id)
    {
      $profesor = Profesor::find($profesor_id);
      if($profesor){
        $this->validacion($request);
        $campos = $request->all();
        $campos['profesor_id'] = $profesor_id;
        Curso::create($campos);
        return $this->crearRespuesta('el curso ha sido creado satisfactoriamente', 200);
      } 
      return $thi->crearRespuestaError('No existe un profesor con el id dado', 404); 
    }

    public function update(Request $request, $profesor_id, $curso_id)
    {
      $profesor = Profesor::find($profesor_id);
      if($profesor){
        $curso = Curso::find($curso_id);
        if($curso){
          $this->validacion($request);
          $curso->titulo = $request->get('titulo');
          $curso->descripcion = $request->get('descripcion');
          $curso->valor = $request->get('valor');
          $curso->profesor_id = $profesor_id;
          $curso->save();
          return $this->crearRespuesta('el curso se ha actualizado', 200);
        }
        return $this->crearRespuestaError('no existe un curso con el id dado', 404);
      }
      return $this->crearRespuestaError('no existe un profesor con el id dado', 404);
    }

    public function destroy($profesor_id, $curso_id)
    {
      $profesor = Profesor::find($profesor_id);
      if($profesor){
        $cursos = $profesor->cursos();
        if($cursos->find($curso_id)){
          $curso = Curso::find($curso_id);
          $curso->estudiantes()->detach();
          $curso->delete();
          return $this->crearRespuesta('curso eliminado', 200);
        }
        return $this->crearRespuestaError('no existe un curso con el id dado', 404);
      }
      return $this->crearRespuestaError('no existe un prof con el id dado', 404);
    }

    public function validacion($request)
    {
      $reglas = [
        'titulo' => 'required',
        'descripcion' => 'required',
        'valor' => 'required|numeric'
      ];
      $this->validate($request, $reglas);
    }
}