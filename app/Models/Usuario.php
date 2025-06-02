<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class Usuario extends Model
{
    public $table = 'usuario';
    public $primaryKey = 'id';
    public $timestamps = true;
    public $incrementing = true;
    public $fillable = [
        'nombres',
        'apellidos',
        'correo',
        'nombre_usuario',
        'correo',
        'password',
        'habilitado',
        'eliminado',
        'id_rol'
    ];

    public static function obtenerUsuarioPorLogin($nombre_usuario,$password)
    {
        return DB::table('usuario')
            ->join('rol','usuario.id_rol','=','rol.id')
            ->select(
                'usuario.id',
                'usuario.nombres',
                'usuario.apellidos',
                'usuario.nombre_usuario',
                'usuario.id_rol',
                'rol.nombre as nombre_rol'
            )
            ->where('usuario.habilitado', true)
            ->where('usuario.eliminado', false)
            ->where('usuario.nombre_usuario', $nombre_usuario)
            ->where('usuario.password', $password)
            ->first();
    }

    public static function filtroUsuario($search)
    {
        $query = DB::table('usuario')
            ->join('rol', 'usuario.id_rol', '=', 'rol.id')
            ->select(
                'usuario.id',
                'usuario.nombres',
                'usuario.apellidos',
                'usuario.nombre_usuario',
                'usuario.correo',
                'usuario.habilitado',
                'rol.nombre as nombre_rol'
            )
            ->where('usuario.eliminado', false);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('usuario.id', $search)
                  ->orWhereRaw('LOWER(usuario.nombres) LIKE LOWER(?)', ["%$search%"])
                  ->orWhereRaw('LOWER(usuario.apellidos) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('usuario.id', 'desc')->get();
    }


    public static function obtenerUsuarioPorNombreUsuario($nombre_usuario)
    {
        return DB::table('usuario')
            ->select(
                'usuario.*'
            )
            ->where('usuario.eliminado', false)
            ->where('usuario.nombre_usuario', $nombre_usuario)
            ->first();
    }


    public static function obtenerUsuarioPorCorreo($correo)
    {
        return DB::table('usuario')
            ->select(
                'usuario.*'
            )
            ->where('usuario.eliminado', false)
            ->where('usuario.correo', $correo)
            ->first();
    }



    public static function obtenerUsuarioPorTokenYCodigo($token,$codigo)
    {
        return DB::table('usuario')
            ->select(
                'usuario.*'
            )
            ->where('usuario.eliminado', false)
            ->where('usuario.token_recuperacion_password', $token)
            ->where('usuario.codigo_recuperacion_password', $codigo)
            ->first();
    }


    public static function getNroUsuarios()
    {
        $query = DB::table('usuario')
            ->select(
                'usuario.id'
            )
            ->where('usuario.eliminado', false);
        return $query->count();
    }


    public static function getUsuarioPorNombreUsuario($nombre_usuario)
    {
        $query = DB::table('usuario')
            ->select(
                'usuario.id'
            )
            ->where('usuario.eliminado', false)
            ->where('usuario.nombre_usuario', $nombre_usuario);
        return $query->first();
    }


    public static function getUsuarioPorNombreUsuarioDiferente($id,$nombre_usuario)
    {
        $query = DB::table('usuario')
            ->select(
                'usuario.id'
            )
            ->where('usuario.eliminado', false)
            ->where('usuario.nombre_usuario', $nombre_usuario)
            ->where('usuario.id', '<>', $id);
        return $query->first();
    }
    


    public static function verificarLogin($nombre_usuario,$password)
    {
        $usuario = Usuario::obtenerUsuarioPorLogin($nombre_usuario,$password);
        if(!$usuario){
            throw new \Exception("Los datos ingresados son incorrectos. Verifique su nombre de usuario y contraseña e inténtelo nuevamente.");
        }
        Session::put('data', $usuario);
        return $usuario;
    }


    public static function registrarUsuario($nombres,$apellidos,$correo,$nombre_usuario,$password,$habilitado,$id_rol)
    {
        $nombreUsuario = Usuario::getUsuarioPorNombreUsuario($nombre_usuario);
        if ($nombreUsuario) {
            throw new \Exception("El nombre de usuario ".$nombre_usuario." ya se encuentra en uso.");
        }

        $usuario = new Usuario;
        $usuario->nombres = $nombres;
        $usuario->apellidos = $apellidos;
        $usuario->correo = $correo;
        $usuario->nombre_usuario = $nombre_usuario;
        $usuario->password = $password;
        $usuario->habilitado = $habilitado;
        $usuario->id_rol = $id_rol;
        $usuario->eliminado = false;
        $usuario->save();

        return $usuario;
    }

    public static function actualizarUsuario($id,$nombres,$apellidos,$correo,$nombre_usuario,$password,$habilitado,$id_rol)
    {
        $nombreUsuario = Usuario::getUsuarioPorNombreUsuarioDiferente($id,$nombre_usuario);
        if ($nombreUsuario) {
            throw new \Exception("El nombre de usuario ".$nombre_usuario." ya se encuentra en uso.");
        }


        $usuario = Usuario::findOrFail($id);
        $usuario->nombres = $nombres;
        $usuario->apellidos = $apellidos;
        $usuario->correo = $correo;
        $usuario->nombre_usuario = $nombre_usuario;
        if($password!="" && $password!=null){
            $usuario->password = $password;
        }
        $usuario->habilitado = $habilitado;
        $usuario->id_rol = $id_rol;
        $usuario->save();

        return $usuario;
    }


    public static function eliminarUsuario($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->eliminado = true;
        $usuario->save();

        return $usuario;
    }



    public static function cerrarSesion()
    {
        Session::forget('data');
        return true;
    }


    public static function enviarCodigoRecuperacion($nombre_usuario)
    {
        $usuario = Usuario::obtenerUsuarioPorNombreUsuario($nombre_usuario);
        if(!$usuario){
          throw new \Exception("No se ha encontrado ninguna cuenta asociada a este nombre de usuario.");
        }
        $usuario = Usuario::generarCodigoRecuperacionPassword($usuario->id);
        Mail::send('email.recuperar-password', 
            ['codigo' => $usuario->codigo_recuperacion_password, 'token' => $usuario->token_recuperacion_password], 
            function($message) use ($usuario) {
                $message->to($usuario->correo, $usuario->nombres . ' ' . $usuario->apellidos)
                    ->subject('Recuperación de contraseña')
                    ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });
        $data = [
            'token' => $usuario->token_recuperacion_password,
            'correo' => $usuario->correo,
            'nombre_usuario' => $usuario->nombre_usuario
        ];
        return $data;
    }

    public static function generarCodigoRecuperacionPassword($id_usuario)
    {
        $usuario = Usuario::findOrFail($id_usuario);
        $usuario->codigo_recuperacion_password = Usuario::generarNumeroAleatorio(4);
        $usuario->token_recuperacion_password = Usuario::generarHashAlfanumerico(24);
        $usuario->save();

        return $usuario;
    }




    public static function obtenerUsuarioPorToken($token)
    {
        return DB::table('usuario')
            ->select(
                'usuario.*'
            )
            ->where('usuario.eliminado', false)
            ->where('usuario.token_recuperacion_password', $token)
            ->first();
    }



    public static function generarTokenPorCorreo($correo)
    {
        $usuario = Usuario::obtenerUsuarioPorCorreo($correo);
        if(!$usuario){
          throw new \Exception("No se ha encontrado ninguna cuenta asociada a este correo electrónico.");
        }
        $usuario = Usuario::generarToken($usuario->id);
        return $usuario->token_recuperacion_password;   
    }


    public static function generarToken($id_usuario)
    {
        $usuario = Usuario::findOrFail($id_usuario);
        $usuario->token_recuperacion_password = Usuario::generarHashAlfanumerico(24);
        $usuario->save();

        return $usuario;
    }

    public static function validarCodigoRecuperacion($token,$codigo)
    {
        $usuario = Usuario::obtenerUsuarioPorTokenYCodigo($token,$codigo);
        if(!$usuario){
          throw new \Exception("El código ingresado es incorrecto.");
        }
        return $usuario; 
    }

    public static function actualizarNuevoPassword($token,$password,$confirmacion_password)
    {
        $usuario = Usuario::obtenerUsuarioPorToken($token);
        if(!$usuario){
          throw new \Exception("Token es incorrecto.");
        }
        if($password!=$confirmacion_password){
          throw new \Exception("Las contraseñas ingresadas no coinciden. Por favor, verifica que ambas contraseñas sean idénticas para completar el proceso de recuperación de tu contraseña.");
        }
        Usuario::updatePasswordPorId($usuario->id,$password);
        Usuario::quitarCodigoRecuperacionPassword($usuario->id);
        return $usuario; 
    }

    public static function updatePasswordPorId($id_usuario,$password)
    {
        $usuario = Usuario::findOrFail($id_usuario);
        $usuario->password = $password;
        $usuario->save();
        return $usuario;
    }

    public static function quitarCodigoRecuperacionPassword($id_usuario)
    {
        $usuario = Usuario::findOrFail($id_usuario);
        $usuario->codigo_recuperacion_password = null;
        $usuario->token_recuperacion_password = null;
        $usuario->save();

        return $usuario;
    }


    public static function generarNumeroAleatorio($digitos) {
        $min = pow(10, $digitos - 1); 
        $max = pow(10, $digitos) - 1;
        return rand($min, $max);
    }

    public static function generarHashAlfanumerico($longitud) {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyz';
        $longitudConjunto = strlen($caracteres);
        $hash = '';

        for ($i = 0; $i < $longitud; $i++) {
            $hash .= $caracteres[rand(0, $longitudConjunto - 1)];
        }
        return $hash;
    }


}
