document.addEventListener("DOMContentLoaded", function () {
    const contactForm = document.querySelector("form[method='POST']");
    if (!contactForm) return;

    // Validation rules for each field
    const validationRules = {
        first_name: {
            required: true,
            pattern: /^[A-Za-z\s'-]+$/,
            message:
                "First name can only contain letters, spaces, apostrophes, or hyphens.",
        },
        last_name: {
            required: true,
            pattern: /^[A-Za-z\s'-]+$/,
            message:
                "Last name can only contain letters, spaces, apostrophes, or hyphens.",
        },
        email: {
            required: true,
            pattern: /^[^@\s]+@[^@\s]+\.[^@\s]+$/,
            message: "Please enter a valid email address.",
        },
        subject: {
            required: true,
            pattern: /^.{2,100}$/,
            message: "Subject must be between 2 and 100 characters.",
        },
        inquiry_type: {
            required: true,
            message: "Please select an inquiry type.",
        },
        priority: {
            required: true,
            message: "Please select a priority level.",
        },
        message: {
            required: true,
            minLength: 10,
            message: "Message must be at least 10 characters.",
        },
    };

    // Clear all error messages
    function clearErrors() {
        document.querySelectorAll(".error").forEach((el) => {
            el.textContent = "";
        });
        document.querySelectorAll("input, select, textarea").forEach((el) => {
            el.classList.remove("error-border", "valid-border");
        });
    }

    // Validate a single field
    function validateField(fieldId) {
        const field = document.getElementById(fieldId);
        const rule = validationRules[fieldId];

        if (!field || !rule) return true;

        const value = field.value.trim();
        const errorSpan = field.parentElement.querySelector(".error");

        // Check if required
        if (rule.required && value === "") {
            if (errorSpan) {
                errorSpan.textContent =
                    field.parentElement
                        .querySelector("label")
                        .textContent.replace("*", "") + " is required.";
            }
            field.classList.add("error-border");
            return false;
        }

        if (value === "") {
            field.classList.remove("error-border");
            if (errorSpan) errorSpan.textContent = "";
            return true;
        }

        // Check pattern (for text fields)
        if (rule.pattern && !rule.pattern.test(value)) {
            if (errorSpan) errorSpan.textContent = rule.message;
            field.classList.add("error-border");
            return false;
        }

        // Check minimum length (for message)
        if (rule.minLength && value.length < rule.minLength) {
            if (errorSpan) errorSpan.textContent = rule.message;
            field.classList.add("error-border");
            return false;
        }

        // Valid field
        field.classList.remove("error-border");
        if (errorSpan) errorSpan.textContent = "";
        return true;
    }

    // Add real-time validation on input/change
    Object.keys(validationRules).forEach((fieldId) => {
        const field = document.getElementById(fieldId);
        if (!field) return;

        ["input", "change", "blur"].forEach((event) => {
            field.addEventListener(event, () => {
                validateField(fieldId);
            });
        });
    });

    // Validate all fields on form submission
    contactForm.addEventListener("submit", function (e) {
        clearErrors();

        let isValid = true;
        Object.keys(validationRules).forEach((fieldId) => {
            if (!validateField(fieldId)) {
                isValid = false;
            }
        });

        if (!isValid) {
            e.preventDefault();

            // Focus on first invalid field
            const firstInvalid = contactForm.querySelector(".error-border");
            if (firstInvalid) {
                firstInvalid.focus();
                firstInvalid.scrollIntoView({
                    behavior: "smooth",
                    block: "center",
                });
            }
        }
    });

    // Optional: Reset form validation on reset button click
    const resetBtn = contactForm.querySelector("button[type='reset']");
    if (resetBtn) {
        resetBtn.addEventListener("click", () => {
            setTimeout(clearErrors, 0);
        });
    }
});
