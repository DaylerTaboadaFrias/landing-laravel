@foreach($cursos as $item)
<tr>
    <td class="roboto-medium">{{ $item->id }}</td>
    <td class="roboto-medium">
        <div class="symbol symbol-50px">
            <img class="imagen-rectangular-galeria" src="{{ asset($item->imagen) }}" alt=""/>
        </div>
    </td>
    <td class="roboto-medium">{{ $item->nombre_docente }}</td>
    <td class="roboto-medium">{{ $item->nombre_subcategoria }}</td>
    <td class="roboto-medium">{{ $item->nombre }}</td>
    <td class="roboto-medium">{{ $item->precio }}</td>
    <td class="roboto-medium">{{ $item->descuento }}</td>
    <td class="roboto-medium">
        @if($item->curso_popular)
            <span class="badge badge-light-success">Sí</span>
        @else
            <span class="badge badge-light-danger">No</span>
        @endif
    </td>
    <td class="roboto-medium">
        @if($item->curso_ideal)
            <span class="badge badge-light-success">Sí</span>
        @else
            <span class="badge badge-light-danger">No</span>
        @endif
    </td>
    <td class="roboto-medium">
        @if($item->habilitado)
            <span class="badge badge-light-success">Sí</span>
        @else
            <span class="badge badge-light-danger">No</span>
        @endif
    </td>
    <td class="roboto-medium">
        <a href="{{ url('/curso/pregunta-frecuente/'.$item->id) }}" class="btn btn-icon btn-primary" title="Asignar pregutna frecuente">
            <i class="fas fa-plus-circle"></i>
        </a>
    </td>
    <td class="roboto-medium">
        <a href="{{ url('/curso/opinion-estudiante/'.$item->id) }}" class="btn btn-icon btn-primary" title="Asignar opinión del estudiante">
            <i class="fas fa-plus-circle"></i>
        </a>
    </td>
    <td class="roboto-medium">
        <a href="{{ url('curso/editar/'.$item->id) }}" class="btn btn-icon btn-primary" title="Editar">
            <i class="fas fa-pencil-alt fs-4 text-white"></i>
        </a>

        <a href="#" class="btn btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#eliminarCurso{{ $item->id }}" title="Eliminar">
            <i class="fas fa-trash fs-4 text-white"></i>
        </a>

        @include('curso.modal-eliminar')
    </td>
</tr>
@endforeach
