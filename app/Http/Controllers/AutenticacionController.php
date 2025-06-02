<?php

namespace App\Http\Controllers;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use DB;
use App\Models\Usuario;

class AutenticacionController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function login()
    {
        if (Session::get('data',null)){
            return redirect('/inicio');
        }else{
            return view('autenticacion.login');
        }
    }


    public function loginUsuario(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_usuario' => 'required|string|max:255',
            'password' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            Usuario::verificarLogin(
                $request->nombre_usuario,
                $request->password
            );
            return response()->json(['success' => true, 'message' => 'Consulta realizada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }  


    public function cerrarSessionUsuario(Request $request)
    {
        try {
            Usuario::cerrarSesion();
            return response()->json(['success' => true, 'message' => 'Sesión cerrada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }


    public function recuperarPassword()
    {
        return view('autenticacion.recuperar-password');
    }


    public function generarCodigoRecuperacion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_usuario' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            $data = Usuario::enviarCodigoRecuperacion(
                $request->nombre_usuario
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Correo de recuperación de contraseña enviada correctamente', 'data'=>$data]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }


    public function codigoRecuperacion($token)
    {   
        $usuario = Usuario::obtenerUsuarioPorToken($token);
        if($usuario){
            $token = Usuario::generarTokenPorCorreo($usuario->correo);
            return view('autenticacion.codigo-recuperacion',['token'=>$token,'correo'=>$usuario->correo,'nombre_usuario'=>$usuario->nombre_usuario]);
        }else{
            return redirect('/login');
        }
    }
    

    public function validarCodigoRecuperacion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string|max:255',
            'codigo' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            $usuario = Usuario::validarCodigoRecuperacion(
                $request->token,
                $request->codigo
            );
            $token = Usuario::generarTokenPorCorreo($usuario->correo);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Código validado correctamente', 'data'=>$token]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }


    public function resetearPassword($token)
    {
        $usuario = Usuario::obtenerUsuarioPorToken($token);
        if($usuario){
            $token = Usuario::generarTokenPorCorreo($usuario->correo);
            return view('autenticacion.resetear-password',['token'=>$token,'email'=>$usuario->correo]);
        }else{
            return redirect('/login');
        }
    }
    

    public function actualizarNuevoPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string|max:255',
            'password' => 'required|string|min:4|max:255',
            'confirmacion_password' => 'required|string|min:4|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            $asociado = Usuario::actualizarNuevoPassword(
                $request->token,
                $request->password,
                $request->confirmacion_password
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Contraseña recuperada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }


}
