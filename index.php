<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle POST request to save location
    $lat = $_POST['lat'] ?? 'unknown';
    $lon = $_POST['lon'] ?? 'unknown';
    $user = $_POST['user'] ?? 'anonymous';

    $content = "User: $user\nLatitude: $lat\nLongitude: $lon\nGoogle Maps: https://maps.google.com/?q=$lat,$lon\nTime: " . date('Y-m-d H:i:s') . "\n\n";

    file_put_contents('locations.txt', $content, FILE_APPEND | LOCK_EX);

    echo "Location saved";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Save Location</title>
</head>
<body>
  <h1>Saving your location...</h1>
  <script>
    function sendLocation(lat, lon, user) {
      const data = new URLSearchParams();
      data.append('lat', lat);
      data.append('lon', lon);
      data.append('user', user);

      fetch('', { // POST to same page
        method: 'POST',
        body: data
      })
      .then(response => response.text())
      .then(text => alert(text))
      .catch(err => console.error('Error:', err));
    }

    const userName = prompt("Please enter your name:", "anonymous") || "anonymous";

    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        position => sendLocation(position.coords.latitude, position.coords.longitude, userName),
        error => alert('Geolocation error: ' + error.message)
      );
    } else {
      alert('Geolocation not supported');
    }
  </script>
</body>
</html>