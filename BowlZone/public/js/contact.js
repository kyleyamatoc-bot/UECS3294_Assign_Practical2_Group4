document.addEventListener("DOMContentLoaded", function () {
  function validateContactForm() {
    let isValid = true;
    document
      .querySelectorAll(".error")
      .forEach((div) => (div.textContent = ""));

    const firstName = document.getElementById("first-name");
    if (firstName && firstName.value.trim() === "") {
      document.getElementById("firstNameError").textContent =
        "First name is required.";
      firstName.classList.add("error-border");
      isValid = false;
    }

    const lastName = document.getElementById("last-name");
    if (lastName && lastName.value.trim() === "") {
      document.getElementById("lastNameError").textContent =
        "Last name is required.";
      lastName.classList.add("error-border");
      isValid = false;
    }

    const phone = document.getElementById("phone");
    if (phone && phone.value.trim() === "") {
      document.getElementById("phoneNoError").textContent =
        "Phone number is required.";
      phone.classList.add("error-border");
      isValid = false;
    }

    const email = document.getElementById("email");
    if (email && email.value.trim() === "") {
      document.getElementById("emailError").textContent = "Email is required.";
      email.classList.add("error-border");
      isValid = false;
    }

    const message = document.getElementById("message");
    if (message && message.value.trim() === "") {
      document.getElementById("messageError").textContent =
        "Message is required.";
      message.classList.add("error-border");
      isValid = false;
    }

    return isValid;
  }

  window.validateContactForm = validateContactForm;

  const contactRules = {
    "first-name": {
      requiredMsg: "First name is required.",
      pattern: /^[A-Za-z\s'-]+$/,
      patternMsg:
        "First name can only contain letters, spaces, apostrophes, or hyphens.",
    },
    "last-name": {
      requiredMsg: "Last name is required.",
      pattern: /^[A-Za-z\s'-]+$/,
      patternMsg:
        "Last name can only contain letters, spaces, apostrophes, or hyphens.",
    },
    phone: {
      requiredMsg: "Phone number is required.",
      pattern: /^\d{10,15}$/,
      patternMsg: "Enter a valid phone number (10-15 digits).",
    },
    email: {
      requiredMsg: "Email is required.",
      pattern: /^[^@\s]+@[^@\s]+\.[^@\s]+$/,
      patternMsg: "Enter a valid email address (e.g., name@example.com).",
    },
    message: {
      requiredMsg:
        "Message is required. Please type your message so we can respond properly.",
      minWords: 10,
      patternMsg: "Message must be at least 10 words long.",
    },
  };

  const contactErrorMap = {
    "first-name": "firstNameError",
    "last-name": "lastNameError",
    phone: "phoneNoError",
    email: "emailError",
    message: "messageError",
  };

  function showError(fieldEl, errorId, msg) {
    fieldEl.classList.remove("valid-border");
    fieldEl.classList.add("error-border");
    const box = document.getElementById(errorId);
    if (box) box.textContent = msg;
  }

  function showValid(fieldEl, errorId) {
    fieldEl.classList.remove("error-border");
    fieldEl.classList.add("valid-border");
    const box = document.getElementById(errorId);
    if (box) box.textContent = "";
  }

  function clearNeutral(fieldEl, errorId) {
    fieldEl.classList.remove("error-border", "valid-border");
    const box = document.getElementById(errorId);
    if (box) box.textContent = "";
  }

  Object.keys(contactRules).forEach((fieldId) => {
    const field = document.getElementById(fieldId);
    if (!field) return;

    field.addEventListener("input", function () {
      const rule = contactRules[fieldId];
      const errorId = contactErrorMap[fieldId];
      const val = field.value.trim();

      if (fieldId === "message") {
        const words = val.split(/\s+/).filter((w) => w.length > 0);
        const wordCount = words.length;
        const wordCounter = document.getElementById("messageWordCount");
        if (wordCounter) {
          wordCounter.textContent = `${wordCount} / ${rule.minWords} words`;
          wordCounter.style.color = wordCount < rule.minWords ? "red" : "green";
        }

        if (val === "") {
          clearNeutral(field, errorId);
          return;
        }

        if (wordCount >= rule.minWords) {
          showValid(field, errorId);
        } else {
          showError(field, errorId, rule.patternMsg);
        }
        return;
      }

      if (val === "") {
        clearNeutral(field, errorId);
        return;
      }

      if (rule.pattern.test(val)) {
        showValid(field, errorId);
      } else {
        showError(field, errorId, rule.patternMsg);
      }
    });
  });

  const contactForm = document.getElementById("contactForm");
  if (contactForm) {
    contactForm.addEventListener("submit", function (e) {
      let ok = true;

      Object.keys(contactRules).forEach((fieldId) => {
        const field = document.getElementById(fieldId);
        if (!field) return;
        const rule = contactRules[fieldId];
        const errorId = contactErrorMap[fieldId];
        const val = field.value.trim();

        if (fieldId === "message") {
          const words = val.split(/\s+/).filter((w) => w.length > 0);
          if (val === "" || words.length < rule.minWords) {
            showError(field, errorId, rule.patternMsg);
            ok = false;
          } else {
            showValid(field, errorId);
          }
          return;
        }

        if (val === "") {
          showError(field, errorId, rule.requiredMsg);
          ok = false;
        } else if (rule.pattern && !rule.pattern.test(val)) {
          showError(field, errorId, rule.patternMsg);
          ok = false;
        } else {
          showValid(field, errorId);
        }
      });

      if (!ok) {
        e.preventDefault();
        const firstInvalid = contactForm.querySelector(".error-border");
        if (firstInvalid) firstInvalid.focus();
      }
    });
  }

  const clearErrorsBtn = document.getElementById("clearErrorsBtn");
  if (clearErrorsBtn) {
    clearErrorsBtn.addEventListener("click", function () {
      document
        .querySelectorAll(".error")
        .forEach((err) => (err.textContent = ""));
      document.querySelectorAll("input, textarea").forEach((field) => {
        field.classList.remove("error-border", "valid-border");
      });
      const wordCount = document.getElementById("messageWordCount");
      if (wordCount) wordCount.textContent = "";
    });
  }

  const clearFormBtn = document.getElementById("clearFormBtn");
  if (clearFormBtn && contactForm) {
    clearFormBtn.addEventListener("click", function () {
      contactForm.reset();
      document
        .querySelectorAll(".error")
        .forEach((err) => (err.textContent = ""));
      document.querySelectorAll("input, textarea").forEach((field) => {
        field.classList.remove("error-border", "valid-border");
      });
      const wordCount = document.getElementById("messageWordCount");
      if (wordCount) wordCount.textContent = "";
    });
  }
});
