@foreach($configuracionIncompany as $item)
<tr>
    <td class="roboto-medium">{{$item->id}}</td>
    <td class="roboto-medium">{{$item->correo}}</td>
    <td class="roboto-medium">{{$item->codigo_area}}</td>
    <td class="roboto-medium">{{$item->celular}}</td>
    
    <td class="roboto-medium">

        <a href="{{ url('configuracion-incompany/editar/'.$item->id) }}" data-bs-placement="top" title="Editar" class="btn btn-icon btn-primary"><i class="fas fa-pencil-alt fs-4 text-white"></i></a>

    </td>
</tr> 
@endforeach