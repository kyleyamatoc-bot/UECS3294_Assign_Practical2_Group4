document.addEventListener("DOMContentLoaded", function () {
    const hamburger = document.getElementById("hamburgerBtn");
    const navbar = document.querySelector(".navbar");
    const naviOverlay = document.querySelector(".naviOverlay");
    const dropdowns = document.querySelectorAll(".navbar .dropdown");

    // Hamburger toggle
    if (hamburger && navbar && naviOverlay) {
        hamburger.addEventListener("click", () => {
            navbar.classList.toggle("active");
            naviOverlay.classList.toggle("active");
            hamburger.classList.toggle("open");
        });

        naviOverlay.addEventListener("click", () => {
            navbar.classList.remove("active");
            naviOverlay.classList.remove("active");
            hamburger.classList.remove("open");
            dropdowns.forEach((d) => d.classList.remove("open"));
        });
    }

    // Dropdown click toggle — MOBILE ONLY
    dropdowns.forEach((dropdown) => {
        const button = dropdown.querySelector(".dropbtn, .user-dropbtn");
        if (!button) return;

        button.addEventListener("click", function (e) {
            if (window.innerWidth > 840) return; // desktop: CSS hover handles it
            e.preventDefault();
            e.stopPropagation();

            const isOpen = dropdown.classList.contains("open");
            // Close all
            dropdowns.forEach((d) => d.classList.remove("open"));
            // Toggle clicked one
            if (!isOpen) dropdown.classList.add("open");
        });
    });

    // Close dropdowns on outside click
    document.addEventListener("click", function (e) {
        if (!e.target.closest(".navbar .dropdown")) {
            dropdowns.forEach((d) => d.classList.remove("open"));
        }
    });

    // Active link highlight
    const currentPath = window.location.pathname;
    document.querySelectorAll(".navbar a[href]").forEach((link) => {
        const href = link.getAttribute("href");
        if (!href || href === "#") return;
        if (
            currentPath === href ||
            (href !== "/" && currentPath.startsWith(href))
        ) {
            link.classList.add("active");
            const parentDropdown = link.closest(".dropdown");
            if (parentDropdown) {
                const dropBtn = parentDropdown.querySelector(".dropbtn");
                if (dropBtn) dropBtn.classList.add("active");
            }
        }
    });
});
