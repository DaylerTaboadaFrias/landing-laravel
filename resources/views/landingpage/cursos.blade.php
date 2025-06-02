@extends('layout.landing')
@section('titulo')
<title>Cursos</title>
@endsection

@section('styles')
	<link rel="stylesheet" href="{{asset('css/range-custom.css')}}">
@endsection

@section('content')

<div class="pt-15 pb-15 bg-primary position-relative custom-bg position-relative z-index-2">
	<img src="{{asset('images/curva_1.png')}}" class="left-top-ornament ornament-200">
	<img src="{{asset('images/curva_2.png')}}" class="right-bottom-ornament ornament-200">
	<div class="container pt-5 pb-5">
	  <div class="text-center pb-4">
		<h2 class="fs-3x fw-bold text-white">Modalidades flexibles para tu formación</h2>
	  </div>
	</div>
</div>
  
<div class="pt-15 pb-15 bg-blue-light">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-4 filter-lg">
				<h1 class="fs-6 text-normal text-start ms-5">
					Filtrar resultados
				</h1>
				<div id="contenedorAcordeonFiltros">
					<div class="accordion mb-4 ms-5" id="accordionFiltros">

						{{-- Categorías --}}
						<div class="accordion-item">
							<h2 class="accordion-header" id="headingCategorias">
								<button class="accordion-button fs-6 text-bold-primary collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategorias" aria-expanded="false" aria-controls="collapseCategorias">
									Categorías
								</button>
							</h2>
							<div id="collapseCategorias" class="accordion-collapse collapse show" aria-labelledby="headingCategorias">
								<div class="accordion-body fs-6 p-0">
									<div>
										<input type="radio" name="categoria" id="cat-0" value="0"/>
										<label for="cat-0" class="category-option fs-6 text-normal text-start">Todas las cursos</label>
									</div>
									@foreach ($categorias as $item)
									<div>
										<input type="radio" name="categoria" id="cat-{{ $item->id }}" value="{{ $item->id }}"/>
										<label for="cat-{{ $item->id }}" class="category-option fs-6 text-normal text-start">{{ $item->nombre }}</label>
									</div>
									@endforeach
								</div>
							</div>
						</div>

						{{-- Subcategorías --}}
						<div class="accordion-item">
							<h2 class="accordion-header" id="headingSubcategorias">
								<button class="accordion-button fs-6 text-bold-primary collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSubcategorias" aria-expanded="false" aria-controls="collapseSubcategorias">
									Subcategorías
								</button>
							</h2>
							<div id="collapseSubcategorias" class="accordion-collapse collapse" aria-labelledby="headingSubcategorias">
								<div class="accordion-body fs-6 p-0" id="subcategorias"></div>
							</div>
						</div>

						{{-- Modalidades --}}
						<div class="accordion-item">
							<h2 class="accordion-header" id="headingModalidades">
								<button class="accordion-button fs-6 text-bold-primary collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseModalidades" aria-expanded="false" aria-controls="collapseModalidades">
									Modalidades
								</button>
							</h2>
							<div id="collapseModalidades" class="accordion-collapse collapse" aria-labelledby="headingModalidades">
								<div class="accordion-body fs-6 p-0">
									@foreach ($modalidades as $item)
									<div class="d-flex align-items-center mb-4 mt-md-0 mt-4">
										<input class="form-check-input modalidad-checkbox" type="checkbox" id="modalidad{{ $item->id }}" value="{{ $item->id }}">
										<label class="fs-6 text-normal text-start ms-2" for="modalidad{{ $item->id }}">{{ $item->nombre }}</label>
									</div>
									@endforeach
								</div>
							</div>
						</div>

						{{-- Calendario --}}
						<div class="accordion-item">
							<h2 class="accordion-header" id="headingCalendario">
								<button class="accordion-button fs-6 text-bold-primary collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCalendario" aria-expanded="false" aria-controls="collapseCalendario">
									Calendario
								</button>
							</h2>
							<div id="collapseCalendario" class="accordion-collapse collapse" aria-labelledby="headingCalendario">
								<div class="accordion-body fs-6 p-0">
									@foreach ($meses as $item)
									<div class="d-flex align-items-center mb-4 mt-md-0 mt-4">
										<input class="form-check-input mes-checkbox check-filtro" type="checkbox" id="mes{{ $item['mes'] }}" data-anio="{{ $item['anio'] }}" value="{{ $item['mes'] }}">
										<label class="fs-6 text-normal text-start ms-2" for="mes{{ $item['mes'] }}">{{ $item['nombre'] }}</label>
									</div>
									@endforeach
								</div>
							</div>
						</div>

						{{-- Tipos de Curso --}}
						<div class="accordion-item">
							<h2 class="accordion-header" id="headingTipos">
								<button class="accordion-button fs-6 text-bold-primary collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTipos" aria-expanded="false" aria-controls="collapseTipos">
									Tipos de curso
								</button>
							</h2>
							<div id="collapseTipos" class="accordion-collapse collapse" aria-labelledby="headingTipos">
								<div class="accordion-body fs-6 p-0">
									@foreach ($tiposCursos as $item)
									<div class="d-flex align-items-center mb-4 mt-md-0 mt-4">
										<input class="form-check-input tipo-checkbox check-filtro" type="checkbox" id="tipoCurso{{ $item->id }}" value="{{ $item->id }}">
										<label class="fs-6 text-normal text-start ms-2" for="tipoCurso{{ $item->id }}">{{ $item->nombre }}</label>
									</div>
									@endforeach
								</div>
							</div>
						</div>

						{{-- Precio --}}
						<div class="accordion-item">
							<h2 class="accordion-header" id="headingPrecio">
								<button class="accordion-button fs-6 text-bold-primary collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePrecio" aria-expanded="false" aria-controls="collapsePrecio">
									Precio
								</button>
							</h2>
							<div id="collapsePrecio" class="accordion-collapse collapse" aria-labelledby="headingPrecio">
								<div class="accordion-body fs-6 p-0">
									<div class="price-input">
										<div class="field">
											<span>Min</span>
											<input type="number" class="input-min" id="minimo" value="0" placeholder="Min">
										</div>
										<div class="separator"> </div>
										<div class="field">
											<span>Max</span>
											<input type="number" class="input-max" id="maximo" value="3000" placeholder="Max">
										</div>
									</div>
									<div class="slider">
										<div class="progress"></div>
									</div>
									<div class="range-input">
										<input type="range" class="range-min" min="0" max="3000" value="0" step="50">
										<input type="range" class="range-max" min="0" max="3000" value="3000" step="50">
									</div>
								</div>
							</div>
						</div>
					</div>					
				</div>

			</div>

			<div class="col-12 col-md-4 filter-sm">
				<div class="row">
					<div class="col-12 mb-3">
						<h1 id="cantidadResultadoSm" class="fs-4 text-normal text-start mb-0 w-100">
						</h1>
					</div>

				
					<div class="col-12">
						<div class="d-flex flex-column flex-sm-row align-items-stretch gap-3">
							<a data-bs-toggle="modal" data-bs-target="#filtroModal" class="btns btn-round-primary w-100 flex-sm-fill d-flex align-items-center justify-content-center">
								<img src="{{ asset('images/filter_list.png') }}" class="icon-img me-2">
								FILTRAR
							</a>

							<div class="d-flex flex-column flex-sm-row w-100 flex-sm-fill">
								<p class="fs-6 text-normal text-start mb-0 me-sm-2 mb-sm-0 w-auto">Ordenar por:</p>
								<select id="ordenar-sm" name="ordenar" class="form-select roboto-medium flex-fill">
									<option value="0">Seleccionar orden</option>
									<option value="1">Nombre del curso A-Z</option>
									<option value="2">Nombre del curso Z-A</option>
									<option value="3">Precio: menor a mayor</option>
									<option value="4">Precio: mayor a menor</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-12 col-md-8">
				<div class="filter-lg">
					<div class="row">
						<div class="col-md-6">
							<h1 class="fs-3x text-bold-primary">
								Todos los cursos
							</h1>
						</div>
					</div>
					<div class="row align-items-center">
					    <div class="col-md-4">
					        <h1 id="cantidadResultado" class="fs-4 text-normal text-start mb-0">
					        </h1>
					    </div>
					    <div class="col-md-8 d-flex justify-content-end">
					        <div class="row align-items-center w-100">
					            <div class="col-md-4">
					                <p class="fs-6 text-normal text-start mb-0">
					                    Ordenar por: 
					                </p>
					            </div>
					            <div class="col-md-8">
					                <select id="ordenar" name="ordenar" class="form-select roboto-medium">
					                    <option value="0">Seleccionar orden</option>
					                    <option value="1">Nombre del curso A-Z</option>
					                    <option value="2">Nombre del curso Z-A</option>
					                    <option value="3">Precio: menor a mayor</option>
					                    <option value="4">Precio: mayor a menor</option>
					                </select>
					            </div>
					        </div>
					    </div>
					</div>						
				</div>


				<div class="mt-15">
					<div id="lista-cursos" class="row">
					
					</div>
				    <div class="text-center mt-4">
				        <button id="load-more"
				                class="btn btn-primary"
				                data-page="2"
				                style="display: none;">
				            Cargar más
				        </button>
				    </div>
				</div>
			</div>
	  	</div>
  	</div>
