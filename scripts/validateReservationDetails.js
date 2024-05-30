document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.reservation-form');
    const submitButton = form.querySelector('button[type="submit"]');
    const licenseSelect = form.querySelector('#license');
    const inputs = form.querySelectorAll('input');

    function validateForm() {
        let isValid = true;

        inputs.forEach(input => {
            if (!input.validity.valid) {
                isValid = false;
            }
        });

        // Check if the driver's license selection is set to "Yes"
        if (licenseSelect.value !== "Yes") {
            isValid = false;
        }

        // Enable or disable the submit button based on form validity
        submitButton.disabled = !isValid;
    }

    // Add event listeners to inputs and the license select
    inputs.forEach(input => {
        input.addEventListener('input', validateForm);
    });

    licenseSelect.addEventListener('change', validateForm);

    // Initial validation check
    validateForm();
});
