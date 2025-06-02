<!DOCTYPE html>
<html lang="en">
    <head>
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
        <link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
        @yield('styles')
    </head>
    <body id="kt_body" class="bg-body">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">         
        <div class="d-flex flex-column flex-root">
            <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed">
                <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20" id="content">
                   @yield('content')
                </div>
            </div>
        </div>
        <script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
        <script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
        <script type="text/javascript">
        $(document).ready(function(){
            var target = document.querySelector("#content");
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