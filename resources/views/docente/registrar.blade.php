@extends('layout.admin')
@section('titulo')
<title>Docentes</title>
@endsection

@section('styles')
@endsection

@section('header')
<h1 class="text-white lh-base fw-bolder roboto-medium fs-1">Docentes</h1>
@endsection


@section('content')
<div class="container">
    <div class="row align-items-center mt-5 mb-5">
        <div class="col-12 col-lg-6 d-flex align-items-center mb-lg-0">
            <a href="{{url('docente')}}" class="d-flex align-items-center text-decoration-none">
                <img src="{{asset('images/arrow_left.svg')}}" alt="Icon" class="me-4" style="width: 20px; height: 20px;">
                <h1 class="text-dark fw-bolder roboto-medium fs-2 my-0">Atrás</h1>
            </a>
        </div>
    </div>
    <div class="mb-4">
        <h4 class="fs-2">Crear nuevo docente</h4>
    </div>
    <form id="formulario">

        <div class="row mt-3">
            <div class="col-md-4">
                <label class="form-label fw-bolder roboto-medium">Prefijo academico<small class="required"></small></label>
                <input type="text" name="prefijo_academico" class="form-control roboto-medium" placeholder="Lic,Msc,Dr,Ing,etc." required>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bolder roboto-medium">Nombre completo<small class="required"></small></label>
                <input type="text" name="nombre_completo" class="form-control roboto-medium" placeholder="Ingresar nombre completo" required>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bolder roboto-medium">Profesión <small class="required"></small></label>
                <input type="text" name="profesion" class="form-control roboto-medium" placeholder="Ingresar profesión" required>
            </div>
        </div>

        <div class="row mt-3">
            
            <div class="col-md-4">
                <label class="form-label fw-bolder roboto-medium">Profesión <small class="required"></small></label>
                <input type="text" name="profesion" class="form-control roboto-medium" placeholder="Ingresar profesión" required>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bolder roboto-medium">ID docente externo</label>
                <input type="text" name="id_docente_externo" class="form-control roboto-medium" placeholder="Ingresar ID docente externo" >
            </div>

        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <label class="form-label fw-bolder roboto-medium">Biografía  <small class="required"></small></label>
                <textarea name="biografia" class="form-control roboto-medium" cols="5" rows="3" placeholder="Ingresar biografía "  required></textarea>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Enlace linkedin <small class="required"></small></label>
                <input type="text" name="enlace_linkedin" class="form-control roboto-medium" placeholder="Ingresar enlace del linkedin" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Habilitado <small class="required"></small></label>
                <select name="habilitado" class="form-select roboto-medium" required>
                    <option value="">Seleccione una opción</option>
                    @foreach($estados as $item)
                        <option @if($item->id == 1) selected @endif value="{{$item->id}}">{{$item->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <label class="form-label fw-bolder roboto-medium">Imagen <small class="required"></small></label>
                    <div class="alert alert-info roboto-medium">
                    Para asegurar la calidad de la imagen debe cumplir con el siguiente peso: ser menor a 10MB y una dimensión aproximada: 500x500 px.
                    </div>
                <div class="image-upload-wrap" id="image-upload-wrap">
                    <input type="hidden" name="imagen" id="imagen">
                    <input class="file-upload-input" id="file-upload-input" type='file' onchange="readURL(this);" accept="image/jpg, image/jpeg,image/png" required=""/>
                    <div class="drag-text">
                        <h3>Arrastra la imagen o selecciona</h3>
                    </div>
                </div>
                <div class="file-upload-content" id="file-upload-content">
                    <img class="file-upload-image" id="file-upload-image" src="#" alt="Imagen" />
                    <div class="image-title-wrap">
                        <button type="button" onclick="removeUpload()" class="btn btn-border-white">Eliminar</button>
                        <button type="button" onclick="getImage()" id="btnRecortar" class="btn btn-primary">Recortar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <a href="{{url('docente')}}" class="btn btn-border-white">Cancelar</a>
                <a id="registrar" class="btn btn-primary">Registrar</a>
            </div>
        </div>
    </form>
   
</div>


@endsection
@push('scripts')     
<script type="text/javascript">
$(document).ready(function() {
     $('#cursos').addClass('here show');
     $('#navDocente').addClass('actived');


    var cropper = null;
    var recortado = true;

    var formulario = document.getElementById('formulario');


    $('#registrar').on('click', function() {

        if (!formulario.checkValidity()) {
            formulario.reportValidity();
            return;
        }

        if(!recortado){
          toastr.error('La imagen debe ser recortada', 'Ocurrio un error!');
          toastr.options.closeDuration = 10000;
          toastr.options.timeOut = 10000;
          toastr.options.extendedTimeOut = 10000;
          return;
        }

        $.ajax({
            type: "POST",
            url: "{{url('docente/registrar-docente')}}",
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
                    setTimeout(function(){window.location = "/docente"} , 2000);   
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


    readURL = function(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            if (!file) {
                return;
            }
            new Compressor(file, {
                quality: 0.3,
                success(result) {
                    var reader = new FileReader();
                    reader.readAsDataURL(result); 
                    reader.onloadend = function(e) {

                        $('#image-upload-wrap').hide();
                        $('#file-upload-image').attr('src', e.target.result);
                        $('#file-upload-content').show();
                        recortado = false;
                        const image = document.getElementById('file-upload-image');
                        cropper = new Cropper(image, {
                            aspectRatio: 1 / 1,
                            zoomable: false,
                            crop(event) {
                            },
                        });

                    }
                },
                error(err) {
                }
            });
        } else {
            removeUpload();
        }
    }


    removeUpload = function() {
        $('#file-upload-input').replaceWith($('.file-upload-input').clone());
        $('#file-upload-content').hide();
        $('#image-upload-wrap').show();
        $('#file-upload-input').val('');
        $('#image-upload-wrap').removeClass('image-dropping');
        $('#file-upload-input').prop('required',true);
        $('#btnRecortar').show();
        if(cropper!=null){
            cropper.destroy();
        }
    }

    $('#image-upload-wrap').bind('dragover', function () {
        $('#image-upload-wrap').addClass('image-dropping');
    });

    $('#image-upload-wrap').bind('dragleave', function () {
        $('#image-upload-wrap').removeClass('image-dropping');
    });


    getImage = function(){
        $('#file-upload-image').attr('src', cropper.getCroppedCanvas().toDataURL());
        $('#imagen').val(cropper.getCroppedCanvas().toDataURL());
        if(cropper!=null){
            cropper.destroy();
        }
        $('#btnRecortar').hide();
        recortado = true;
    } 
});
</script>
@endpush
