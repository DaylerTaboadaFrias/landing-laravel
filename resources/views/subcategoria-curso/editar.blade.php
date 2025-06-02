@extends('layout.admin')
@section('titulo')
<title>Subcategorías</title>
@endsection

@section('styles')
@endsection

@section('header')
<h1 class="text-white lh-base fw-bolder roboto-medium fs-1">Subcategoría</h1>
@endsection


@section('content')
<div class="container mt-5 mb-5">
    <div class="row align-items-center">
        <div class="col-12 col-lg-6 d-flex align-items-center mb-lg-0">
            <a href="{{url('subcategoria-curso')}}" class="d-flex align-items-center text-decoration-none">
                <img src="{{asset('images/arrow_left.svg')}}" alt="Icon" class="me-4" style="width: 20px; height: 20px;">
                <h1 class="text-dark fw-bolder roboto-medium fs-2 my-0">Atrás</h1>
            </a>
        </div>
    </div>

    <div class="mt-5 mb-5">
        <h4 class="fs-2">Modificar Subcategoría</h4>
    </div>
    <form id="formulario">
        <input type="hidden" name="id" value="{{$subcategoria->id}}">

        <div class="row mt-3">
            <div class="col-md-6">
                <label for="nombre" class="form-label fw-bolder roboto-medium roboto-medium">Nombre de subcategoría <small class="required"></small></label>
                <input type="text" name="nombre" value="{{$subcategoria->nombre}}" class="form-control roboto-medium" placeholder="Ingresar nombre de subcategoría" required>
            </div>
            <div class="col-md-6">
                <label for="id_categoria_curso" class="form-label fw-bolder roboto-medium roboto-medium">Categoría <small class="required"></small></label>
                <select name="id_categoria_curso" class="form-select roboto-medium" data-control="select2" data-placeholder="Seleccione una opción" data-allow-clear="true" required>
                    <option value="">Seleccione una opción</option>
                    @foreach($categorias as $item)
                        <option value="{{$item->id}}" {{ $subcategoria->id_categoria_curso == $item->id ? 'selected' : '' }}>{{$item->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label for="habilitado" class="form-label fw-bolder roboto-medium roboto-medium">Orden <small class="required"></small></label>
                <input type="number" name="orden" value="{{$subcategoria->orden}}" class="form-control roboto-medium" placeholder="Ingresar orden" required>
            </div>
            <div class="col-md-6">
                <label for="habilitado" class="form-label fw-bolder roboto-medium roboto-medium">Estado <small class="required"></small></label>
                <select name="habilitado" class="form-select roboto-medium" required>
                    <option value="">Seleccione una opción</option>
                    <option value="1" {{ $subcategoria->habilitado == 1 ? 'selected' : '' }}>Si</option>
                    <option value="0" {{ $subcategoria->habilitado == 0 ? 'selected' : '' }}>No</option>
                </select>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <a href="{{url('subcategoria-curso')}}" class="btn btn-border-white">Cancelar</a>
                <a id="actualizar" class="btn btn-primary">Actualizar</a>
            </div>
        </div>

    </form>

</div>


@endsection
@push('scripts')     
<script type="text/javascript">
$(document).ready(function() {
    $('#cursos').addClass('here show');
    $('#navSubCategoriaCurso').addClass('actived');

    var formulario = document.getElementById('formulario');


    $('#actualizar').on('click', function() {

        if (!formulario.checkValidity()) {
            formulario.reportValidity();
            return;
        }

        $.ajax({
            type: "POST",
            url: "{{url('subcategoria-curso/actualizar-subcategoria-curso')}}",
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
                    setTimeout(function(){window.location = "/subcategoria-curso"} , 2000);   
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
