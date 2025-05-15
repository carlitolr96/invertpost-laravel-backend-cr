<div class="modal fade" id="editarClienteModal" tabindex="-1" aria-labelledby="editarClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editarClienteForm" class="modal-content" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="editarClienteModalLabel">Editar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editarClienteId" name="ClienteId">
                <div class="mb-3">
                    <label for="editarNombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="editarNombre" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="editarTelefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="editarTelefono" name="telefono" required>
                </div>
                <div class="mb-3">
                    <label for="editarTipoCliente" class="form-label">Tipo de Cliente</label>
                    <input type="text" class="form-control" id="editarTipoCliente" name="tipo_cliente" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var editarModal = document.getElementById('editarClienteModal');
        if (editarModal) {
            editarModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                var nombre = button.getAttribute('data-nombre');
                var telefono = button.getAttribute('data-telefono');
                var tipo_cliente = button.getAttribute('data-tipo_cliente');

                document.getElementById('editarClienteId').value = id;
                document.getElementById('editarNombre').value = nombre;
                document.getElementById('editarTelefono').value = telefono;
                document.getElementById('editarTipoCliente').value = tipo_cliente;

                document.getElementById('editarClienteForm').action = '/clientes/' + id;
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('editarClienteForm');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const id = document.getElementById('editarClienteId').value;
            const formData = new FormData(form);

            fetch('/clientes/' + id, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(async response => {
                if (!response.ok) {
                    let msg = 'Error al actualizar el cliente.';
                    try {
                        const errData = await response.json();
                        if (errData.errors) {
                            msg = Object.values(errData.errors).flat().join('<br>');
                        } else if (errData.message) {
                            msg = errData.message;
                        }
                    } catch {}
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        html: msg,
                        timer: 3000,
                        showConfirmButton: false
                    });
                    throw new Error(msg);
                }
                return response.json();
            })
            .then(data => {
                var modal = bootstrap.Modal.getInstance(document.getElementById('editarClienteModal'));
                modal.hide();

                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Cliente actualizado correctamente.',
                    timer: 2000,
                    showConfirmButton: false
                });

                setTimeout(() => location.reload(), 2000);
            })
            .catch(error => {

            });
        });
    }
});
</script>
@endpush