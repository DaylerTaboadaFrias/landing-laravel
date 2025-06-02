@extends('layout.autenticacion')
@section('titulo')
<title>Recuperar Contraseña</title>
@endsection
@section('content')
<a href="{{url('/')}}" class="mb-12">
    <img alt="Logo" src="{{asset('images/logo_cenace.png')}}" class="h-60px" />
</a>
<div class="w-lg-500px bg-body rounded shadow-sm mx-auto">
    <div class="pt-4 pb-4">
        <div class="text-center mb-4">
            <h1 class="text-dark mb-3">Recuperar Contraseña</h1>
        </div>
    </div>
    <div class="ps-10 pe-10 pb-10 pt-5">
        <form class="form w-100" id="formulario">


            <div class="fv-row mb-4">
                <label class="form-label fs-6 fw-bolder text-dark">Nombre de usuario</label>
                <input class="form-control form-control-lg form-control-solid" type="text" name="nombre_usuario" placeholder="Ingrese su nombre de usuario" autocomplete="off" />
            </div>


            <div class="text-center">
                <a id="generarCodigoRecuperacion" class="btn btn-lg btn-primary w-100 mb-5">
                    Continuar <i class="fas fa-sign-in-alt text-white"></i>
                </a>
            </div>
            <div class="text-center">
                <a href="{{url('/login')}}" class="btn btn-border-white w-100 mb-5">
                    <i class="fas fa-arrow-left me-2 blue-600"></i>
                    Volver
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            $('#generarCodigoRecuperacion').on('click', function() {
                $.ajax({
                    type: "POST",
                    url: "{{url('autenticacion/generar-codigo-recuperacion')}}",
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
                            setTimeout(function(){window.location = "/codigo-recuperacion/"+response.data.token} , 2000);   
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