@extends('layout.admin')
@section('titulo')
<title>Importar cursos</title>
@endsection

@section('styles')

@endsection

@section('header')
<h1 class="text-white lh-base fw-bolder roboto-medium fs-1">Importar cursos</h1>
@endsection


@section('content')
<div class="container">
    <div class="row align-items-center mt-5 mb-5">
        <div class="col-12 col-lg-6 d-flex align-items-center mb-3 mb-lg-0">
            <h1 class="text-dark fw-bolder roboto-medium fs-2 my-0" id="titulo"> Importar cursos</h1>
        </div>
        <div class="col-12 col-lg-6 d-flex justify-content-lg-end align-items-center flex-column flex-lg-row gap-3">
            <div class="btn-group">
                <a href="#" class="btn btn-primary" data-bs-placement="top" title="Limpiar datos" data-bs-toggle="modal" data-bs-target="#limpiarCursos">Limpiar datos</a>
             </div>
        </div>
    </div>
    @include('importar-curso.modal-limpiar')

    <h4 style="margin-bottom: 1em;"> Los campos con <strong style="color: red;">*</strong> son obligatorios</h4>
    <div class="row portlet-body" id="bloqueImportador">

        <form method="post" action="" id="formulario" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="row mt-3">
                <div class="col-md-12">
                    <label class="form-label fw-bolder roboto-medium">Archivo excel<small class="required"></small></label>
                    <input type="file" id="archivo" name="archivo" class="form-control form-control-sm" placeholder="Archivo" required="" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                </div>
                
            </div>
            <div class="form-body col-md-2" style="margin-top: 1em;">
                <a  id="guardar" class="btn btn-primary w-100 w-lg-auto d-flex align-items-center">Leer excel</a>
            </div>
        </form>
    </div>
    
    <br>
    <div class="row portlet-body" id="bloqueDatos">
        <div class="col-md-12"> 
          <form method="post" action="" id="formularioDatos">
                <div class="row mb-7">
                    <div class="col-md-6">
                        <input type="text" id="buscador" class="form-control" placeholder="Buscador">
                    </div> 
                    <div class="col-md-6">
                        
                    </div>
                </div>
                <h4 style="margin-bottom: 1em;"> Los campos con <strong style="color: red;">color rojo</strong> no seran importados por que presentan un error de formato</h4>
                <div class="portlet-body table-responsive">
                    <table id="table" class="table table-row-bordered table-responsive ">
                    <thead class="fw-bold fs-7 blue-600">
                      <tr>
                          <th style="width: 5%;"> Nro </th>
                          <th style="width: 10%;"> ID curso externo </th>
                          <th style="width: 5%;"> Nombre </th>
                          <th style="width: 5%;"> Orden </th>
                          <th style="width: 10%;"> Duración </th>
                          <th style="width: 10%;"> Recursos disponibles </th>
                          <th style="width: 10%;"> Fecha inicio </th>
                          <th style="width: 10%;"> Fecha fin </th>
                          <th style="width: 10%;"> Precio </th>
                          <th style="width: 10%;"> Descuento</th>
                          <th style="width: 10%;"> Resumen </th>
                          <th style="width: 10%;"> Requisitos </th>
                          <th style="width: 10%;"> Objetivos </th>
                          <th style="width: 10%;"> Contenido </th>
                          <th style="width: 10%;"> ID docente externo  </th>
                          <th style="width: 10%;"> Nombre  </th>
                          <th style="width: 10%;"> Prefijo academico  </th>
                          <th style="width: 10%;"> Profesión  </th>
                          <th style="width: 10%;"> Biografía  </th>
                          <th style="width: 10%;"> Enlace  </th>
                          <th style="width: 10%;"> Categoria  </th>
                          <th style="width: 10%;"> Subcategoria  </th>
                          <th style="width: 10%;"> Modalidad  </th>
                          <th style="width: 10%;"> Tipo Curso  </th>
                          <th style="width: 10%;"> Error</th>
                      </tr>
                    </thead>
                    <tbody id="cuerpo">
    
                    </tbody>
                    </table>
                </div>
          </form>
        </div>
        <div class="form-body col-md-2" style="margin-top: 1em;">
            <a  id="guardarDatos" class="btn btn-primary w-100 w-lg-auto d-flex align-items-center">Importar datos</a>
        </div>
    </div>
</div>

@endsection
@push('scripts') 

<script type="text/javascript">
$(document).ready(function() {
    $('#cursos').addClass('here show');
    $('#navImportarCurso').addClass('actived');
    
    $("#buscador").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#table tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });



    var formulario = document.getElementById('formulario');



    $('#guardar').click(function() {

        if (formulario.checkValidity()) {
            $.ajax({
                type: "POST",
                url: "{{url('importar-curso/visualizar-importar-curso')}}",
                data: new FormData($("#formulario")[0]),
                processData: false,
                contentType: false,
                success: function( response ) {
                    toastr.success('Archivo leido', 'Satisfactorio!');
                    toastr.options.closeDuration = 10000;
                    toastr.options.timeOut = 10000;
                    toastr.options.extendedTimeOut = 10000;
                    $('#cuerpo').empty();
                    $('#cuerpo').html(response);
                
                },
                error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr);
                        console.log(ajaxOptions);
                        console.log(thrownError);

                }
            });
        }else{
            formulario.reportValidity();
        }

    }); 


    var formularioDatos = document.getElementById('formularioDatos');



    $('#guardarDatos').click(function() {

        if (formularioDatos.checkValidity()) {
            $.ajax({
                type: "POST",
                url: "{{url('importar-curso/store-importar-curso')}}",
                data: new FormData($("#formularioDatos")[0]),
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

                        setTimeout(function(){window.location = "/importar-curso/"} , 2000);   

                    }else{
                        toastr.error(response.message, 'Ocurrio un error!');
                        toastr.options.closeDuration = 10000;
                        toastr.options.timeOut = 10000;
                        toastr.options.extendedTimeOut = 10000;
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                        var errors = xhr.responseJSON.errors;
                        $.each( errors, function( key, value ) {
                            toastr.error(value[0], 'Datos invalidos!');
                            toastr.options.closeDuration = 10000;
                            toastr.options.timeOut = 10000;
                            toastr.options.extendedTimeOut = 10000;
                        });

                }
            });
        }else{
            formularioDatos.reportValidity();
        }

    });


    limpiarCursos = function (){
        $('#cuerpo').empty();
        $('#archivo').val('');
        $('#buscador').val('');
        toastr.success('Limpiado correctamente', 'Satisfactorio!');
        toastr.options.closeDuration = 10000;
        toastr.options.timeOut = 10000;
        toastr.options.extendedTimeOut = 10000;
    }

});
</script>
@endpush
