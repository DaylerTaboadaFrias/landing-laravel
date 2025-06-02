<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\PortadaIncompany;
use App\Models\Util;
use DB;
use Validator;


class PortadaIncompanyController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        return view('portada-incompany.index');
    }


    public function registrar()
    {
        $estados = Util::getEstados();
        return view('portada-incompany.registrar',['estados'=>$estados]);
    }

    public function editar($id_portada)
    {
        $portada = PortadaIncompany::findOrFail($id_portada);
        $estados = Util::getEstados();
        return view('portada-incompany.editar',['portada'=>$portada,'estados'=>$estados]);
    }

    public function listarPortadaIncompany(Request $request)
    {
        $search = $request->input('search');
        $portadas = PortadaIncompany::filtroPortadaIncompany($search);
        $view = view('portada-incompany.item-portada-incompany',['portadas'=>$portadas]);
        return Response($view);
    }



    public function actualizarPortadaIncompany(Request $request)
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
            PortadaIncompany::actualizarPortadaIncompany(
                $request->id,
                $request->enlace,
                $request->imagen,
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Portada de incompany actualizada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



}
