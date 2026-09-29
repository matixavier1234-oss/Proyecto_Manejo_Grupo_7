// Función principal para mostrar los detalles
function mostrarDetalleMoto(idMoto) {
    try {
        // Buscamos la moto directamente en tu arreglo 'motos' de catalogo.js
        // Esto evita el desajuste de IDs con el data.json antiguo
        const moto = motos.find(m => m.id === idMoto);

        if (moto) {
            // Inyectamos los datos e imágenes reales
            document.getElementById('detalle-imagen').src = moto.imagen;
            document.getElementById('detalle-imagen').alt = `${moto.marca} ${moto.modelo}`;
            document.getElementById('detalle-marca-modelo').textContent = `${moto.marca} ${moto.modelo}`;
            document.getElementById('detalle-tipo').textContent = moto.tipo;
            document.getElementById('detalle-precio').textContent = `$${moto.precio.toLocaleString()}`;
            
            // Como tu arreglo no tiene descripción ni stock, ponemos un texto por defecto
            // para que no quede vacío (luego pueden agregarlo a catalogo.js si lo desean)
            document.getElementById('detalle-descripcion').textContent = moto.descripcion || `Motocicleta ${moto.tipo} marca ${moto.marca}, excelente rendimiento y diseño.`;
            document.getElementById('detalle-stock').textContent = moto.stock || "5";

            // Lógica de visibilidad (Ocultar el inicio, mostrar el detalle)
            document.getElementById('hero').classList.add('d-none');
            
            const seccionCatalogo = document.getElementById('catalogo');
            if(seccionCatalogo) seccionCatalogo.classList.add('d-none');

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
document.getElementById('btn-volver-catalogo').addEventListener('click', () => {
    // Ocultar el módulo de detalles
    document.getElementById('detalle-producto').classList.add('d-none');
    
    // Restaurar la visibilidad de la página principal
    document.getElementById('hero').classList.remove('d-none');
    const seccionCatalogo = document.getElementById('catalogo');
    if(seccionCatalogo) seccionCatalogo.classList.remove('d-none');
});