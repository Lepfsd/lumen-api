<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->get('/profesores', 'ProfesorController@index');
$app->post('/profesores', 'ProfesorController@store');
$app->get('/profesores/{profesores}', 'ProfesorController@show');
$app->put('/profesores/{profesores}', 'ProfesorController@update');
$app->patch('/profesores/{profesores}', 'ProfesorController@update');
$app->delete('/profesores/{profesores}', 'ProfesorController@destroy');

$app->get('/estudiantes', 'EstudianteController@index');
$app->post('/estudiantes', 'EstudianteController@store');
$app->get('/estudiantes/{estudiantes}', 'EstudianteController@show');
$app->put('/estudiantes/{estudiantes}', 'EstudianteController@update');
$app->patch('/estudiantes/{estudiantes}', 'EstudianteController@update');
$app->delete('/estudiantes/{estudiantes}', 'EstudianteController@destroy');

$app->get('/cursos', 'CursoController@index');
$app->get('/cursos/{cursos}', 'CursoController@show');

$app->get('/profesores/{profesores}/cursos', 'ProfesorCursoController@index');
$app->post('/profesores/{profesores}/cursos', 'ProfesorCursoController@store');
$app->put('/profesores/{profesores}/cursos/{cursos}', 'ProfesorCursoController@update');
$app->patch('/profesores/{profesores}/cursos/{cursos}', 'ProfesorCursoController@update');
$app->delete('/profesores/{profesores}/cursos/{cursos}', 'ProfesorCursoController@destroy');

$app->get('/cursos/{cursos}/estudiantes', 'CursoEstudianteController@index');
$app->post('/cursos/{cursos}/estudiantes/{estudiantes}', 'CursoEstudianteController@store');
$app->delete('/cursos/{cursos}/estudiantes/{estudiantes}', 'CursoEstudianteController@destroy');


