@extends('layout.admin')
@section('titulo')
<title>Cursos</title>
@endsection

@section('styles')
@endsection

@section('header')
<h1 class="text-white lh-base fw-bolder roboto-medium fs-1">Cursos</h1>
@endsection


@section('content')
<div class="container">
    <div class="row align-items-center mt-5 mb-5">
        <div class="col-12 col-lg-6 d-flex align-items-center mb-lg-0">
            <a href="{{url('curso')}}" class="d-flex align-items-center text-decoration-none">
                <img src="{{asset('images/arrow_left.svg')}}" alt="Icon" class="me-4" style="width: 20px; height: 20px;">
                <h1 class="text-dark fw-bolder roboto-medium fs-2 my-0">Atrás</h1>
            </a>
        </div>
    </div>
    <div class="mb-4">
        <h4 class="fs-2">Modificar curso</h4>
    </div>
    <form id="formulario">

        <input type="hidden" name="id" value="{{$curso->id}}">
        
        <div class="row mt-3">
            <div class="col-md-12">
                <label class="form-label fw-bolder roboto-medium">Nombre <small class="required"></small></label>
                <input type="text" name="nombre" value="{{$curso->nombre}}" class="form-control roboto-medium" placeholder="Ingresar nombre" required>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">ID curso externo</label>
                <input type="text" name="id_curso_externo" value="{{$curso->id_curso_externo}}" class="form-control roboto-medium" placeholder="Ingresar ID curso externo" >
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Orden </label>
                <input type="number" name="orden" value="{{$curso->orden}}" class="form-control roboto-medium" placeholder="Ingresar orden" required>
            </div>
        </div>


        <div class="row mt-3">
            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Duración <small class="required"></small></label>
                <input type="text" name="duracion" value="{{$curso->duracion}}" class="form-control roboto-medium" placeholder="Ingresar duración y horas" required >
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Recursos disponibles <small class="required"></small></label>
                <input type="number" name="recursos_disponibles" value="{{$curso->recursos_disponibles}}" class="form-control roboto-medium" placeholder="Ingresar la cantidad de recursos disponibles" required>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Fecha inicio <small class="required"></small></label>
                <input type="date" name="fecha_inicio" value="{{$curso->fecha_inicio}}" class="form-control roboto-medium" placeholder="Ingresar la fecha de inicio del curso" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Fecha fin <small class="required"></small></label>
                <input type="date" name="fecha_fin" value="{{$curso->fecha_fin}}" class="form-control roboto-medium" placeholder="Ingresar la fecha final del curso" required>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-4">
                <label class="form-label fw-bolder roboto-medium">Precio <small class="required"></small></label>
                <input type="number" id="precio"  name="precio" step="0.01" value="{{number_format($curso->precio, 2, '.', '')}}" class="form-control roboto-medium" placeholder="Ingresar el precio" required>
            </div>
            
            <div class="col-md-4">
                <label class="form-label fw-bolder roboto-medium">Descuento </label>
                <div class="porcentaje">
                    <input type="number" id="descuento"  name="descuento" step="0.01" value="{{number_format($curso->descuento, 2, '.', '')}}" class="form-control roboto-medium" placeholder="Ingresar el descuento" min="0" max="100">
                    <span>%</span>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bolder roboto-medium">Precio con descuento </label>
                <input type="number" id="precio_descuento" value="{{number_format($curso->precio_descuento, 2, '.', '')}}" name="precio_descuento" step="0.01" class="form-control roboto-medium" placeholder="Ingresar el precio" readonly>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <label class="form-label fw-bolder roboto-medium">Resumen  <small class="required"></small></label>
                <textarea name="resumen" class="form-control roboto-medium" cols="3" rows="3" placeholder="Ingresar resumen"  required>{{$curso->resumen}}</textarea>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <label class="form-label fw-bolder roboto-medium">Requisitos </label>
                <textarea name="requisitos" class="form-control roboto-medium" cols="3" rows="3" placeholder="Ingresar requisitos">{{$curso->requisitos}}</textarea>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <label class="form-label fw-bolder roboto-medium">Objetivos </label>
                <textarea name="objetivos" class="form-control roboto-medium" cols="3" rows="3" placeholder="Ingresar objetivos">{{$curso->objetivos}}</textarea>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <label class="form-label fw-bolder roboto-medium">Contenido </label>
                <textarea name="contenido" class="form-control roboto-medium" cols="3" rows="3" placeholder="Ingresar contenido">{{$curso->contenido}}</textarea>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-12">
                <label class="form-label fw-bolder roboto-medium">Archivo PDF</label>
                <div class="alert alert-info roboto-medium">
                    El archivo debe ser en formato PDF y no debe exceder los 10MB.
                </div>
                <div class="file-upload-wrap" id="file-upload-wrap">
                    <input type="hidden" name="archivo" id="archivo">
                    <input class="file-upload-input" id="file-upload-input" type='file' onchange="readPDF(this);" accept="application/pdf" />
                    <div class="drag-text">
                        <h3>Arrastra el PDF o selecciona uno</h3>
                    </div>
                </div>
                <div class="file-upload-content" id="file-upload-content" style="display: none;">
                    <div class="pdf-file-info">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/PDF_file_icon.svg/1024px-PDF_file_icon.svg.png" alt="PDF Icon" width="30" />
                        <span id="file-name"></span>
                    </div>
                    <div class="file-title-wrap">
                        <button type="button" onclick="removeUploadFile()" class="btn btn-border-white">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-12">
                <label class="form-label fw-bolder roboto-medium">Imagen </label>
                    <div class="alert alert-info roboto-medium">
                    Para asegurar la calidad de la imagen debe cumplir con el siguiente peso: ser menor a 10MB y una dimensión aproximada: 700x312 px.
                    </div>
                <div class="image-upload-wrap" id="image-upload-wrap">
                    <input type="hidden" name="imagen" id="imagen">
                    <input class="image-upload-input" id="image-upload-input" type='file' onchange="readURL(this);" accept="image/jpg, image/jpeg,image/png" />
                    <div class="drag-text">
                        <h3>Arrastra la imagen o selecciona</h3>
                    </div>
                </div>
                <div class="image-upload-content" id="image-upload-content">
                    <img class="file-upload-image" id="image-upload-image" src="#" alt="Imagen" />
                    <div class="image-title-wrap">
                        <button type="button" onclick="removeUploadImage()" class="btn btn-border-white">Eliminar</button>
                        <button type="button" onclick="getImage()" id="btnRecortar" class="btn btn-primary">Recortar</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Curso popular <small class="required"></small></label>
                <select name="curso_popular" class="form-select roboto-medium" required>
                    <option value="">Seleccione si es un curso popular</option>
                    <option @if($curso->curso_popular == 1) selected @endif value="1">Si</option>
                    <option @if($curso->curso_popular == 0) selected @endif value="0">No</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Curso ideal <small class="required"></small></label>
                <select name="curso_ideal" class="form-select roboto-medium" required>
                    <option value="">Seleccione si es un curso ideal</option>
                    <option @if($curso->curso_ideal == 1) selected @endif value="1">Si</option>
                    <option @if($curso->curso_ideal == 0) selected @endif value="0">No</option>
                </select>
            </div>        
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Habilitado <small class="required"></small></label>
                <select name="habilitado" class="form-select roboto-medium" required>
                    <option value="">Seleccione un estado</option>
                    @foreach($estados as $item)
                        @if($curso->habilitado==$item->id)
                            <option value="{{$item->id}}" selected>{{$item->nombre}}</option>
                        @else
                            <option value="{{$item->id}}">{{$item->nombre}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Notificar suscriptores <small class="required"></small></label>
                <select name="notificar_suscriptores" class="form-select roboto-medium" required>
                    <option value="">Seleccione un estado</option>
                    @foreach($estados as $item)
                        @if($curso->notificar_suscriptores==$item->id)
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
                <label class="form-label fw-bolder roboto-medium">Docente <small class="required"></small></label>
                <select name="id_docente" class="form-select roboto-medium" required>
                    <option value="">Seleccione una docente</option>
                    @foreach($docentes as $item)
                        @if($curso->id_docente==$item->id)
                            <option value="{{$item->id}}" selected>{{$item->nombre_completo}}</option>
                        @else
                            <option value="{{$item->id}}">{{$item->nombre_completo}}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Subcategoría <small class="required"></small></label>
                <select name="id_subcategoria_curso" class="form-select roboto-medium" required>
                    <option value="">Seleccione una subcategoría</option>
                    @foreach($subcategorias as $item)
                        @if($curso->id_subcategoria_curso==$item->id)
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
                <label class="form-label fw-bolder roboto-medium">Modalidad <small class="required"></small></label>
                <select name="id_modalidad" class="form-select roboto-medium" required>
                    <option value="">Seleccione una modalidad</option>
                    @foreach($modalidades as $item)
                        @if($curso->id_modalidad==$item->id)
                            <option value="{{$item->id}}" selected>{{$item->nombre}}</option>
                        @else
                            <option value="{{$item->id}}">{{$item->nombre}}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bolder roboto-medium">Tipo de curso <small class="required"></small></label>
                <select name="id_tipo_curso" class="form-select roboto-medium" required>
                    <option value="">Seleccione un tipo de curso</option>
                    @foreach($tiposCurso as $item)
                        @if($curso->id_tipo_curso==$item->id)
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
                <a href="{{url('curso')}}" class="btn btn-border-white">Cancelar</a>
                <a id="actualizar" class="btn btn-primary">Actualizar</a>
            </div>
        </div>
    </form>
   
</div>


@endsection
@push('scripts')     
<script type="text/javascript">
$(document).ready(function() {
    const precioInput = document.getElementById("precio");
    const descuentoInput = document.getElementById("descuento");
    const precioDescuentoInput = document.getElementById("precio_descuento");
    if (!precioInput || !descuentoInput || !precioDescuentoInput) {
        console.error("Uno o más elementos no fueron encontrados en el DOM.");
        return;
    }

    function calcularDescuento() {
        const precio = parseFloat(precioInput.value) || 0;
        const descuento = parseFloat(descuentoInput.value) || 0;
        const precioFinal = precio - (precio * descuento / 100);
        precioDescuentoInput.value = precioFinal.toFixed(2);
    }

    precioInput.addEventListener("input", calcularDescuento);
    descuentoInput.addEventListener("input", calcularDescuento);






    
     $('#cursos').addClass('here show');
     $('#navCurso').addClass('actived');

    var cropper = null;
    var recortado = true;

    var formulario = document.getElementById('formulario');

    var curso = {!! json_encode($curso) !!};
   

    var imagen = curso.imagen;
    var archivo = curso.archivo;

    if (imagen!=null) {
        imagen = imagen.substring(1,imagen.length);
        $('#image-upload-image').attr('src',`{{asset('`+imagen+`')}}`);
        $('#image-upload-wrap').hide();
        $('#image-upload-content').show();
        $('#btnRecortar').hide();
    }

    if (archivo!=null) {
        archivo = archivo.substring(1,archivo.length);
        $('#file-name').text(archivo);
        $('#file-upload-wrap').hide();
        $('#file-upload-content').show();
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
            url: "{{url('curso/actualizar-curso')}}",
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
                    setTimeout(function(){window.location = "/curso"} , 2000);   
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

    readPDF = function(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            if (!file) {
                return;
            }
            console.log("ss");
            // Verifica si el archivo es PDF
            if (file.type !== 'application/pdf') {
                toastr.error('Solo se permite cargar archivos PDF.', 'Error!');
                return;
            }

            console.log("sss");
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onloadend = function(e) {
                let base64String = e.target.result;
                $('#archivo').val(base64String);
                $('#file-name').text(file.name);
                $('#file-upload-wrap').hide();
                $('#file-upload-content').show();
                
            console.log("ssss");
            }
        } else {
            removeUploadFile();
        }
    }


    removeUploadFile = function() {
        $('#file-upload-input').replaceWith($('.file-upload-input').clone());
        $('#file-upload-content').hide();
        $('#file-upload-wrap').show();
        $('#file-upload-input').val('');
        $('#archivo').val('');
    }

    $('#file-upload-wrap').bind('dragover', function () {
        $('#file-upload-wrap').addClass('image-dropping');
    });

    $('#file-upload-wrap').bind('dragleave', function () {
        $('#file-upload-wrap').removeClass('image-dropping');
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
                        $('#image-upload-image').attr('src', e.target.result);
                        $('#image-upload-content').show();
                        recortado = false;
                        const image = document.getElementById('image-upload-image');
                        cropper = new Cropper(image, {
                            aspectRatio: 2.24 / 1,
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
            removeUploadImage();
        }
    }


    removeUploadImage = function() {
        $('#image-upload-input').replaceWith($('.image-upload-input').clone());
        $('#image-upload-content').hide();
        $('#image-upload-wrap').show();
        $('#image-upload-input').val('');
        $('#image-upload-wrap').removeClass('image-dropping');
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
        $('#image-upload-image').attr('src', cropper.getCroppedCanvas().toDataURL());
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
