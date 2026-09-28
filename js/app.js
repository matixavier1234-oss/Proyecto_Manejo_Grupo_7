document.addEventListener("DOMContentLoaded", function () {
    const enlaces = document.querySelectorAll(".navbar-nav .nav-link");

    enlaces.forEach(function (enlace) {
        enlace.addEventListener("click", function () {
            enlaces.forEach(function (item) {
                item.classList.remove("active");
            });

            this.classList.add("active");
        });
    });
});

/*Cargar imagenes en slider */
const heroSlides = document.querySelectorAll('.hero-slide');

if (heroSlides.length > 0) {
    let slideActual = 0;

    setInterval(() => {
        heroSlides[slideActual].classList.remove('active');

        slideActual++;

        if (slideActual >= heroSlides.length) {
            slideActual = 0;
        }

        heroSlides[slideActual].classList.add('active');
    }, 5000);
}