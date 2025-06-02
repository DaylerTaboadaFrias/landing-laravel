@foreach($portadas as $item)
<tr>
    <td class="roboto-medium">{{$item->id}}</td>
    <td class="roboto-medium">
        <div class="symbol symbol-80px">
            <img class="imagen-rectangular-incompany" src="{{asset($item->imagen)}}" alt=""/>
        </div>
    </td>
    <td class="roboto-medium">{{$item->enlace}}</td>
    <td class="roboto-medium">

        <a href="{{ url('portada-incompany/editar/'.$item->id) }}" data-bs-placement="top" title="Editar" class="btn btn-icon btn-primary"><i class="fas fa-pencil-alt fs-4 text-white"></i></a>

    </td>
</tr> 
@endforeach