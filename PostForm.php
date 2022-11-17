<?php

$APIFoodFetchURL = 'https://localhost:5001/api/Food';

//Initialize Curl Instance
$curl_Instance =curl_init();

//Set Curl Headers/Request
curl_setopt($curl_Instance, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl_Instance, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl_Instance, CURLOPT_URL, $APIFoodFetchURL);
curl_setopt($curl_Instance, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl_Instance, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
curl_setopt($curl_Instance, CURLOPT_VERBOSE, true);
curl_setopt($curl_Instance, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl_Instance, CURLOPT_SSL_VERIFYPEER, false);

//Get response Data and Parse from String to JSON
$GET_requestFoodData = json_decode(curl_exec($curl_Instance), true) ;

//Close Curl Instance
curl_close($curl_Instance);


//POST Button request
if(isset($_POST["submitOrder"])){

  //Retreive Data from form to post
  $input_orderName = filter_input(INPUT_POST, "orderName");
  $input_menuItem = filter_input(INPUT_POST, "menuItem");
  $input_quantity = filter_input(INPUT_POST, "quantity");

  //Display to ensure form is working
  // echo "input_orderName: ". $input_orderName ."<br>";
  // echo "input_menuItem: ". $input_menuItem ."<br>";
  // echo "input_quantity: ". $input_quantity ."<br>";

}


  //POST REQUEST 
  class Log {
    public static function debug($str) {
        print "DEBUG: " . $str . "\n";
    }
    public static function info($str) {
        print "INFO: " . $str . "\n";
    }
    public static function error($str) {
        print "ERROR: " . $str . "\n";
    }
}

function Curl($APIFoodFetchURL, $post_data, &$http_status, &$header = null) {
      Log::debug("Curl $APIFoodFetchURL JsonData=" . $post_data);

      $curl_Instance=curl_init();
      curl_setopt($curl_Instance, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl_Instance, CURLOPT_URL, $APIFoodFetchURL);
      // post_data
      curl_setopt($curl_Instance, CURLOPT_POST, true);
      curl_setopt($curl_Instance, CURLOPT_POSTFIELDS, $post_data);
      if (!is_null($header)) {
          curl_setopt($curl_Instance, CURLOPT_HEADER, true);
      curl_setopt($curl_Instance, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($curl_Instance, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
      curl_setopt($curl_Instance, CURLOPT_VERBOSE, true);
      curl_setopt($curl_Instance, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($curl_Instance, CURLOPT_SSL_VERIFYPEER, false);

      $response = curl_exec($curl_Instance);
      Log::debug('Curl exec=' . $APIFoodFetchURL);
        
      $body = null;
      // error
      if (!$response) {
          $body = curl_error($curl_Instance);
          // HostNotFound, No route to Host, etc  Network related error
          $http_status = -1;
          Log::error("CURL Error: = " . $body);
      } else {
        //parsing http status code
          $http_status = curl_getinfo($curl_Instance, CURLINFO_HTTP_CODE);

          if (!is_null($header)) {
              $header_size = curl_getinfo($curl_Instance, CURLINFO_HEADER_SIZE);
              $header = substr($response, 0, $header_size);
              $body = substr($response, $header_size);

          } else {
              $body = $response;
          }
      }

      curl_close($curl_Instance);

      return $body;
  }

  $APIFoodFetchURL = "https://localhost:5001/api/Food";

  //$ret = Curl($APIFoodFetchURL, $http_status, $json);

  //var_dump($ret);
}

;?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Post Order Form</title>
    <style>
      .form-div{
        position: absolute;
        top: 10%;
        left: 30%;
        margin-top: -50px;
        margin-left: -50px;
        width: 40%;
        height: 100px;
      }

    </style>
</head>
<body>

  <div class="form-div" >

  
    <!--Title Section of Post Food Form -->
    <center>
      <h4>Post Order Form</h4>
      <h6>By Michael Lopez & Saimer Nieves</h6>
    </center>



    <form  class="contact-form style-2" method="post" action = "" enctype="multipart/form-data">


     <!--Enter Order Name Field -->
      <div class="form-group">
        <label for="orderName">Enter Order Name:</label>
        <input type="text"  name="orderName" class="form-control" id="orderName" placeholder="Order Name">
      </div>


        <!--Enter Food Item Field -->
      <div class="form-group">
        <label for="menuItem">Menu Item</label>
        <select class="form-control" id="menuItem"  name="menuItem">

        <!-- Populate Select Tag from GET REQUEST with Food Items -->
        <?php foreach ($GET_requestFoodData as $oneFoodItem):?>

          <option value="<?=$oneFoodItem["id"];?>" > <?=$oneFoodItem["title"];?> </option>

        <?php endforeach;?>

        </select>
      </div>


      <!-- Enter numeric quantity field -->
      <div class="form-group">
        <label for="quantity">Quantity:</label>
        <input type="number"  name="quantity" class="form-control" id="quantity" placeholder="Quantity">
      </div>


      <!-- submit form button -->

      <button name="submitOrder" type="submit" class="btn bg-dark text-white" style="width:100%;">Submit Order</button>

    </form>
  </div>
</body>
</html>

