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





  //POST REQUEST BELOW************************

  //POST REQUEST ABOVE********************

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

