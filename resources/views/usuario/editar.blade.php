@extends('layout.admin')
@section('titulo')
<title>Usuario</title>
@endsection

@section('styles')
@endsection

@section('header')
<h1 class="text-white lh-base fw-bolder roboto-medium fs-1">Modificar Usuario</h1>
@endsection


@section('content')
<div class="container mt-5 mb-5">
    <div class="row align-items-center">
        <div class="col-12 col-lg-6 d-flex align-items-center mb-lg-0">
            <a href="{{url('usuario')}}" class="d-flex align-items-center text-decoration-none">
                <img src="{{asset('images/arrow_left.svg')}}" alt="Icon" class="me-4" style="width: 20px; height: 20px;">
                <h1 class="text-dark fw-bolder roboto-medium fs-2 my-0">Atrás</h1>
            </a>
        </div>
    </div>

    <div class="mt-5 mb-5">
        <h4 class="fs-2">Modificar Usuario</h4>
    </div>
    <form id="formulario">
        <input type="hidden" name="id" value="{{$usuario->id}}">


        <div class="row">
            <div class="col-md-6">
                <label for="nombres" class="form-label fw-bolder roboto-medium roboto-medium">Nombres <small class="required"></small></label>
                <input type="text" name="nombres" value="{{$usuario->nombres}}" class="form-control roboto-medium" placeholder="Ingresar nombres" required>
            </div>
            <div class="col-md-6">
                <label for="apellidos" class="form-label fw-bolder roboto-medium roboto-medium">Apellidos <small class="required"></small></label>
                <input type="text" name="apellidos" value="{{$usuario->apellidos}}" class="form-control roboto-medium" placeholder="Ingresar apellidos" required>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label for="nombre_usuario" class="form-label fw-bolder roboto-medium roboto-medium">Nombre de usuario <small class="required"></small></label>
                <input type="text" name="nombre_usuario" value="{{$usuario->nombre_usuario}}" class="form-control roboto-medium" placeholder="Ingresar nombre de usuario" required>
            </div>
            <div class="col-md-6">
                <label for="correo" class="form-label fw-bolder roboto-medium roboto-medium">Correo <small class="required"></small></label>
                <input type="email" name="correo" value="{{$usuario->correo}}" class="form-control roboto-medium" placeholder="Ingresar correo" required>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label for="password" class="form-label fw-bolder roboto-medium roboto-medium">Contraseña</label>
                <input type="text" name="password" value="{{$usuario->password}}" class="form-control roboto-medium" placeholder="Ingresar contraseña">
            </div>
            <div class="col-md-6">
                <label for="id_rol" class="form-label fw-bolder roboto-medium roboto-medium">Rol de usuario <small class="required"></small></label>
                <select name="id_rol" class="form-select roboto-medium" required>
                    <option value="">Seleccione una opción</option>
                    @foreach($roles as $item)
                        <option value="{{$item->id}}" {{ $usuario->id_rol == $item->id ? 'selected' : '' }}>{{$item->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label for="habilitado" class="form-label fw-bolder roboto-medium roboto-medium">Estado <small class="required"></small></label>
                <select name="habilitado" class="form-select roboto-medium" required>
                    <option value="">Seleccione una opción</option>
                    <option value="1" {{ $usuario->habilitado == 1 ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ $usuario->habilitado == 0 ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <a href="{{url('usuario')}}" class="btn btn-border-white">Cancelar</a>
                <a id="actualizar" class="btn btn-primary">Actualizar</a>
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


    $('#actualizar').on('click', function() {

        if (!formulario.checkValidity()) {
            formulario.reportValidity();
            return;
        }

        $.ajax({
            type: "POST",
            url: "{{url('usuario/actualizar-usuario')}}",
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
