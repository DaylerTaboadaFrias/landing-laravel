<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use App\Models\Util;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\SeccionContacto;
use Illuminate\Support\Facades\Session;


class SeccionContactoController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        return view('seccion-contacto.index');
    }

    public function editar($id_seccion_contacto)
    {
        $seccionContacto = SeccionContacto::findOrFail($id_seccion_contacto);
        $estados = Util::getEstados();
        return view('seccion-contacto.editar',['seccionContacto'=>$seccionContacto,'estados'=>$estados]);
    }

    public function listarSeccionContacto(Request $request)
    {
        $search = $request->input('search');
        $seccionesContactos = SeccionContacto::filtroSeccionContacto($search);
        $view = view('seccion-contacto.item-seccion-contacto',['seccionesContactos'=>$seccionesContactos]);
        return Response($view);
    }

    public function actualizarSeccionContacto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'titulo' => 'required|string|max:191',
            'direccion' => 'required|string|max:191',
            'telefono' => 'required|string|max:191',
            'codigo_area' => 'required|numeric|min:0',
            'celular' => 'required|numeric|min:0',
            'correo' => 'required|string|max:191',
            'enlace_facebook' => 'required|string|max:191',
            'enlace_instagram' => 'required|string|max:191',
            'enlace_linkedin' => 'required|string|max:191',
            'enlace_pago' => 'required|string|max:191',
            'enlace_inicio_sesion' => 'required|string|max:191',
            'enlace_registro' => 'required|string|max:191'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            SeccionContacto::actualizarSeccionContacto(
                $request->id,
                $request->titulo,
                $request->direccion,
                $request->telefono,
                $request->codigo_area,
                $request->celular,
                $request->correo,
                $request->enlace_facebook,
                $request->enlace_instagram,
                $request->enlace_linkedin,
                $request->enlace_pago,
                $request->enlace_inicio_sesion,
                $request->enlace_registro,
                $request->imagen
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Sección de contacto actualizada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



}
