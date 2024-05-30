<!-- Logo, Search Bar, and Category Buttons -->
<div class="header">
    <div class="logo">
        <a href="index.php">
            <img src="icons/WoodlandWheels.png" alt="Woodland Wheels Logo">
        </a>
    </div>

    <!-- Car Categories Dropdown -->
    <div class="category-dropdown">
        <button class="category-dropdown-toggle">Categories</button>
        <div class="category-buttons">
            <a class="category-link" href="category.php?type=sedan"><button class="category-button">Sedan</button></a>
            <a class="category-link" href="category.php?type=hatchback"><button class="category-button">Hatchback</button></a>
            <a class="category-link" href="category.php?type=SUV"><button class="category-button">SUV</button></a>
        </div>
    </div>

    <div class="search-bar">
        <form action="search.php" method="get">
            <input type="text" id="searchInput" name="q" placeholder="Search for cars...">
            <button type="submit" id="searchButton">Search</button>
            <div id="suggestionBox"></div>
        </form>
    </div>

    <!-- Reserve Button -->
    <div class="reserve-button">
        <a href="reserve.php">
            <button class="reservation-button">Reservation</button>
        </a>
    </div>
</div>

<script src="scripts/autocomplete.js" defer></script>
<script src="scripts/showCategories.js" defer></script>
