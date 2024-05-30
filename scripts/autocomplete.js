document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const suggestionBox = document.getElementById('suggestionBox');
    const form = searchInput.closest('form');

    const getPreviousSearches = () => {
        return JSON.parse(localStorage.getItem('previousSearches') || '[]');
    };

    const saveSearch = (query) => {
        let searches = getPreviousSearches();
        if (!searches.includes(query)) {
            searches.push(query);
            if (searches.length > 3) {
                searches = searches.slice(-3); // Keep only the last 3 searches
            }
            localStorage.setItem('previousSearches', JSON.stringify(searches));
        }
    };

    const getCars = async () => {
        const response = await fetch('cars.json');
        return response.json();
    };

    const showSuggestions = (recentSearches, suggestions) => {
        suggestionBox.innerHTML = '';

        // Create and append recent searches section
        if (recentSearches.length > 0) {
            const recentSearchesHeader = document.createElement('div');
            recentSearchesHeader.className = 'suggestion-header';
            recentSearchesHeader.textContent = 'Recent Searches';
            suggestionBox.appendChild(recentSearchesHeader);

            const recentSearchesList = document.createElement('ul');
            recentSearches.forEach(search => {
                const listItem = document.createElement('li');
                listItem.textContent = search;
                listItem.addEventListener('click', () => {
                    searchInput.value = search;
                    suggestionBox.style.display = 'none';
                    saveSearch(search);
                    form.submit();  // Submit the form
                });
                recentSearchesList.appendChild(listItem);
            });
            suggestionBox.appendChild(recentSearchesList);
        }

        // Create and append suggested options section
        if (suggestions.length > 0) {
            const suggestedOptionsHeader = document.createElement('div');
            suggestedOptionsHeader.className = 'suggestion-header';
            suggestedOptionsHeader.textContent = 'Suggested Options';
            suggestionBox.appendChild(suggestedOptionsHeader);

            const suggestedOptionsList = document.createElement('ul');
            suggestions.forEach(suggestion => {
                const listItem = document.createElement('li');
                listItem.textContent = suggestion;
                listItem.addEventListener('click', () => {
                    searchInput.value = suggestion;
                    suggestionBox.style.display = 'none';
                    saveSearch(suggestion);
                    form.submit();  // Submit the form
                });
                suggestedOptionsList.appendChild(listItem);
            });
            suggestionBox.appendChild(suggestedOptionsList);
        }

        // Show the suggestion box if there are suggestions
        if (recentSearches.length > 0 || suggestions.length > 0) {
            suggestionBox.style.display = 'block';
            searchInput.style.borderBottomLeftRadius = '0px';
        } else {
            suggestionBox.style.display = 'none';
            searchInput.style.borderBottomLeftRadius = '30px';
        }
    };

    const filterCars = (cars, query) => {
        const lowerQuery = query.toLowerCase();
        return cars
            .filter(car => Object.keys(car).some(key => key !== 'vehicle_ID' && String(car[key]).toLowerCase().includes(lowerQuery)))
            .map(car => `${car.brand} ${car.model}`);
    };

    searchInput.addEventListener('input', async () => {
        const query = searchInput.value.trim();
        if (query) {
            const cars = await getCars();
            const suggestions = filterCars(cars, query);
            showSuggestions([], suggestions);
        } else {
            showSuggestions(getPreviousSearches(), []);
        }
    });

    searchInput.addEventListener('focus', () => {
        const query = searchInput.value.trim();
        if (!query) {
            showSuggestions(getPreviousSearches(), []);
        }
        searchInput.style.borderBottomLeftRadius = '0px';
    });

    searchInput.addEventListener('blur', () => {
        searchInput.style.borderBottomLeftRadius = '30px';
        setTimeout(() => { suggestionBox.style.display = 'none'; }, 100);
    });

    document.addEventListener('click', (event) => {
        if (!suggestionBox.contains(event.target) && event.target !== searchInput) {
            suggestionBox.style.display = 'none';
        }
    });

    form.addEventListener('submit', () => {
        saveSearch(searchInput.value.trim());
    });
});
