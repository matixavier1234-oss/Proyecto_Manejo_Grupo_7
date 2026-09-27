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