</div>

<div class="modal fade" id="filtroModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true" data-bs-backdrop="false" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex flex-column align-items-start">
                    <h5 class="mb-0 mt-4 text-description">Filtrar resultados</h5>
                </div>
		       <button type="button"
		                class="btn-close"
		                data-bs-dismiss="modal"
		                aria-label="Close">
		        </button>
            </div>
            <div class="modal-body">
				<div id="contenedorModalFiltros"></div>
            </div>
        </div>
    </div>
</div>

<div class="pt-15 pb-15 bg-primary">
	<div class="container pt-15 pb-15">
		<div class="text-center pb-4">
		  <h2 class="fs-3x text-bold-primary white">Solicita tu curso ideal</h2>
		  <p class="fs-6 white mt-4 text-medium-primary white">¿Te interesa un curso? Pide que lo programemos para ti.</p>
		</div>
	   	<div class="row mt-15 mb-15">
			@foreach ($cursosIdeales as $item)
				<div class="col-md-4 mb-4 mt-md-0">
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
								SOLICITAR
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
@endsection
@push('scripts')  
<script type="text/javascript">
$(document).ready(function () {
    // Variables globales
    let timeoutChecks, timeoutMin, timeoutMax, timeout;
    let valorMinAnterior = '', valorMaxAnterior = '';
    const rangeInput = document.querySelectorAll(".range-input input"),
        priceInput = document.querySelectorAll(".price-input input"),
        range = document.querySelector(".slider .progress");

    let priceGap = 0;
    let minAnterior = priceInput[0].value;
    let maxAnterior = priceInput[1].value;
    let id_categoria = 0;

    // Configuración de eventos
    $('#minimo').on('input', function () {
        clearTimeout(timeoutMin);
        timeoutMin = setTimeout(procesarMinimo, 1000);
    });

    $('#maximo').on('input', function () {
        clearTimeout(timeoutMax);
        timeoutMax = setTimeout(procesarMaximo, 1000);
    });

    $(document).on('change', '.form-check-input', function () {
        clearTimeout(timeoutChecks);
        timeoutChecks = setTimeout(obtenerCursosFiltros, 1000);
    });

    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        handlePaginationClick(this);
    });

    $('#ordenar').on('change', function() {
        obtenerCursosFiltros();
    });

    $('#ordenar-sm').on('change', function() {
        obtenerCursosFiltros();
    });

    $("input[name='categoria']").on("change", function () {
        id_categoria = $(this).val();
        cargarSubcategorias();
    });

    $("input[name='categoria'][value='0']").prop("checked", true).trigger("change");

    // Funciones
    function procesarMinimo() {
        let minimo = $('#minimo').val();
        if (minimo !== valorMinAnterior) {
            valorMinAnterior = minimo;
            let minimoNum = parseFloat(minimo);
            if (!isNaN(minimoNum)) {
                $('#maximo').attr('min', minimoNum);
                let maximo = parseFloat($('#maximo').val());
                if (!isNaN(maximo) && maximo < minimoNum) {
                    $('#maximo').val(minimo);
                    valorMaxAnterior = minimo; // actualizar porque se modificó automáticamente
                }
            }
        }
    }

    function procesarMaximo() {
        let maximo = $('#maximo').val();
        if (maximo !== valorMaxAnterior) {
            valorMaxAnterior = maximo;
            let minimo = parseFloat($('#minimo').val());
            let maximoNum = parseFloat(maximo);
            if (!isNaN(minimo) && !isNaN(maximoNum) && maximoNum < minimo) {
                $('#maximo').val(minimo);
                valorMaxAnterior = minimo; // actualizar porque se modificó automáticamente
            }
        }
    }

    function cargarSubcategorias() {
        $.ajax({
            url: "{{ route('subcategorias.html') }}",
            method: "GET",
            data: { id_categoria: id_categoria },
            success: function (html) {
                $("#subcategorias").html(html);
                obtenerCursosFiltros();
            },
            error: function () {
                $("#subcategorias").html("<p class='text-danger'>Error al cargar subcategorías.</p>");
            }
        });
    }

	function recopilarFiltros() {
	    let subcategorias = [], mesesAnios = [], modalidades = [], tipos = [];

	    $('.mes-checkbox:checked').each(function () {
	        mesesAnios.push({
	            mes:   parseInt($(this).val()),
	            anio:  parseInt($(this).data('anio'))
	        });
	    });
	    $('.subcategoria-checkbox:checked').each(function () {
	        subcategorias.push($(this).val());
	    });
	    $('.modalidad-checkbox:checked').each(function () {
	        modalidades.push($(this).val());
	    });
	    $('.tipo-checkbox:checked').each(function () {
	        tipos.push($(this).val());
	    });

	    return {
	        id_categoria: id_categoria,
	        subcategorias,
	        meses_anios:   mesesAnios,
	        modalidades,
	        tipos,
	        ordenar: $('#ordenar').val(),
	        minimo:  $('#minimo').val(),
	        maximo:  $('#maximo').val()
	    };
	}


    function obtenerCursosFiltros() {
	    const data = recopilarFiltros();
        console.table(data);

	    $.ajax({
	        url: "{{ route('cursos.filtrar') }}",
	        method: "GET",
	        data,
	        success: function(response) {
	            $('#lista-cursos').html(response.html);
	            $('#cantidadResultado').text(response.cantidadCursos + ' resultados');
	            $('#cantidadResultadoSm').text(response.cantidadCursos + ' resultados');

	            if (response.hasMorePages) {
	                $('#load-more')
	                    .data('page', response.currentPage + 1)
	                    .show();
	            } else {
	                $('#load-more').hide();
	            }
	        },
	        error: function() {
	            $('#lista-cursos').html('<div class="alert alert-danger">Error al cargar los cursos.</div>');
	        }
	    });
    }

    function ejecutarConDelay(min, max) {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            if (min != minAnterior || max != maxAnterior) {
                minAnterior = min;
                maxAnterior = max;
                obtenerCursosFiltros();
            }
        }, 1000);
    }

	$('#load-more').on('click', function() {
	    const $btn     = $(this);
	    const nextPage = $btn.data('page');
	    const data     = recopilarFiltros();

	    data.page = nextPage;
        console.table(data);

	    $.ajax({
	        url: "{{ route('cursos.filtrar') }}",
	        method: "GET",
	        data,
	        beforeSend: () => $btn.prop('disabled', true).text('Cargando...'),
	        success: function(response) {
	            $('#lista-cursos').append(response.html);
	            $('#cantidadResultado').text(response.cantidadCursos + ' resultados');
	            $('#cantidadResultadoSm').text(response.cantidadCursos + ' resultados');
	            if (response.hasMorePages) {
	                $btn
	                  .data('page', response.currentPage + 1)
	                  .prop('disabled', false)
	                  .text('Cargar más');
	            } else {
	                $btn.remove();
	            }
	        },
	        error: function() {
	            alert('Error al cargar más cursos.');
	            $btn.prop('disabled', false).text('Cargar más');
	        }
	    });
	});



    // Event listeners for price input range changes
    priceInput.forEach(input => {
        input.addEventListener("input", e => {
            let minVal = priceInput[0].value.trim();
            let maxVal = priceInput[1].value.trim();

            let minPrice = (minVal === "" || isNaN(minVal)) ? 0 : parseInt(minVal);
            let maxPrice = (maxVal === "" || isNaN(maxVal)) ? parseInt(rangeInput[1].max) : parseInt(maxVal);

            if ((maxPrice - minPrice >= priceGap) && maxPrice <= rangeInput[1].max) {
                if (e.target.classList.contains("input-min")) {
                    rangeInput[0].value = minPrice;
                    range.style.left = ((minPrice / rangeInput[0].max) * 100) + "%";
                } else {
                    rangeInput[1].value = maxPrice;
                    range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
                }
            }

            // Ejecutamos el filtro con valores válidos o por defecto
            ejecutarConDelay(minPrice, maxPrice);
        });
    });

    // Detecta cambios en los inputs de rango (range-min, range-max)
    rangeInput.forEach(input => {
        input.addEventListener("input", e => {
            let minVal = parseInt(rangeInput[0].value),
                maxVal = parseInt(rangeInput[1].value);

            if ((maxVal - minVal) < priceGap) {
                if (e.target.className === "range-min") {
                    rangeInput[0].value = maxVal - priceGap;
                } else {
                    rangeInput[1].value = minVal + priceGap;
                }
            } else {
                priceInput[0].value = minVal;
                priceInput[1].value = maxVal;
                range.style.left = ((minVal / rangeInput[0].max) * 100) + "%";
                range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";

                ejecutarConDelay(minVal, maxVal);
            }
        });
    });


    const $accordion = $('#accordionFiltros');
    const $originalContainer = $('#contenedorAcordeonFiltros');
    const $modalContainer = $('#contenedorModalFiltros');

    $('#filtroModal').on('show.bs.modal', function () {
        $modalContainer.append($accordion);
    });

    $('#filtroModal').on('hidden.bs.modal', function () {
        $originalContainer.append($accordion);
    });

});

</script>

@endpush
