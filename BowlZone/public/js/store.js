document.addEventListener("DOMContentLoaded", function () {
    // Quantity controls for product pages
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
            if (value < 10) quantityInput.value = value + 1;
        });

        quantityInput.addEventListener("input", () => {
            const value = parseInt(quantityInput.value, 10);
            if (isNaN(value) || value < 0) {
                quantityInput.value = 0;
            } else if (value > 10) {
                quantityInput.value = 10;
            } else {
                quantityInput.value = value;
            }
        });
    });

    // Auto-dismiss success and warning messages after 5 seconds
    document
        .querySelectorAll(".success-message, .warning-message")
        .forEach((msg) => {
            setTimeout(() => {
                msg.style.transition = "opacity 0.5s ease";
                msg.style.opacity = "0";
                setTimeout(() => msg.remove(), 500);
            }, 5000);
        });

    // Checkout form enhancements and validation
    const checkoutForm = document.getElementById("checkout-form");
    if (checkoutForm) {
        const methodSelect = document.getElementById("payment_method");
        const cardField = document.getElementById("card-field");
        const bankField = document.getElementById("bank-field");
        const walletField = document.getElementById("wallet-field");

        const cardholderName = document.getElementById("cardholder_name");
        const cardNumber = document.getElementById("card_number");
        const expiryDate = document.getElementById("expiry_date");
        const cvv = document.getElementById("cvv");

        const fpxFullName = document.getElementById("fpx_full_name");
        const bankName = document.getElementById("bank");
        const accountNumber = document.getElementById("account_number");

        const walletProvider = document.getElementById("wallet_provider");
        const walletPhone = document.getElementById("wallet_phone");
        const walletFullName = document.getElementById("wallet_full_name");

        const cardholderNameError = document.getElementById(
            "cardholder_name_error",
        );
        const cardNumberError = document.getElementById("card_number_error");
        const expiryDateError = document.getElementById("expiry_date_error");
        const cvvError = document.getElementById("cvv_error");

        const fpxFullNameError = document.getElementById("fpx_full_name_error");
        const bankError = document.getElementById("bank_error");
        const accountNumberError = document.getElementById(
            "account_number_error",
        );

        const walletProviderError = document.getElementById(
            "wallet_provider_error",
        );
        const walletPhoneError = document.getElementById("wallet_phone_error");
        const walletFullNameError = document.getElementById(
            "wallet_full_name_error",
        );

        // Clear all error messages
        function clearErrors() {
            [
                cardholderNameError,
                cardNumberError,
                expiryDateError,
                cvvError,
                fpxFullNameError,
                bankError,
                accountNumberError,
                walletProviderError,
                walletPhoneError,
                walletFullNameError,
            ].forEach(function (el) {
                el.textContent = "";
            });
        }

        // Set error message for a field
        function setError(errorEl, message) {
            errorEl.textContent = message;
        }

        // Validate expiry date format (MM/YY) and ensure not expired
        function isValidExpiry(value) {
            if (!/^\d{2}\/\d{2}$/.test(value)) {
                return false;
            }

            const parts = value.split("/");
            const month = parseInt(parts[0], 10);
            const yearTwoDigit = parseInt(parts[1], 10);
            if (
                Number.isNaN(month) ||
                Number.isNaN(yearTwoDigit) ||
                month < 1 ||
                month > 12
            ) {
                return false;
            }

            const now = new Date();
            const currentYearTwoDigit = now.getFullYear() % 100;
            const currentMonth = now.getMonth() + 1;

            if (yearTwoDigit < currentYearTwoDigit) {
                return false;
            }
            if (yearTwoDigit === currentYearTwoDigit && month < currentMonth) {
                return false;
            }

            return true;
        }

        // Toggle visibility of payment method fields
        function toggleFields() {
            const val = methodSelect.value;
            cardField.style.display = val === "Card" ? "block" : "none";
            bankField.style.display = val === "FPX" ? "block" : "none";
            walletField.style.display = val === "E-Wallet" ? "block" : "none";
        }

        // Initialize field visibility
        toggleFields();

        // Show/hide fields when payment method changes
        methodSelect.addEventListener("change", function () {
            clearErrors();
            toggleFields();
        });

        // Clear errors when user starts typing
        document
            .querySelectorAll(".payment-form input, .payment-form select")
            .forEach((field) => {
                field.addEventListener("focus", function () {
                    const errorSpan =
                        this.parentElement.querySelector(".form-error");
                    if (errorSpan) {
                        errorSpan.textContent = "";
                    }
                });
            });

        // Format card number input (spaces every 4 digits)
        if (cardNumber) {
            cardNumber.addEventListener("input", function () {
                let value = this.value.replace(/\s/g, "");
                if (value.length > 16) value = value.slice(0, 16);
                let formatted = value.replace(/(\d{4})(?=\d)/g, "$1 ");
                this.value = formatted;
            });
        }

        // Format expiry date input (MM/YY format)
        if (expiryDate) {
            expiryDate.addEventListener("input", function () {
                let value = this.value.replace(/\D/g, "");
                if (value.length >= 2) {
                    value = value.slice(0, 2) + "/" + value.slice(2, 4);
                }
                this.value = value;
            });
        }

        // Format CVV input (only digits)
        if (cvv) {
            cvv.addEventListener("input", function () {
                this.value = this.value.replace(/\D/g, "").slice(0, 3);
            });
        }

        // Format account number input (only digits)
        if (accountNumber) {
            accountNumber.addEventListener("input", function () {
                this.value = this.value.replace(/\D/g, "").slice(0, 16);
            });
        }

        // Format wallet phone number input
        if (walletPhone) {
            walletPhone.addEventListener("input", function () {
                this.value = this.value.replace(/\D/g, "").slice(0, 11);
            });
        }

        // Form submission validation
        checkoutForm.addEventListener("submit", function (event) {
            clearErrors();
            const val = methodSelect.value;
            let hasError = false;

            if (!val) {
                hasError = true;
                setError(bankError, "Please select a payment method.");
            }

            // Validate Credit/Debit Card
            if (val === "Card") {
                if (!/^[A-Za-z ]+$/.test(cardholderName.value.trim())) {
                    hasError = true;
                    setError(
                        cardholderNameError,
                        "Cardholder name is required and must contain letters/spaces only.",
                    );
                }

                if (
                    !/^\d{16}$/.test(cardNumber.value.replace(/\s/g, "").trim())
                ) {
                    hasError = true;
                    setError(
                        cardNumberError,
                        "Card number must be exactly 16 digits.",
                    );
                }

                if (!isValidExpiry(expiryDate.value.trim())) {
                    hasError = true;
                    setError(
                        expiryDateError,
                        "Expiry must be MM/YY and not in the past.",
                    );
                }

                if (!/^\d{3}$/.test(cvv.value.trim())) {
                    hasError = true;
                    setError(cvvError, "CVV must be exactly 3 digits.");
                }
            }

            // Validate FPX
            if (val === "FPX") {
                if (fpxFullName.value.trim() === "") {
                    hasError = true;
                    setError(fpxFullNameError, "Full name is required.");
                }

                if (!bankName.value.trim()) {
                    hasError = true;
                    setError(bankError, "Please select a bank name.");
                }

                if (!/^\d{10,16}$/.test(accountNumber.value.trim())) {
                    hasError = true;
                    setError(
                        accountNumberError,
                        "Account number must be 10 to 16 digits.",
                    );
                }
            }

            // Validate E-Wallet
            if (val === "E-Wallet") {
                if (!walletProvider.value.trim()) {
                    hasError = true;
                    setError(
                        walletProviderError,
                        "Please select a wallet provider.",
                    );
                }

                if (!/^01\d{8,9}$/.test(walletPhone.value.trim())) {
                    hasError = true;
                    setError(
                        walletPhoneError,
                        "Phone number must be 10-11 digits and start with 01.",
                    );
                }

                if (walletFullName.value.trim() === "") {
                    hasError = true;
                    setError(walletFullNameError, "Full name is required.");
                }
            }

            if (hasError) {
                event.preventDefault();
            }
        });
    }
});
