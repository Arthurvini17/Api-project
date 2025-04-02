<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        //retorna os dados paginados, pelo id em ordem decrescente
        $users = User::orderBy('id', 'DESC')->paginate(2);

        //retorna os usuarios em json
        return response()->json([
            'message' => 'listando usuarios',
            'users' => $users,
        ], 200);
    }

    //listando apenas um usuario
    public function show(User $user): JsonResponse
    {
        return response()->json([
            'status' => true,
            'user' => $user,
        ]);
    }

    public function store(UserRequest $request)
    {
        //usando trycatch para excpetion de errors
        try {
            //inicia o create passando o request
            $user =  User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            //Caso seja criado ele cria o usuario e retorna uma mensagem de usuario criado com o verbo http 201,
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => "usuario cadastrado com sucesso"
            ], 201);
            //Caso de error ele captura o erro e envia uma mensagem de erro com o status http 400
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Não foi possivel adicionar o usuario'
            ], 400);
        }
    }


    public function update(UserRequest $request, User $user): JsonResponse
    {
        //edita o usuario de acordo com os inputs solicitado
       try {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        //caso o usuario seja editado ele retorna uma mensagem de sucesso
        return response()->json([
            'status' => true,
            'message' => 'usuario editado com sucesso',
        ], 200);

        //caso o erro caia no catch retorna um erro 
       } catch (Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Não foi possivel editar o usuario',
            'error' => $e->getMessage(),
        ], 400);
       }
    }


    //excluindo usuario do banco de dados

    public function destroy(User $user) : JsonResponse{
        try {
            $user->delete();

            return response()->json(null, 204);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Usuario NÃO foi apagado',
                'error' => $e->getMessage(),
            ],400);
        }
    }
}
