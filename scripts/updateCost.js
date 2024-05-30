function updateCost() {
    var quantity = parseInt(document.getElementById('quantity').value);

    var startDateInput = document.getElementById('start_date').value;
    var endDateInput = document.getElementById('end_date').value;

    var startDate = new Date(startDateInput);
    var endDate = new Date(endDateInput);

    // Calculate the difference in milliseconds and convert to whole days
    var timeDiff = endDate - startDate;
    var daysHired = Math.round(timeDiff / (1000 * 60 * 60 * 24)); // Convert milliseconds to days and round to nearest whole number

    if (isNaN(daysHired) || daysHired < 1) {
        daysHired = 0; // If invalid or negative, set to 0
    }

    var pricePerDayText = document.getElementById('ppd').textContent;
    var dollarValue = parseFloat(pricePerDayText.replace('Price per Day: $', ''));

    var totalCost = quantity * dollarValue * daysHired;

    // Update the rental cost element
    var rentalCostElement = document.getElementById('rental_cost');
    rentalCostElement.textContent = 'Rental Cost: $' + totalCost.toFixed(2); // Display total cost with two decimal places
}

document.getElementById('end_date').addEventListener('change', updateCost);
document.getElementById('start_date').addEventListener('change', updateCost);
document.getElementById('quantity').addEventListener('change', updateCost);