// Carga los datos del catálogo desde data.json
async function cargarCatalogo() {
  try {
    const res = await fetch('js/data.json');
    if (!res.ok) throw new Error('No se pudo cargar el catálogo');
    const motos = await res.json();
    renderizarMotos(motos);
    inicializarFiltros(motos);
  } catch (error) {
    console.error(error);
    const contenedor = document.getElementById('catalogo-container');
    if (contenedor) {
      contenedor.innerHTML = '<p class="text-danger">No se pudo cargar el catálogo de motocicletas.</p>';
    }
  }
}

// Dibuja las tarjetas de motos en el contenedor
function renderizarMotos(motos) {
  const contenedor = document.getElementById('catalogo-container');
  if (!contenedor) {
    console.error('No se encontró el contenedor #catalogo-container');
    return;
  }

  if (motos.length === 0) {
    contenedor.innerHTML = '<p>No hay motocicletas para mostrar.</p>';
    return;
  }

  contenedor.innerHTML = motos.map(moto => `
    <div class="col-md-4 mb-4">
      <div class="card h-100">
        <img src="${moto.imagen}" class="card-img-top" alt="${moto.marca} ${moto.modelo}">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">${moto.marca} ${moto.modelo}</h5>
          <p class="card-text">${moto.descripcion}</p>
          <p class="fw-bold">$${moto.precio}</p>
          <a href="detalle.html?id=${moto.id}" class="btn btn-primary mt-auto">Ver detalle</a>
        </div>
      </div>
    </div>
  `).join('');
}

// Configura el select de filtro por tipo
function inicializarFiltros(motos) {
  const filtro = document.getElementById('filtro-tipo');
  if (!filtro) return;

  filtro.addEventListener('change', (e) => {
    const tipoSeleccionado = e.target.value;
    const motosFiltradas = tipoSeleccionado === 'todas'
      ? motos
      : motos.filter(m => m.tipo === tipoSeleccionado);
    renderizarMotos(motosFiltradas);
  });
}

// Ejecuta todo cuando el HTML ya está cargado
document.addEventListener('DOMContentLoaded', cargarCatalogo);