@extends('layout.admin')
@section('titulo')
<title>Usuario</title>
@endsection

@section('styles')
@endsection
@section('header')
<h1 class="text-white lh-base fw-bolder roboto-medium fs-1">Usuario</h1>
@endsection


@section('content')
<div class="container">
    <div class="row align-items-center mt-5 mb-5">
        <div class="col-12 col-lg-6 d-flex align-items-center mb-lg-0">
            <a href="{{url('usuario')}}" class="d-flex align-items-center text-decoration-none">
                <img src="{{asset('images/arrow_left.svg')}}" alt="Icon" class="me-4" style="width: 20px; height: 20px;">
                <h1 class="text-dark fw-bolder roboto-medium fs-2 my-0">Atrás</h1>
            </a>
        </div>
    </div>

    <div class="mt-5 mb-5">
        <h4 class="fs-2">Crear Nuevo Usuario</h4>
    </div>
    <form id="formulario">
        <div class="row">
            <div class="col-md-6">
                <label for="nombres" class="form-label fw-bolder roboto-medium roboto-medium">Nombres <small class="required"></small></label>
                <input type="text" name="nombres" class="form-control roboto-medium" placeholder="Ingresar nombres" required>
            </div>
            <div class="col-md-6">
                <label for="apellidos" class="form-label fw-bolder roboto-medium roboto-medium">Apellidos <small class="required"></small></label>
                <input type="text" name="apellidos" class="form-control roboto-medium" placeholder="Ingresar apellidos" required>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label for="nombre_usuario" class="form-label fw-bolder roboto-medium roboto-medium">Nombre de usuario <small class="required"></small></label>
                <input type="text" name="nombre_usuario" class="form-control roboto-medium" placeholder="Ingresar nombre de usuario" required>
            </div>
            <div class="col-md-6">
                <label for="correo" class="form-label fw-bolder roboto-medium roboto-medium">Correo <small class="required"></small></label>
                <input type="email" name="correo" class="form-control roboto-medium" placeholder="Ingresar correo" required>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label for="password" class="form-label fw-bolder roboto-medium roboto-medium">Contraseña <small class="required"></small></label>
                <input type="text" name="password" class="form-control roboto-medium" placeholder="Ingresar contraseña" required>
            </div>
            <div class="col-md-6">
                <label for="id_rol" class="form-label fw-bolder roboto-medium roboto-medium">Rol de usuario <small class="required"></small></label>
                <select name="id_rol" class="form-select roboto-medium" required>
                    <option value="">Seleccione una opción</option>
                    @foreach($roles as $item)
                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label for="habilitado" class="form-label fw-bolder roboto-medium roboto-medium">Estado <small class="required"></small></label>
                <select name="habilitado" class="form-select roboto-medium" required>
                    <option value="">Seleccione una opción</option>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <a href="{{url('usuario')}}" class="btn btn-border-white">Cancelar</a>
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
    $('#navUsuarios').addClass('actived');

    var formulario = document.getElementById('formulario');


    $('#registrar').on('click', function() {

        if (!formulario.checkValidity()) {
            formulario.reportValidity();
            return;
        }

        $.ajax({
            type: "POST",
            url: "{{url('usuario/registrar-usuario')}}",
            data: new FormData($("#formulario")[0]),
            dataType:'json',
            async:true,
            type:'post',
            processData: false,
            contentType: false,
            success: function( response ) {
                if (response.success) {
                    toastr.success(response.message, 'Satisfactorio!');
                    toastr.options.closeDuration = 10000;
                    toastr.options.timeOut = 10000;
                    toastr.options.extendedTimeOut = 10000;
                    setTimeout(function(){window.location = "/usuario"} , 2000);   
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
