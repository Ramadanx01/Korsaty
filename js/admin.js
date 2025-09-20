document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.querySelector(".sidebar");
    const contentWrapper = document.querySelector(".content-wrapper");
    const toggleBtn = document.querySelector("#sidebarToggle");

    if (toggleBtn && sidebar && contentWrapper) {
        toggleBtn.addEventListener("click", () => {
            sidebar.classList.toggle("toggled");
            contentWrapper.classList.toggle("toggled");
            // Optional: You can also toggle a class on the button itself if you want to animate it.
            // toggleBtn.classList.toggle("toggled");
        });
    }
});