
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Weather map</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="script.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form action="" method="POST">
  <input type="text" name="location"/><br>
  <input type="text" name="countryCode"/>
  <button type="submit">Submit</button>
</form>
<br/>
</div>
</body>

<?php
if (!empty($_POST['location'])) {

  //location gathered from 'location' in form
  //country code gathered from 'countryCode' in form
  $location = $_POST['location'];
  $countryCode = $_POST['countryCode'];
  //Open Weather Map API key
  $key = 'c8e6829de50d9766dd33d6252db306ee';

  //API call and concatenated location and country code separated by comma
  //appid is the API key
  $weatherUrl = "http://api.openweathermap.org/data/2.5/weather?q=" . $location . ',' . $countryCode . '&appid=' . $key . '&units=metric&lang=en';
  //Get the contents of $url
  $json = file_get_contents($weatherUrl);
  //decode the json string from $json and convert it into a php variable
  $array = json_decode($json, true);
  //var_dump($array);

  echo "You can expect " . $array['weather'][0]['description']. "<br>";
  echo "The temperature will be around " . $array['main']['temp']. " degrees<br>";
  echo "In  " . $array['name'] . ", ";
  echo $array['sys']['country']. "<br>";

  $geoMapsKey = 'AIzaSyAjxWT1KBW78bslMG53vaKzd1EH7nK72ns';
  $mapUrl = "http://maps.googleapis.com/maps/api/geocode/json?address=" .$location .$countryCode ."&sensor=true";
  $string = file_get_contents($mapUrl);
  $json_a = json_decode($string, true);
  $lat = $json_a['results'][0]['geometry']['location']['lat'];
  $lng = $json_a['results'][0]['geometry']['location']['lng'];


  echo $lat. " ". $lng;

  $mapsKey = "";
  $mapsUrl = "https://maps.googleapis.com/maps/api/js?key=". $mapsKey ."&callback=initMap";
}

?>
</html>
