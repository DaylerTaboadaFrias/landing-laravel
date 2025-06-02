@extends('layout.landing')
@section('titulo')
<title>Detalle del curso</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('assets/plugins/intlTelInput/intlTelInput.css')}}">
@endsection

@section('content')

<div class="pt-15 pb-15 bg-primary custom-bg position-relative z-index-2">
	<img src="{{asset('images/curva_1.png')}}" class="left-top-ornament ornament-200">
	<img src="{{asset('images/curva_2.png')}}" class="right-bottom-ornament ornament-200">
	<div class="container pt-15 pb-15">
		<div class="text-center pb-4">
		  <h2 class="fs-3x text-bold-primary white">{{ $curso->nombre }}</h2>
        </div>
  	</div>
</div>


<div class="pt-15 pb-15 bg-blue-light">
	<div class="container">
		<div class="row pb-4">
		  	<div class="col-md-8">
				<h1 class="fs-3x text-bold-primary mb-4">
				Acerca del curso
				</h1>

				<div class="accordion mb-4" id="accordionCourse">
					<div class="accordion-item">
						<h2 class="accordion-header" id="headingOne">
							<button class="accordion-button fs-6 text-bold-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								Resumen
							</button>
						</h2>
						<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionCourse">
							<div class="accordion-body fs-6 text-description-secondary roboto-medium">
								{!! nl2br(e($curso->resumen)) !!}
							</div>
						</div>
					</div>
					<div class="accordion-item">
						<h2 class="accordion-header" id="headingTwo">
							<button class="accordion-button fs-6 text-bold-primary collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
								Requisitos
							</button>
						</h2>
						<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionCourse">
							<div class="accordion-body fs-6 text-description-secondary roboto-medium">
								{!! nl2br(e($curso->requisitos)) !!}
							</div>
						</div>
					</div>
					<div class="accordion-item">
						<h2 class="accordion-header" id="headingThree">
							<button class="accordion-button fs-6 text-bold-primary collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
								Objetivos de aprendizaje
							</button>
						</h2>
						<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionCourse">
							<div class="accordion-body fs-6 text-description-secondary roboto-medium">
								{!! nl2br(e($curso->objetivos)) !!}
							</div>
						</div>
					</div>
					<div class="accordion-item">
						<h2 class="accordion-header" id="headingFour">
							<button class="accordion-button fs-6 text-bold-primary collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
								Contenido
							</button>
						</h2>
						<div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionCourse">
							<div class="accordion-body fs-6 text-description-secondary roboto-medium">
								{!! nl2br(e($curso->contenido)) !!}
							</div>
						</div>
					</div>
				</div>

				
				<div class="card card-temario mb-20">
					<div class="card-body">
							<div class="row">
								<div class="col-md-9">
									<h1 class="fs-3x text-bold-primary mb-4">Temario del curso</h1>
								</div>
								<div class="col-md-3">

			                        <a href="{{asset($curso->archivo)}}" target="_blank" class="btns btn-round-white w-100">
						                DESCARGAR
						                <img src="{{asset('images/descargar_azul.png')}}" class="img-icon-20 ms-2">
						            </a>
								</div>
							</div>
					</div>
				</div>
				<div class="card rounded-3 bg-white mb-20">
					<div class="card-body">
						<div class="row align-items-center text-center text-md-start">
							{{-- Imagen del docente --}}
							<div class="col-12 col-md-3 d-flex justify-content-center mb-4 mb-md-0">
								<div class="symbol symbol-circle symbol-150px">
									<img src="{{ asset($curso->imagen_docente) }}" alt=""/>
								</div>
							</div>

							{{-- Información del docente --}}
							<div class="col-12 col-md-9">
								<div class="mb-3">
									<h5 class="fs-3x text-bold-primary mb-3">{{ $curso->nombre_docente }}</h5>
									<p class="fs-6 text-normal">{{ $curso->profesion_docente }}</p>
								</div>

								@if ($curso->enlace_linkedin_docente)
									<div class="d-flex justify-content-center justify-content-md-start">
										<a href="{{ $curso->enlace_linkedin_docente }}" target="_blank">
											<img src="{{ asset('images/logo_linkedin_azul.png') }}" alt="LinkedIn" class="img-fluid mx-2" style="max-height: 30px;">
										</a>
									</div>
								@endif
							</div>
						</div>
					</div>
					<div class="card-body">
						<p class="fs-6 text-normal text-start">
							{{ $curso->biografia_docente }}
						</p>
					</div>
				</div>
				@if (count($preguntasFrecuentes) > 0)
					<h1 class="fs-3x text-bold-primary mb-4 mt-4 mt-md-0">Preguntas frecuentes</h1>
					<div class="accordion mb-4" id="accordionQuestions">
						@foreach ($preguntasFrecuentes as $item)
							<div class="accordion-item">
								<h2 class="accordion-header" id="heading{{ $item->id }}">
									<button class="accordion-button fs-6 text-bold-primary {{ !$loop->first ? 'collapsed' : '' }}" type="button"
										data-bs-toggle="collapse"
										data-bs-target="#collapse{{ $item->id }}"
										aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
										aria-controls="collapse{{ $item->id }}">
										{{ $item->pregunta }}
									</button>
								</h2>
								<div id="collapse{{ $item->id }}"
									class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
									aria-labelledby="heading{{ $item->id }}">
									<div class="accordion-body fs-6 text-description-secondary roboto-medium">
										{{ $item->respuesta }}
									</div>
								</div>
							</div>
						@endforeach
					</div>
				@endif

		  	</div>
		  	<div class="col-md-4">
			    <div class="card rounded-3 mb-4">
			      <img src="{{asset($curso->imagen)}}" class="card-img-top" alt="Imagen del curso">
			      <div class="card-body">
			      	<div class="row">
			      		<div class="col-md-6">
			    			<div class="card rounded-3 h-100 bg-card-light mb-4">
			    				<div class="card-body card-padding-h-0 text-center">
					        		<div class="symbol symbol-circle symbol-50px">
								        <img src="{{asset('images/curso_corto.png')}}" alt=""/>
								    </div>
									<p class="fs-6 text-normal roboto-medium">
										{{ $curso->nombre_tipo_curso }}
									</p>			
			    				</div>
			      			</div>
			      		</div>
			      		<div class="col-md-6 mt-4 mt-md-0">
			    			<div class="card rounded-3 h-100 bg-card-light mb-4">
			    				<div class="card-body card-padding-h-0 text-center">
					        		<div class="symbol symbol-circle symbol-50px">
								        <img src="{{asset('images/modalidad.png')}}" alt=""/>
								    </div>
									<p class="fs-6 text-normal roboto-medium">
										Modalidad {{ $curso->nombre_modalidad }}
									</p>			    					
			    				</div>

			      			</div>
			      		</div>
			      	</div>
			      	<div class="row mt-4">
			      		<div class="col-md-6">
			    			<div class="card rounded-3 h-100 bg-card-light mb-4">
			    				<div class="card-body card-padding-h-0 text-center">
					        		<div class="symbol symbol-circle symbol-50px">
								        <img src="{{asset('images/tiempo.png')}}" alt=""/>
								    </div>
									<p class="fs-6 text-normal roboto-medium">
										{{ $curso->duracion }}
									</p>			    					
			    				</div>

			      			</div>
			      		</div>
			      		<div class="col-md-6 mt-4 mt-md-0">
			    			<div class="card rounded-3 h-100 bg-card-light mb-4">
			    				<div class="card-body card-padding-h-0 text-center">
					        		<div class="symbol symbol-circle symbol-50px">
								        <img src="{{asset('images/recurso.png')}}" alt=""/>
								    </div>
									<p class="fs-6 text-normal roboto-medium">
										{{ $curso->recursos_disponibles }} Recursos <br>
										disponibles
									</p>			    					
			    				</div>

			      			</div>
			      		</div>
			      	</div>
			        <div class="d-flex justify-content-center align-items-center mt-10">
			        	<div class="row">
			        		<div class="symbol symbol-circle symbol-50px">
						        <img src="{{asset('images/calendar.png')}}" alt=""/>
						    </div>
			        	</div>
			        	<div class="row">
			        		<p class="fs-6 text-description-secondary roboto-medium m-0">¡Comienza pronto!</p>
			        		<p class="fs-6 text-description-secondary roboto-medium m-0">{{ $curso->rango_fechas }}</p>
			        	</div>
			        </div>
			        <div class="d-flex justify-content-between align-items-center mt-4">
			          <div class="row">
			            <span class="fs-6 text-bold-primary roboto-medium">Precio</span>
			            <span class="fs-2x text-bold-primary roboto-medium">Bs.{{ $curso->precio }}</span>
			          </div>
						@if ($curso->descuento != null || $curso->descuento != 0)
							<div class="row">
								<span class="fs-6 text-normal roboto-medium">Descuento</span>
								
								<span class="fs-2x text-normal roboto-medium">{{ $curso->descuento }}%</span>
							</div>
						@endif
			        </div>
				    <div class="d-flex align-items-center mt-4">
						<a href="#" class="btns btn-round-primary w-100" data-bs-toggle="modal" data-bs-target="#compartir" title="Compartir">
						    COMPARTIR
						    <img src="{{asset('images/arrow_forward_white.png')}}" class="icon-img ms-2">
						</a>
				    </div>
			      </div>
			    </div>
				@include('landingpage.modal-compartir')
	            <div class="card rounded-3 bg-primary mb-4">
	                <div class="card-body">
	                    <h5 class="fs-3x text-bold-primary white text-center">Inscríbete hoy</h5>
	                    <p class="fs-6 white mt-4 text-medium-primary white text-center">Empieza tu camino de aprendizaje ahora.</p>
	                    <form id="formularioInteresadoInscripcion">
	                    	<input type="hidden" name="id_curso" value="{{$curso->id}}">
	                        <div class="mb-3">
	                        	<label class="fs-6 mt-4 text-medium-primary white mb-4">Nombre completo</label>
	                            <input type="text" name="nombre_completo" class="form-control" placeholder="Nombre completo" required>
	                        </div>
	                        <div class="mb-3">
	                        	<label class="fs-6 mt-4 text-medium-primary white mb-4">Correo electrónico</label>
	                            <input type="email" name="correo" class="form-control" placeholder="Correo electrónico" required>
	                        </div>
	                        <div class="mb-3">
	                        	<label class="fs-6 mt-4 text-medium-primary white mb-4">Telefono</label>
								<div class="roboto-medium">
									<input name="telefono" type="tel"  class="form-control roboto-medium ml-5" placeholder="Teléfono" id="telefono" required>
								</div>
	                        </div>
	                        <div class="mb-3">
	                        	<label class="fs-6 white mt-4 text-medium-primary white">¿ Eres agente comercial de CENACE?</label>
	                        </div>

							<div class="d-flex gap-4">
							    <div class="form-check d-flex align-items-center gap-2">
							        <input class="form-check-input" type="radio" name="agente_comercial" id="opcion1" value="1" required>
							        <label class="fs-6 white text-medium-primary mb-0" for="opcion1">
							            Sí
							        </label>
							    </div>
							    
							    <div class="form-check d-flex align-items-center gap-2">
							        <input class="form-check-input" type="radio" name="agente_comercial" id="opcion2" value="0" required>
							        <label class="fs-6 white text-medium-primary mb-0" for="opcion2">
							            No
							        </label>
							    </div>
							</div>


	                        <a id="registrar" class="btns btn-round-secondary mt-4 w-100 cursor-pointer">
				                COMPRAR AHORA
				                <img src="{{asset('images/arrow_forward.png')}}" class="icon-img ms-2">
				            </a>
	                    </form>
	                </div>
	            </div>

	            <div class="card rounded-3 bg-primary mb-4">
	                <div class="card-body">

						<p class="fs-6 text-medium-secondary-light mb-4">Capacitaciones In Company</p>

                    	<h5 class="fs-4x text-bold-primary white text-center">Potencia el talento de tu equipo</h5>
                    
                        <a href="{{url('empresas/'.$curso->id)}}" class="btns btn-round-secondary mt-4 w-100">
			                COTIZAR AHORA
			                <img src="{{asset('images/arrow_forward.png')}}" class="icon-img ms-2">
			            </a>
	                </div>
	            </div>
		  	</div>
	    </div>
	</div>

	<div class="container text-center pt-14">
		<p class="fs-6 text-normal">Regístrate a nuestro Newsletter</p>
	    <h1 class="fs-3x text-bold-primary">
	       Recibe actualizaciones exclusivas para impulsar tu carrera
	    </h1>
	    <div class="col-md-6 d-flex align-items-center justify-content-center mt-4 mx-auto">
            <div class="me-4 w-100">
            	<form id="formularioSuscripcion">
                	<input type="email" name="correo" class="form-control roboto-medium" placeholder="Ingresa tu correo electrónico" required>
    			</form>
            </div>
			<a id="suscribirse" class="btns btn-round-primary cursor-pointer">
			    ENVIAR
			</a>
	    </div>
	</div>
