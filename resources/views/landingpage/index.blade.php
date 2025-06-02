@extends('layout.landing')
@section('titulo')
<title>Inicio</title>
@endsection

@section('content')
<div class="bg-blue-light position-relative pt-15 pb-15">
	<img src="{{asset('images/c.png')}}" class="left-vertically-centered-ornament ornament-200">
	<img src="{{asset('images/o.png')}}" class="right-top-ornament ornament-200">
	<div class="container">
		<div class="row d-flex align-items-center">
			<div class="col-12 col-md-7">
				<p class="fs-6 text-medium-primary">{{ $portadaInicio->titulo }}</p>
				<h1 class="fs-3x text-bold-primary">{{ $portadaInicio->subtitulo }}</h1>
				<a href="#" class="btn btn-round-primary mt-4 w-100 text-start"> 
				<img src="{{asset('images/search_round.png')}}" width="30">
				¿Qué deseas aprender?
				</a>
			</div>
			<div class="col-12 col-md-5">
				<img class="img-fluid rounded-3 w-100 mt-4 mt-md-0" src="{{asset($portadaInicio->imagen)}}">
			</div>
		</div>		
	</div>
</div>

<div class="bg-blue-light pt-15 pb-15">
	<div class="container">
		<div class="row justify-content-center">
			@foreach ($secciones as $seccion)
				<div class="col-md-4 text-center
					@if (!$loop->last)
						borde-derecha
					@endif">
					
					<img src="{{ asset($seccion->imagen) }}" width="60">
					<h1 class="fs-1x text-bold-primary mt-4">{{ $seccion->titulo }}</h1>
					<p class="fs-6 text-medium-primary">{{ $seccion->descripcion }}</p>
				</div>
			@endforeach
		</div>					
	</div>
</div>



<div class="bg-blue-light pt-15 pb-15">
	<div class="container">
	    <div class="row position-relative text-center bg-primary p-10 rounded-3 z-index-2">
			<img src="{{asset('images/c_intersect.png')}}" class="left-top-ornament ornament-300">
	        <p class="fs-6 text-medium-secondary-light">Capacitaciones In Company</p>
	        <h1 class="fs-3x white mt-4">Potencia el talento de tu equipo</h1>
	        <div class="d-flex justify-content-center mt-4">
	            <a href="{{url('empresas')}}" class="btns btn-round-secondary">
	                ¿COTIZAR AHORA?
	                <img src="{{asset('images/arrow_forward.png')}}" class="icon-img ms-2">
	            </a>
	        </div>
	    </div>
	</div>
</div>

<div class="wrapper-carousel">
    <div class="carousel" id="carousel">
		@foreach ($galeria as $item)
			<div>
				<a href="{{ $item->enlace }}" target="_blank">
					<img src="{{asset($item->imagen)}}"/>
				</a>
			</div>
		@endforeach
  	</div>
</div>


@if(count($cursosPopulares)>0)

<div class="container mt-15 mb-15">
	<div class="d-flex justify-content-between align-items-end w-100 mt-10  flex-column flex-md-row">
	    <div class="flex-grow-1">
	        <h1 class="fs-3x text-bold-primary">
	           Cursos populares
	        </h1>
	        <p class="fs-6 text-normal">
	            Encuentra el curso ideal para fortalecer tu carrera y avanzar en tu profesión.
	        </p>
	    </div>
	    <div class="d-flex align-items-center ms-3 mb-4 w-100 w-md-auto">
			<a href="{{url('cursos')}}" class="btns btn-round-secondary w-100">
			    EXPLORAR MÁS
			    <img src="{{asset('images/arrow_forward.png')}}" class="icon-img ms-2">
			</a>
	    </div>
	</div>
</div>


