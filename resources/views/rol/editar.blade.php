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
    <div class="row align-items-center  mt-5 mb-5">
        <div class="col-12 col-lg-6 d-flex align-items-center mb-lg-0">
            <a href="{{url('rol')}}" class="d-flex align-items-center text-decoration-none">
                <img src="{{asset('images/arrow_left.svg')}}" alt="Icon" class="me-4" style="width: 20px; height: 20px;">
                <h1 class="text-dark fw-bolder roboto-medium fs-2 my-0">Atrás</h1>
            </a>
        </div>
    </div>
    <div class="mb-4">
        <h4 class="fs-2">Modificar rol</h4>
    </div>
    <form id="formulario">
        <input type="hidden" name="id" value="{{$rol->id}}">

        <div class="row">
            <div class="col-md-6">
                <label for="nombre" class="form-label fw-bolder roboto-medium roboto-medium">Nombre <small class="required"></small></label>
                <input type="text" name="nombre" value="{{$rol->nombre}}" class="form-control" placeholder="Ingresar nombre" required>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <a href="{{url('rol')}}" class="btn btn-border-white">Cancelar</a>
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
     $('#navRoles').addClass('actived');

    var formulario = document.getElementById('formulario');


    $('#actualizar').on('click', function() {

        if (!formulario.checkValidity()) {
            formulario.reportValidity();
            return;
        }

        $.ajax({
            type: "POST",
            url: "{{url('rol/actualizar-rol')}}",
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
