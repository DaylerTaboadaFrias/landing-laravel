@extends('layout.admin')
@section('titulo')
<title>Portada formulario de postulación</title>
@endsection

@section('styles')

@endsection

@section('header')
<h1 class="text-white lh-base fw-bolder roboto-medium fs-1">Portada formulario de postulación</h1>
@endsection


@section('content')
<div class="container">
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
        </div>
    </div>

    <table id="tabla" class="table table-row-bordered">
        <thead>
            <tr class="fw-bold fs-7 blue-600">
                <th>ID</th>
                <th>Imagen</th>
                <th>Enlace</th>
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
     $('#nosotros').addClass('here show');
     $('#navPortadaFormularioPostulacion').addClass('actived');

    filtroPortadaFormularioPostulacion();

    $("#buscar").click(function () {
        filtroPortadaFormularioPostulacion();
    });   
    


    function filtroPortadaFormularioPostulacion()
    {
        var search = $('#search').val();
        $.ajax({
          type: "POST",
          url: "{{url('portada-formulario-postulacion/listar-portada-formulario-postulacion')}}",
          data: {search:search},
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
            var nro_portada = $("#tabla").DataTable().rows().count();
            $("#titulo").text(nro_portada+" Portada formulario de postulación");
          },
          error: function (xhr, ajaxOptions, thrownError) {
          }
        });
    }

    eliminarPortadaFormularioPostulacion = function(id){
        $.ajax({
            type: "POST",
            url: "{{url('portada-formulario-postulacion/eliminar-portada-formulario-postulacion')}}",
            data: {id: id},
            success: function( response ) {
                if (response.success) {
                    filtroPortadaFormularioPostulacion();

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
