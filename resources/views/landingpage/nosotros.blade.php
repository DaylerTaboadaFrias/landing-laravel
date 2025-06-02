@extends('layout.landing')
@section('titulo')
<title>Nosotros</title>
@endsection

@section('content')
<div class="pt-15 pb-15 bg-primary position-relative z-index-2">
	<img src="{{asset('images/curva_1.png')}}" class="left-top-ornament ornament-200">
	<img src="{{asset('images/curva_2.png')}}" class="right-bottom-ornament ornament-200">
	<div class="container pt-15 pb-15">
		<div class="text-center pb-4">
			<p class="fs-6 text-medium-secondary-light">Nosotros</p>
		  	<h2 class="fs-3x text-bold-primary white">Comprometidos con la excelencia</h2>
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

@if (count($valoresPostulacion)>0)
  <div class="pt-15 pb-15 bg-blue-light">
    <div class="container p-0 position-relative z-index-2">
	<img src="{{asset('images/curva_blanca_1.png')}}" class="left-top-ornament ornament-200 z-index-2">
	<img src="{{asset('images/curva_blanca_2.png')}}" class="right-bottom-ornament ornament-200 z-index-2">

      <div class="row no-gutters-x d-flex justify-content-between align-items-center bg-white p-10 rounded-3">
        <div class="col-md-6">
          <h1 class="fs-3x text-bold-primary mb-4">Nuestros valores,</h1>
          <h1 class="fs-3x text-bold-primary mb-4">tu respaldo académico</h1>
        </div>
        <div class="col-md-6">
          @foreach ($valoresPostulacion as $item)
            <div class="d-flex align-items-center mb-3">
              <img 
                src="{{ asset('images/check_circle.png') }}" 
                class="img-icon-30 me-2" 
                alt="check">
              <p class="fs-6 text-medium-primary mb-0">
                {{ $item->titulo }}
              </p>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
@endif

<div class="bg-blue-light pt-15 pb-15">
	<div class="container">
	    <div class="row text-center p-10 rounded-3">
	        <p class="fs-6 fs-6 text-normal roboto-medium">Lleva tu enseñanza al siguiente nivel</p>
	        <h1 class="fs-3x text-bold-primary mt-4">Únete a nuestro plantel académico</h1>

	        <div class="d-flex justify-content-center mt-4">
	            <a href="{{url('postula')}}" class="btns btn-round-primary">
	                POSTULA AHORA
	                <img src="{{asset('images/arrow_forward_white.png')}}" class="icon-img ms-2">
	            </a>
	        </div>
	    </div>
	</div>
</div>
@if (count($preguntasFrecuentes)>0)
<div class="pt-15 pb-15 bg-blue-light">
	<div class="container">
		<div class="row pb-4">
		  	<div class="col-md-12">
				<h1 class="fs-3x text-bold-primary mb-4 mt-4 mt-md-0">
					Preguntas frecuentes
				</h1>
				<div class="accordion mb-4" id="accordionQuestions">
				  @foreach ($preguntasFrecuentes as $item)
				    <div class="accordion-item">
				      <h2 class="accordion-header" id="heading{{ $item->id }}">
				        <button 
				          class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" 
				          type="button"
				          data-bs-toggle="collapse"
				          data-bs-target="#collapse{{ $item->id }}"
				          aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
				          aria-controls="collapse{{ $item->id }}"
				        >
				          {{ $item->pregunta }}
				        </button>
				      </h2>
				      <div 
				        id="collapse{{ $item->id }}"
				        class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
				        aria-labelledby="heading{{ $item->id }}"
				      >
				        <div class="accordion-body fs-6 text-description-secondary roboto-medium">
				          {{ $item->respuesta }}
				        </div>
				      </div>
				    </div>
				  @endforeach
				</div>
		  	</div>
	  	</div>
	</div>
</div>
@endif

@if(count($opinionesDocentes)>0)
<div class="wrapper-carousel d-flex align-items-center" style="position: relative; height: 400px;">
	<div class="bg-opinion">
		<img src="{{asset('images/comillas.png')}}" class="bg-opinion-img">
	</div>
	<div id="carouselOpinionTitulo">
		<h1  class="fs-2x text-bold-primary">Nuestros <br> docentes</h1>
	</div>
	<div class="carousel d-flex align-items-center" id="carouselOpinion">
		@foreach ($opinionesDocentes as $item)
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
@endsection
@push('scripts')     
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

});

</script>
@endpush
