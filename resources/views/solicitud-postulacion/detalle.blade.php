@extends('layout.admin')
@section('titulo')
<title>Detalle de la solicitud de postulación</title>
@endsection

@section('styles')

@endsection

@section('header')
<h1 class="text-white lh-base fw-bolder fs-1">Detalle de la solicitud de postulación</h1>
@endsection

@section('content')
<div class="container">
    <div class="row align-items-center mt-5 mb-5">
        <div class="col-12 col-lg-6 d-flex align-items-center mb-lg-0">
            <a href="{{url('solicitud-postulacion')}}" class="d-flex align-items-center text-decoration-none">
                <img src="{{asset('images/arrow_left.svg')}}" alt="Icon" class="me-4" style="width: 20px; height: 20px;">
                <h1 class="text-dark fw-bolder fs-2 my-0">Atrás</h1>
            </a>
        </div>
    </div>
    <div class="mb-4">
        <h4 class="fs-2">Detalle de la solicitud de postulación {{$solicitud->id}}</h4>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0 fw-bold fs-3">Información de la solicitud</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4 roboto-medium">

                        <div class="col-6"><strong>Código de solicitud:</strong></div>
                        <div class="col-6 roboto-medium">{{$solicitud->id}}</div>
                        
                        <div class="col-6"><strong>Fecha de la solicitud:</strong></div>
                        <div class="col-6 roboto-medium">{{ \Carbon\Carbon::parse($solicitud->created_at)->format('d/m/Y H:i') }}</div>

                        <div class="col-6"><strong>Nombre completo:</strong></div>
                        <div class="col-6">{{$solicitud->nombre_completo}}</div>

                        <div class="col-6"><strong>Número de teléfono:</strong></div>
                        <div class="col-6">{{$solicitud->telefono}}</div>

                        <div class="col-6"><strong>Correo electrónico:</strong></div>
                        <div class="col-6">{{$solicitud->correo}}</div>
                        
                        <div class="col-6"><strong>Perfil profesional:</strong></div>
                        <div class="col-6">{{$solicitud->perfil_profesional}}</div>
 
                        <div class="col-6"><strong>Especializaciones:</strong></div>
                        <div class="col-6">{{$solicitud->especializaciones}}</div>

                        <div class="col-6"><strong>Experiencia:</strong></div>
                        <div class="col-6">{{ $solicitud->experiencia }}</div>

                        <div class="col-6"><strong>Referencias:</strong></div>
                        <div class="col-6">{{ $solicitud->referencias }}</div>
 

                        <div class="col-6"><strong>Curriculum vitae:</strong></div>
                        <div class="col-6">
                            <a href="{{$solicitud->archivo}}" target="_blank" class="btn btn-icon btn-primary" data-bs-placement="top" title="Ver curriculum vitae"><i class="fas fa-eye fs-4 text-white"></i></a>
                        </div>
                        

                        <div class="col-6"><strong>Estado:</strong></div>
                        <div class="col-6">
                            @if($solicitud->recibido == 0)
                                <span class="badge badge-light-warning">Pendiente</span>
                            @elseif($solicitud->recibido == 1)
                                <span class="badge badge-light-success">Recibido</span>
                            @endif
                        </div>
                        
                        @if($solicitud->recibido == 0)
                        <div class="col-6"><strong>Acciones:</strong></div>
                        <div class="col-6">
                            <a href="#" class="btn btn-icon btn-primary" data-bs-placement="top" title="Marcar como recibido" data-bs-toggle="modal" data-bs-target="#recibidoSolicitudPostulacion"><i class="fas fa-check fs-4 text-white"></i></a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="recibidoSolicitudPostulacion" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true" data-bs-backdrop="false" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex flex-column align-items-start">
                    <h5 class="mb-0 mt-4">¿Esta seguro que desea marcar como recibido la solicitud de postulación con ID <strong>{{$solicitud->id}}</strong> a nombre de  <strong>{{ $solicitud->nombre_completo }}</strong> ?</h5>
                </div>
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-border-white" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="recibidoSolicitudPostulacion('{{$solicitud->id}}')">Aceptar</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')     
<script type="text/javascript">
$(document).ready(function() {
     $('#nosotros').addClass('here show');
     $('#navSolicitudPostulacion').addClass('actived');




    recibidoSolicitudPostulacion = function(id){
        $.ajax({
            type: "POST",
            url: "{{url('solicitud-postulacion/recibido-solicitud-postulacion')}}",
            data: {id: id},
            success: function( response ) {
                if (response.success) {
                    toastr.success(response.message, 'Satisfactorio!');
                    toastr.options.closeDuration = 10000;
                    toastr.options.timeOut = 10000;
                    toastr.options.extendedTimeOut = 10000;

                    setTimeout(function(){window.location = window.location} , 2000);

                }else{
                    toastr.error(response.message, 'Ocurrio un error!');
                    toastr.options.closeDuration = 10000;
                    toastr.options.timeOut = 10000;
                    toastr.options.extendedTimeOut = 10000;
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
            }
        });
    }


});
</script>
@endpush
