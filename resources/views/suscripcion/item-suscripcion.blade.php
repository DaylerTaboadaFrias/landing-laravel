@foreach($suscripciones as $item)
<tr>
    <td class="roboto-medium">{{$item->id}}</td>
    <td class="roboto-medium">{{$item->correo}}</td>
    <td class="roboto-medium">
        <a href="#" class="btn btn-icon btn-primary" data-bs-placement="top" title="Eliminar" data-bs-toggle="modal" data-bs-target="#eliminarSuscripcion{{$item->id}}"><i class="fas fa-trash fs-4 text-white"></i></a>

        @include('suscripcion.modal-eliminar')
    </td>
</tr> 
@endforeach