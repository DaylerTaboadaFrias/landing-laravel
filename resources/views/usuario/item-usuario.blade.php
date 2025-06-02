@foreach($usuarios as $item)
<tr>
    <td class="roboto-medium">{{$item->id}}</td>
    <td class="roboto-medium">{{$item->nombres}}</td>
    <td class="roboto-medium">{{$item->apellidos}}</td>
    <td class="roboto-medium">{{$item->nombre_usuario}}</td>
    <td class="roboto-medium">{{$item->correo}}</td>
    <td class="roboto-medium">
        @if($item->habilitado==1)
            <span class="badge badge-light-success">Activo</span>
        @else
            <span class="badge badge-light-danger">Inactivo</span>
        @endif
    </td>
    <td class="roboto-medium">

        <a href="{{ url('usuario/editar/'.$item->id) }}" class="btn btn-icon btn-primary"><i class="fas fa-pencil-alt fs-4 text-white"></i></a>

        <a href="#" class="btn btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#eliminarUsuario{{$item->id}}"><i class="fas fa-trash fs-4 text-white"></i></a>

        @include('usuario.modal-eliminar')
    </td>
</tr> 
@endforeach