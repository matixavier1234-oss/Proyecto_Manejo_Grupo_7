// Función principal para mostrar los detalles
async function mostrarDetalleMoto(idMoto) {
    try {
        // 1. Petición al archivo JSON
        const respuesta = await fetch('js/data.json');
        const motos = await respuesta.json();

        // 2. Buscar la motocicleta por su ID
        const moto = motos.find(m => m.id === idMoto);

        if (moto) {
            // 3. Inyectar los datos en el HTML
            document.getElementById('detalle-imagen').src = moto.imagen;
            document.getElementById('detalle-imagen').alt = `${moto.marca} ${moto.modelo}`;
            document.getElementById('detalle-marca-modelo').textContent = `${moto.marca} ${moto.modelo}`;
            document.getElementById('detalle-tipo').textContent = moto.tipo;
            document.getElementById('detalle-precio').textContent = `$${moto.precio.toLocaleString()}`;
            document.getElementById('detalle-descripcion').textContent = moto.descripcion;
            document.getElementById('detalle-stock').textContent = moto.stock;

            // 4. Lógica de visibilidad (Ocultar el inicio, mostrar el detalle)
            document.getElementById('hero').classList.add('d-none');
            
            // Si Mikel ya creó su sección de catálogo, la ocultamos también
            const seccionCatalogo = document.getElementById('catalogo');
            if(seccionCatalogo) seccionCatalogo.classList.add('d-none');

            // Mostramos tu módulo
            document.getElementById('detalle-producto').classList.remove('d-none');
            
            // Subir el scroll al inicio de la página para mejor experiencia de usuario
            window.scrollTo(0, 0);
        } else {
            console.error("La motocicleta solicitada no existe en el inventario.");
        }
    } catch (error) {
        console.error("Error al cargar la base de datos:", error);
    }
}

// Evento para el botón de regresar
document.getElementById('btn-volver-catalogo').addEventListener('click', () => {
    // Ocultar tu módulo
    document.getElementById('detalle-producto').classList.add('d-none');
    
    // Restaurar la visibilidad de la página principal
    document.getElementById('hero').classList.remove('d-none');
    const seccionCatalogo = document.getElementById('catalogo');
    if(seccionCatalogo) seccionCatalogo.classList.remove('d-none');
});