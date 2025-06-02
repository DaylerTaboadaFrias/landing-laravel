@foreach($solicitudes as $item)
<tr>
    <td class="roboto-medium">{{$item->id}}</td>
    <td class="roboto-medium">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}</td>
    <td class="roboto-medium">{{$item->nombre_completo}}</td>
    <td class="roboto-medium">{{$item->telefono}}</td>
    <td class="roboto-medium">{{$item->correo}}</td>
    <td class="roboto-medium">{{$item->nombre_motivo_contacto}}</td>
    <td>
        @if($item->recibido == 0)
            <span class="badge badge-light-danger">Pendiente</span>
        @elseif($item->recibido == 1)
            <span class="badge badge-light-success">Recibido</span>

        @endif
    </td>
    <td class="roboto-medium">

        <a href="{{ url('solicitud-contacto/detalle/'.$item->id) }}" data-bs-placement="top" title="Ver detalle" class="btn btn-icon btn-primary"><i class="fas fa-eye fs-4 text-white"></i></a>

        @if($item->recibido == 0)
        <a href="#" class="btn btn-icon  btn-icon btn-primary" data-bs-placement="top" title="Marcar como recibido" data-bs-toggle="modal" data-bs-target="#recibidoSolicitudPostulacion{{$item->id}}"><i class="fas fa-check fs-4 text-white"></i></a>
        @endif

        <a href="#" class="btn btn-icon btn-primary" data-bs-placement="top" title="Eliminar" data-bs-toggle="modal" data-bs-target="#eliminarSolicitudContacto{{$item->id}}"><i class="fas fa-trash fs-4 text-white"></i></a>

        @include('solicitud-contacto.modal-recibido-solicitud')
        @include('solicitud-contacto.modal-eliminar')
    </td>
</tr> 
@endforeach