@extends('layout.admin')
@section('titulo')
<title>Rol</title>
@endsection

@section('styles')
@endsection

@section('header')
<h1 class="text-white lh-base fw-bolder roboto-medium fs-1">Rol</h1>
@endsection


@section('content')
<div class="container">
    <div class="row align-items-center mt-5 mb-5">
        <div class="col-12 col-lg-6 d-flex align-items-center mb-lg-0">
            <a href="{{url('rol')}}" class="d-flex align-items-center text-decoration-none">
                <img src="{{asset('images/arrow_left.svg')}}" alt="Icon" class="me-4" style="width: 20px; height: 20px;">
                <h1 class="text-dark fw-bolder roboto-medium fs-2 my-0">Atrás</h1>
            </a>
        </div>
    </div>
    <div class="mb-4">
        <h4 class="fs-2">Asignar permisos</h4>
    </div>
    <form id="formulario">
        <input type="hidden" name="id_rol" value="{{$rol->id}}">
        @foreach($opciones as $modulo)
        <div class="mb-4 mt-4">
            <h4 class="fs-2">{{$modulo->nombre}}</h4>
        </div>
        <div class="row">
            @foreach($modulo->permisos as $permiso)
                <div class="col-md-6">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="permisos[]" value="{{$permiso->id}}" @checked($permiso->existe == 1)>
                        <label class="form-check-label roboto-medium">
                            {{$permiso->nombre}}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
        @endforeach
        <div class="row mt-3">
            <div class="col-md-6">
                <a href="{{url('rol')}}" class="btn btn-border-white">Cancelar</a>
                <a id="registrar" class="btn btn-primary">Registrar</a>
            </div>
        </div>
    </form>
   
</div>


@endsection
@push('scripts')     
<script type="text/javascript">
$(document).ready(function() {
    $('#seguridad').addClass('here show');
    $('#navRoles').addClass('actived');

    $('#navRol').addClass('active');

    var formulario = document.getElementById('formulario');


    $('#registrar').on('click', function() {

        $.ajax({
            type: "POST",
            url: "{{url('rol/actualizar-permiso')}}",
            data: new FormData($("#formulario")[0]),
            dataType:'json',
            async:true,
            type:'post',
            processData: false,
            contentType: false,
            success: function( response ) {
                console.log(response);
                if (response.success) {
                    toastr.success(response.message, 'Satisfactorio!');
                    toastr.options.closeDuration = 10000;
                    toastr.options.timeOut = 10000;
                    toastr.options.extendedTimeOut = 10000;
                    setTimeout(function(){window.location = "/rol"} , 2000);   
                }else{
                    toastr.error(response.message, 'Ocurrio un error!');
                    toastr.options.closeDuration = 10000;
                    toastr.options.timeOut = 10000;
                    toastr.options.extendedTimeOut = 10000;
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
               

            }
        });
    });

});
</script>
@endpush
