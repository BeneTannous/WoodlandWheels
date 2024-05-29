// Sample array to store previous search terms
var previousSearches = ["sedan", "SUV", "BMW"];

// Function to display suggestions
function showSuggestions() {
    var input = document.getElementById("searchInput").value.toLowerCase();
    var suggestionBox = document.getElementById("suggestionBox");
    suggestionBox.innerHTML = "";

    previousSearches.forEach(function(term) {
        if (term.toLowerCase().indexOf(input) !== -1) {
            var suggestion = document.createElement("div");
            suggestion.classList.add("suggestion");
            suggestion.textContent = term;
            suggestion.addEventListener("click", function() {
                document.getElementById("searchInput").value = term;
                suggestionBox.style.display = "none";
            });
            suggestionBox.appendChild(suggestion);
        }
    });

    if (input === "") {
        suggestionBox.style.display = "none";
    } else {
        suggestionBox.style.display = "block";
    }
}

// Event listener for input field
document.getElementById("searchInput").addEventListener("input", showSuggestions);