function validateStartDate() {
    var startDateInput = document.getElementById('start_date');
    var startDate = new Date(startDateInput.value);
    var today = new Date();

    // Compare the start date with today's date
    if (startDate < today) {
        alert("Start date cannot be in the past.");
        startDateInput.value = ""; // Clear the input field
        return false;
    }

    return true;
}

function validateEndDate() {
    var startDateInput = document.getElementById('start_date');
    var startDate = new Date(startDateInput.value);

    var endDateInput = document.getElementById('end_date');
    var endDate = new Date(endDateInput.value);

    // Check if the end date is less than one day after the start date
    if ((endDate - startDate) < (1000 * 60 * 60 * 24)) {
        alert("End date must be at least one day after the start date.");
        endDateInput.value = ""; // Clear the end date input
        return false;
    }
    return true;
}
