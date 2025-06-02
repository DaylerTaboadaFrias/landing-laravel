<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Usuario;
use App\Models\Rol;
use DB;
use Validator;

class UsuarioController extends Controller
{
   
    public function __construct()
    {
   
    }

    
    public function index()
    {
        return view('usuario.index');
    }

    public function listarUsuario(Request $request)
    {
        $search = $request->input('search');
        $usuarios = Usuario::filtroUsuario($search);
        $view = view('usuario.item-usuario',['usuarios'=>$usuarios]);
        return Response($view);
    }


    public function eliminarUsuario(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            Usuario::eliminarUsuario($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Usuario eliminado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



    public function registrar()
    {
        $roles = Rol::getRoles();
        return view('usuario.registrar',['roles'=>$roles]);
    }


    public function registrarUsuario(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required',
            'apellidos' => 'required',
            'correo' => 'required',
            'nombre_usuario' => 'required',
            'password' => 'required',
            'habilitado' => 'required',
            'id_rol' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            Usuario::registrarUsuario(
                $request->nombres,
                $request->apellidos,
                $request->correo,
                $request->nombre_usuario,
                $request->password,
                $request->habilitado,
                $request->id_rol
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Usuario registrado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }

    public function actualizarUsuario(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nombres' => 'required',
            'apellidos' => 'required',
            'correo' => 'required',
            'nombre_usuario' => 'required',
            'password' => 'required',
            'habilitado' => 'required',
            'id_rol' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            Usuario::actualizarUsuario(
                $request->id,
                $request->nombres,
                $request->apellidos,
                $request->correo,
                $request->nombre_usuario,
                $request->password,
                $request->habilitado,
                $request->id_rol
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Usuario actualizado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }

    public function editar($id_usuario)
    {
        $roles = Rol::getRoles();
        $usuario = Usuario::findOrFail($id_usuario);
        return view('usuario.editar',['roles'=>$roles,'usuario'=>$usuario]);
    }


}
