<!DOCTYPE html>
<html lang="en">
	<head><base href="../../">
        @yield('titulo')
        <meta charset="utf-8" />
        <meta name="description" content="Cenace" />
        <meta name="keywords" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta property="og:locale" content="" />
        <meta property="og:type" content="" />
        <meta property="og:title" content="" />
        <meta property="og:url" content="" />
        <meta property="og:site_name" content="" />
        <link rel="canonical" href="" />
        <link rel="shortcut icon" href="{{asset('images/logo_cenace.png')}}" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Host+Grotesk:ital,wght@0,300..800;1,300..800&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
		<link href="{{asset('assets/plugins/custom/prismjs/prismjs.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/plugins/custom/cropper/cropper.bundle.css')}}" rel="stylesheet" type="text/css" />
    	<link href="{{asset('assets/plugins/cropperjs/dist/cropper.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('css/file-upload.css')}}" rel="stylesheet" type="text/css" />
        @yield('styles')
	</head>
	<body id="kt_body" class="header-tablet-and-mobile-fixed toolbar-enabled aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">         
		<div class="d-flex flex-column flex-root">
			<div class="page d-flex flex-row flex-column-fluid">
				<div id="kt_aside" class="aside aside-light aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
					<div class="aside-logo flex-column-auto" id="kt_aside_logo">
						<a href="{{url('inicio')}}">
							<img alt="Logo" src="{{asset('images/logo_cenace.png')}}" class="h-50px logo" />
						</a>
					</div>
					<!--MENU-->
					<div class="aside-menu flex-column-fluid">
					    <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
					        <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true">
					            
					            <div class="d-block d-lg-none text-center mb-3">
					                <img src="{{asset('images/logo_cenace.png')}}" alt="Logo" class="h-50px logo">
					            </div>

								@foreach($opciones as $item)
								    <div data-kt-menu-trigger="click" class="menu-item menu-accordion" id="{{$item->identificador}}">
								        <span class="menu-link">
								            <span class="menu-icon">
								                <img src="{{asset($item->icono)}}" alt="Icono" width="24" height="24">
								            </span>
								            <span class="menu-title">{{$item->nombre}}</span>
								            <span class="menu-arrow"></span>
								        </span>
								        <div class="menu-sub menu-sub-accordion menu-active-bg">
								            @foreach($item->permisos as $permiso)
								                <div class="menu-item">
								                    <a class="menu-link" href="{{ url($permiso->url) }}" id="{{$permiso->identificador}}">
								                        <span class="menu-bullet">
								                            <span class="bullet bullet-dot"></span>
								                        </span>
								                        <span class="menu-title">{{$permiso->nombre}}</span>
								                    </a>
								                </div>
								            @endforeach
								        </div>
								    </div>
								@endforeach
					        </div>
					    </div>
					</div>

					<div class="aside-footer flex-column-auto pt-5 pb-7 px-10" id="kt_aside_footer">
					    <a id="cerrarSession" class="menu-link cursor-pointer">
					        <span class="menu-icon">
					            <span class="svg-icon svg-icon-2">
					                <img src="{{asset('images/cerrar_sesion.svg')}}" alt="Menu Icon" width="24" height="24">
					            </span>
					        </span>
					        <span class="menu-title text-dark fw-bold">Cerrar sesión</span>
					    </a>
					</div>
				</div>
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<div id="kt_header" style="" class="header align-items-stretch bg-primary">
						<div class="container-fluid d-flex align-items-stretch justify-content-between">
							<div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show aside menu">
								<div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_aside_mobile_toggle">
									<img src="{{asset('images/menu.svg')}}" height="25" width="25">
								</div>
							</div>
							<div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
								<div class="col-12">
							        @yield('header')
							    </div>
							</div>
						</div>
					</div>
					<div class="content d-flex flex-column flex-column-fluid" style="background-color: white;">
						@yield('content')

					</div>
					<div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
						<div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
							<div class="text-dark roboto-medium order-2 order-md-1">
								<span class="text-muted roboto-medium  fw-bold me-1">{{ date('Y') }} ©</span>
								<a href="#" target="_blank" class="text-gray-800 roboto-medium  text-hover-primary">Cenace</a>
							</div>
						</div>
					</div>
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
		<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
		<script src="{{asset('assets/plugins/custom/prismjs/prismjs.bundle.js')}}"></script>
		<script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
		<script src="{{asset('assets/plugins/custom/tinymce/tinymce.bundle.js')}}"></script>
		<script src="{{asset('assets/js/widgets.bundle.js')}}"></script>
		<script src="{{asset('assets/js/custom/widgets.js')}}"></script>
		<script src="{{asset('assets/js/custom/apps/chat/chat.js')}}"></script>
		<script src="{{asset('assets/js/custom/utilities/modals/upgrade-plan.js')}}"></script>
		<script src="{{asset('assets/js/custom/utilities/modals/create-app.js')}}"></script>
		<script src="{{asset('assets/js/custom/utilities/modals/users-search.js')}}"></script>
		<script src="{{asset('assets/plugins/cropperjs/dist/cropper.js')}}" type="text/javascript"></script>
		<script src="{{asset('js/compressor/compressor.js')}}" type="text/javascript"></script>
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

            $('#cerrarSession').on('click', function() {
                $.ajax({
                    type: "POST",
                    url: "{{url('autenticacion/cerrar-session')}}",
                    data: {},
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
            

        });
        </script>
        @stack('scripts')

	</body>
</html>