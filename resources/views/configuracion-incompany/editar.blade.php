@extends('layout.admin')
@section('titulo')
<title>Configuración incompany</title>
@endsection

@section('styles')
@endsection

@section('header')
<h1 class="text-white lh-base fw-bolder roboto-medium fs-1">Configuración incompany</h1>
@endsection


@section('content')
<div class="container">
    <div class="row align-items-center mt-5 mb-5">
        <div class="col-12 col-lg-6 d-flex align-items-center mb-lg-0">
            <a href="{{url('configuracion-incompany')}}" class="d-flex align-items-center text-decoration-none">
                <img src="{{asset('images/arrow_left.svg')}}" alt="Icon" class="me-4" style="width: 20px; height: 20px;">
                <h1 class="text-dark fw-bolder roboto-medium fs-2 my-0">Atrás</h1>
            </a>
        </div>
    </div>
    <div class="mb-4">
        <h4 class="fs-2">Modificar configuración incompany</h4>
    </div>
    <form id="formulario">
        <input type="hidden" name="id" value="{{$configuracionIncompany->id}}">
        <div class="row mt-3">
            <div class="col-md-12">
                <label class="form-label fw-bolder roboto-medium">Correo <small class="required"></small></label>
                <input type="text" name="correo" value="{{$configuracionIncompany->correo}}" class="form-control roboto-medium" placeholder="Ingresar correo" required>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Código del area <small class="required"></small></label>
                <input type="text" name="codigo_area" value="{{$configuracionIncompany->codigo_area}}" class="form-control roboto-medium" placeholder="Ingresar código del area" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Celular <small class="required"></small></label>
                <input type="text" name="celular" value="{{$configuracionIncompany->celular}}" class="form-control roboto-medium" placeholder="Ingresar celular" required>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <a href="{{url('configuracion-incompany')}}" class="btn btn-border-white">Cancelar</a>
                <a id="actualizar" class="btn btn-primary">Actualizar</a>
            </div>
        </div>
    </form>
   
</div>


@endsection
@push('scripts')     
<script type="text/javascript">
$(document).ready(function() {
     $('#incompany').addClass('here show');
     $('#navConfiguracionInCompany').addClass('actived');

    var formulario = document.getElementById('formulario');
    $('#actualizar').on('click', function() {

        if (!formulario.checkValidity()) {
            formulario.reportValidity();
            return;
        }

        $.ajax({
            type: "POST",
            url: "{{url('configuracion-incompany/actualizar-configuracion-incompany')}}",
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
                    setTimeout(function(){window.location = "/configuracion-incompany"} , 2000);   
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
