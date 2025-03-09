document.addEventListener("DOMContentLoaded", function () {
    let preloader = document.getElementById("preloder");

    
    setTimeout(() => {
        preloader.style.display = "none";
    }, 1000);
});

function topPage() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}