<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class LibroController extends Controller // Cambiado a PascalCase
{
    /**
     * Listar todos los libros
     */
    public function index()
    {
        $libros = Libro::all();
        
        return response()->json([
            'success' => true,
            'data' => $libros,
            'message' => 'Libros obtenidos correctamente'
        ]);
    }

    /**
     * Crear un nuevo libro
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'fecha_publicacion' => 'required|date' // Cambiado a formato estándar
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422); // Código 422 para errores de validación
        }

        $libro = Libro::create([
            'titulo' => $request->titulo,
            'autor' => $request->autor,
            'fecha_publicacion' => $request->fecha_publicacion // Ya no es necesaria conversión
        ]);

        return response()->json([
            'success' => true,
            'data' => $libro,
            'message' => 'Libro creado exitosamente'
        ], 201);
    }

    /**
     * Mostrar un libro específico
     */
    public function show($id)
    {
        $libro = Libro::find($id);

        if (!$libro) {
            return response()->json([
                'success' => false,
                'message' => 'Libro no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $libro,
            'message' => 'Libro obtenido correctamente'
        ]);
    }

    /**
     * Eliminar un libro (REST standard: destroy)
     */
    // Cambia el nombre del método de delete() a destroy()
    public function delete($id)
    {
        $libro = Libro::find($id);

        if (!$libro) {
            return response()->json([
                'success' => false,
                'message' => 'Libro no encontrado'
            ], 404);
        }

        $libro->delete();

        return response()->json([
            'success' => true,
            'message' => 'Libro eliminado correctamente',
            'status' => 200
        ]);
    }
    /**
     * Actualización completa de un libro
     */
    public function update(Request $request, $id)
    {
        $libro = Libro::find($id);

        if (!$libro) {
            return response()->json([
                'success' => false,
                'message' => 'Libro no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'fecha_publicacion' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $libro->update([
            'titulo' => $request->titulo,
            'autor' => $request->autor,
            'fecha_publicacion' => $request->fecha_publicacion
        ]);

        return response()->json([
            'success' => true,
            'data' => $libro,
            'message' => 'Libro actualizado correctamente'
        ]);
    }

    /**
     * Actualización parcial de un libro
     */
    public function updatePartial(Request $request, $id)
    {
        $libro = Libro::find($id);

        if (!$libro) {
            return response()->json([
                'success' => false,
                'message' => 'Libro no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'titulo' => 'sometimes|required|string|max:255',
            'autor' => 'sometimes|required|string|max:255',
            'fecha_publicacion' => 'sometimes|required|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $libro->update($request->only(['titulo', 'autor', 'fecha_publicacion']));

        return response()->json([
            'success' => true,
            'data' => $libro,
            'message' => 'Libro actualizado parcialmente'
        ]);
    }
}