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
            <input type="hidden" value="{{$token}}" name="token">
            <div class="text-center mb-4">
                <h1 class="text-dark mb-3">Ingresar nueva contraseña</h1>
            </div>
            <div class="fv-row position-relative">
                <label class="form-label fw-bolder text-dark fs-6 mb-0">Nueva Contraseña</label>
                <div class="position-relative">
                    <input id="password" class="form-control form-control-lg form-control-solid pe-5" type="password" name="password" placeholder="Ingresar nueva contraseña" autocomplete="off" />
                    <span id="togglePassword" class="eye-icon">
                        <i class="fa fa-eye-slash"></i>
                    </span>
                </div>
            </div>
            <div class="fv-row position-relative mb-4">
                <label class="form-label fw-bolder text-dark fs-6 mb-0">Confirmar Contraseña</label>
                <div class="position-relative">
                    <input id="confirmacion_password" class="form-control form-control-lg form-control-solid pe-5" type="password" name="confirmacion_password" placeholder="Ingresar contraseña" autocomplete="off" />
                    <span id="toggleConfirmacionPassword" class="eye-icon">
                        <i class="fa fa-eye-slash"></i>
                    </span>
                </div>
            </div>
            <div class="text-center">
                <a id="recuperarPassword" class="btn btn-lg btn-primary w-100 mb-5">
                    Recuperar contraseña 
                </a>
            </div>
            <div class="text-center">
                <a href="{{url('/recuperar-password')}}" class="btn btn-border-white w-100 mb-5">
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

            $('#recuperarPassword').on('click', function() {
                $.ajax({
                    type: "POST",
                    url: "{{url('autenticacion/actualizar-nuevo-password')}}",
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
                            setTimeout(function(){window.location = "/login"} , 2000);   
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


            $("#togglePassword").click(function() {
                let passwordInput = $("#password");
                let icon = $(this).find("i");

                if (passwordInput.attr("type") === "password") {
                    passwordInput.attr("type", "text");
                    icon.removeClass("fa-eye-slash").addClass("fa-eye");
                } else {
                    passwordInput.attr("type", "password");
                    icon.removeClass("fa-eye").addClass("fa-eye-slash");
                }
            });


            $("#toggleConfirmacionPassword").click(function() {
                let passwordInput = $("#confirmacion_password");
                let icon = $(this).find("i");

                if (passwordInput.attr("type") === "password") {
                    passwordInput.attr("type", "text");
                    icon.removeClass("fa-eye-slash").addClass("fa-eye");
                } else {
                    passwordInput.attr("type", "password");
                    icon.removeClass("fa-eye").addClass("fa-eye-slash");
                }
            });

        });
    </script>
@endpush