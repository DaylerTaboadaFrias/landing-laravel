@if(count($subcategorias)==0)
    <p class="text-muted">No hay subcategorías disponibles.</p>
@else
    @foreach($subcategorias as $sub)
        <div class="d-flex align-items-center mb-4 mt-md-0 mt-4">
            <input type="checkbox" class="form-check-input subcategoria-checkbox" id="sub-{{ $sub->id }}" value="{{ $sub->id }}">
            <label class="fs-6 text-normal text-start ms-2" for="sub-{{ $sub->id }}">{{ $sub->nombre }}</label>
        </div>
    @endforeach
@endif
