<?php
include 'countriesArray.php';
?>
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
  <legend>
    <fieldset>
               <form action="" method="POST">
      Country: <input type='text' name='country'><br>
               <input type='submit' name='submit'><br>
               </form>
    </fieldset>
  </legend>
<!--<form action="" method="POST">
  <input type="text" name="location"/><br>
  <input type="text" name="countryCode"/>
  <button type="submit">Submit</button>
</form> -->
<br/>
</div>
</body>

<?php

if (isset($_POST['country'])) {

  function returnCountry() {
    $input = $_POST['country'];
      if (in_array($input, $countries)) {
        return "True";
      } else {
        return "Country does not exist in array";
      }
  }
returnCountry();
}

if (!empty($_POST['location'])) {

  //location gathered from 'location' in form
  //country code gathered from 'countryCode' in form
  $location = $_POST['location'];
  $countryCode = $_POST['countryCode'];
  //Open Weather Map API key
  $key = 'c8e6829de50d9766dd33d6252db306ee';

  //next example will recieve all messages for specific conversation
  $weatherUrl = "http://api.openweathermap.org/data/2.5/weather?q=" . $location . ',' . $countryCode . '&appid=' . $key . '&units=metric&lang=en';
  $curl = curl_init($weatherUrl);
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
  echo "<br>";

  //line 51 doesn't work, other echos work, something wrong in accessing object
  echo "You can expect " . $json->weather[0]->description . "<br>";
  echo "The temperature will be around " . $json->main->temp. " degrees<br>";
  echo "In  " . $json->name . ", ";
  echo $json->sys->country. "<br>";

}

?>
</html>
