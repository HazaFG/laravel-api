<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//Este controller tendra los metodos o funciones cuando se visiten mis rutas

class studentController extends Controller
{
    // GET de todos los estudiantes
    public function index(){
        $estudiantes = Estudiante::all();

        $data = [
            'students' => $estudiantes,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    //POST de los estudiantes
    public function store(Request $request){

        //Validaciones para el formulario de registro de usuarios
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:student',
            'phone' => 'required|digits:10',
            'language' => 'required|in:English, Spanish, French'
        ]);

        //Catch por si hay algun error en la validacion de los datos
        if($validator ->fails()){
            $data= [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        //Y si no, pues aqui jeje
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

    // GET por id jeje
    public function show($id){
        $student = Estudiante::find($id);

        if(!$student){
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'student' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    //DELETE
    public function destroy($id){
        $student = Estudiante::find($id);

        //Si no existe el estudiando aqui voy a crear un arreglo que devolvere como json para decir que no fue encontrado el estudiante
        if(!$student){
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        //Aqui pues se hace el delete xd
        $student->delete();

        //Arreglo para mandar como json
        $data = [
            'message' => 'Estudiante eliminado correctamente',
            'status' => 200
        ];

        //Respuesta status 200
        return response()->json($data, 200);
    }

    //UPDATE
    public function update(Request $request, $id){
        $student = Estudiante::find($id);

        if(!$student){
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:student,email,'.$id,
            'phone' => 'required|digits:10',
            'language' => 'required|in:English,Spanish,French',
        ]);

        if($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->language = $request->language;

        $student->save();

        $data = [
            'student' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
