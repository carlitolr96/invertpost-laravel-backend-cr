<div class="modal fade" id="editarArticuloModal" tabindex="-1" aria-labelledby="editarArticuloModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editarArticuloForm" class="modal-content" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="editarArticuloModalLabel">Editar Artículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editarArticuloId" name="ArticuloId">
                <div class="mb-3">
                    <label for="editarDescripcion" class="form-label">Descripción</label>
                    <input type="text" class="form-control" id="editarDescripcion" name="descripcion" required>
                </div>
                <div class="mb-3">
                    <label for="editarFabricante" class="form-label">Fabricante</label>
                    <input type="text" class="form-control" id="editarFabricante" name="fabricante" required>
                </div>
                <div class="mb-3">
                    <label for="editarCodigoBarras" class="form-label">Código de Barras</label>
                    <input type="text" class="form-control" id="editarCodigoBarras" name="codigo_barras" required>
                </div>
                <div class="mb-3">
                    <label for="editarPrecio" class="form-label">Precio</label>
                    <input type="number" class="form-control" id="editarPrecio" name="precio" required>
                </div>
                <div class="mb-3">
                    <label for="editarStock" class="form-label">Stock</label>
                    <input type="number" class="form-control" id="editarStock" name="stock" required>
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
document.addEventListener('DOMContentLoaded', function () {
    var editarModal = document.getElementById('editarArticuloModal');
    if (editarModal) {
        editarModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var descripcion = button.getAttribute('data-descripcion');
            var fabricante = button.getAttribute('data-fabricante');
            var codigo_barras = button.getAttribute('data-codigo_barras');
            var precio = button.getAttribute('data-precio');
            var stock = button.getAttribute('data-stock');

            document.getElementById('editarArticuloId').value = id;
            document.getElementById('editarDescripcion').value = descripcion;
            document.getElementById('editarFabricante').value = fabricante;
            document.getElementById('editarCodigoBarras').value = codigo_barras;
            document.getElementById('editarPrecio').value = precio;
            document.getElementById('editarStock').value = stock;

            document.getElementById('editarArticuloForm').action = '/articulos/' + id;
        });
    }

    
    const form = document.getElementById('editarArticuloForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const id = document.getElementById('editarArticuloId').value;
            const formData = new FormData(form);

            fetch('/articulos/' + id, {
                method: 'POST', 
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(async response => {
                if (!response.ok) {
                    let msg = 'Error al actualizar el artículo.';
                    try {
                        const errData = await response.json();
                        if (errData.errors) {
                            msg = Object.values(errData.errors).flat().join('<br>');
                        } else if (errData.message) {
                            msg = errData.message;
                        }
                    } catch {}
                    alert(msg);
                    throw new Error(msg);
                }
                return response.json();
            })
            .then(data => {
               
                var modal = bootstrap.Modal.getInstance(document.getElementById('editarArticuloModal'));
                modal.hide();

               
                let row = document.querySelector(`button[data-id="${id}"]`).closest('tr');
                row.children[1].textContent = data.descripcion ?? '';
                row.children[2].textContent = data.fabricante ?? '';
                row.children[3].textContent = data.codigo_barras ?? '';
                row.children[4].textContent = data.precio ?? '';
                row.children[5].textContent = data.stock ?? '';
                
            })
            .catch(error => {
                
            });
        });
    }
});
</script>
@endpush