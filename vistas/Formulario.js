// Función para manejar el cambio en el input de archivo y mostrar la previsualización de la imagen
document.getElementById('image').addEventListener('change', function(event) {
    const input = event.target;
    const preview = document.getElementById('image-preview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(input.files[0]);
    }
});

// Función para abrir el diálogo de selección de archivo al hacer clic en el botón
function openFileInput() {
    document.getElementById('image').click();
}