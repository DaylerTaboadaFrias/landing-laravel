@extends('layout.landing')
@section('titulo')
<title>Postula</title>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/plugins/intlTelInput/intlTelInput.css')}}">
@endsection
@section('content')

<div class="pt-15 pb-15 bg-primary position-relative z-index-2">
    <img src="{{asset('images/curva_1.png')}}" class="left-top-ornament ornament-200">
    <img src="{{asset('images/curva_2.png')}}" class="right-bottom-ornament ornament-200">
	<div class="container pt-15 pb-15">
		<div class="text-center pb-4">
			<p class="fs-6 text-medium-secondary-light">Trabaja con nosotros</p>
		  	<h2 class="fs-3x text-bold-primary white">Únete a nuestro equipo de docentes</h2>
        </div>
  	</div>

</div>
<img 
  src="{{ asset($portada->imagen) }}" 
  class="img-fluid @if(!empty($portada->enlace)) clickable-image @endif" 
  @if(!empty($portada->enlace)) 
    data-href="{{ $portada->enlace }}" 
  @endif
  alt="Portada" 
/>


<form id="formulario">
    <div class="pt-15 pb-15">
    	<div class="container">
    		<div class="row pb-4">
    		  	<div class="col-md-8 roboto-medium">
    				<h1 class="fs-3x text-bold-primary mb-4">
    				Comparte tu experiencia como docente con nosotros
    				</h1>

    				<h5 class="fs-2x text-bold-primary">Completa el formulario</h5>
                
                    <div class="row mb-3 mt-10">
                        <div class="col-md-12 mt-md-0 mt-4">
                        	<label class="fs-6 text-bold-primary mb-2">Nombre completo</label>
                            <input type="text" class="form-control" placeholder="Nombre completo" name="nombre_completo" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 mt-md-0 mt-4">
                        	<label class="fs-6 text-bold-primary mb-2">Perfil profesional</label>
                            <input type="text" class="form-control" placeholder="Perfil profesional" name="perfil_profesional" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 mt-md-0 mt-4">
                        	<label class="fs-6 text-bold-primary mb-2">Especializaciones</label>
                            <input type="text" class="form-control" placeholder="Especializaciones" name="especializaciones" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 mt-md-0 mt-4">
                            <label class="fs-6 text-bold-primary mb-2">Telefono</label>
                            <div class="roboto-medium">
                                <input name="telefono" type="number"  class="form-control roboto-medium ml-5" placeholder="Teléfono" id="telefono" required>
                            </div>
                         </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 mt-md-0 mt-4">
                            <label class="fs-6 text-bold-primary mb-2">Correo electrónico del contacto</label>
                            <input type="email" class="form-control" placeholder="Correo electrónico del contacto" name="correo" required>
                         </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-md-12 mt-md-0 mt-4">
                        	<label class="fs-6 text-bold-primary mb-2">Disponibilidad</label>
                            <select class="form-select" placeholder="Cursos" name="id_disponibilidad" required>
                            	<option>Selecciona una opción</option>
                                @foreach($disponibilidades as $item)
                                    <option value="{{$item->id}}">{{$item->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12 mt-md-0 mt-4">
                        	<label class="fs-6 text-bold-primary mb-2">¿Cuál es tu experiencia como docente?</label>
                            <textarea class="form-control" placeholder="¿Cuál es tu experiencia como docente?" rows="5" name="experiencia" required></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 mt-md-0 mt-4">
                        	<label class="fs-6 text-bold-primary mb-2">Referencias</label>
                            <textarea class="form-control" placeholder="Referencias" rows="5" name="referencias" required></textarea>
                        </div>
                    </div>
    		  	</div>
    		  	<div class="col-md-4">
    			    <div class="card bg-primary rounded-3 mb-4">
    			      <div class="card-body">
                        <h5 class="fs-6 text-bold-primary white text-center">Adjunta tu curriculum vitae</h5>

    					<div class="d-flex justify-content-center align-items-center mb-3">
    						<img src="{{asset('images/error.png')}}" class="img-icon-20">
    					</div>
    					<p class="fs-6 fs-6 text-medium-secondary-light roboto-medium text-center">Tipo de archivo permitido: PDF, Word...</p>
    					<p class="fs-6 fs-6 text-medium-secondary-light roboto-medium text-center">Peso permitido: 10 Mb</p>
    			      	<div class="row mt-4">
    			      		<div class="col-md-12">
    			    			<div class="rounded-3 bg-card-light">
    								<div class="file-upload-wrap" id="file-upload-wrap">
    									<input type="hidden" name="archivo" id="archivo">
    									<input class="file-upload-input" id="file-upload-input" type='file' onchange="readPDF(this);" accept="application/pdf" required/>
    									<div class="drag-text py-12">
    										<div class="symbol symbol-circle symbol-50px">
    											<img src="{{asset('images/docs.png')}}" alt=""/>
    										</div>
    										<p class="fs-6 text-normal roboto-medium">
    											Suelta el archivo aquí
    										</p>			
    									</div>
    								</div>
    								<div class="file-upload-content  py-12" id="file-upload-content" style="display: none;">
    									<div class="pdf-file-info py-6">
    										<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/PDF_file_icon.svg/1024px-PDF_file_icon.svg.png" alt="PDF Icon" width="30" />
    										<span id="file-name"></span>
    									</div>
    									<div class="file-title-wrap">
    										<button type="button" onclick="removeUploadFile()" class="btn btn-border-white">Eliminar</button>
    									</div>
    								</div>
    			      			</div>
    			      		</div>
    			      	</div>

                        <a id="btn-subir-doc" class="btns btn-round-secondary cursor-pointer mt-4 w-100">
    		                SUBIR DOCUMENTO
    		                <img src="{{asset('images/arrow_forward.png')}}" class="icon-img ms-2">
    		            </a>

    			      </div>
    			    </div>
    		    </div>
    		    <div class="col-md-12">
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <div class="d-flex align-items-start mb-4 mt-md-0 mt-4">
                                <input class="form-check-input col-md-2 col-2 mt-1" type="checkbox" name="acepto" id="acepto" required>
                                <label class="fs-6 text-normal text-start ms-2">
                                    Al enviar este formulario, aceptas que CENACE utilice tus datos personales para evaluar tu postulación. La información será tratada de forma confidencial y no se compartirá con terceros sin tu consentimiento, salvo lo permitido por la ley.
                                </label>
                            </div>  
                        </div>
                    </div>
    		        <div class="row mb-3">
                        <div class="col-md-8">
    		            <a id="registrar" class="btns btn-round-primary cursor-pointer w-100">
    		                ENVIAR SOLICITUD
    		                <img src="{{asset('images/arrow_forward_white.png')}}" class="icon-img ms-2">
    		            </a>
                        </div>
    		        </div>
    		    </div>
    	    </div>
    	</div>
    </div>
</form>

@endsection
@push('scripts')     
<script src="{{asset('assets/plugins/intlTelInput/intlTelInput.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.clickable-image')
    .css('cursor','pointer')
    .on('click', function(){
      var url = $(this).data('href');
      if (url) {
        window.open(url, '_blank');
      }
    });

    var input = document.querySelector("#telefono");
    var iti = intlTelInput(input, {
        preferredCountries: ['bo'],
        separateDialCode: true,
        initialCountry: 'bo',
        utilsScript: "{{asset('assets/plugins/intlTelInput/utils.js')}}"
    });
    
	$('#btn-subir-doc').on('click', function(e) {
        e.preventDefault();
        $('#file-upload-input').click();
    });

	var formulario = document.getElementById('formulario');
    $('#registrar').on('click', function() {
        if (!formulario.checkValidity()) {
            formulario.reportValidity();
            return;
        }
        var codigoPais = iti.getSelectedCountryData().dialCode;
        var formData = new FormData($("#formulario")[0]);
		formData.append('codigoPais', codigoPais); 
        $.ajax({
            type: "POST",
            url: "{{url('postulacion/registrar-postulacion')}}",
            data: formData,
            dataType:'json',
            async:true,
            type:'post',
            processData: false,
            contentType: false,
            success: function( response ) {
                if (response.success) {
					$('#formulario')[0].reset();
					removeUploadFile();
                    $('#solicitudEnviadaTitulo').text("¡Solicitud realizada con éxito!");
                    $('#solicitudEnviadaDescripcion').text("Tu solicitud de contacto ha sido enviada correctamente. Pronto recibirás noticias nuestras con respecto al proceso de selección.");
                    $("#solicitudEnviada").modal('show');

                }else{
                    $("#error").modal('show');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
				$("#error").modal('show');
            }
        });
    });
	readPDF = function(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            if (!file) {
                return;
            }

            if (file.type !== 'application/pdf') {
                toastr.error('Solo se permite cargar archivos PDF.', 'Error!');
                return;
            }

            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onloadend = function(e) {
                let base64String = e.target.result;
                $('#archivo').val(base64String);
                $('#file-name').text(file.name);
                $('#file-upload-wrap').hide();
                $('#file-upload-content').show();
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
        $('#file-upload-input').prop('required',true);
        $('#archivo').val('');
    }

    $('#file-upload-wrap').bind('dragover', function () {
        $('#file-upload-wrap').addClass('image-dropping');
    });

    $('#file-upload-wrap').bind('dragleave', function () {
        $('#file-upload-wrap').removeClass('image-dropping');
    });
});
</script>
@endpush
