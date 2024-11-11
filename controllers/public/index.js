// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    // Inicialmente muestra los productos de la categoría seleccionada en los parámetros de la URL
    loadHome();

    // Agregar un event listener al combobox para manejar los cambios de selección
    
});

// Función para cargar productos basados en la categoría seleccionada
async function loadHome() {
    const FORM = new FormData();
   MAIN_TITLE.textContent = `Inicio`;

}
