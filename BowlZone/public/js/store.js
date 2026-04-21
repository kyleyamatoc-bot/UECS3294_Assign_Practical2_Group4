document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".quantity").forEach((quantityBlock) => {
    const minusBtn = quantityBlock.querySelector(".minus");
    const plusBtn = quantityBlock.querySelector(".plus");
    const quantityInput = quantityBlock.querySelector(".quantity-input");
    if (!minusBtn || !plusBtn || !quantityInput) return;

    minusBtn.addEventListener("click", () => {
      const value = parseInt(quantityInput.value, 10) || 0;
      if (value > 0) quantityInput.value = value - 1;
    });

    plusBtn.addEventListener("click", () => {
      const value = parseInt(quantityInput.value, 10) || 0;
      if (value < 5) quantityInput.value = value + 1;
    });

    quantityInput.addEventListener("input", () => {
      const value = parseInt(quantityInput.value, 10);
      if (isNaN(value) || value < 0) {
        quantityInput.value = 0;
      } else if (value > 5) {
        quantityInput.value = 5;
      } else {
        quantityInput.value = value;
      }
    });
  });
});

document
  .querySelectorAll(".success-message, .warning-message")
  .forEach((msg) => {
    setTimeout(() => {
      msg.style.transition = "opacity 0.5s ease";
      msg.style.opacity = "0";
      setTimeout(() => msg.remove(), 500);
    }, 5000);
  });
