// Add JavaScript to toggle active class on category dropdown
document.addEventListener("DOMContentLoaded", function() {
    const dropdownToggle = document.querySelector('.category-dropdown-toggle');
    const categoryDropdown = document.querySelector('.category-dropdown');

    dropdownToggle.addEventListener('click', function() {
        categoryDropdown.classList.toggle('active');
    });

    // Close the dropdown if the user clicks outside of it
    window.addEventListener('click', function(event) {
        if (!event.target.matches('.category-dropdown-toggle')) {
            const dropdowns = document.getElementsByClassName('category-dropdown');
            for (let i = 0; i < dropdowns.length; i++) {
                const openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('active')) {
                    openDropdown.classList.remove('active');
                }
            }
        }
    });
});
