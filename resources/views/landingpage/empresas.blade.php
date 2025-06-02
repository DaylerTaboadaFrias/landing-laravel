@extends('layout.landing')
@section('titulo')
<title>Empresas</title>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/plugins/intlTelInput/intlTelInput.css')}}">
@endsection
@section('content')

<div class="pt-15 pb-15 bg-primary position-relative z-index-2">
	<div class="container pt-15 pb-15">
		<img src="{{asset('images/curva_1.png')}}" class="left-top-ornament ornament-200">
		<img src="{{asset('images/curva_2.png')}}" class="right-bottom-ornament ornament-200">
		<div class="text-center pb-4">
			<p class="fs-6 text-medium-secondary-light">Capacitaciones In Company</p>
		  	<h2 class="fs-3x text-bold-primary white">Solicita una cotización para cursos in company</h2>
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

<div class="pt-15 pb-15">
	<div class="container">
		<div class="row pb-4">
		  	<div class="col-md-8 order-2 order-md-1">
				<h1 class="fs-3x text-bold-primary mb-4">
				Cuéntanos tus necesidades, para una cotización a tu medida
				</h1>

				<h5 class="fs-2x text-bold-primary">Completa el formulario</h5>

                <form id="formulario">
                    <div class="row mb-3 mt-10">
                    	<div class="col-md-12 mt-md-0 mt-4">
	                    	<label class="fs-6 text-bold-primary mb-2">Nombre de la compañía</label>
	                        <input type="text" class="form-control roboto-medium" name="nombre_empresa" placeholder="Nombre de la compañía" required>
                    	</div>
                    </div>
                    <div class="row mb-3">
                    	<div class="col-md-12 mt-md-0 mt-4">
	                    	<label class="fs-6 text-bold-primary mb-2">Responsable del contacto</label>
	                        <input type="text" class="form-control roboto-medium" name="nombre_responsable" placeholder="Responsable del contacto" required>
                    	</div>
                    </div>
                    <div class="row mb-3">
                    	<div class="col-md-12 mt-md-0 mt-4">
	                    	<label class="fs-6 text-bold-primary mb-2">Correo electrónico del contacto</label>
	                        <input type="email" class="form-control roboto-medium" name="correo_responsable" placeholder="Correo electrónico del contacto" required>
                    	</div>
                    </div>
                    <div class="row mb-3">
                    	<div class="col-md-12 mt-md-0 mt-4">
	                    	<label class="fs-6 text-bold-primary mb-2">Telefono</label>
							<div class="roboto-medium">
								<input name="telefono_responsable" type="tel"  class="form-control roboto-medium ml-5" placeholder="Teléfono" id="telefono" required>
							</div>
                    	</div>
                    </div>
                    <div class="row mb-3">
                    	<div class="col-md-12 mt-md-0 mt-4">
	                    	<label class="fs-6 text-bold-primary mb-2">Curso de interés</label>
	                    	 <select name="id_curso" id="cursoSelect" class="form-select form-select-lg" data-control="select2" data-placeholder="Seleccione una opción" data-allow-clear="true" required>
	                        	<option>Seleccione una opción</option>
	                        	@if($curso!=null)
	                        		<option value="{{$curso->id}}" selected>{{$curso->nombre}}</option>
	                        	@endif
	                        </select>
                    	</div>
                    </div>
                    <div class="row mb-3">
                    	<div class="col-md-12 mt-md-0 mt-4">
	                    	<label class="fs-6 text-bold-primary mb-2">Duración del curso</label>
	                        <input type="text" class="form-control roboto-medium" name="duracion_curso" placeholder="Duración del curso" required>
                    	</div>
                    </div>
                    <div class="row mb-3">
                    	<div class="col-md-12 mt-md-0 mt-4">
	                    	<label class="fs-6 text-bold-primary mb-2">Fecha</label>
	                        <input type="date" class="form-control roboto-medium" name="fecha_curso" placeholder="Fecha" required>
                    	</div>
                    </div>
                    <div class="row mb-3">
                    	<div class="col-md-12 mt-md-0 mt-4">
	                    	<label class="fs-6 text-bold-primary mb-2">Localización del curso</label>
	                        <input type="text" class="form-control roboto-medium" name="localizacion_curso" placeholder="Localización del curso" required>
                    	</div>
                    </div>
                    <div class="row mb-3">
                    	<div class="col-md-6 mt-md-0 mt-4">
	                    	<label class="fs-6 text-bold-primary mb-2">Modalidad</label>
	                        <select class="form-select roboto-medium" name="id_modalidad" placeholder="Modalidad" required>
	                        	<option>Seleccione una opción</option>
	                        	@foreach($modalidades as $item)
	                        		<option value="{{$item->id}}">{{$item->nombre}}</option>
	                        	@endforeach
	                        </select>
                    	</div>
                    	<div class="col-md-6 mt-md-0 mt-4">
	                    	<label class="fs-6 text-bold-primary mb-2">Número de participantes</label>
	                         <input type="number" class="form-control roboto-medium" name="numero_participante" placeholder="Número de participantes" required>
                    	</div>
                    </div>
                    <div class="row mb-3">
                    	<div class="col-md-12 mt-md-0 mt-4">
	                    	<label class="fs-6 text-bold-primary mb-2">Especifica lo que esperas del curso</label>
	                        <textarea class="form-control roboto-medium" name="expectativa_curso" placeholder="Especifica lo que esperas del curso" rows="5" required></textarea>
                    	</div>
                    </div>
                    <div class="row mb-3">
                    	<div class="col-md-12">
		                    <a id="registrar" class="btns btns btn-round-primary mt-4 w-100 cursor-pointer">
				                GUARDAR
				            </a>
                    	</div>
                    </div>
                </form>
		  	</div>
		  	<div class="col-md-4 order-1 order-md-2">
			    <div class="card bg-primary rounded-3 mb-4">
			      <div class="card-body">
                    <h5 class="fs-2x text-bold-primary white text-center">¿Porqué elegir CENACE para capacitarse?</h5>
			      	<div class="row row-cols-1 row-cols-md-6 g-4 justify-content-md-center mt-4">
						@foreach ($caracteristicas as $item)
							<div class="col-md-5">
								<div class="card rounded-3 h-100 bg-card-light mb-4">
									<div class="card-body card-padding-h-0 text-center">
										<div class="symbol symbol-circle symbol-50px">
											<img src="{{asset($item->imagen)}}" alt="{{ $item->nombre }}"/>
										</div>
										<p class="fs-6 text-normal roboto-medium">
											{{ $item->nombre }}
										</p>			
									</div>
								</div>
							</div>
						@endforeach
			      	</div>

					<a href="mailto:{{ $configuracionIncompany->correo }}" 
					   class="btns btn-round-secondary mt-4 w-100">
					    COMUNÍCATE CON UN ASESOR
					    <img src="{{ asset('images/arrow_forward.png') }}" class="icon-img ms-2" alt="→">
					</a>
					<a href="https://api.whatsapp.com/send?phone={{ $configuracionIncompany->codigo_area }}{{ $configuracionIncompany->celular }}" 
					   target="_blank" 
					   rel="noopener" 
					   class="btns btn-round-green mt-4 w-100">
					    ESCRÍBENOS POR WHATSAPP
					    <img src="{{ asset('images/arrow_forward.png') }}" class="icon-img ms-2" alt="→">
					</a>
			      </div>
			    </div>

			    @if($curso!=null)
	            <div class="card rounded-3 bg-primary mb-4">
	                <div class="card-body">
	                    <h5 class="fs-2x text-bold-primary white text-center">Verifica tu solicitud</h5>

	                    {{-- 
	                    <p class="fs-6 white mt-4 text-medium-primary color-number">ID de solicitud de cotización</p>
	                    <div class="d-flex justify-content-between">
	                    	<p class="fs-6 white roboto-medium">Nombre de la compañía</p>
	                    	<p class="fs-6 white roboto-medium text-end">Nombre</p>
	                    </div>
	                    <div class="d-flex justify-content-between">
	                    	<p class="fs-6 white roboto-medium">Contacto</p>
	                    	<p class="fs-6 white roboto-medium text-end">Contacto</p>
	                    </div>

	                    <div class="d-flex justify-content-between">
	                    	<p class="fs-6 white roboto-medium">Fecha de solicitud</p>
	                    	<p class="fs-6 white roboto-medium text-end">20/08/2024</p>
	                    </div>
	                    --}}
	                 	<div class="d-flex justify-content-between">
	                 		<div class="d-flex justify-content-between">
	                 			<div class="symbol symbol-50px">
	                 				<img src="{{asset($curso->imagen)}}" class="object-fit-cover">
	                 			</div>
	                 			<div class="row ms-2">
		                    		<p class="fs-6 white roboto-medium m-0">{{$curso->nombre}}</p>
		                    		<p class="fs-6 color-number roboto-medium">{{$curso->nombre_modalidad}}</p>	
	                 			</div>
	                 		</div>
	                 		<div class="row text-end">
	                    		<p class="fs-6 color-number roboto-medium m-0">Precio</p>
	                    		<p class="fs-6 color-number roboto-medium m-0">Bs. {{ $curso->precio_descuento }}</p>
	                    		@if ($curso->descuento != null || $curso->descuento != 0)
	                    		<p class="fs-6 white roboto-medium m-0">Descuento</p>
	                    		<p class="fs-6 white roboto-medium m-0">Bs. {{ $curso->precio }}</p>
	                    		@endif
	                 		</div>
	                 	</div>
		                <a id="completarSolicitud" 
						   class="btns btn-round-secondary mt-4 w-100 cursor-pointer">
						    ENVIAR SOLICITUD
						    <img src="{{ asset('images/arrow_forward.png') }}" class="icon-img ms-2" alt="→">
						</a>
	                </div>
	            </div>
	            @endif

	            <img src="{{ asset('images/logo_upsa.jpg') }}"
			     class="img-fluid d-none d-md-block"
			     alt="Logo">
	    	</div>
	    </div>
	    <div class="row pb-4">
	    	<img src="{{ asset('images/logo_upsa.jpg') }}"
		     class="img-fluid d-block d-md-none"
		     alt="Logo">
	    </div>
	</div>
