<div class="modal fade" id="solicitudEnviada" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true" data-bs-backdrop="false" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content modal-confirmar m-7">

            <div class="modal-body m-4">
                <button type="button" class="btn-close btn-sm position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Cerrar" ></button>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row justify-content-center mb-5">
                            <div class="col-auto">
                                <img src="{{asset('images/check_celeste.png')}}" class="w-lg-70px">
                            </div>
                        </div>
                        <div class="row justify-content-center mb-15">
                            <div class="text-center justify-content-center">
                                <h5 class="fs-3 text-bold-primary" id="solicitudEnviadaTitulo">
                                    
                                </h5>
								<small class="text-normal fs-6" id="solicitudEnviadaDescripcion"></small>
							</div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-10 text-center">
                                <a href="{{url('/')}}" class="btns btn-round-primary">
                                    IR AL INICIO
                                    <img src="{{asset('images/arrow_forward_white.png')}}" class="icon-img ms-2">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
