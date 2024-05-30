function cancelReservation(){
    // Delete the reserved_vehicle_id cookie
    document.cookie = "reserved_vehicle_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

    // Redirect the user to the home page
    window.location.href = "index.php";
}