</div>
@if(count($opinionesEstudiantes)>0)
<div class="wrapper-carousel d-flex align-items-center" style="position: relative; height: 400px;">
	<div class="bg-opinion">
		<img src="{{asset('images/comillas.png')}}" class="bg-opinion-img">
	</div>
	<div id="carouselOpinionTitulo">
		<h1  class="fs-2x text-bold-primary">Nuestros <br> estudiantes</h1>
	</div>
	<div class="carousel d-flex align-items-center" id="carouselOpinion">
		@foreach ($opinionesEstudiantes as $item)
			<div>
				<div class="card border-2 shadow-sm rounded mt-15 mb-15">
					<div class="card-body">
						<div class="d-flex align-items-center mb-3">
							<div class="text-start">
								<h6 class="mb-0 text-bold-primary">{{ $item->nombre_completo }}</h6>
								<small class="text-normal">{{ $item->profesion }}</small>
							</div>
						</div>
						<p class="text-normal mb-0 text-start">
							"{{ $item->opinion }}"
						</p>
					</div>
				</div>
			</div>
		@endforeach
	</div>
</div>
@endif
@if(count($cursosRelacionados)>0)
<div class="pt-20 pb-20 bg-blue-light">
	<div class="container">
		<div class="d-flex justify-content-between w-100 mt-10 flex-column flex-md-row">
		    <div class="flex-grow-1">
		        <h1 class="fs-3x text-bold-primary">
		            Cursos que te pueden interesar
		        </h1>
		    </div>
		    <div class="d-flex align-items-center w-100 w-md-auto">
				<a href="{{url('cursos')}}" class="btns btn-round-secondary w-100">
				    COMPRAR AHORA
				    <img src="{{asset('images/arrow_forward.png')}}" class="icon-img ms-2">
				</a>
		    </div>
		</div>
    </div>

	<div class="container mt-4 mb-15">
	    <div class="carousel" id="carouselCursoPopular">
			@foreach ($cursosRelacionados as $item)
				<div>
					<div class="card padding-10">
					<label class="card-label top-20 left-20">
						{{ $item->nombre_modalidad }}
					</label>
					<img src="{{asset($item->imagen)}}" class="card-img-top" alt="Imagen del curso">
					<div class="card-body card-padding-h-0">
						<h5 class="fs-2x text-bold-primary label-limited">{{ $item->nombre }}</h5>
						<p class="fs-6 text-description-secondary roboto-medium">{{ $item->rango_fechas }}</p>
						<p class="fs-6 text-normal roboto-medium">Un curso de {{ $item->prefijo_academico_docente }}. {{ $item->nombre_docente }}</p>
						<div class="d-flex justify-content-between align-items-center">
						<div>
							<span class="fs-2x text-bold-primary roboto-medium">Bs. {{ $item->precio_descuento }}</span>
							@if ($item->descuento != null || $item->descuento != 0)
								<span class="fs-1x text-normal text-decoration-line-through roboto-medium">Bs. {{ $item->precio }}</span>
							@endif
						</div>
						</div>
						<div class="d-flex align-items-center mt-4">
							<a href="{{url('detalle-curso/'.$item->id)}}" class="btns btn-round-primary w-100">
								INSCRÍBETE
								<img src="{{asset('images/arrow_forward_white.png')}}" class="icon-img ms-2">
							</a>
						</div>
					</div>
					</div>	
				</div>
			@endforeach
	   	</div>
	</div>
