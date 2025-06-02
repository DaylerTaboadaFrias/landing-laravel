<?php

namespace App\Http\Controllers;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InicioController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        $data = Session::get('data',null);
        return view('inicio.index',['data'=>$data]);
    }


}
