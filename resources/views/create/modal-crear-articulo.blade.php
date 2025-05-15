<div class="modal fade" id="crearArticuloModal" tabindex="-1" aria-labelledby="crearArticuloModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="articuloForm" class="modal-content" method="POST" action="{{ route('articulos.store') }}">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="crearArticuloModalLabel">Agregar Nuevo Articulo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div id="formErrores" class="text-danger small mb-2"></div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripcion</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                </div>
                <div class="mb-3">
                    <label for="fabricante" class="form-label">Fabricante</label>
                    <input type="text" class="form-control" id="fabricante" name="fabricante" required>
                </div>
                <div class="mb-3">
                    <label for="codigo_barras" class="form-label">Código de Barra</label>
                    <input type="text" class="form-control" id="codigo_barras" name="codigo_barras" required>
                </div>
                <div class="mb-3">
                    <label for="precio" class="form-label">Precio</label>
                    <input type="number" class="form-control" id="precio" name="precio" required>
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" class="form-control" id="stock" name="stock" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Guardar Articulo</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
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
                var modal = bootstrap.Modal.getInstance(document.getElementById('editarArticuloModal'));
                modal.hide();

                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Artículo actualizado correctamente.',
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