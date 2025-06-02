@foreach($datos as $item)
      <tr>
        @if($item->error=='')
          <input type="hidden" name="idCursoExterno[]" value="{{$item->idCursoExterno}}">
          <input type="hidden" name="nombreCurso[]" value="{{$item->nombreCurso}}">
          <input type="hidden" name="orden[]" value="{{$item->orden}}">
          <input type="hidden" name="duracion[]" value="{{$item->duracion}}">
          <input type="hidden" name="recursosDisponibles[]" value="{{$item->recursosDisponibles}}">
          <input type="hidden" name="fechaInicio[]" value="{{$item->fechaInicio}}">
          <input type="hidden" name="fechaFin[]" value="{{$item->fechaFin}}">
          <input type="hidden" name="precio[]" value="{{$item->precio}}">
          <input type="hidden" name="descuento[]" value="{{$item->descuento}}">
          <input type="hidden" name="resumen[]" value="{{$item->resumen}}">
          <input type="hidden" name="requisitos[]" value="{{$item->requisitos}}">
          <input type="hidden" name="objetivos[]" value="{{$item->objetivos}}">
          <input type="hidden" name="contenido[]" value="{{$item->contenido}}">
          <input type="hidden" name="idDocenteExterno[]" value="{{$item->idDocenteExterno}}">
          <input type="hidden" name="nombreDocente[]" value="{{$item->nombreDocente}}">
          <input type="hidden" name="prefijoAcademico[]" value="{{$item->prefijoAcademico}}">
          <input type="hidden" name="profesion[]" value="{{$item->profesion}}">
          <input type="hidden" name="biografia[]" value="{{$item->biografia}}">
          <input type="hidden" name="enlaceLinkedin[]" value="{{$item->enlaceLinkedin}}">
          <input type="hidden" name="nombreCategoria[]" value="{{$item->nombreCategoria}}">
          <input type="hidden" name="nombreSubcategoria[]" value="{{$item->nombreSubcategoria}}">
          <input type="hidden" name="modalidad[]" value="{{$item->modalidad}}">
          <input type="hidden" name="tipoCurso[]" value="{{$item->tipoCurso}}">
          
          <td style="width: 5%;">{{$loop->iteration}}</td>
          <td style="width: 5%;">{{$item->idCursoExterno}}</td>
          <td style="width: 5%;">{{$item->nombreCurso}}</td>
          <td style="width: 5%;">{{$item->orden}}</td>
          <td style="width: 5%;">{{$item->duracion}}</td>
          <td style="width: 5%;">{{$item->recursosDisponibles}}</td>
          <td style="width: 5%;">{{$item->fechaInicio}}</td>
          <td style="width: 5%;">{{$item->fechaFin}}</td>
          <td style="width: 5%;">{{$item->precio}}</td>
          <td style="width: 5%;">{{$item->descuento}}</td>
          <td style="width: 5%;">{{$item->resumen}}</td>
          <td style="width: 5%;">{{$item->requisitos}}</td>
          <td style="width: 5%;">{{$item->objetivos}}</td>
          <td style="width: 5%;">{{$item->contenido}}</td>
          <td style="width: 5%;">{{$item->idDocenteExterno}}</td>
          <td style="width: 5%;">{{$item->nombreDocente}}</td>
          <td style="width: 5%;">{{$item->prefijoAcademico}}</td>
          <td style="width: 5%;">{{$item->profesion}}</td>
          <td style="width: 5%;">{{$item->biografia}}</td>
          <td style="width: 5%;">{{$item->enlaceLinkedin}}</td>
          <td style="width: 5%;">{{$item->nombreCategoria}}</td>
          <td style="width: 5%;">{{$item->nombreSubcategoria}}</td>
          <td style="width: 5%;">{{$item->modalidad}}</td>
          <td style="width: 5%;">{{$item->tipoCurso}}</td>
          <td></td>
        @else
          <td style="width: 5%;">{{$loop->iteration}}</td>
          <td style="width: 5%;">{{$item->idCursoExterno}}</td>
          <td style="width: 5%;">{{$item->nombreCurso}}</td>
          <td style="width: 5%;">{{$item->orden}}</td>
          <td style="width: 5%;">{{$item->duracion}}</td>
          <td style="width: 5%;">{{$item->recursosDisponibles}}</td>
          <td style="width: 5%;">{{$item->fechaInicio}}</td>
          <td style="width: 5%;">{{$item->fechaFin}}</td>
          <td style="width: 5%;">{{$item->precio}}</td>
          <td style="width: 5%;">{{$item->descuento}}</td>
          <td style="width: 5%;">{{$item->resumen}}</td>
          <td style="width: 5%;">{{$item->requisitos}}</td>
          <td style="width: 5%;">{{$item->objetivos}}</td>
          <td style="width: 5%;">{{$item->contenido}}</td>
          <td style="width: 5%;">{{$item->idDocenteExterno}}</td>
          <td style="width: 5%;">{{$item->nombreDocente}}</td>
          <td style="width: 5%;">{{$item->prefijoAcademico}}</td>
          <td style="width: 5%;">{{$item->profesion}}</td>
          <td style="width: 5%;">{{$item->biografia}}</td>
          <td style="width: 5%;">{{$item->enlaceLinkedin}}</td>
          <td style="width: 5%;">{{$item->nombreCategoria}}</td>
          <td style="width: 5%;">{{$item->nombreSubcategoria}}</td>
          <td style="width: 5%;">{{$item->modalidad}}</td>
          <td style="width: 5%;">{{$item->tipoCurso}}</td>
          <td style="width: 10%;background-color: red; color: white;">{{$item->error}}</td>
        @endif

      </tr>

@endforeach

