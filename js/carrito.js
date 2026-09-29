// Módulo del carrito de compras
console.log("Módulo del carrito cargado exitosamente.");

// Estructura de datos principal
let carrito = [];

// Función para agregar una moto al carrito
function agregarAlCarrito(idMoto, nombreMoto, precioMoto) {
    const item = {
        id: idMoto,
        nombre: nombreMoto,
        precio: precioMoto
    };

    carrito.push(item);
    console.log(`[Carrito] Se agregó: ${nombreMoto}`);
}

// Función para calcular el precio total
function calcularTotal() {
    let total = 0;
    for (let i = 0; i < carrito.length; i++) {
        total += carrito[i].precio;
    }
    return total;
}

// Función para eliminar una moto específica del carrito usando su ID
function eliminarDelCarrito(idMoto) {
    carrito = carrito.filter(item => item.id !== idMoto);
    console.log(`[Carrito] Se eliminó la moto con ID: ${idMoto}`);
}

// Función para vaciar completamente el carrito
function vaciarCarrito() {
    carrito = [];
    console.log("[Carrito] El carrito ha sido vaciado.");
}

// ==========================================
// CONEXIÓN CON LA INTERFAZ VISUAL (DOM)
// ==========================================

// Función para actualizar visualmente el panel lateral del carrito
function actualizarInterfazCarrito() {
    const listaCarrito = document.getElementById('lista-carrito');
    const precioTotal = document.getElementById('precio-total');
    const contadorCarrito = document.getElementById('contador-carrito');

    // 1. Limpiar la lista actual en pantalla
    listaCarrito.innerHTML = '';

    // 2. Verificar si está vacío o tiene productos
    if (carrito.length === 0) {
        listaCarrito.innerHTML = '<li class="list-group-item text-center text-muted mt-4">El carrito está vacío</li>';
    } else {
        // Recorrer el arreglo y crear un elemento visual para cada moto
        carrito.forEach(moto => {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = `
                <div>
                    <h6 class="my-0">${moto.nombre}</h6>
                    <small class="text-muted">$${moto.precio}</small>
                </div>
                <button class="btn btn-sm btn-outline-danger" onclick="eliminarDelCarrito(${moto.id}); actualizarInterfazCarrito();">X</button>
            `;
            listaCarrito.appendChild(li);
        });
    }

    // 3. Actualizar el precio total y el contador rojo de la barra superior
    precioTotal.textContent = '$' + calcularTotal();
    contadorCarrito.textContent = carrito.length;
}

// Conectar el botón de "Vaciar Carrito" del panel
document.getElementById('btn-vaciar-carrito').addEventListener('click', () => {
    vaciarCarrito();
    actualizarInterfazCarrito();
});
// ==========================================
// INTEGRACIÓN CON EL BOTÓN DE LA PÁGINA
// ==========================================
const btnAgregarPantalla = document.getElementById('btn-agregar-carrito');

if (btnAgregarPantalla) {
    btnAgregarPantalla.addEventListener('click', () => {
        // Leer el nombre que esté en la pantalla en ese momento
        const nombreObtenido = document.getElementById('detalle-marca-modelo').textContent || "Moto Seleccionada";

        // ¡SOLUCIÓN! Borramos el signo $ y todas las comas (,) antes de convertir a número
        const precioTexto = document.getElementById('detalle-precio').textContent.replace('$', '').replace(/,/g, '').trim();
        const precioObtenido = parseFloat(precioTexto) || 0;

        // Usamos un ID temporal aleatorio
        const idGenerado = Math.floor(Math.random() * 1000);

        // Llamar a tus funciones
        agregarAlCarrito(idGenerado, nombreObtenido, precioObtenido);
        actualizarInterfazCarrito();

        // Extra: Desplegar el carrito automáticamente para que el usuario vea su moto
        const panelCarrito = document.getElementById('carritoOffcanvas');
        const bsOffcanvas = bootstrap.Offcanvas.getInstance(panelCarrito) || new bootstrap.Offcanvas(panelCarrito);
        bsOffcanvas.show();
    });
}