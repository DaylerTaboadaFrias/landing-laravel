@foreach($opiniones as $item)
<tr>
    <td class="roboto-medium">{{$item->id}}</td>
    <td class="roboto-medium">
        <div class="symbol symbol-50px">
            <img src="{{asset($item->imagen)}}" alt=""/>
        </div>
    </td>
    <td class="roboto-medium">{{$item->nombre_completo}}</td>
    <td class="roboto-medium">{{$item->profesion}}</td>
    <td class="roboto-medium">{{$item->opinion}}</td>
    <td class="roboto-medium">{{$item->orden}}</td>
    <td class="roboto-medium">
        @if($item->habilitado==1)
            <span class="badge badge-light-success">Si</span>
        @else
            <span class="badge badge-light-danger">No</span>
        @endif
    </td>
    <td class="roboto-medium">

        <a href="{{ url('opinion-docente/editar/'.$item->id) }}" data-bs-placement="top" title="Editar" class="btn btn-icon btn-primary"><i class="fas fa-pencil-alt fs-4 text-white"></i></a>

        <a href="#" class="btn btn-icon btn-primary" data-bs-placement="top" title="Eliminar" data-bs-toggle="modal" data-bs-target="#eliminarOpinionDocente{{$item->id}}"><i class="fas fa-trash fs-4 text-white"></i></a>

        @include('opinion-docente.modal-eliminar')
    </td>
</tr> 
@endforeach