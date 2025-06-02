@extends('layout.admin')
@section('titulo')
<title>Opiniones de estudiantes de {{ $curso->nombre }}</title>
@endsection

@section('styles')
@endsection

@section('header')
<h1 class="text-white lh-base fw-bolder roboto-medium fs-1">Opiniones de estudiantes de {{ $curso->nombre }}</h1>
@endsection


@section('content')
<div class="container">
    <div class="row align-items-center mt-5 mb-5">
        <div class="col-12 col-lg-6 d-flex align-items-center mb-lg-0">
            <a href="{{url('curso/opinion-estudiante/'.$curso->id)}}" class="d-flex align-items-center text-decoration-none">
                <img src="{{asset('images/arrow_left.svg')}}" alt="Icon" class="me-4" style="width: 20px; height: 20px;">
                <h1 class="text-dark fw-bolder roboto-medium fs-2 my-0">Atrás</h1>
            </a>
        </div>
    </div>
    <div class="mb-4">
        <h4 class="fs-2">Modificar opinión del estudiante</h4>
    </div>
    <form id="formulario">

        <input type="hidden" name="id_curso" value="{{$curso->id}}">

        <input type="hidden" name="id" value="{{$opinion->id}}">

        <div class="row mt-3">
            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Nombre completo <small class="required"></small></label>
                <input type="text" name="nombre_completo" value="{{$opinion->nombre_completo}}" class="form-control roboto-medium" placeholder="Ingresar nombre completo" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Profesión </label>
                <input type="text" name="profesion" value="{{$opinion->profesion}}" class="form-control roboto-medium" placeholder="Ingresar profesión" >
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <label class="form-label fw-bolder roboto-medium">Opinión  <small class="required"></small></label>
                <textarea name="opinion" class="form-control roboto-medium" cols="3" rows="2" placeholder="Ingresar opinión"  required>{{$opinion->opinion}}</textarea>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Orden <small class="required"></small></label>
                <input type="number" name="orden" value="{{$opinion->orden}}" class="form-control roboto-medium" placeholder="Ingresar orden" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Habilitado <small class="required"></small></label>
                <select name="habilitado" class="form-select roboto-medium" required>
                    <option value="">Seleccione una opción</option>
                    @foreach($estados as $item)
                        @if($opinion->habilitado==$item->id)
                        <option value="{{$item->id}}" selected>{{$item->nombre}}</option>
                        @else
                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <a href="{{url('curso/opinion-estudiante/'.$curso->id)}}" class="btn btn-border-white">Cancelar</a>
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
     $('#navCurso').addClass('actived');
     var curso = {!! json_encode($curso) !!};

    var formulario = document.getElementById('formulario');

    $('#actualizar').on('click', function() {

        if (!formulario.checkValidity()) {
            formulario.reportValidity();
            return;
        }

        $.ajax({
            type: "POST",
            url: "{{url('curso/opinion-estudiante/actualizar-opinion-estudiante')}}",
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
                    setTimeout(function(){window.location = "/curso/opinion-estudiante/"+curso.id} , 2000);   
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
