<?php namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Validator as ValidationValidator;
use PhpParser\Node\Expr\FuncCall;
use Symfony\Contracts\Service\Attribute\Required;

class UsersControllers extends Controller
{
    public function apistore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|',
            'password' => 'required|digits:8',
            
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $users = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
           
        ]);

        if (!$users) {
            $data = [
                'message' => 'Error al crear el usuario',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'uses' => $users,
            'status' => 201
        ];

        return response()->json($data, 201);

    }

}