document.addEventListener("DOMContentLoaded", function () {
  function showErrorPS(field, errorEl, message) {
    if (errorEl) errorEl.textContent = message;
    field.classList.add("error-border");
    field.classList.remove("valid-border");
  }

  function showValidPS(field, errorEl) {
    if (errorEl) errorEl.textContent = "";
    field.classList.remove("error-border");
    field.classList.add("valid-border");
  }

  function clearNeutralPS(field, errorEl) {
    if (errorEl) errorEl.textContent = "";
    field.classList.remove("error-border");
    field.classList.remove("valid-border");
  }

  function attachFieldValidation(form, rules, errorMap) {
    Object.keys(rules).forEach((fieldId) => {
      const field = form.querySelector(`#${fieldId}`);
      if (!field) return;
      const rule = rules[fieldId];
      const errorEl = form.querySelector(`#${errorMap[fieldId]}`);

      field.addEventListener("input", function () {
        const val = field.value.trim();
        if (val === "") {
          clearNeutralPS(field, errorEl);
          return;
        }

        if (rule.matchField) {
          const matchVal = form
            .querySelector(`#${rule.matchField}`)
            .value.trim();
          if (val === matchVal) showValidPS(field, errorEl);
          else showErrorPS(field, errorEl, rule.patternMsg);
          return;
        }

        if (rule.pattern && rule.pattern.test(val)) showValidPS(field, errorEl);
        else showErrorPS(field, errorEl, rule.patternMsg);
      });
    });
  }

  function attachFormSubmitValidation(form, rules, errorMap) {
    form.addEventListener("submit", function (e) {
      let ok = true;

      Object.keys(rules).forEach((fieldId) => {
        const field = form.querySelector(`#${fieldId}`);
        if (!field) return;
        const rule = rules[fieldId];
        const errorEl = form.querySelector(`#${errorMap[fieldId]}`);
        const val = field.value.trim();

        if (val === "") {
          showErrorPS(field, errorEl, rule.requiredMsg);
          ok = false;
        } else if (rule.matchField) {
          const matchVal = form
            .querySelector(`#${rule.matchField}`)
            .value.trim();
          if (val !== matchVal) {
            showErrorPS(field, errorEl, rule.patternMsg);
            ok = false;
          } else {
            showValidPS(field, errorEl);
          }
        } else if (rule.pattern && !rule.pattern.test(val)) {
          showErrorPS(field, errorEl, rule.patternMsg);
          ok = false;
        } else {
          showValidPS(field, errorEl);
        }

        if (fieldId === "currentPassword") {
          field.addEventListener("input", function () {
            const curVal = field.value.trim();
            if (curVal === "") {
              clearNeutralPS(field, errorEl);
            } else {
              clearNeutralPS(field, errorEl);
            }
          });
          return;
        }

        field.addEventListener("input", function () {
          const liveVal = field.value.trim();
          if (liveVal === "") {
            clearNeutralPS(field, errorEl);
            return;
          }

          if (rule.matchField) {
            const matchVal = form
              .querySelector(`#${rule.matchField}`)
              .value.trim();
            if (liveVal === matchVal) showValidPS(field, errorEl);
            else showErrorPS(field, errorEl, rule.patternMsg);
            return;
          }

          if (rule.pattern && rule.pattern.test(liveVal))
            showValidPS(field, errorEl);
          else showErrorPS(field, errorEl, rule.patternMsg);
        });
      });

      if (!ok) {
        e.preventDefault();
        const firstInvalid = form.querySelector(".error-border");
        if (firstInvalid) {
          firstInvalid.focus();
          form.scrollIntoView({ behavior: "smooth", block: "start" });
        }
      }
    });
  }

  const loginForm = document.getElementById("loginForm");
  if (loginForm) {
    const loginRules = {
      loginInput: {
        requiredMsg: "Email or Username is required.",
        pattern: /.+/,
        patternMsg: "Enter a valid email or username.",
      },
      loginPassword: {
        requiredMsg: "Password is required.",
        pattern: /.+/,
        patternMsg: "Password is required.",
      },
    };

    const loginErrorMap = {
      loginInput: "loginInputError",
      loginPassword: "loginPasswordError",
    };

    attachFieldValidation(loginForm, loginRules, loginErrorMap);
    attachFormSubmitValidation(loginForm, loginRules, loginErrorMap);
  }

  const registerForm = document.getElementById("registerForm");
  if (registerForm) {
    const regRules = {
      firstName: {
        requiredMsg: "First name is required.",
        pattern: /^[A-Za-z\s'-]+$/,
        patternMsg: "Only letters, spaces, apostrophes, or hyphens allowed.",
      },
      lastName: {
        requiredMsg: "Last name is required.",
        pattern: /^[A-Za-z\s'-]+$/,
        patternMsg: "Only letters, spaces, apostrophes, or hyphens allowed.",
      },
      username: {
        requiredMsg: "Username is required.",
        pattern: /^[A-Za-z0-9_]{4,15}$/,
        patternMsg: "4-15 characters, letters, numbers, underscore.",
      },
      email: {
        requiredMsg: "Email is required.",
        pattern: /^[^@\s]+@[^@\s]+\.[^@\s]+$/,
        patternMsg: "Enter a valid email.",
      },
      password: {
        requiredMsg: "Password is required.",
        pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/,
        patternMsg: "At least 8 chars, upper/lower, number, special char.",
      },
      confirm_password: {
        requiredMsg: "Confirm your password.",
        matchField: "password",
        patternMsg: "Passwords do not match.",
      },
    };

    const regErrorMap = {
      firstName: "firstNameError",
      lastName: "lastNameError",
      username: "usernameError",
      email: "emailError",
      password: "passwordError",
      confirm_password: "confirmPasswordError",
    };

    attachFieldValidation(registerForm, regRules, regErrorMap);
    attachFormSubmitValidation(registerForm, regRules, regErrorMap);
  }

  const resetForm = document.getElementById("resetPasswordForm");
  if (resetForm) {
    const resetRules = {
      currentPassword: {
        requiredMsg: "Current password is required.",
        pattern: /.+/,
        patternMsg: "Current password is required.",
      },
      newPassword: {
        requiredMsg: "New password is required.",
        pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/,
        patternMsg: "At least 8 chars, upper/lower, number, special char.",
      },
      confirmPassword: {
        requiredMsg: "Confirm your new password.",
        matchField: "newPassword",
        patternMsg: "Passwords do not match.",
      },
    };

    const resetErrorMap = {
      currentPassword: "currentPasswordError",
      newPassword: "newPasswordError",
      confirmPassword: "confirmPasswordError",
    };

    attachFieldValidation(resetForm, resetRules, resetErrorMap);
    attachFormSubmitValidation(resetForm, resetRules, resetErrorMap);
  }

  const forgotEmailForm = document.getElementById("forgotEmailForm");
  if (forgotEmailForm) {
    const forgotEmailRules = {
      email: {
        requiredMsg: "Email is required.",
        pattern: /^[^@\s]+@[^@\s]+\.[^@\s]+$/,
        patternMsg: "Enter a valid email.",
      },
    };

    const forgotEmailErrorMap = { email: "emailError" };
    attachFieldValidation(
      forgotEmailForm,
      forgotEmailRules,
      forgotEmailErrorMap,
    );
    attachFormSubmitValidation(
      forgotEmailForm,
      forgotEmailRules,
      forgotEmailErrorMap,
    );
  }

  const forgotResetForm = document.getElementById("resetForm");
  if (forgotResetForm) {
    const resetRules = {
      password: {
        requiredMsg: "New password is required.",
        pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/,
        patternMsg: "At least 8 chars, upper/lower, number, special char.",
      },
      confirm_password: {
        requiredMsg: "Confirm your password.",
        matchField: "password",
        patternMsg: "Passwords do not match.",
      },
    };

    const resetErrorMap = {
      password: "passwordError",
      confirm_password: "confirmPasswordError",
    };

    attachFieldValidation(forgotResetForm, resetRules, resetErrorMap);
    attachFormSubmitValidation(forgotResetForm, resetRules, resetErrorMap);

    const passwordField = forgotResetForm.querySelector("[name='password']");
    const confirmField = forgotResetForm.querySelector(
      "[name='confirm_password']",
    );
    const confirmError = document.getElementById("confirmPasswordError");

    if (passwordField && confirmField && confirmError) {
      confirmField.addEventListener("input", () => {
        if (confirmField.value !== passwordField.value) {
          confirmError.textContent = "Passwords do not match.";
        } else {
          confirmError.textContent = "";
        }
      });
    }
  }

  const editForm = document.getElementById("editProfileFormElement");
  if (editForm) {
    const profileRules = {
      firstName: {
        requiredMsg: "First name is required.",
        pattern: /^[A-Za-z\s'-]+$/,
        patternMsg: "First name should only contain letters.",
      },
      lastName: {
        requiredMsg: "Last name is required.",
        pattern: /^[A-Za-z\s'-]+$/,
        patternMsg: "Last name should only contain letters.",
      },
      username: {
        requiredMsg: "Username is required.",
        pattern: /^[A-Za-z0-9_]{3,20}$/,
        patternMsg: "3-20 chars, letters, numbers, underscores.",
      },
    };

    const profileErrorMap = {
      firstName: "firstNameError",
      lastName: "lastNameError",
      username: "usernameError",
    };

    attachFieldValidation(editForm, profileRules, profileErrorMap);
    attachFormSubmitValidation(editForm, profileRules, profileErrorMap);

    const phpProfileSuccess = document.querySelector(
      "#editProfileForm .message.success",
    );
    if (phpProfileSuccess) {
      editForm.reset();
      Object.keys(profileErrorMap).forEach((id) => {
        const f = editForm.querySelector(`#${id}`);
        const e = document.getElementById(profileErrorMap[id]);
        if (f) f.classList.remove("error-border", "valid-border");
        if (e) e.textContent = "";
      });
    }
  }

  document.querySelectorAll(".message").forEach((msg) => {
    setTimeout(() => {
      msg.style.opacity = "0";
      setTimeout(() => msg.remove(), 500);
    }, 5000);
  });
});
