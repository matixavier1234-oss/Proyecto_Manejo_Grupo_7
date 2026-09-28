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