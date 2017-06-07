<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <form action="" method="POST">
<p>Write dates as YYYY-MM-DD or else it aint gonna work.</p>
Start date    <input type="text" name="startDate"/><br>
End date      <input type="text" name="endDate"/>
      <input type="submit" name="submit" value="Asteroids?">
    </form>
    <br>
    <form action="" method="POST">
      <select name="rover">
        <option value="FHAZ">Front Hazard Avoidance Camera</option>
        <option value="RHAZ">Rear Hazard Avoidance Camera</option>
        <option value="MAST">Mast Camera</option>
        <option value="CHEMCAM">Chemistry and Camera Complex</option>
        <option value="MAHLI">Mars Hand Lens Imager</option>
        <option value="MARDI">Mars Descent Imager</option>
      <input type="submit" name="submit" value="submit">
    </form>
  </body>
</html>

<?php
//function to retrieve Mars Rover photos from API
function roverPhotos() {
  $apiKey = 'MJNM4W8Ot1jbNzCPVOVLBd5v381zqy7m57Rl9p6d';
  $cam = $_POST['rover'];
  switch ($cam) {
    case 'FHAZ':
      $camInput = 'FHAZ';
      break;
    case 'RHAZ':
      $camInput = 'RHAZ';
      break;
    case 'MAST':
      $camInput = 'MAST';
      break;
    case 'CHEMCAM':
      $camInput = 'CHEMCAM';
      break;
    case 'MAHLI':
      $camInput = 'MAHLI';
      break;
    case 'MARDI':
      $camInput = 'MARDI';
      break;
    default:
      echo "Error. Please try again.";
      break;
  }
  $sol = rand(0, 1000);
  $url = "https://api.nasa.gov/mars-photos/api/v1/rovers/curiosity/photos?sol=". $sol ."&camera=". $camInput ."&api_key=". $apiKey;
  $json = file_get_contents($url);
  $array = json_decode($json, true);
  echo '<div class="img">';
  echo '<img class=img src='. "'" . $array['photos'][0]["img_src"]. "'" .'>';
  echo "</div>";
}

if (isset($_POST['rover'])) {
  roverPhotos();

}

function listAsteroids() {
  $startDate = $_POST['startDate']; //YYYY-MM-DD
  $endDate = $_POST['endDate'];
  $apiKey = 'MJNM4W8Ot1jbNzCPVOVLBd5v381zqy7m57Rl9p6d';
  $url = 'https://api.nasa.gov/neo/rest/v1/feed?start_date='. $startDate. '&end_date='. $endDate .'&api_key='. $apiKey;
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $curl_response = curl_exec($curl);
  if ($curl_response === false) {
      $info = curl_getinfo($curl);
      curl_close($curl);
      die('error occured during curl exec. Additional info: ' . var_export($info));
  }
  curl_close($curl);
  $json = json_decode($curl_response);
  if (isset($json->response->status) && $json->response->status == 'ERROR') {
      die('error occured: ' . $json->response->errormessage);
  }

  var_dump($json);
}

 ?>
