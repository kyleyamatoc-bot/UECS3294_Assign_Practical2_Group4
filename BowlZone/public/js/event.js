document.addEventListener("DOMContentLoaded", function () {
  const joinButtons = document.querySelectorAll(".join-now-login");

  joinButtons.forEach((btn) => {
    btn.addEventListener("click", function () {
      const msgDiv = document.createElement("div");
      msgDiv.style.cssText = `
      padding: 25px;
      margin: 20px auto;
      max-width: 500px;
      text-align: center;
      color: #dc3545;
      font-weight: bold;
      font-size: 18px;
      border: 2px solid #dc3545;
      border-radius: 10px;
      background-color: #ffe6e6;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      `;
      msgDiv.innerHTML = `
      Please login first to join this event.<br><br>
      <a href="../auth/login.php" style="color:#0077cc; text-decoration:underline; font-weight:bold;">Login here</a>
      `;

      btn.closest(".event-card").appendChild(msgDiv);
      setTimeout(() => msgDiv.remove(), 8000);
    });
  });
});

const eventsForm = document.getElementById("eventsForm");
const eventList = document.getElementById("eventList");
if (eventsForm && eventList) {
  const qInput = eventsForm.querySelector('input[name="q"]');
  const dateInput = eventsForm.querySelector('input[name="date"]');
  const sortSelect = eventsForm.querySelector('select[name="sort"]');
  const cards = Array.from(eventList.querySelectorAll(".event-card"));

  function isReal(card) {
    return (
      card.dataset &&
      card.dataset.name &&
      card.dataset.date &&
      card.dataset.price
    );
  }

  function apply() {
    const q = (qInput?.value || "").trim().toLowerCase();
    const date = (dateInput?.value || "").trim();
    const sort = sortSelect?.value || "relevance";

    cards.forEach((c) => {
      if (!isReal(c)) {
        c.style.display = "";
        return;
      }
      const name = (c.dataset.name || "").toLowerCase();
      const d = c.dataset.date || "";
      const okName = q === "" ? true : name.includes(q);
      const okDate = date === "" ? true : d === date;
      c.style.display = okName && okDate ? "" : "none";
    });

    const visible = cards.filter(
      (c) => c.style.display !== "none" && isReal(c),
    );
    const placeholders = cards.filter((c) => !isReal(c));

    if (sort === "date_asc" || sort === "date_desc") {
      visible.sort((a, b) =>
        sort === "date_asc"
          ? a.dataset.date.localeCompare(b.dataset.date)
          : b.dataset.date.localeCompare(a.dataset.date),
      );
    } else if (sort === "price_low" || sort === "price_high") {
      visible.sort((a, b) =>
        sort === "price_low"
          ? Number(a.dataset.price) - Number(b.dataset.price)
          : Number(b.dataset.price) - Number(a.dataset.price),
      );
    } else {
      visible.sort((a, b) =>
        (a.dataset.name || "").localeCompare(b.dataset.name || ""),
      );
    }

    visible.concat(placeholders).forEach((c) => eventList.appendChild(c));
  }

  eventsForm.addEventListener("submit", (e) => {
    e.preventDefault();
    apply();
  });

  apply();

  if (window.location.search.includes("event_history=1")) {
    const bookingSection = document.getElementById("eventHistory");
    bookingSection?.scrollIntoView({ behavior: "smooth" });
  }
}

(function () {
  const form = document.getElementById("bookEventForm");
  if (!form) return;

  const eventField =
    document.getElementById("event_name") ||
    form.querySelector('input[name="event_name"]');
  const qtyField = document.getElementById("qty");
  const nameField = document.getElementById("full_name");
  const emailField = document.getElementById("email");
  const phoneField = document.getElementById("phone");
  const priceEl = document.getElementById("pricePerPax");
  const totalEl = document.getElementById("totalAmount");

  const errors = {
    event: document.getElementById("eventError"),
    name: document.getElementById("nameError"),
    email: document.getElementById("emailError"),
    phone: document.getElementById("phoneError"),
    qty: document.getElementById("qtyError"),
  };

  function clearErrors() {
    for (const key in errors) {
      if (errors[key]) errors[key].textContent = "";
    }
  }

  function getEventPrice() {
    if (!eventField) return 0;
    if (
      eventField.tagName === "SELECT" &&
      eventField.selectedOptions.length > 0
    ) {
      return parseFloat(eventField.selectedOptions[0].dataset.price || 0);
    }
    if (eventField.dataset && eventField.dataset.price) {
      return parseFloat(eventField.dataset.price || 0);
    }
    return 0;
  }

  function refreshTotals() {
    const price = getEventPrice();
    const qty = parseInt(qtyField.value, 10) || 1;
    if (priceEl) priceEl.textContent = price.toFixed(2);
    if (totalEl) totalEl.textContent = (price * qty).toFixed(2);
  }

  if (qtyField) qtyField.addEventListener("input", refreshTotals);
  if (eventField && eventField.tagName === "SELECT") {
    eventField.addEventListener("change", refreshTotals);
  }

  if (phoneField) {
    phoneField.addEventListener("input", function () {
      phoneField.value = phoneField.value.replace(/\D/g, "").slice(0, 11);
    });
  }

  form.addEventListener("submit", function (e) {
    clearErrors();
    let valid = true;

    if (!eventField.value) {
      if (errors.event) errors.event.textContent = "Please choose an event.";
      valid = false;
    }
    if (!nameField.value.trim()) {
      if (errors.name) errors.name.textContent = "Full name is required.";
      valid = false;
    }
    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,}$/i;
    if (!emailPattern.test(emailField.value.trim())) {
      if (errors.email) errors.email.textContent = "Enter a valid email.";
      valid = false;
    }
    if (!/^\d{10,11}$/.test(phoneField.value.trim())) {
      if (errors.phone)
        errors.phone.textContent = "Phone must be 10-11 digits.";
      valid = false;
    }
    if (parseInt(qtyField.value, 10) < 1) {
      if (errors.qty)
        errors.qty.textContent = "At least 1 participant required.";
      valid = false;
    }

    if (!valid) e.preventDefault();
  });

  refreshTotals();
})();
