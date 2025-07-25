document.addEventListener("DOMContentLoaded", function () {
    console.log("burgercharge");
    const sidenav = document.getElementById("mySidenav");
    const openBtn = document.getElementById("openBtn");
    const closeBtn = document.getElementById("closeBtn");

    openBtn.addEventListener("click", function () {
        sidenav.classList.add("active");
        sidenav.setAttribute("aria-hidden", "false");
    });

    closeBtn.addEventListener("click", function () {
        sidenav.classList.remove("active");
        sidenav.setAttribute("aria-hidden", "true");
    });

    document.addEventListener("click", function (event) {
        if (sidenav.classList.contains("active") &&
            !sidenav.contains(event.target) &&
            event.target !== openBtn) {
            sidenav.classList.remove("active");
            sidenav.setAttribute("aria-hidden", "true");
        }
    });
});


