// Módulo del carrito de compras - Con persistencia en LocalStorage

// 1. Intentamos recuperar el carrito guardado; si no hay nada, inicia vacío []
let carrito = JSON.parse(localStorage.getItem('carrito_motostore')) || [];

// Función para guardar el carrito en la memoria del navegador
function guardarCarritoEnStorage() {
    localStorage.setItem('carrito_motostore', JSON.stringify(carrito));
}

// Función para agregar una moto al carrito
function agregarAlCarrito(idMoto, nombreMoto, precioMoto) {
    const item = {
        id: idMoto,
        nombre: nombreMoto,
        precio: precioMoto
    };

    carrito.push(item);
    guardarCarritoEnStorage(); // <--- Guarda automáticamente en localStorage
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
// Función para eliminar una sola instancia de la moto usando su ID
function eliminarDelCarrito(idMoto) {
    // Buscamos el índice de la primera coincidencia con ese ID
    const index = carrito.findIndex(item => item.id === idMoto);

    // Si la encuentra, la borramos del arreglo usando splice (solo 1 elemento)
    if (index !== -1) {
        carrito.splice(index, 1);
        guardarCarritoEnStorage();
        console.log(`[Carrito] Se eliminó una unidad de la moto con ID: ${idMoto}`);
    }
}

// Función para vaciar completamente el carrito
function vaciarCarrito() {
    carrito = [];
    guardarCarritoEnStorage(); // <--- Limpia el localStorage
    console.log("[Carrito] El carrito ha sido vaciado.");
}

// ==========================================
// CONEXIÓN CON LA INTERFAZ VISUAL (DOM)
// ==========================================

function actualizarInterfazCarrito() {
    const listaCarrito = document.getElementById('lista-carrito');
    const precioTotal = document.getElementById('precio-total');
    const contadorCarrito = document.getElementById('contador-carrito');

    if (!listaCarrito) return; // Validación por seguridad

    listaCarrito.innerHTML = '';

    if (carrito.length === 0) {
        listaCarrito.innerHTML = '<li class="list-group-item text-center text-muted mt-4">El carrito está vacío</li>';
    } else {
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

    if (precioTotal) precioTotal.textContent = '$' + calcularTotal();
    if (contadorCarrito) contadorCarrito.textContent = carrito.length;
}

// Conectar el botón de "Vaciar Carrito" del panel
const btnVaciar = document.getElementById('btn-vaciar-carrito');
if (btnVaciar) {
    btnVaciar.addEventListener('click', () => {
        vaciarCarrito();
        actualizarInterfazCarrito();
    });
}

// Cargar la interfaz visual automáticamente apenas abra cualquier página
document.addEventListener('DOMContentLoaded', () => {
    actualizarInterfazCarrito();
});
