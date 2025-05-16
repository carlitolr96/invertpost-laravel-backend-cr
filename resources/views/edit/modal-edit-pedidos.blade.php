<div class="modal fade" id="editarPedidoModal" tabindex="-1" aria-labelledby="editarPedidoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editarPedidoForm" class="modal-content" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="editarPedidoModalLabel">Editar Pedido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editarPedidoId" name="PedidoId">
                <div class="mb-3">
                    <label for="editarClientePedido" class="form-label">Cliente</label>
                    <select class="form-control" id="editarClientePedido" name="ClienteId" required>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->ClienteId }}">{{ $cliente->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="editarArticuloPedido" class="form-label">Artículo</label>
                    <select class="form-control" id="editarArticuloPedido" name="ArticuloId" required>
                        @foreach($articulos as $articulo)
                            <option value="{{ $articulo->ArticuloId }}">{{ $articulo->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="editarFechaPedido" class="form-label">Fecha de Pedido</label>
                    <input type="date" class="form-control" id="editarFechaPedido" name="fecha_pedido" required>
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
        var editarModal = document.getElementById('editarPedidoModal');
        if (editarModal) {
            editarModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                var cliente = button.getAttribute('data-cliente');
                var articulo = button.getAttribute('data-articulo');
                var fecha = button.getAttribute('data-fecha');

                document.getElementById('editarPedidoId').value = id;
                document.getElementById('editarClientePedido').value = cliente;
                document.getElementById('editarArticuloPedido').value = articulo;
                document.getElementById('editarFechaPedido').value = fecha ? fecha.substring(0, 10) : '';

                document.getElementById('editarPedidoForm').action = '/pedidos/' + id;
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('editarPedidoForm');
        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const id = document.getElementById('editarPedidoId').value;
                const formData = new FormData(form);

                fetch('/pedidos/' + id, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(async response => {
                    if (!response.ok) {
                        let msg = 'Error al actualizar el pedido.';
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
                    var modal = bootstrap.Modal.getInstance(document.getElementById('editarPedidoModal'));
                    modal.hide();

                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'Pedido actualizado correctamente.',
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