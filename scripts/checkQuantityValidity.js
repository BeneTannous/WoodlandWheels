function checkQuantityValidity() {
    var quantityInput = document.getElementById('quantity');
    var maxQuantity = parseInt(quantityInput.getAttribute('max'));
    var currentQuantity = parseInt(quantityInput.value);

    if (currentQuantity > maxQuantity) {
        quantityInput.value = maxQuantity; // Reset to the maximum value
    }
}
