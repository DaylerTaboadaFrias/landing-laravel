@extends('layout.admin')
@section('titulo')
<title>Encuentra tu curso ideal</title>
@endsection

@section('styles')
@endsection

@section('header')
<h1 class="text-white lh-base fw-bolder roboto-medium fs-1">Encuentra tu curso ideal</h1>
@endsection


@section('content')
<div class="container">
    <div class="row align-items-center mt-5 mb-5">
        <div class="col-12 col-lg-6 d-flex align-items-center mb-lg-0">
            <a href="{{url('encuentra-curso-ideal')}}" class="d-flex align-items-center text-decoration-none">
                <img src="{{asset('images/arrow_left.svg')}}" alt="Icon" class="me-4" style="width: 20px; height: 20px;">
                <h1 class="text-dark fw-bolder roboto-medium fs-2 my-0">Atrás</h1>
            </a>
        </div>
    </div>
    <div class="mb-4">
        <h4 class="fs-2">Modificar encuentra curso ideal</h4>
    </div>
    <form id="formulario">
        <input type="hidden" name="id" value="{{$encuentraCurso->id}}">
        <div class="row mt-3">
            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Título <small class="required"></small></label>
                <input type="text" name="titulo" value="{{$encuentraCurso->titulo}}" class="form-control roboto-medium" placeholder="Ingresar título" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Subtítulo <small class="required"></small></label>
                <input type="text" name="subtitulo" value="{{$encuentraCurso->subtitulo}}" class="form-control roboto-medium" placeholder="Ingresar subtítulo" required>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Título enlace <small class="required"></small></label>
                <input type="text" name="titulo_enlace" value="{{$encuentraCurso->titulo_enlace}}" class="form-control roboto-medium" placeholder="Ingresar el titulo del enlace" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Enlace <small class="required"></small></label>
                <input type="text" name="enlace" value="{{$encuentraCurso->enlace}}" class="form-control roboto-medium" placeholder="Ingresar enlace" required>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <label class="form-label fw-bolder roboto-medium">Imagen </label>
                    <div class="alert alert-info roboto-medium">
                    Para asegurar la calidad de la imagen debe cumplir con el siguiente peso: ser menor a 10MB y una dimensión aproximada: 472x482 px.
                    </div>
                <div class="image-upload-wrap" id="image-upload-wrap">
                    <input type="hidden" name="imagen" id="imagen">
                    <input class="file-upload-input" id="file-upload-input" type='file' onchange="readURL(this);" accept="image/jpg, image/jpeg,image/png"/>
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
                <a href="{{url('encuentra-curso-ideal')}}" class="btn btn-border-white">Cancelar</a>
                <a id="actualizar" class="btn btn-primary">Actualizar</a>
            </div>
        </div>
    </form>
   
</div>


@endsection
@push('scripts')     
<script type="text/javascript">
$(document).ready(function() {
     $('#home').addClass('here show');
     $('#navEncuentraCursoIdeal').addClass('actived');

    var cropper = null;
    var recortado = true;

    var formulario = document.getElementById('formulario');

    var encuentraCurso = {!! json_encode($encuentraCurso) !!};
   

    var imagen = encuentraCurso.imagen;
    if (imagen!=null) {
        imagen = imagen.substring(1,imagen.length);
        $('#file-upload-image').attr('src',`{{asset('`+imagen+`')}}`);
        $('#image-upload-wrap').hide();
        $('#file-upload-content').show();
        $('#btnRecortar').hide();
    }

    $('#actualizar').on('click', function() {

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
            url: "{{url('encuentra-curso-ideal/actualizar-encuentra-curso-ideal')}}",
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
                    setTimeout(function(){window.location = "/encuentra-curso-ideal"} , 2000);   
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
                            aspectRatio: 0.98 / 1,
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
        $('#btnRecortar').show();
        if(cropper!=null){
            cropper.destroy();
        }
        recortado = true;
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
