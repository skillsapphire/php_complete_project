<?php
include 'db.php';
require 'codeguy-Slim/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
use \Slim\Slim AS Slim;
// create new Slim instance
$app = new Slim();

$app->get("/f2", function () {
    echo "<h1>f2 service</h1>";
});
$app->get('/f3/:name', function ($name) {
    echo "Hello, $name";
});
$app->post('/postJob',
function () use ($app) {
   try{
   $request = $app->request();
   $postedJob = json_decode($request->getBody());
   $experience = $postedJob->experience;
   $technology = $postedJob->technology;
   $expiry_date = $postedJob->expiry_date;
   $description = $postedJob->description;

   $sql = "INSERT INTO Jobs (`description`,`technology`,`posted_date`,`expiry_date`,`experience`)
   VALUES ('$description','$technology',CURDATE(),'$expiry_date','$experience')";
   try {
      $db = getDB();
      $stmt = $db->prepare($sql);
      $res = $stmt->execute();

      $db = null;
      $result = null;
      if ($res !=0 ) {

      	$sql = "SELECT * FROM Jobs";
      	$db = getDB();
		$stmt = $db->prepare($sql);
		$stmt->execute();
		 $jobsFetched = $stmt->fetchAll();
		 $db = null;
         $result = null;
         $result = '{"resultObj":{"jobsObj":'.json_encode($jobsFetched).',"status":"SUCCESS"}}';
      }else{
         $result = "FAILURE";
      }
      echo $result;
   } catch(PDOException $e) {
      //error_log($e->getMessage(), 3, '/var/tmp/php.log');
      echo '{"error":{"text":'. $e->getMessage() .'}}';
   }
}catch(PDOException $e) {
      //error_log($e->getMessage(), 3, '/var/tmp/php.log');
      echo '{"error":{"text":'. $e->getMessage() .'}}';
   }
});


$app->post('/fetchMenu',
function () use ($app) {
   try{

   try {

//check if the starting row variable was passed in the URL or not
if (!isset($_GET['startrow']) or !is_numeric($_GET['startrow'])) {
  //we give the value of the starting row to 0 because nothing was found in URL
  $startrow = 0;
//otherwise we take the value from the URL
} else {
  $startrow = (int)$_GET['startrow'];
}

      	$sql = "SELECT * FROM Menu LIMIT $startrow, 15";
      	$db = getDB();
		$stmt = $db->prepare($sql);
		$stmt->execute();
		 $products = $stmt->fetchAll();

		 $db = null;
         $result = null;
         $result = '{"resultObj":{"productsObj":'.json_encode($products).',"status":"SUCCESS"}}';

      echo $result;
   } catch(PDOException $e) {
      //error_log($e->getMessage(), 3, '/var/tmp/php.log');
      echo '{"error":{"text":'. $e->getMessage() .'}}';
   }
}catch(PDOException $e) {
      //error_log($e->getMessage(), 3, '/var/tmp/php.log');
      echo '{"error":{"text":'. $e->getMessage() .'}}';
   }
});



$app->post('/login',
function () use ($app) {

   try{
   $request = $app->request();
   $userRegister = json_decode($request->getBody());
   $user_email = $userRegister->user_email;
   $user_password = $userRegister->user_password;

   $sql = "SELECT * FROM user WHERE user_email='$user_email' && user_password='$user_password'";
   try {
      $db = getDB();
      $stmt = $db->prepare($sql);
      $stmt->execute();
      $stmt->bindParam("user_email", $user_email);
      $stmt->bindParam("user_password", $user_password);
     $stmt->execute();
     $userFetch = $stmt->fetchObject();
     $db = null;
     $result = null;
     if($userFetch != null){
         $result =  '{"resultObj":{"userObj":'.json_encode($userFetch).',"status":"SUCCESS"}}';
     }else{
         $result =  '{"resultObj":{"status":"FAILURE"}}';
     }
     echo $result;
   } catch(PDOException $e) {
      //error_log($e->getMessage(), 3, '/var/tmp/php.log');
      echo '{"error":{"text":'. $e->getMessage() .'}}';
   }
}catch(PDOException $e) {
      //error_log($e->getMessage(), 3, '/var/tmp/php.log');
      echo '{"error":{"text":'. $e->getMessage() .'}}';
   }
});
// run the Slim app
$app->run();
?>