</div>
@endif


@endsection
@push('scripts')     
<script src="{{asset('assets/plugins/intlTelInput/intlTelInput.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {

	$('#copyButton').click(function() {
        var copyText = $('#copyInput')[0];
        copyText.select();
        document.execCommand('copy');
        toastr.success("Link copiado al portapapeles", 'Satisfactorio!');
		toastr.options.closeDuration = 10000;
		toastr.options.timeOut = 10000;
		toastr.options.extendedTimeOut = 10000;
	});

  	$('#carouselOpinion').slick({
	  	slidesToShow: 2,
	  	dots:false,
	  	centerMode: false,
	  	arrows: false,
	  	infinite: false,
	  	autoplay: true,
		autoplaySpeed: 2000,
	 	responsive: [
	        {
	          breakpoint: 768,
	          settings: {
	            slidesToShow: 1,
	            variableWidth: false,
	            centerMode: false
	          }
	        },
	        {
	          breakpoint: 480,
	          settings: {
	            slidesToShow: 1,
	            variableWidth: false,
	            centerMode: false
	          }
	        }
	      ]
  	});


  	$('#carouselCursoPopular').slick({
	  	slidesToShow: 3,
	  	dots:false,
	  	centerMode: false,
	  	arrows: false,
	  	infinite: false,
	  	autoplay: true,
		autoplaySpeed: 2000,
	 	responsive: [
	        {
	          breakpoint: 768,
	          settings: {
	            slidesToShow: 1,
	            variableWidth: false,
	            centerMode: false
	          }
	        },
	        {
	          breakpoint: 480,
	          settings: {
	            slidesToShow: 1,
	            variableWidth: false,
	            centerMode: false
	          }
	        }
	      ]
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


	var formularioInteresadoInscripcion = document.getElementById('formularioInteresadoInscripcion');


	$('#registrar').on('click', function(event) {
        event.preventDefault();
		if (!formularioInteresadoInscripcion.checkValidity()) {
            formularioInteresadoInscripcion.reportValidity();
            return;
        }
        var codigoPais = iti.getSelectedCountryData().dialCode;
		var formData = new FormData($("#formularioInteresadoInscripcion")[0]);
		formData.append('codigoPais', codigoPais); 
        $.ajax({
            type: "POST",
            url: "{{url('interesado-inscripcion/registrar-interesado-inscripcion')}}",
            data: formData ,
            dataType: 'json',
            async: true,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message, 'Satisfactorio!');
                	 window.open(response.data, '_blank');
                    $('#formularioInteresadoInscripcion')[0].reset();
                } else {
                    toastr.error(response.message, 'Ocurrió un error!');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
               
            }
        });
    });


	var formularioSuscripcion = document.getElementById('formularioSuscripcion');

	$('#suscribirse').on('click', function(event) {
        event.preventDefault();
		if (!formularioSuscripcion.checkValidity()) {
            formularioSuscripcion.reportValidity();
            return;
        }
       
		var formData = new FormData($("#formularioSuscripcion")[0]);
        $.ajax({
            type: "POST",
            url: "{{url('suscripcion/registrar-suscripcion')}}",
            data: formData ,
            dataType: 'json',
            async: true,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#formularioSuscripcion')[0].reset();
                    $('#solicitudEnviadaTitulo').text("¡Solicitud realizada con éxito!");
                    $('#solicitudEnviadaDescripcion').text("¡Gracias por unirte a nuestra comunidad! Te mantendremos al día con todas las actualizaciones de nuestros cursos.");
                    $("#solicitudEnviada").modal('show');
                } else {
                    $("#error").modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
               $("#error").modal('show');
            }
        });
    });

    

});
</script>
@endpush
