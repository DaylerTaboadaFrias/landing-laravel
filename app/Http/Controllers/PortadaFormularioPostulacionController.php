<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\PortadaFormularioPostulacion;
use App\Models\Util;
use DB;
use Validator;


class PortadaFormularioPostulacionController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        return view('portada-formulario-postulacion.index');
    }


    public function registrar()
    {
        $estados = Util::getEstados();
        return view('portada-formulario-postulacion.registrar',['estados'=>$estados]);
    }

    public function editar($id_portada)
    {
        $portada = PortadaFormularioPostulacion::findOrFail($id_portada);
        $estados = Util::getEstados();
        return view('portada-formulario-postulacion.editar',['portada'=>$portada,'estados'=>$estados]);
    }

    public function listarPortadaFormularioPostulacion(Request $request)
    {
        $search = $request->input('search');
        $portadas = PortadaFormularioPostulacion::filtroPortadaFormularioPostulacion($search);
        $view = view('portada-formulario-postulacion.item-portada-formulario-postulacion',['portadas'=>$portadas]);
        return Response($view);
    }



    public function actualizarPortadaFormularioPostulacion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'enlace' => 'nullable|string|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            PortadaFormularioPostulacion::actualizarPortadaFormularioPostulacion(
                $request->id,
                $request->enlace,
                $request->imagen,
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Portada formulario de postulación actualizada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



}
