@extends('layout.landing')
@section('titulo')
<title>Contacto</title>
@endsection

@section('styles')
	<link rel="stylesheet" href="{{asset('css/leaflet/leaflet.css')}}">
	<link rel="stylesheet" href="{{asset('assets/plugins/intlTelInput/intlTelInput.css')}}">
@endsection

@section('content')
<div class="pt-15 pb-15 bg-primary position-relative z-index-2">
	<img src="{{asset('images/curva_1.png')}}" class="left-top-ornament ornament-200">
	<img src="{{asset('images/curva_2.png')}}" class="right-bottom-ornament ornament-200">
	<div class="container pt-15 pb-15">
		<div class="text-center pb-4">
			<p class="fs-6 text-medium-secondary-light">Contacto</p>
		  	<h2 class="fs-3x text-bold-primary white">Comprometidos con la excelencia</h2>
        </div>
  	</div>
</div>
<div class="pt-15 pb-15 bg-blue-light">
	<div class="container pt-15 pb-15">
		<div id="map"></div>
	</div>
	<div class="container">
		<div class="row pb-4">
		  	<div class="col-md-7 order-2 order-md-1">
				<div class="card rounded-3 bg-white">
					<div class="card-body">
						<h5 class="fs-3x text-bold-primary text-center mb-4">Conéctate con nosotros</h5>
						<p class="fs-6 text-medium-primary text-center">
							Estamos aquí para responder tus consultas y ayudarte a alcanzar tus objetivos profesionales.
						</p>
	                    <form id="formulario">
	                        <div class="row mb-4">
	                        	<div class="col-md-12 mt-md-0 mt-4">
		                        	<label class="fs-6 text-bold-primary mb-2">Nombre completo (*)</label>
		                            <input name="nombre_completo" type="text" class="form-control roboto-medium" placeholder="Nombre completo" required>	                        		
	                        	</div>
	                        </div>
	                        <div class="row mb-4">
								<div class="col-md-12 mt-md-0 mt-4">
									<label class="fs-6 text-bold-primary mb-2">Correo electrónico (*)</label>
                            		<input name="correo" type="email" class="form-control roboto-medium" placeholder="Correo electrónico" required>
								</div>
	                        </div>
	                        <div class="row mb-4">
								<div class="col-md-12 mt-md-0 mt-4">
									<label class="fs-6 text-bold-primary mb-2">Telefono (*)</label>
									<div class="roboto-medium">
										<input name="telefono" type="tel"  class="form-control roboto-medium ml-5" placeholder="Teléfono" id="telefono" required>
									</div>
								</div>
	                        </div>
	                        <div class="row mb-4">
								<div class="col-md-12 mt-md-0 mt-4">
		                        	<label class="fs-6 text-bold-primary mb-2">Motivo de Mensaje (*)</label>
		                            <select name="id_motivo_contacto" class="form-control roboto-medium" placeholder="Motivo de Mensaje" required>
		                            	<option>Seleccione una opción</option>
		                            	@foreach($motivoContactos as $item)
		                            		<option value="{{$item->id}}">{{$item->nombre}}</option>
		                            	@endforeach
		                            </select>
	                        	</div>
	                        </div>
	                        <div class="row mb-4">
								<div class="col-md-12 mt-md-0 mt-4">
		                        	<label class="fs-6 text-bold-primary mb-2">Consulta o sugerencia (*)</label>
		                            <textarea name="consulta" class="form-control roboto-medium" placeholder="Consulta o sugerencia" rows="5" required></textarea>
	                        	</div>
	                        </div>
	                        <div class="row mb-4">
								<div class="col-md-12 mt-md-0 mt-4">
									<p class="fs-6 text-medium-primary text-start">
										* Datos requeridos. <br>
									</p>
	                        	</div>
	                        </div>
	                        <div class="row mb-4">
								<div class="col-md-12 mt-md-0 mt-4">
			                        <a id="registrar" class="btns btns btn-round-primary mt-4 w-100 cursor-pointer">
						                ENVIAR
						                <img src="{{asset('images/arrow_forward_white.png')}}" class="icon-img ms-2">
						            </a>
	                        	</div>
	                        </div>
	                    </form>
					</div>
				</div>
		  	</div>
		  	<div class="col-md-5 order-1 order-md-2">
	            <div class="card rounded-3 bg-primary mb-4">
	                <div class="card-body">
	                	<img src="{{asset($seccionContacto->imagen)}}" class="img-fluid rounded-3 w-100 mb-4">
	                    <h5 class="mt-5 fs-5 roboto-medium white">{!! nl2br(e($seccionContacto->titulo)) !!}</h5>
						<p class="fs-6 white mt-4 roboto-medium white">{{ $seccionContacto->direccion}}</p>
						<p class="fs-6 white mt-4 roboto-medium white">{{ $seccionContacto->telefono}}</p>
						<p class="fs-6 white mt-4 roboto-medium white">{{ $seccionContacto->celular}}</p>
						<p class="fs-6 white mt-4 roboto-medium white">{{ $seccionContacto->correo}}</p>
						<p class="fs-6 white mt-4 roboto-medium white">{{ $seccionContacto->enlace_facebook}}</p>
						<p class="fs-6 white mt-4 roboto-medium white">{{ $seccionContacto->localidad}}</p>
	                </div>
	            </div>
		  	</div>
		</div>
  	</div>
</div>

@endsection
@push('scripts') 
<script src="{{asset('js/leaflet/leaflet.js')}}"></script>
<script src="{{asset('assets/plugins/intlTelInput/intlTelInput.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {

	var lat = -17.763010;
	var lng = -63.147408;

	var map = L.map('map', {
	    center: [lat, lng], 
	    zoom: 15,
	    dragging: false,
	    zoomControl: false,
	    scrollWheelZoom: false,
	    doubleClickZoom: false, 
	    touchZoom: false, 
	    boxZoom: false 
	});
	
	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
	    attribution: '&copy; OpenStreetMap contributors'
	}).addTo(map);

	L.marker([lat, lng]).addTo(map)
	    .bindPopup("<b>UPSA</b>")
	    .openPopup();

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


	$('#registrar').on('click', function(event) {
        event.preventDefault();
		if (!formulario.checkValidity()) {
            formulario.reportValidity();
            return;
        }
		var codigoPais = iti.getSelectedCountryData().dialCode;
		var formData = new FormData($("#formulario")[0]);
		formData.append('codigoPais', codigoPais); 
        $.ajax({
            type: "POST",
            url: "{{url('contacto/registrar-contacto')}}",
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
    });

});
</script>
@endpush
