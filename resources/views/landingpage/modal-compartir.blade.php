<div class="modal fade" id="compartir" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true" data-bs-backdrop="false" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-compartir">
            <div class="modal-header modal-header-compartir">
                <h5 class="pt-0 mt-4 fs-4 roboto-medium text-bold-primary"><strong>Compartir este curso</strong></h5>

                <!-- Botón X en la esquina -->
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <div class="row pb-12">
                    <div class="col-md-9">
                        <input type="text" class="form-control roboto-medium input-copiar-compartir" id="copyInput" value="{{$urlAdmin}}/detalle-curso/{{ $curso->id}}" readonly>
                    </div>
                    <div class="col-md-3">
                        <button id="copyButton" class="btn btn-primary boton-copiar-compartir text-normal roboto-medium">COPIAR</button>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-auto d-flex justify-content-center align-items-center">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{$urlAdmin}}/detalle-curso/{{ $curso->id}}" target="_blank">
                            <img src="{{ asset('images/facebook_azul.png') }}" alt="LinkedIn" class="img-fluid mx-2" style="max-height: 30px;">
                        </a>
                        <a href="https://wa.me/?text={{$urlAdmin}}/detalle-curso/{{ $curso->id}}" target="_blank">
                            <img src="{{ asset('images/whatsapp_azul.png') }}" alt="LinkedIn" class="img-fluid mx-2" style="max-height: 30px;">
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url{{$urlAdmin}}/detalle-curso/{{ $curso->id}}" target="_blank">
                            <img src="{{ asset('images/logo_linkedin_azul.png') }}" alt="LinkedIn" class="img-fluid mx-2" style="max-height: 30px;">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
