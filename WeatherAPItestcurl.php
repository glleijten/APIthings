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

//TODO Find out how to get $countryArr[$input][$i] into $location (see API URL)
//TODO Why does the loop catch the last value in array and doesn't loop through all
$key = 'c8e6829de50d9766dd33d6252db306ee';

  function returnCountry() {
    global $countryArr;
    global $key;
    $input = $_POST['country'];
      if (array_key_exists($input, $countryArr)) {
        $count = count($countryArr[$input], COUNT_RECURSIVE);
        for ($i=0; $i < $count; $i++) {
          $weatherUrl = "http://api.openweathermap.org/data/2.5/weather?q=" . $countryArr[$input][$i] . ',' . $countryArr['codes'][$input] . '&appid=' . $key . '&units=metric&lang=en';
        }
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
          echo "The temperature will be around " . $json->main->temp. " degrees<br>";
          var_dump($json);
      } else {
          echo "Country does not exist in array";
      }
    }
    returnCountry();
}


  //echo "You can expect " . $json->weather[0]->description . "<br>";
  //echo "The temperature will be around " . $json->main->temp. " degrees<br>";
  //echo "In  " . $json->name . ", ";
  //echo $json->sys->country. "<br>";

?>
</html>
