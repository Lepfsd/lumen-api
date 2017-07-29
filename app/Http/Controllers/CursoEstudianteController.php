<?php

namespace App\Http\Controllers;

use App\Curso;
use App\Estudiante;

class CursoEstudianteController extends Controller
{   

    public function __construct()
    {
      $this->middleware('oauth2', ['except' => ['index']]);
    }  
    
    public function index($curso_id)
    {
      $curso = Curso::find($curso_id);

      if($curso){
        $estudiantes = $curso->estudiantes;
        return $this->crearRespuesta($estudiantes, 200);
      }
      return $this->crearRespuestaError('No se puede encontrar el curso con el id', 404);  
    }

    public function show($curso_id, $estudiante_id)
    {
      $curso = Curso::find($curso_id);
      if($curso){
        $estudiante = Estudiante::find($estudiante_id);
        if($estudiante){
          $estudiantes = $curso->estudiantes();
          if($estudiantes->find($estudiante_id)){
            return $this->crearRespuesta('el estudiante ya existe en el curso', 409);
          }
          $curso->estudiantes()->attach($estudiante_id);
          return $this->crearRespuesta('el estudiante ha sido agregado al curso', 201);
        }
        return $this->crearRespuestaError('no se puede encontrar el estudiante con el id dado', 404);
      }
      return $this->crearRespuestaError('no se puede encontrar un curso con el id dado', 404);
    }

    public function destroy($curso_id, $estudiante_id)
    {
      $curso = Curso::find($curso_id);
      if($curso){
        $estudiantes = $curso->estudiantes();
        if($estudiantes->find($estudiante_id)){
          $estudiantes->detach($estudiante_id);
          return $this->crearRespuesta('El estudiante se elimino', 200);
        }
        return $this->crearRespuestaError('no existe un estudiante con el id dado', 404); 
      }
      return $this->crearRespuestaError('no se puede encontrar un estudiante con el id dado', 404);
    }
}