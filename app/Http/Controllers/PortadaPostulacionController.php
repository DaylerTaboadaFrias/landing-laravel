<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\PortadaPostulacion;
use App\Models\Util;
use DB;
use Validator;


class PortadaPostulacionController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        return view('portada-postulacion.index');
    }


    public function registrar()
    {
        $estados = Util::getEstados();
        return view('portada-postulacion.registrar',['estados'=>$estados]);
    }

    public function editar($id_portada)
    {
        $portada = PortadaPostulacion::findOrFail($id_portada);
        $estados = Util::getEstados();
        return view('portada-postulacion.editar',['portada'=>$portada,'estados'=>$estados]);
    }

    public function listarPortadaPostulacion(Request $request)
    {
        $search = $request->input('search');
        $portadas = PortadaPostulacion::filtroPortadaPostulacion($search);
        $view = view('portada-postulacion.item-portada-postulacion',['portadas'=>$portadas]);
        return Response($view);
    }



    public function actualizarPortadaPostulacion(Request $request)
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
            PortadaPostulacion::actualizarPortadaPostulacion(
                $request->id,
                $request->enlace,
                $request->imagen,
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Portada de postulación actualizada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



}
