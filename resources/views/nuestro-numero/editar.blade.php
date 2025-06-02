@extends('layout.admin')
@section('titulo')
<title>Nuestros números</title>
@endsection

@section('styles')
@endsection

@section('header')
<h1 class="text-white lh-base fw-bolder roboto-medium fs-1">Nuestros números</h1>
@endsection


@section('content')
<div class="container">
    <div class="row align-items-center mt-5 mb-5">
        <div class="col-12 col-lg-6 d-flex align-items-center mb-lg-0">
            <a href="{{url('nuestro-numero')}}" class="d-flex align-items-center text-decoration-none">
                <img src="{{asset('images/arrow_left.svg')}}" alt="Icon" class="me-4" style="width: 20px; height: 20px;">
                <h1 class="text-dark fw-bolder roboto-medium fs-2 my-0">Atrás</h1>
            </a>
        </div>
    </div>
    <div class="mb-4">
        <h4 class="fs-2">Modificar nuestros números</h4>
    </div>
    <form id="formulario">
        <input type="hidden" name="id" value="{{$nuestroNumero->id}}">
        <div class="row mt-3">
            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Título <small class="required"></small></label>
                <input type="text" name="titulo" value="{{$nuestroNumero->titulo}}" class="form-control roboto-medium" placeholder="Ingresar título" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Subtítulo <small class="required"></small></label>
                <input type="text" name="subtitulo" value="{{$nuestroNumero->subtitulo}}" class="form-control roboto-medium" placeholder="Ingresar subtítulo" required>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Orden <small class="required"></small></label>
                <input type="number" name="orden" value="{{$nuestroNumero->orden}}" class="form-control roboto-medium" placeholder="Ingresar orden" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Habilitado <small class="required"></small></label>
                <select name="habilitado" class="form-select roboto-medium" required>
                    <option value="">Seleccione una opción</option>
                    @foreach($estados as $item)
                        @if($nuestroNumero->habilitado==$item->id)
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
                <a href="{{url('nuestro-numero')}}" class="btn btn-border-white">Cancelar</a>
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
     $('#navNuestroNumero').addClass('actived');

    var cropper = null;
    var recortado = true;

    var formulario = document.getElementById('formulario');

    var nuestroNumero = {!! json_encode($nuestroNumero) !!};
   

    var imagen = nuestroNumero.imagen;
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
            url: "{{url('nuestro-numero/actualizar-nuestro-numero')}}",
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
                    setTimeout(function(){window.location = "/nuestro-numero"} , 2000);   
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
