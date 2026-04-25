document.addEventListener("DOMContentLoaded", function () {
    /* ======================= */
    /* NAVIGATION BAR          */
    /* ======================= */
    const dropdowns = document.querySelectorAll(".navbar .dropdown");
    const hamburger = document.getElementById("hamburgerBtn");
    const navbar = document.querySelector(".navbar");
    const naviOverlay = document.querySelector(".naviOverlay");

    // Dropdown toggle (click for mobile, hover handled by CSS for desktop)
    dropdowns.forEach((dropdown) => {
        const button = dropdown.querySelector(".dropbtn");
        if (!button) return;

        button.addEventListener("click", function (e) {
            e.preventDefault();
            dropdowns.forEach((d) => {
                if (d !== dropdown) d.classList.remove("open");
            });
            dropdown.classList.toggle("open");
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener("click", function (e) {
        if (!e.target.closest(".navbar .dropdown")) {
            dropdowns.forEach((d) => d.classList.remove("open"));
        }
    });

    // Active link highlighting
    const currentPath = window.location.pathname;
    document.querySelectorAll(".navbar a").forEach((link) => {
        const href = link.getAttribute("href");
        if (!href || href === "#") return;
        if (
            currentPath === href ||
            (currentPath.startsWith(href) && href !== "/")
        ) {
            link.classList.add("active");
            const parentDropdown = link.closest(".dropdown");
            if (parentDropdown) {
                const dropBtn = parentDropdown.querySelector(".dropbtn");
                if (dropBtn) dropBtn.classList.add("active");
            }
        }
    });

    // Hamburger menu toggle
    if (hamburger && naviOverlay && navbar) {
        hamburger.addEventListener("click", () => {
            navbar.classList.toggle("active");
            naviOverlay.classList.toggle("active");
        });

        naviOverlay.addEventListener("click", () => {
            navbar.classList.remove("active");
            naviOverlay.classList.remove("active");
        });
    }
});