</div>

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
  

	$('#telefono').on('input', function() {
	  $(this).val( $(this).val().replace(/\D/g, '') );
	});

    var input = document.querySelector("#telefono");
    var iti = intlTelInput(input, {
        preferredCountries: ['bo'],
        separateDialCode: true,
        initialCountry: 'bo',
        utilsScript: "{{asset('assets/plugins/intlTelInput/utils.js')}}"
    });


	var formulario = document.getElementById('formulario');

	$('#completarSolicitud').on('click', function(event) {
		enviarSolicitud();

	});

	$('#registrar').on('click', function(event) {
		enviarSolicitud();
    });


	function enviarSolicitud()
	{
		if (!formulario.checkValidity()) {
            formulario.reportValidity();
            return;
        }
		var codigoPais = iti.getSelectedCountryData().dialCode;
		var formData = new FormData($("#formulario")[0]);
		formData.append('codigoPais', codigoPais);
        $.ajax({
            type: "POST",
            url: "{{url('cotizacion-incompany/registrar-cotizacion-incompany')}}",
            data: formData ,
            dataType: 'json',
            async: true,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#formulario')[0].reset();
                    $('#solicitudEnviadaTitulo').text("¡Solicitud realizada con éxito!");
                    $('#solicitudEnviadaDescripcion').text("¡Gracias por contactarnos! Hemos recibido tu solicitud correctamente y nos comunicaremos contigo a la brevedad.");
                    $("#solicitudEnviada").modal('show');
                } else {
                    $("#error").modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $("#error").modal('show');
            }
        });
	}

	$('#cursoSelect').select2({
		placeholder: 'Seleccione una opción',
		allowClear: true,
		minimumInputLength: 3,
		ajax: {
			url: "{{url('cursos/obtener-cursos-nombre')}}",
			type: 'POST',
			dataType: 'json',
			delay: 250,
			global: false,
			headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: function(params) {
				return {
				nombre: params.term
				};
			},
			processResults: function(response) {
				if (response.success) {
					return {
						results: response.data.map(function(curso) {
							return {
							id:   curso.id,
							text: curso.nombre
							};
						})
					};
				}
				return { results: [] };
			},
			cache: true
		}
	});

});
</script>
@endpush
