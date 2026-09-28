const motos = [
    { id: 1, marca: "Bajaj", modelo: "Pulsar NS200", tipo: "urbana", precio: 3200, imagen: "img/Bajaj Pulsar NS200.jpg" },
    { id: 2, marca: "Honda", modelo: "CB190R", tipo: "urbana", precio: 3500, imagen: "img/Honda CB190R.jpg" },
    { id: 3, marca: "Honda", modelo: "Wave 110", tipo: "trabajo", precio: 1500, imagen: "img/Honda Wave 110.jpg" },
    { id: 4, marca: "Honda", modelo: "XR150L", tipo: "trabajo", precio: 2800, imagen: "img/Honda XR150L.jpg" },
    { id: 5, marca: "Kawasaki", modelo: "Ninja 300", tipo: "deportiva", precio: 6000, imagen: "img/Kawasaki Ninja 300.jpg" },
    { id: 6, marca: "Suzuki", modelo: "GSX-S150", tipo: "deportiva", precio: 3000, imagen: "img/Suzuki GSX-S150.jpg" },
    { id: 7, marca: "Yamaha", modelo: "MT-03", tipo: "deportiva", precio: 5500, imagen: "img/Yamaha MT-03.jpg" },
    { id: 8, marca: "Yamaha", modelo: "XTZ125", tipo: "trabajo", precio: 2200, imagen: "img/Yamaha XTZ125.jpg" }
];

const contenedor = document.getElementById('catalogo-container');
const filtro = document.getElementById('filtro-tipo');

function mostrarMotos(motosMostrar) {
    contenedor.innerHTML = '';

    motosMostrar.forEach(moto => {
        const tarjeta = `
            <div class="col-12 col-sm-6 col-lg-3 mb-4">
                <div class="card h-100">
                    <img 
                        src="${moto.imagen}" 
                        class="card-img-top img-moto" 
                        alt="${moto.marca} ${moto.modelo}">

                    <div class="card-body">
                        <h5 class="card-title">
                            ${moto.marca} ${moto.modelo}
                        </h5>

                        <p class="card-text text-muted">
                            Tipo:
                            <span class="text-capitalize">
                                ${moto.tipo}
                            </span>
                        </p>

                        <p class="card-text fw-bold text-danger">
                            $${moto.precio}
                        </p>

                        <button class="btn btn-outline-danger w-100 mt-2" onclick="mostrarDetalleMoto(${moto.id})">
                            Ver detalles
                        </button>
                    </div>
                </div>
            </div>
        `;

        contenedor.innerHTML += tarjeta;
    });
}

mostrarMotos(motos);

filtro.addEventListener('change', (e) => {
    const tipoSeleccionado = e.target.value;

    if (tipoSeleccionado === 'todas') {
        mostrarMotos(motos);
    } else {
        const motosFiltradas = motos.filter(
            moto => moto.tipo === tipoSeleccionado
        );

        mostrarMotos(motosFiltradas);
    }
});