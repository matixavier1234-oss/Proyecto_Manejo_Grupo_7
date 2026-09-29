// Función principal para mostrar los detalles
function mostrarDetalleMoto(idMoto) {
    try {
        // Buscamos la moto directamente en tu arreglo 'motos' de catalogo.js
        const moto = motos.find(m => m.id === idMoto);

        if (moto) {
            // Inyectamos los datos e imágenes reales
            document.getElementById('detalle-imagen').src = moto.imagen;
            document.getElementById('detalle-imagen').alt = `${moto.marca} ${moto.modelo}`;
            document.getElementById('detalle-marca-modelo').textContent = `${moto.marca} ${moto.modelo}`;
            document.getElementById('detalle-tipo').textContent = moto.tipo;
            document.getElementById('detalle-precio').textContent = `$${moto.precio.toLocaleString()}`;

            document.getElementById('detalle-descripcion').textContent = moto.descripcion || `Motocicleta ${moto.tipo} marca ${moto.marca}, excelente rendimiento y diseño.`;
            document.getElementById('detalle-stock').textContent = moto.stock || "5";

            // CONEXIÓN DEL BOTÓN "AÑADIR AL CARRITO" PARA ESTA MOTO ESPECÍFICA
            const btnAgregarDetalle = document.getElementById('btn-agregar-carrito');
            if (btnAgregarDetalle) {
                // Reemplazamos el botón para limpiar eventos anteriores duplicados
                const nuevoBtn = btnAgregarDetalle.cloneNode(true);
                btnAgregarDetalle.parentNode.replaceChild(nuevoBtn, btnAgregarDetalle);

                nuevoBtn.addEventListener('click', () => {
                    // Limpiamos el precio por si tiene comas o puntos
                    const precioTexto = document.getElementById('detalle-precio').textContent;
                    const precioLimpio = parseFloat(precioTexto.replace(/[\$,\.\s]/g, '')) || moto.precio;

                    // Llamamos a la función de carrito.js pasándole los datos reales
                    agregarAlCarrito(moto.id, `${moto.marca} ${moto.modelo}`, precioLimpio);
                    actualizarInterfazCarrito();

                    // Desplegar el offcanvas del carrito automáticamente
                    const panelCarrito = document.getElementById('carritoOffcanvas');
                    if (panelCarrito) {
                        const bsOffcanvas = bootstrap.Offcanvas.getInstance(panelCarrito) || new bootstrap.Offcanvas(panelCarrito);
                        bsOffcanvas.show();
                    }
                });
            }

            // Lógica de visibilidad (Ocultar el inicio, mostrar el detalle)
            document.getElementById('hero').classList.add('d-none');

            const seccionCatalogo = document.getElementById('catalogo');
            if (seccionCatalogo) seccionCatalogo.classList.add('d-none');

            document.getElementById('detalle-producto').classList.remove('d-none');

            // Subir el scroll al inicio de la página para mejor experiencia
            window.scrollTo(0, 0);
        } else {
            console.error("La motocicleta solicitada no existe en el inventario.");
        }
    } catch (error) {
        console.error("Error al cargar los detalles:", error);
    }
}

// Evento para el botón de regresar
const btnVolver = document.getElementById('btn-volver-catalogo');
if (btnVolver) {
    btnVolver.addEventListener('click', () => {
        // Ocultar el módulo de detalles
        document.getElementById('detalle-producto').classList.add('d-none');

        // Restaurar la visibilidad de la página principal
        document.getElementById('hero').classList.remove('d-none');
        const seccionCatalogo = document.getElementById('catalogo');
        if (seccionCatalogo) seccionCatalogo.classList.remove('d-none');
    });
}