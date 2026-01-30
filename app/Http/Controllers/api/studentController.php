<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//NI modo, vamos a adaptar este controller para devolver las vistas en blade ahora jeje
class studentController extends Controller
{
    // Listado de estudiantes devuelto en blade
    public function index()
    {
        $students = Estudiante::all();
        return view('estudiantes.index', compact('students'));
    }

    // Formulario de creación
    public function create()
    {
        return view('estudiantes.create');
    }

    // Guardar nuevo estudiante
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:student',
            'phone' => 'required|digits:10',
            'language' => 'required|in:English,Spanish,French'
        ]);

        Estudiante::create($request->all());

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante creado con éxito');
    }

    // Formulario de edición
    public function edit($id)
    {
        $student = Estudiante::findOrFail($id);
        return view('estudiantes.edit', compact('student'));
    }

    // Actualizar estudiante
    public function update(Request $request, $id)
    {
        $student = Estudiante::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:student,email,'.$id,
            'phone' => 'required|digits:10',
            'language' => 'required|in:English,Spanish,French',
        ]);

        $student->update($request->all());

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante actualizado');
    }

    // Eliminar estudiante
    public function destroy($id)
    {
        $student = Estudiante::findOrFail($id);
        $student->delete();

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante eliminado');
    }
}
