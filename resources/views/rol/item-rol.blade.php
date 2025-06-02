@foreach($roles as $item)
<tr>
    <td class="roboto-medium">{{$item->id}}</td>
    <td class="roboto-medium">{{$item->nombre}}</td>
    <td class="roboto-medium">

        <a href="{{ url('rol/editar/'.$item->id) }}" class="btn btn-icon btn-primary" data-bs-placement="top" title="Editar">
            <i class="fas fa-pencil-alt fs-4 text-white"></i>
        </a>

        <a href="{{ url('rol/permiso/'.$item->id) }}" class="btn btn-icon btn-primary" data-bs-placement="top" title="Asignar permisos">
            <i class="fas fa-shield-alt fs-4 text-white"></i>
        </a>

        <a href="#" class="btn btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#eliminarRol{{$item->id}}" data-bs-placement="top" title="Eliminar">
            <i class="fas fa-trash fs-4 text-white"></i>
        </a>


        @include('rol.modal-eliminar')
    </td>
</tr> 
@endforeach