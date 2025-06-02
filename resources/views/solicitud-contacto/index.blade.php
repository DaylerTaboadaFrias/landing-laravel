@extends('layout.admin')
@section('titulo')
<title>Solicitudes de contacto</title>
@endsection

@section('styles')

@endsection

@section('header')
<h1 class="text-white lh-base fw-bolder roboto-medium fs-1">Solicitudes de contacto</h1>
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

    <div class="row align-items-center mt-5 mb-5">
        <div class="col-md-3 mb-3 mb-lg-0">
            <label class="form-label fw-bolder">Fecha inicio <small class="required"></small></label>
            <input type="date" id="fecha_inicio" class="form-control roboto-medium" value="{{$fecha_inicio}}">
        </div> 
        <div class="col-md-3 mb-3 mb-lg-0">
            <label class="form-label fw-bolder">Fecha fin <small class="required"></small></label>
            <input type="date" id="fecha_fin" class="form-control roboto-medium" value="{{$fecha_fin}}">
        </div> 
        <div class="col-md-3 mb-3 mb-lg-0">
            <label class="form-label fw-bolder">Motivo de contacto <small class="required"></small></label>
            <select id="id_motivo_contacto" class="form-select roboto-medium" required>
                <option value="0">Todos</option>
                @foreach($motivo_contactos as $item)
                <option value="{{$item->id}}">{{$item->nombre}}</option>
                @endforeach
            </select>
        </div> 
        <div class="col-md-3 mb-3 mb-lg-0">
            <label class="form-label fw-bolder">Estado <small class="required"></small></label>
            <select id="recibido" class="form-select roboto-medium" required>
                <option value="-1">Todos</option>
                <option value="0">Pendiente</option>
                <option value="1">Recibido</option>
            </select>
        </div> 
    </div>
    <table id="tabla" class="table table-row-bordered">
        <thead>
            <tr class="fw-bold fs-7 blue-600">
                <th>ID</th>
                <th>Fecha</th>
                <th>Nombre completo</th>
                <th>Telefono</th>
                <th>Correo </th>
                <th>Motivo </th>
                <th>Estado </th>
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
    $('#contacto').addClass('here show');
    $('#navSolicitudContacto').addClass('actived');


    $('#fecha_inicio, #fecha_fin, #id_motivo_contacto, #recibido').on('change', function(){
          filtroSolicitudContacto();
    });

    filtroSolicitudContacto();

    $("#buscar").click(function () {
        filtroSolicitudContacto();
    });   
    


    function filtroSolicitudContacto()
    {
        var search = $('#search').val();
        var fecha_inicio = $('#fecha_inicio').val();
        var fecha_fin = $('#fecha_fin').val();
        var recibido = $('#recibido').val();
        var id_motivo_contacto = $('#id_motivo_contacto').val();
        $.ajax({
          type: "POST",
          url: "{{url('solicitud-contacto/listar-solicitud-contacto')}}",
          data: {search:search, fecha_inicio:fecha_inicio , fecha_fin:fecha_fin, recibido:recibido, id_motivo_contacto:id_motivo_contacto },
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
            var nro_solicitud_contacto = $("#tabla").DataTable().rows().count();
            if(nro_solicitud_contacto>1){
                $("#titulo").text(nro_solicitud_contacto+" Solicitudes de contacto");
            }else{
                $("#titulo").text(nro_solicitud_contacto+" Solicitud de contacto");
            }

          },
          error: function (xhr, ajaxOptions, thrownError) {
          }
        });
    }

    eliminarSolicitudContacto = function(id){
        $.ajax({
            type: "POST",
            url: "{{url('solicitud-contacto/eliminar-solicitud-contacto')}}",
            data: {id: id},
            success: function( response ) {
                if (response.success) {
                    filtroSolicitudContacto();

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

    recibidoSolicitudContacto  = function(id){
        $.ajax({
            type: "POST",
            url: "{{url('solicitud-contacto/recibido-solicitud-contacto')}}",
            data: {id: id},
            success: function( response ) {
                if (response.success) {
                    filtroSolicitudContacto();

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
