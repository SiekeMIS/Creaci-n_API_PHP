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

        $data = [
            'libros' => $libros,
            'status' => 200
        ];

        return response()-> json($data, 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request ->all(), [
            'titulo' => 'required|max:255',
            'autor'=> 'required|max:255',
            'fecha_publicacion'=> 'required|date'
        ]);

        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validación de los',
                'errors' => $validator->errors(),
                'status' => 400
            ];
        return response()->json($data, 400);
        }

        $libros = Libro::create([
            'titulo' => $request->titulo,
            'autor' => $request->autor,
            'fecha_publicacion' => $request->fecha_publicacion
        ]);

        if (!$libros){
            $data = [
                'message' => 'Error al crear el libro',
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
    public function show($id)
    {
        $libro = Libro::find($id);

        if (!$libro) {
            $data = [
                'message' => 'Libro no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'libro' => $libro,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
    public function delete($id)
    {
        $libro = Libro::find($id);

        if (!$libro) {
            $data = [
                'message' => 'Libro no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $libro->delete();

        $data = [
            'message' => 'Libro eliminado correctamente',
            'status' => 200
        ];

        return response()->json($data, 200);
    }
    public function update(Request $request, $id)
    {
        $libro = Libro::find($id);

        if (!$libro) {
            $data = [
                'message' => 'Libro no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'titulo' => 'required|max:255',
            'autor' => 'required|max:255',
            'fecha_publicacion' => 'required|date'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $libro->titulo = $request->titulo;
        $libro->autor = $request->autor;
        $libro->fecha_publicacion = $request->fecha_publicacion;
        $libro->save();

        $data = [
            'libro' => $libro,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
    public function updatePartial(Request $request, $id)
    {
        $libro = Libro::find($id);

        if (!$libro) {
            $data = [
                'message' => 'Libro no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'titulo' => 'sometimes|required|max:255',
            'autor' => 'sometimes|required|max:255',
            'fecha_publicacion' => 'sometimes|required|date'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('titulo')) {
            $libro->titulo = $request->titulo;
        }
        if ($request->has('autor')) {
            $libro->autor = $request->autor;
        }
        if ($request->has('fecha_publicacion')) {
            $libro->fecha_publicacion = $request->fecha_publicacion;
        }
        
        $libro->save();

        $data = [
            'libro' => $libro,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

}
