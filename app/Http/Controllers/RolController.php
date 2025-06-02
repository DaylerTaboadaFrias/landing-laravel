<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Rol;
use App\Models\Permiso;
use App\Models\RolPermiso;
use DB;
use Validator;

class RolController extends Controller
{
   
    public function __construct()
    {
   
    }

    
    public function index()
    {
        return view('rol.index');
    }

    public function listarRol(Request $request)
    {
        $search = $request->input('search');
        $roles = Rol::filtroRol($search);
        $view = view('rol.item-rol',['roles'=>$roles]);
        return Response($view);
    }


    public function eliminarRol(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            Rol::eliminarRol($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Rol eliminado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



    public function registrar()
    {
        return view('rol.registrar');
    }


    public function registrarRol(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            Rol::registrarRol(
                $request->nombre
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Rol registrado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }

    public function actualizarRol(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nombre' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            Rol::actualizarRol(
                $request->id,
                $request->nombre,
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Rol actualizado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }

    public function editar($id_rol)
    {
        $rol = Rol::findOrFail($id_rol);
        return view('rol.editar',['rol'=>$rol]);
    }

    public function indexPermiso($id_rol)
    {
        $opciones = RolPermiso::getPermisosPorRol($id_rol);
        $rol = Rol::findOrFail($id_rol);
        return view('rol.index-permiso',['opciones'=>$opciones,'rol'=>$rol]);
    }



    public function actualizarPermiso(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_rol' => 'required',
            'permisos' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            RolPermiso::registrarRolPermisoMasivo(
                $request->id_rol,
                $request->permisos,
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Permiso asignados correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }

}
