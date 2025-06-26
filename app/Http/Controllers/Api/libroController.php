<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class libroController extends Controller
{
    public function index()
    {
        $libros = Libro::all();

        // if ($libros->isEmpty()) {
        //     $data = [
        //         'message' => 'No se encontraron estudiantes'
        //         'status' => '200'
        //     ];
        // }

        $data = [
            'libros' => $libros,
            'status' => 200
        ];

        return response()-> json($data, 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request ->all(), [
            'titulo' => 'required',
            'autor'=> 'required',
            'fecha_publicacion'=> 'required'
        ]);

        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validación de los',
                'errors' => $validator->errors(),
                'status' => 400
            ];
        return response()->json($data, 400);
        }

        $libros = Libro::created([
            'titulo' => $request->titulo,
            'autor' => $request->autor,
            'fecha_publicacion' => $request->fecha_publicacion
        ]);

        if (!$libros){
            $data = [
                'message' => 'Error al crear el esttudiante',
                'status' => 500
            ];
            return response()->json($data,500);
        }

        $data = [
            'libro' => $libros,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

}
