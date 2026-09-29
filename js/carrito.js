// Módulo del carrito de compras
console.log("Módulo del carrito cargado exitosamente.");

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
    guardarCarritoEnStorage(); // <-- Guardamos el cambio
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

// Función para eliminar una moto específica del carrito
function eliminarDelCarrito(idMoto) {
    carrito = carrito.filter(item => item.id !== idMoto);
    guardarCarritoEnStorage(); // <-- Guardamos el cambio
    console.log(`[Carrito] Se eliminó la moto con ID: ${idMoto}`);
}

// Función para vaciar completamente el carrito
function vaciarCarrito() {
    carrito = [];
    guardarCarritoEnStorage(); // <-- Guardamos el cambio
    console.log("[Carrito] El carrito ha sido vaciado.");
}

// ==========================================
// CONEXIÓN CON LA INTERFAZ VISUAL (DOM)
// ==========================================

function actualizarInterfazCarrito() {
    const listaCarrito = document.getElementById('lista-carrito');
    const precioTotal = document.getElementById('precio-total');
    const contadorCarrito = document.getElementById('contador-carrito');

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

    precioTotal.textContent = '$' + calcularTotal();
    contadorCarrito.textContent = carrito.length;
}

// Conectar el botón de "Vaciar Carrito" del panel
const btnVaciar = document.getElementById('btn-vaciar-carrito');
if (btnVaciar) {
    btnVaciar.addEventListener('click', () => {
        vaciarCarrito();
        actualizarInterfazCarrito();
    });
}

// ==========================================
// INTEGRACIÓN CON EL BOTÓN DE LA PÁGINA
// ==========================================
// Capturar el botón de proceder al pago
const btnProcesarCompra = document.getElementById('btn-procesar-compra');

if (btnProcesarCompra) {
    btnProcesarCompra.addEventListener('click', () => {

        // 1. Validar si está vacío con alerta moderna
        if (carrito.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Carrito vacío',
                text: 'Agrega una motocicleta del catálogo primero.',
                confirmButtonColor: '#dc3545' // Rojo estilo Bootstrap
            });
            return;
        }

        // 2. Confirmación de compra elegante
        Swal.fire({
            title: '¿Proceder al pago?',
            text: "Se procesará la compra de las motocicletas en tu carrito.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754', // Verde estilo Bootstrap
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Sí, pagar ahora',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {

                // 3. Pantalla de carga simulando conexión bancaria
                Swal.fire({
                    title: 'Procesando pago...',
                    html: 'Conectando de forma segura, por favor espera.',
                    timer: 2000,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                }).then(() => {
                    // 4. Vaciar carrito usando las funciones de Benjamín
                    vaciarCarrito();
                    actualizarInterfazCarrito();

                    // Ocultar el menú lateral
                    const panelCarrito = document.getElementById('carritoOffcanvas');
                    const bsOffcanvas = bootstrap.Offcanvas.getInstance(panelCarrito);
                    if (bsOffcanvas) {
                        bsOffcanvas.hide();
                    }

                    // 5. Alerta de éxito final
                    Swal.fire({
                        icon: 'success',
                        title: '¡Pago Exitoso!',
                        text: 'Gracias por tu compra en MotoStore.',
                        confirmButtonColor: '#198754'
                    });
                });
            }
        });
    });
}