const inventarioStorageKey = 'motostore-inventario';
let inventario = [];
let modalMoto;

function formatearPrecio(precio) {
    return new Intl.NumberFormat('es-EC', {
        style: 'currency',
        currency: 'USD'
    }).format(precio);
}

function crearCelda(texto, clase = '') {
    const celda = document.createElement('td');
    celda.textContent = texto;
    if (clase) celda.className = clase;
    return celda;
}

function obtenerEstado(stock) {
    if (stock === 0) return { texto: 'Agotado', clase: 'text-bg-danger' };
    if (stock <= 3) return { texto: 'Stock bajo', clase: 'text-bg-warning' };
    return { texto: 'Disponible', clase: 'text-bg-success' };
}

function renderizarInventario() {
    const cuerpoTabla = document.getElementById('tabla-inventario');
    const busqueda = document.getElementById('buscar-moto').value.trim().toLowerCase();
    const tipo = document.getElementById('filtro-tipo-admin').value;
    const motosFiltradas = inventario.filter((moto) => {
        const coincideBusqueda = `${moto.marca} ${moto.modelo}`.toLowerCase().includes(busqueda);
        const coincideTipo = tipo === 'todas' || moto.tipo === tipo;
        return coincideBusqueda && coincideTipo;
    });

    cuerpoTabla.replaceChildren();
    document.getElementById('contador-motos').textContent = motosFiltradas.length;

    if (motosFiltradas.length === 0) {
        const filaVacia = document.createElement('tr');
        const celdaVacia = crearCelda('No hay motocicletas que coincidan con los filtros.', 'text-center text-secondary py-4');
        celdaVacia.colSpan = 7;
        filaVacia.appendChild(celdaVacia);
        cuerpoTabla.appendChild(filaVacia);
        return;
    }

    motosFiltradas.forEach((moto) => {
        const fila = document.createElement('tr');
        const estado = obtenerEstado(moto.stock);

        fila.appendChild(crearCelda(moto.id));
        fila.appendChild(crearCelda(`${moto.marca} ${moto.modelo}`, 'fw-semibold'));
        fila.appendChild(crearCelda(moto.tipo));
        fila.appendChild(crearCelda(formatearPrecio(moto.precio)));
        fila.appendChild(crearCelda(moto.stock));

        const estadoCelda = document.createElement('td');
        const etiquetaEstado = document.createElement('span');
        etiquetaEstado.className = `badge ${estado.clase}`;
        etiquetaEstado.textContent = estado.texto;
        estadoCelda.appendChild(etiquetaEstado);
        fila.appendChild(estadoCelda);

        const acciones = document.createElement('td');
        acciones.className = 'text-end text-nowrap';
        acciones.appendChild(crearBotonAccion('Editar', 'btn-outline-primary', () => abrirFormulario(moto)));
        acciones.appendChild(crearBotonAccion('Eliminar', 'btn-outline-danger', () => eliminarMoto(moto.id)));
        fila.appendChild(acciones);
        cuerpoTabla.appendChild(fila);
    });
}

function crearBotonAccion(texto, clase, accion) {
    const boton = document.createElement('button');
    boton.className = `btn btn-sm ${clase} me-1`;
    boton.type = 'button';
    boton.textContent = texto;
    boton.addEventListener('click', accion);
    return boton;
}

function guardarInventario() {
    localStorage.setItem(inventarioStorageKey, JSON.stringify(inventario));
}

function cargarTipos() {
    const filtro = document.getElementById('filtro-tipo-admin');
    const tipos = [...new Set(inventario.map((moto) => moto.tipo))].sort();
    tipos.forEach((tipo) => {
        const opcion = document.createElement('option');
        opcion.value = tipo;
        opcion.textContent = tipo.charAt(0).toUpperCase() + tipo.slice(1);
        filtro.appendChild(opcion);
    });
}

function limpiarFormulario() {
    document.getElementById('formulario-moto').reset();
    document.getElementById('moto-id').value = '';
    document.getElementById('modal-moto-titulo').textContent = 'Agregar motocicleta';
}

function abrirFormulario(moto = null) {
    limpiarFormulario();
    if (moto) {
        document.getElementById('modal-moto-titulo').textContent = 'Editar motocicleta';
        document.getElementById('moto-id').value = moto.id;
        document.getElementById('moto-marca').value = moto.marca;
        document.getElementById('moto-modelo').value = moto.modelo;
        document.getElementById('moto-tipo').value = moto.tipo;
        document.getElementById('moto-precio').value = moto.precio;
        document.getElementById('moto-stock').value = moto.stock;
        document.getElementById('moto-imagen').value = moto.imagen;
        document.getElementById('moto-descripcion').value = moto.descripcion;
    }
    modalMoto.show();
}

function eliminarMoto(id) {
    const moto = inventario.find((elemento) => elemento.id === id);
    if (!moto || !window.confirm(`¿Eliminar ${moto.marca} ${moto.modelo} del inventario?`)) return;
    inventario = inventario.filter((elemento) => elemento.id !== id);
    guardarInventario();
    renderizarInventario();
}

function guardarMoto(evento) {
    evento.preventDefault();
    const id = Number(document.getElementById('moto-id').value);
    const datosMoto = {
        id: id || Math.max(0, ...inventario.map((moto) => moto.id)) + 1,
        marca: document.getElementById('moto-marca').value.trim(),
        modelo: document.getElementById('moto-modelo').value.trim(),
        tipo: document.getElementById('moto-tipo').value,
        precio: Number(document.getElementById('moto-precio').value),
        stock: Number(document.getElementById('moto-stock').value),
        imagen: document.getElementById('moto-imagen').value.trim(),
        descripcion: document.getElementById('moto-descripcion').value.trim()
    };

    if (id) {
        inventario = inventario.map((moto) => moto.id === id ? datosMoto : moto);
    } else {
        inventario.push(datosMoto);
    }
    guardarInventario();
    renderizarInventario();
    modalMoto.hide();
}

async function cargarInventario() {
    const inventarioGuardado = localStorage.getItem(inventarioStorageKey);
    if (inventarioGuardado) {
        inventario = JSON.parse(inventarioGuardado);
    } else {
        const respuesta = await fetch('js/data.json');
        if (!respuesta.ok) throw new Error('No se pudo cargar el inventario.');
        inventario = await respuesta.json();
        guardarInventario();
    }
}

async function inicializarPanel() {
    modalMoto = new bootstrap.Modal(document.getElementById('modal-moto'));
    document.getElementById('buscar-moto').addEventListener('input', renderizarInventario);
    document.getElementById('filtro-tipo-admin').addEventListener('change', renderizarInventario);
    document.getElementById('btn-nueva-moto').addEventListener('click', () => abrirFormulario());
    document.getElementById('formulario-moto').addEventListener('submit', guardarMoto);

    try {
        await cargarInventario();
        cargarTipos();
        renderizarInventario();
    } catch (error) {
        const cuerpoTabla = document.getElementById('tabla-inventario');
        cuerpoTabla.replaceChildren();
        const filaError = document.createElement('tr');
        const celdaError = crearCelda(error.message, 'text-center text-danger py-4');
        celdaError.colSpan = 7;
        filaError.appendChild(celdaError);
        cuerpoTabla.appendChild(filaError);
    }
}

document.addEventListener('DOMContentLoaded', inicializarPanel);
