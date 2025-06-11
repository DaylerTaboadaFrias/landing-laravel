<!DOCTYPE html>
<html lang="en">
	<head><base href="">
		@yield('titulo')
		<meta charset="utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="" />
		<meta property="og:url" content="" />
		<meta property="og:site_name" content="" />
		<link rel="canonical" href="{{asset('images/logo_cenace.png')}}" />
		<link rel="shortcut icon" href="{{asset('images/logo_cenace.png')}}" />
		<link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="{{asset('css/slick/slick.min.css')}}">
		<link rel="stylesheet" href="{{asset('css/slick/slick-theme.min.css')}}">
        <link href="{{asset('css/file-upload.css')}}" rel="stylesheet" type="text/css" />
        @yield('styles')

	</head>
	<body id="kt_body" class="bg-white position-relative">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="d-flex flex-column flex-root">
			<div class="mb-0" id="home">
				<div class="bgi-no-repeat bgi-size-contain bgi-position-x-center bgi-position-y-bottom">
					<div class="landing-header" data-kt-sticky="true" data-kt-sticky-name="landing-header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
						<div class="container">
							<div class="d-flex align-items-center justify-content-between">
								<div class="d-flex align-items-center flex-equal">
									<button class="btn btn-icon btn-active-color-primary me-3 d-flex d-lg-none" id="kt_landing_menu_toggle">
										<span class="svg-icon svg-icon-2hx">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="black" />
												<path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="black" />
											</svg>
										</span>
									</button>
									<a href="{{url('/')}}">
										<img alt="Logo" src="{{asset('images/logo_cenace.png')}}" class="logo-default h-25px h-lg-30px" />
										<img alt="Logo" src="{{asset('images/logo_cenace.png')}}" class="logo-sticky h-20px h-lg-25px" />
									</a>
								</div>
								<div class="d-lg-block" id="kt_header_nav_wrapper">
									<div class="d-lg-block p-5 p-lg-0" data-kt-drawer="true" data-kt-drawer-name="landing-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="200px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_landing_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav_wrapper'}">
										<div class="menu menu-column flex-nowrap menu-rounded menu-lg-row menu-title-gray-500 menu-state-title-primary nav nav-flush fs-5 fw-bold" id="kt_landing_menu">
											<div class="menu-item">
												<a class="menu-link nav-link py-3 px-4 px-xxl-6 text-bold-primary" href="{{url('/')}}" >Inicio</a>
											</div>
											<div class="menu-item">
												<a class="menu-link nav-link py-3 px-4 px-xxl-6 text-bold-primary" href="{{url('cursos')}}" >Cursos</a>
											</div>
											<div class="menu-item">
												<a class="menu-link nav-link py-3 px-4 px-xxl-6 text-bold-primary" href="{{url('empresas')}}" >Empresas</a>
											</div>
											<div class="menu-item">
												<a class="menu-link nav-link py-3 px-4 px-xxl-6 text-bold-primary" href="{{url('nosotros')}}" >Nosotros</a>
											</div>
											<div class="menu-item">
												<a class="menu-link nav-link py-3 px-4 px-xxl-6 text-bold-primary" href="{{url('contacto')}}" >Contacto</a>
											</div>
											<div class="menu-item">
												<a class="menu-link nav-link py-3 px-4 px-xxl-6 text-bold-primary" href="https://wa.me/{{ $seccionContacto->codigo_area }}{{ $seccionContacto->celular }}" target="_blank" > <img src="{{asset('images/whatsapp_azul_blanco.png')}}" alt="WhatsApp" class="img-fluid me-2 align-self-start" style="max-height: 20px;">  Escríbenos ahora</a>
											</div>
										</div>

									</div>
								</div>
								<div class="d-flex align-items-center">
									<a href="{{$seccionContacto->enlace_inicio_sesion}}" target="_blank" class="btn text-bold-primary">Inicia sesión</a>
									<a href="{{$seccionContacto->enlace_registro}}" target="_blank" class="btn btn-round-primary">Regístrate</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			@include('landingpage.modal-solicitud-enviada')
			@include('landingpage.modal-solicitud-error')
			@yield('content')




			<div class="bg-blue-light pb-15 pt-15">
			    <div class="container">
			        <div class="row bg-primary p-10 rounded-3">
			            <div class="col-md-6 d-flex align-items-center justify-content-md-start justify-content-center">
			                <img src="{{asset('images/logo_cenace_white.png')}}" alt="Logo" class="img-icon-60">
			            </div>
			            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
			                <div class="d-flex flex-column align-items-center align-items-md-end">
			                    <span class="fs-6 white mb-2">Síguesdsnos:</span>
			                    <div>
			                        <a href="{{$seccionContacto->enlace_facebook}}" target="_blank"><img src="{{asset('images/facebook_white.png')}}" alt="Facebook" class="img-icon-30 mx-2"></a>
			                        <a href="{{$seccionContacto->enlace_instagram}}" target="_blank"><img src="{{asset('images/instagram_white.png')}}" alt="Instagram" class="img-icon-30 mx-2"></a>
			                        <a href="https://wa.me/{{ $seccionContacto->codigo_area }}{{ $seccionContacto->celular }}" target="_blank"><img src="{{asset('images/whatsapp_white.png')}}" alt="WhatsApp" class="img-icon-30 mx-2"></a>
			                        <a href="{{$seccionContacto->enlace_linkedin}}" target="_blank"><img src="{{asset('images/linkedin_white.png')}}" alt="LinkedIn" class="img-icon-30 mx-2"></a>
			                    </div>
			                </div>
			            </div>
			        </div>
			    </div>
			</div>

			<div class="bg-light py-4">
			    <div class="container">
			        <div class="row text-center text-md-start align-items-start">
			            <div class="col-md-3">
			                <h6 class="fs-6 text-bold-primary mb-4">Cursos</h6>
			                <ul class="list-unstyled">
			                    <li class="fs-6 text-normal roboto-medium mb-4">Escuela de seguros</li>
			                    <li class="fs-6 text-normal roboto-medium mb-4">Gestión empresarial</li>
			                    <li class="fs-6 text-normal roboto-medium mb-4">Ingeniería y mantenimiento</li>
			                    <li class="fs-6 text-normal roboto-medium mb-4">Idiomas</li>
			                    <li class="fs-6 text-normal roboto-medium mb-4">Tecnología de la información</li>
			                    <li class="fs-6 text-normal roboto-medium mb-4">Sistema de gestión</li>
			                </ul>
			            </div>
			            <div class="col-md-3">
			                <ul class="list-unstyled">
			                    <li class="fs-6 text-normal roboto-medium mb-4">Escuela de seguros</li>
			                    <li class="fs-6 text-normal roboto-medium mb-4">Gestión empresarial</li>
			                    <li class="fs-6 text-normal roboto-medium mb-4">Ingeniería y mantenimiento</li>
			                </ul>
			            </div>
						<div class="col-md-3 mt-10 mt-md-0">
							<h6 class="fs-6 text-bold-primary mb-4">Contacto</h6>
						    <p class="mb-4 d-flex align-items-start fs-6 text-normal roboto-medium text-start">
						        <img src="{{asset('images/ubicacion.png')}}" alt="Ubicación" class="img-fluid me-2 align-self-start" style="max-height: 20px;"> 
						        {!! nl2br(e($seccionContacto->titulo)) !!}<br>{{ $seccionContacto->direccion }}
						    </p>
						    <p class="mb-4 d-flex align-items-start fs-6 text-normal roboto-medium text-start">
						        <img src="{{asset('images/telefono.png')}}" alt="Teléfono" class="img-fluid me-2 align-self-start" style="max-height: 20px;"> 
						        +{{ $seccionContacto->codigo_area }} {{ $seccionContacto->celular }} / Tel : {{ $seccionContacto->telefono }}
						    </p>
						    <p class="d-flex align-items-start fs-6 text-normal roboto-medium text-start">
						        <img src="{{asset('images/email.png')}}" alt="Correo" class="img-fluid me-2 align-self-start" style="max-height: 20px;"> 
						        {{ $seccionContacto->correo }}
						    </p>
						</div>

			            <div class="col-md-3 d-flex justify-content-center justify-content-md-end align-items-end">
			                <img src="{{asset('images/logo_upsa.png')}}" alt="UPSA Logo" class="img-fluid" style="max-height: 60px;">
			            </div>
			        </div>
			        <div class="text-center mt-4">
			            <small class="fs-6 text-normal roboto-medium">© {{ \Carbon\Carbon::now()->year }} CENACE - UPSA. Todos los derechos reservados</small>
			        </div>
			    </div>
			</div>


			<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
				<span class="svg-icon">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black" />
						<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="black" />
					</svg>
				</span>
			</div>
		</div>
		<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
		<script src="{{asset('assets/plugins/custom/fslightbox/fslightbox.bundle.js')}}"></script>
		<script src="{{asset('assets/plugins/custom/typedjs/typedjs.bundle.js')}}"></script>
		<script src="{{asset('assets/js/custom/landing.js')}}"></script>
		<script src="{{asset('js/slick/slick.min.js')}}"></script>
		<script type="text/javascript">
		$(document).ready(function(){

            var target = document.querySelector("#kt_body");
            var blockUI = new KTBlockUI(target, {
                message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Cargando...</div>',
            });

            $.ajaxSetup({
               headers: {
                  'X-CSRF-TOKEN': $('input[name="_token"]').val()
               }
            });

            $(document).ajaxStart(function (){
                blockUI.block();
                $('body').css('overflow','auto');
            }).ajaxStop(function (){
                blockUI.release();
            });

		});
		</script>
        @stack('scripts')

	</body>
</html>