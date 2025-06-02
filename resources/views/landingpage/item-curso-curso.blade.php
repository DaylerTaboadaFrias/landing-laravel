@foreach ($cursos as $curso)
    <div class="col-md-6 mb-4">
        <div class="card padding-10">
            <label class="card-label top-20 left-20">
                {{ $curso->nombre_modalidad }}
            </label>
            <img src="{{asset($curso->imagen)}}" class="card-img-top" alt="Imagen del curso">
            <div class="card-body card-padding-h-0">
                <h5 class="fs-2x text-bold-primary label-limited">{{ $curso->nombre }}</h5>
                <p class="fs-6 text-description-secondary roboto-medium">{{ $curso->rango_fechas }}</p>
                <p class="fs-6 text-normal roboto-medium">Un curso de {{ $curso->prefijo_academico_docente }}. {{ $curso->nombre_docente }}</p>
                <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="fs-2x text-bold-primary roboto-medium">Bs. {{ $curso->precio_descuento }}</span>
                    @if ($curso->descuento != null || $curso->descuento != 0)
                        <span class="fs-1x text-normal text-decoration-line-through roboto-medium">Bs. {{ $curso->precio }}</span>
                    @endif
                </div>
                </div>
                <div class="d-flex align-items-center mt-4">
                    <a href="{{url('detalle-curso/'.$curso->id)}}" class="btns btn-round-primary w-100">
                        INSCRÍBETE
                        <img src="{{asset('images/arrow_forward_white.png')}}" class="icon-img ms-2">
                    </a>
                </div>
            </div>
        </div>	
   </div>
@endforeach
@if ($cursos->isEmpty())
    <div class="col-12">
        <div class="card text-center p-5 shadow-sm border-0 pt-10 pb-10">
            <img src="{{ asset('images/logo_cenace.png') }}" alt="Sin cursos" class="mx-auto mt-10" style="width: 150px;">
            <h4 class="text-bold-primary mt-10">No hay cursos disponibles para este mes</h4>
            <p class="text-description-secondary mt-10">Vuelve a revisar más adelante o explora otros meses.</p>
        </div>
    </div>
@endif