<div class="container mt-4 mb-15">
    <div class="carousel" id="carouselCursoPopular">
		@foreach ($cursosPopulares as $curso)
			
			<div>
				<div class="card" >
				<label class="card-label">
					{{ $curso->nombre_modalidad }}
				</label>
				<img src="{{asset($curso->imagen)}}" class="img-fluid" alt="{{ $curso->nombre }}">
				<div class="card-body card-padding-h-0">
					<h5 class="fs-2x text-bold-primary label-limited">{{ $curso->nombre }}</h5>
					<p class="fs-6 text-description-secondary roboto-medium">
						{{ $curso->rango_fechas  }}
					</p>
					<div class="d-flex justify-content-between align-items-center">
					<div>
						<span class="fs-2x text-bold-primary roboto-medium">Bs. {{ $curso->precio_descuento }}</span>
						@if ($curso->descuento != null || $curso->descuento != 0)
							<span class="fs-1x text-normal text-decoration-line-through roboto-medium">Bs. {{ $curso->precio }}</span>
						@endif
					</div>
					</div>
					<div class="d-flex align-items-center mt-4">
						<a  href="{{url('cursos')}}" class="btns btn-round-primary w-100">
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
@endif

<div class="pt-15 pb-15 bg-primary">
	<div class="container pt-15 pb-15">
		<div class="text-center pb-4">
		  <h2 class="fs-3x text-bold-primary white">Categorías claves para tu desarrollo profesional</h2>
		  <p class="fs-6 white mt-4 text-medium-primary white">Encuentra el curso ideal para fortalecer tu carrera y avanzar en tu profesión.</p>
		</div>
		<div class="row g-4 mt-15 mb-15 col-md-10 mx-auto">
			@foreach ($categorias as $categoria)
				<div class="col-md-4">
					<div class="category-card cursor-pointer">
						<img src="{{asset($categoria->imagen)}}" alt="{{ $categoria->nombre }}" class="category-icon">
						<h5 class="fs-6 text-medium-primary white">{{ $categoria->nombre }}</h5>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</div>

<div class="bg-blue-light pt-15 pb-15">
	<div class="container">
        <h1 class="fs-3x text-bold-primary text-center">
           Calendario
        </h1>

	    <div class="d-flex justify-content-center mb-4 mt-4">
	        @foreach ($meses as $mes)
	            <label class="mx-4 fs-6 text-bold-primary cursor-pointer mes-select" data-anio="{{ $mes['anio'] }}"  data-mes="{{ $mes['mes'] }}">
	                {{ $mes['nombre'] }}
	            </label>
	        @endforeach
	    </div>
		<div id="contenedorCursosCalendario" class="carousel mt-15 mb-15">
			
		</div>
	   	
		<div class="d-flex justify-content-between w-100 mt-10 flex-column flex-md-row">
		    <div class="flex-grow-1">
		        <h1 class="fs-6 text-normal text-start">
		            Aprende a tu ritmo y a tu manera
		        </h1>
		    </div>
		    <div class="d-flex align-items-center w-100 w-md-auto">
				<a  href="{{url('cursos')}}" class="btns btn-round-secondary w-100">
				    EXPLORAR MÁS
				    <img src="{{asset('images/arrow_forward.png')}}" class="icon-img ms-2">
				</a>
		    </div>
		</div>

	</div>
</div>

<div class="container pt-15 pb-15">
    <h1 class="fs-3x text-bold-primary text-center">
       ¿Porqué elegir CENACE para capacitarse?
    </h1>
    <p class="fs-6 mt-4 text-medium-primary text-center">Encuentra el curso ideal para fortalecer tu carrera y avanzar en tu profesión.</p>
</div>

<div class="container">
    <div class="row bg-primary p-10 rounded-3">
    	<div class="col-md-6">
    		<p class="fs-6 white mt-4 text-medium-primary white">{{ $seccionCapacitacion->titulo }}</p>
	        <h1 class="fs-3x text-bold-primary white">
				{{ $seccionCapacitacion->subtitulo }}
	        </h1>
    		<p class="fs-6 white mt-4 text-medium-primary white">{{ $seccionCapacitacion->descripcion }}</p>

    	</div>
    	<div class="col-md-6">
    		<img class="img-fluid mt-4 mt-md-0 rounded-3" src="{{asset($seccionCapacitacion->imagen)}}">
    	</div>
    </div>
</div>

