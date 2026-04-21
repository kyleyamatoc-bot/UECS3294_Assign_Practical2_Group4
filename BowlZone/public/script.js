// script.js

document.addEventListener("DOMContentLoaded", function () {
  /* ======================= */
  /* NAVIGATION BAR */
  /* ======================= */
  const dropdowns = document.querySelectorAll(".navbar .dropdown");
  document.addEventListener("DOMContentLoaded", function () {
    const dropdowns = document.querySelectorAll(".navbar .dropdown");
    const hamburger = document.querySelector(".hamburger");
    const navbar = document.querySelector(".navbar");
    const naviOverlay = document.querySelector(".naviOverlay");

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

    document.addEventListener("click", function (e) {
      if (!e.target.closest(".navbar .dropdown")) {
        dropdowns.forEach((d) => d.classList.remove("open"));
      }
    });

    let currentPage = window.location.pathname.split("/").pop().split("?")[0];
    if (currentPage === "") currentPage = "index.php";

    document.querySelectorAll(".navbar a").forEach((link) => {
      const href = link.getAttribute("href");
      if (!href) return;
      const linkPage = href.split("/").pop();
      if (linkPage === currentPage) {
        link.classList.add("active");
        const parentDropdown = link.closest(".dropdown");
        if (parentDropdown) {
          const dropBtn = parentDropdown.querySelector(".dropbtn");
          if (dropBtn) dropBtn.classList.add("active");
        }
      }
    });

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

    dropdowns.forEach((drop) => {
      drop.addEventListener("click", () => {
        if (window.innerWidth <= 840) {
          drop.classList.toggle("open");
        }
      });
    });
  });
  /* ======================= */
});
