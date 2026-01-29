<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//Este controller tendra los metodos o funciones cuando se visite esta URL

class studentController extends Controller
{
    public function index(){
        $estudiantes = Estudiante::all();

        if($estudiantes->isEmpty()){
            $data = [
                'message' => 'No se encontraron estudiantes',
                'status' => 200
            ];
            return response()->json($data, 404);
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:student',
            'phone' => 'required|digits:10',
            'language' => 'required|in:English, Spanish, French'
        ]);

        if($validator ->fails()){
            $data= [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $student = Estudiante::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'language' => $request->language,
        ]);

        if(!$student){
            $data = [
                'message' => 'Error al crear el estudiante',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'student' => $student,
            'status' => 201
        ];

        return response()->json($data, 201);
    }
}
