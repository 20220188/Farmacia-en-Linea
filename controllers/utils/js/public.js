/*
*   Controlador es de uso general en las páginas web del sitio público.
*   Sirve para manejar las plantillas del encabezado y pie del documento.
*/

// Constante para completar la ruta de la API.
const USER_API = 'services/public/cliente.php';
// Constante para establecer el elemento del contenido principal.
const MAIN = document.querySelector('main');
MAIN.style.paddingTop = '75px';
MAIN.style.paddingBottom = '100px';
MAIN.classList.add('container');
// Se establece el título de la página web.
document.querySelector('title').textContent = 'Farmacia Central - Store';
// Constante para establecer el elemento del título principal.
const MAIN_TITLE = document.getElementById('mainTitle');
MAIN_TITLE.classList.add('text-center', 'py-3');

/*  Función asíncrona para cargar el encabezado y pie del documento.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const loadTemplate = async () => {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    const DATA = await fetchData(USER_API, 'getUser');
    // Se comprueba si el usuario está autenticado para establecer el encabezado respectivo.
    if (DATA.session) {
        // Se verifica si la página web no es el inicio de sesión, de lo contrario se direcciona a la página web principal.
        if (!location.pathname.endsWith('login.html')) {
            // Se agrega el encabezado de la página web antes del contenido principal.
            MAIN.insertAdjacentHTML('beforebegin', `
                <header>
    <nav class="navbar fixed-top navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="index.html"><img src="../../resources/img/dmsystem.png" height="50" alt="Farmacia Central"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">

                    <div class="icon-container">
                        <a class="nav-link" href="index.html"><i class="fa-solid fa-house"></i></a>
                        <span>Inicio</span>
                    </div>
                    <div class="icon-container">
                        <a class="nav-link" href="productos.html"><i class="fa-solid fa-notes-medical"></i></a>
                        <span>Productos</span>
                    </div>
                    <div class="icon-container">
                        <a class="nav-link" href="carrito.html"><i class="fa-solid fa-cart-shopping"></i></a>
                        <span>Carrito</span>
                    </div>
                    <div class="icon-container dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user"></i>
                        </a>
                        <span>Mi cuenta</span>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="perfilUsuario.html">Editar perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="historialCompras.html">Historial de compras</a></li>
                        </ul>
                    </div>

                    <div class="icon-container">
                        <a class="nav-link" href="#" onclick="logOut()">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        </a>
                        <span>Cerrar sesión</span>
                    </div>


                </div>
            </div>
        </div>
    </nav>
</header>

            `);
        } else {
            location.href = 'index.html';
        }
    } else {
        // Se agrega el encabezado de la página web antes del contenido principal.
        MAIN.insertAdjacentHTML('beforebegin', `
            <header>
    <nav class="navbar fixed-top navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="index.html"><img src="../../resources/img/dmsystem.png" height="50" alt="Farmacia Central"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">
                    <div class="icon-container">
                        <a class="nav-link" href="index.html"><i class="fa-solid fa-house"></i></a>
                        <span>Inicio</span>
                    </div>
                    <div class="icon-container">
                        <a class="nav-link" href="productos.html"><i class="fa-solid fa-notes-medical"></i></a>
                        <span>Productos</span>
                    </div>
                    <div class="icon-container dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user"></i>
                        </a>
                        <span>Cuenta</span>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="login.html">
                                    <i class="fa-solid fa-arrow-right-to-bracket me-2"></i> Iniciar sesión
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="signup.html">
                                    <i class="fa-solid fa-user me-2"></i> Crear cuenta
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>


        `);
    }
    // Se agrega el pie de la página web después del contenido principal.
    MAIN.insertAdjacentHTML('afterend', `
        <footer>
            <nav class="navbar fixed-bottom bg-body-tertiary">
                <div class="container">
                    <div>
                        <h6>Farmacia Central de San Juan Opico</h6>
                        <p> Todos los derechos reservados - 2024 </p> 
                        
                    </div>
                    <div>
                        <h6>Diseñador -  Creador</h6>
                        <p>  Jafet Melara </p>
                    </div>
                </div>
            </nav>
        </footer>
        
    `);
}