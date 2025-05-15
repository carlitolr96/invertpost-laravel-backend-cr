<div class="modal fade" id="crearClienteModal" tabindex="-1" aria-labelledby="crearClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="clienteForm" class="modal-content" method="POST" action="{{ route('clientes.store') }}">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="crearClienteModalLabel">Agregar Nuevo Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div id="formErrores" class="text-danger small mb-2"></div>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" required>
                </div>
                <div class="mb-3">
                    <label for="tipo_cliente" class="form-label">Tipo de Cliente</label>
                    <input type="text" class="form-control" id="tipo_cliente" name="tipo_cliente" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Guardar Cliente</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('clienteForm');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(form);

            fetch('/clientes', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(async response => {
                if (!response.ok) {
                    let msg = 'Error al guardar el cliente.';
                    try {
                        const errData = await response.json();
                        if (errData.errors) {
                            msg = Object.values(errData.errors).flat().join('<br>');
                        } else if (errData.message) {
                            msg = errData.message;
                        }
                    } catch {}
                    document.getElementById('formErrores').innerHTML = msg;
                    throw new Error(msg);
                }
                return response.json();
            })
            .then(data => {

                document.getElementById('formErrores').innerHTML = '';

                var modal = bootstrap.Modal.getInstance(document.getElementById('crearClienteModal'));
                modal.hide();

                form.reset();

            })
            .catch(error => {

            });
        });
    }
});
</script>
@endpush