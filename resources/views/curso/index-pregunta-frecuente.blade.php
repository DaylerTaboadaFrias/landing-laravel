@extends('layout.admin')
@section('titulo')
<title>Preguntas frecuentes de {{ $curso->nombre }}</title>
@endsection

@section('styles')

@endsection

@section('header')
<h1 class="text-white lh-base fw-bolder roboto-medium fs-1">Preguntas frecuentes de {{ $curso->nombre }}</h1>
@endsection


@section('content')
<div class="container">
    <div class="row align-items-center mt-5 mb-5">
        <div class="col-12 col-lg-6 d-flex align-items-center mb-lg-0">
            <a href="{{url('/curso')}}" class="d-flex align-items-center text-decoration-none">
                <img src="{{asset('images/arrow_left.svg')}}" alt="Icon" class="me-4" style="width: 20px; height: 20px;">
                <h1 class="text-dark fw-bolder roboto-medium fs-2 my-0">Atrás</h1>
            </a>
        </div>
    </div>
    <div class="row align-items-center mt-5 mb-5">
        <div class="col-12 col-lg-6 d-flex align-items-center mb-3 mb-lg-0">
            <h1 class="text-dark fw-bolder roboto-medium fs-2 my-0" id="titulo"></h1>
        </div>
        <div class="col-12 col-lg-6 d-flex justify-content-lg-end align-items-center flex-column flex-lg-row gap-3">
            <div class="input-group w-100 w-lg-auto">
                <input type="text" class="form-control roboto-medium" placeholder="Buscar" aria-label="Buscar" id="search">
                <span class="input-group-text cursor-pointer" id="buscar">
                    <i class="bi bi-search"></i>
                </span>
            </div>
            <a href="{{url('/curso/pregunta-frecuente/registrar/'.$curso->id)}}" class="btn btn-primary w-100 w-lg-auto d-flex align-items-center">
                Crear Nuevo
            </a>
        </div>
    </div>

    <table id="tabla" class="table table-row-bordered">
        <thead>
            <tr class="fw-bold fs-7 blue-600">
                <th>ID</th>
                <th>Pregunta</th>
                <th>Respuesta</th>
                <th>Orden</th>
                <th>Habilitado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="cuerpo">

        </tbody>
    </table>
</div>

@endsection
@push('scripts') 

<script type="text/javascript">
$(document).ready(function() {
     $('#cursos').addClass('here show');
     $('#navCurso').addClass('actived');
     var curso = {!! json_encode($curso) !!};


    filtroPreguntaFrecuente();

    $("#buscar").click(function () {
        filtroPreguntaFrecuente();
    });   
    


    function filtroPreguntaFrecuente()
    {
        var search = $('#search').val();
        $.ajax({
          type: "POST",
          url: "{{url('/curso/pregunta-frecuente/listar-pregunta-frecuente')}}",
          data: {
            search:search,
            id_curso:curso.id
          },
          success: function( response ) {

            if ($.fn.DataTable.isDataTable('#tabla')) {
                $('#tabla').DataTable().destroy();
            }
            $('#cuerpo').empty();

            $('#cuerpo').html(response);
            
            $("#tabla").DataTable({
                "ordering": true,
                "order": [],
                "columnDefs": [
                    { "orderable": false, "targets": [0] } 
                ]
            });
            var nro_pregunta_frecuente = $("#tabla").DataTable().rows().count();
            if(nro_pregunta_frecuente>1){
                $("#titulo").text(nro_pregunta_frecuente+" Preguntas frecuentes de '"+curso.nombre+"'");
            }else{
                $("#titulo").text(nro_pregunta_frecuente+" Pregunta frecuente de '"+curso.nombre+"'");
            }

          },
          error: function (xhr, ajaxOptions, thrownError) {
          }
        });
    }

    eliminarPreguntaFrecuente = function(id){
        $.ajax({
            type: "POST",
            url: "{{url('/curso/pregunta-frecuente/eliminar-pregunta-frecuente')}}",
            data: {id: id},
            success: function( response ) {
                if (response.success) {
                    filtroPreguntaFrecuente();

                    toastr.success(response.message, 'Satisfactorio!');
                    toastr.options.closeDuration = 10000;
                    toastr.options.timeOut = 10000;
                    toastr.options.extendedTimeOut = 10000;

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
    }


});
</script>
@endpush
