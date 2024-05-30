<!-- Logo, Search Bar, and Category Buttons -->
<div class="header">
    <div class="logo">
        <a href="index.php">
            <img src="icons/WoodlandWheels.png" alt="Woodland Wheels Logo">
        </a>
    </div>

    <div class="search-bar">
        <form action="search.php" method="get">
            <input type="text" id="searchInput" name="q" placeholder="Search for cars...">
            <button type="submit" id="searchButton">Search</button>
            <div id="suggestionBox"></div>
        </form>
    </div>
</div>

<script src="scripts/autocomplete.js" defer></script>
