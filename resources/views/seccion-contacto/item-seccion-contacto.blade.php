@foreach($seccionesContactos as $item)
<tr>
    <td class="roboto-medium">{{$item->id}}</td>
    <td class="roboto-medium">
        <div class="symbol symbol-50px">
            <img src="{{asset($item->imagen)}}" class="imagen-rectangular-contacto" alt=""/>
        </div>
    </td>
    <td class="roboto-medium">{{$item->titulo}}</td>
    <td class="roboto-medium">{{$item->direccion}}</td>
    <td class="roboto-medium">{{$item->telefono}}</td>
    <td class="roboto-medium">{{$item->celular}}</td>
    <td class="roboto-medium">{{$item->correo}}</td>
    <td class="roboto-medium">{{$item->enlace_facebook}}</td>
    <td class="roboto-medium">

        <a href="{{ url('seccion-contacto/editar/'.$item->id) }}" data-bs-placement="top" title="Editar" class="btn btn-icon btn-primary"><i class="fas fa-pencil-alt fs-4 text-white"></i></a>

    </td>
</tr> 
@endforeach