@if (count($nuestrosNumeros) > 0)
<div class="mt-15 pt-15 pb-15 bg-blue-light">
	<div class="container pt-15 pb-15">
		<div class="row row-cols-1 row-cols-md-3 g-4 justify-content-md-center">
			@foreach ($nuestrosNumeros as $item)
				<div class="col text-center">
					<h1 class="fs-3hx text-bold-primary color-number roboto-bold">
						{{ $item->titulo }}
					</h1>
					<p class="fs-6 mt-4 text-medium-primary">{{ $item->subtitulo }}</p>
				</div>
			@endforeach
		</div>
		
    </div>
</div>
@endif

<img src="{{asset('images/portada3.png.png')}}" class="img-fluid" alt="Portada">

@if (count($opinionesProfesionales) > 0)
<div class="wrapper-carousel d-flex align-items-center" style="position: relative; height: 400px;">
	<div class="bg-opinion">
		<img src="{{asset('images/comillas.png')}}" class="bg-opinion-img">
	</div>
	<div id="carouselOpinionTitulo">
		<h1  class="fs-2x text-bold-primary">Opiniciones</h1>
	</div>
	<div class="carousel d-flex align-items-center" id="carouselOpinion">
		@foreach ($opinionesProfesionales as $item)
			<div>
				<div class="card border-2 shadow-sm rounded mt-15 mb-15">
					<div class="card-body">
						<div class="d-flex align-items-center mb-3">
							<img src="{{asset($item->imagen)}}" alt="Avatar" class="rounded-circle me-3">
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


<div class="pt-15 pb-15 bg-blue-light">
    <div class="container">
        <div class="row bg-blue-sky position-relative p-10 rounded-3 d-flex align-items-center z-index-2">
			<img src="{{asset('images/curva_3.png')}}" class="top-horizontally-centered-ornament ornament-500">
            <div class="col-md-6">
                <p class="fs-6 text-bold-primary">{{ $cursoIdeal->titulo }}</p>
                <h1 class="fs-3x text-medium-primary">{{ $cursoIdeal->subtitulo }}</h1>
                <div class="d-flex align-items-center mb-4">
                    <a href="#" class="btns btn-round-white">
                        {{ $cursoIdeal->titulo_enlace }}
                        <img src="{{asset('images/arrow_forward.png')}}" class="icon-img ms-2">
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <img src="{{asset($cursoIdeal->imagen)}}" class="img-fluid rounded-3">
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')     
<script type="text/javascript">
$(document).ready(function() {
  	$('#carousel').slick({
	  	slidesToShow: 1,
	  	dots:false,
	  	centerMode: false,
	  	arrows: true,
	  	infinite: true,
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

	const primerMes = $('.mes-select').first().data('mes');
	const primerMesAnio = $('.mes-select').first().data('anio');

	function cargarCursos(mes,anio) {
		var $container = $('#contenedorCursosCalendario');
		$.ajax({
			url: '{{ route("curso.porMes") }}',
			data: {
				mes: mes,
				anio: anio 
			},
			success: function (response) {
				if ($container.hasClass('slick-initialized')) {
					$container.slick('unslick');
				}

				$container
				.html(response.html)
				.slick({
				  slidesToShow:   3,
				  dots:           false,
				  centerMode:     false,
				  arrows:         false,
				  infinite:       false,
				  autoplay:       true,
				  autoplaySpeed:  2000,
				  responsive: [
				    {
				      breakpoint: 768,
				      settings: {
				        slidesToShow:   1,
				        variableWidth:  false,
				        centerMode:     false
				      }
				    },
				    {
				      breakpoint: 480,
				      settings: {
				        slidesToShow:   1,
				        variableWidth:  false,
				        centerMode:     false
				      }
				    }
				  ]
				});
			}
		});
	}

	cargarCursos(primerMes,primerMesAnio);

	$('.mes-select').click(function () {
		let mes = $(this).data('mes');
		let anio = $(this).data('anio');
		cargarCursos(mes,anio);

		$('.mes-select').removeClass('text-decoration-underline');
		$(this).addClass('text-decoration-underline');
	});
});
</script>
@endpush
