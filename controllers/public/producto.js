// Constante para completar la ruta de la API.
const PRODUCTO_API = 'services/public/producto.php';
const CATEGORIA_API = 'services/public/categoria.php';
const TIPO_PRODUCTO_API = 'services/public/tipo_producto.php';
const CATEGORIA_CB = document.getElementById('categoria');
const TIPO_PRODUCTO_CB = document.getElementById('tipoProducto');
const GENERO_CB = document.getElementById('genero');
// Constante tipo objeto para obtener los parámetros disponibles en la URL.
const PARAMS = new URLSearchParams(location.search);
const PRODUCTOS = document.getElementById('productos');


// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    // Se define un objeto con los datos de la categoría seleccionada.
    const FORM = new FormData();
    FORM.append('idDeporte', PARAMS.get('id'));
    // Petición para solicitar los productos de la categoría seleccionada.
    const DATA = await fetchData(PRODUCTO_API, 'readProductosDeporte', FORM);
    fillSelect(CATEGORIA_API, 'readAll', 'categoria');
    fillSelect(TIPO_PRODUCTO_API, 'readAll_TipoP', 'tipoProducto');


    // Inicialmente muestra los productos de la categoría seleccionada en los parámetros de la URL
    loadProducts();

    // Agregar un event listener al combobox para manejar los cambios de selección
    
});

CATEGORIA_CB.addEventListener('change', () => {
    const selectedValue = CATEGORIA_CB.value;
    loadProducts(selectedValue);
});

TIPO_PRODUCTO_CB.addEventListener('change', () => {
    const selectedValue = TIPO_PRODUCTO_CB.value;
    loadProducts(null,selectedValue);
});

// Función para cargar productos basados en la categoría seleccionada
async function loadProducts(categoria = null, tipoProducto = null, genero = null) {
    const FORM = new FormData();
    FORM.append('idProducto', PARAMS.get('id'));
    if (categoria) {
        // Usar el idDeporte de los parámetros de la URL
        FORM.append('idCategoria', categoria);
    }
    if (tipoProducto) {
        FORM.append('idTipoProducto', tipoProducto);
    }
   const data = await fetchData(PRODUCTO_API, 'readProductoxCategoria', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (data.status) {
        // Se asigna como título principal la categoría de los productos.
        MAIN_TITLE.textContent = `Productos`;
        // Se inicializa el contenedor de productos.
        PRODUCTOS.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        data.dataset.forEach(row => {
            // Se crean y concatenan las tarjetas con los datos de cada producto.
            PRODUCTOS.innerHTML += `
                <div class="col-sm-12 col-md-6 col-lg-3">
                    <div class="card mb-3">
                        <img src="${SERVER_URL}images/productos/${row.imagen}" class="card-img-top" alt="${row.nombre_producto}">
                        <div class="card-body">
                            <h5 class="card-title">${row.nombre_producto}</h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Tipo de producto:</strong> ${row.tipo_producto}</li>
                            <li class="list-group-item"><strong>Categoría:</strong> ${row.nombre_categoria}</li>
                        </ul>
                        <div class="card-body text-center">
                            <a href="detalle_producto.html?id=${row.id_producto}" class="btn btn-primary">Ver detalle</a>
                        </div>
                    </div>
                </div>
            `;
        });
    } else {
        // Se presenta un mensaje de error cuando no existen datos para mostrar.
        MAIN_TITLE.textContent = data.error;
    }

    //Funcion para volver a cargar la vista general de los productos

    async function reloadProductosDeporte() {
        const FORM = new FormData();
        FORM.append('idDeporte', PARAMS.get('id'));
        await loadProducts(null);
    }
    
    // Agrega el event listener después de que el DOM se haya cargado
    document.addEventListener('DOMContentLoaded', () => {
        // Agrega el event listener al botón
        document.getElementById('reloadButton').addEventListener('click', reloadProductosDeporte);
    });
}
