<div class="modal fade" id="eliminarOpinionDocente{{$item->id}}" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true" data-bs-backdrop="false" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex flex-column align-items-start">
                    <h5 class="mb-0 mt-4 roboto-medium">¿Esta seguro que desea eliminar la opinión del docente con ID <strong>{{$item->id}}</strong>?</h5>
                </div>
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-border-white" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="eliminarOpinionDocente('{{$item->id}}')">Aceptar</button>
            </div>
        </div>
    </div>
</div>