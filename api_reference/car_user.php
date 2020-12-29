<?php
include 'car_db.php';
require 'codeguy-Slim/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
use \Slim\Slim AS Slim;
// create new Slim instance
$app = new Slim();

$app->get("/f2", function () {
    echo "<h1>f2 car service</h1>";
});
$app->get('/f3/:name', function ($name) {
    echo "Hello, $name";
});

$app->post('/userlogin',
function () use ($app) {

   try{
	$request = $app->request();
	$user = json_decode($request->getBody());

   try {
		$db = getDB();
		$email = $user->user_email;
		$password=md5($user->user_password);
		$sql ="SELECT id, UserName,Password FROM admin WHERE UserName=:email and Password=:password";
		$query= $db -> prepare($sql);
		$query-> bindParam(':email', $email, PDO::PARAM_STR);
		$query-> bindParam(':password', $password, PDO::PARAM_STR);
		$query-> execute();
		$results=$query->fetchAll(PDO::FETCH_OBJ);
     if($results != null){
         $result =  '{"resultObj":{"userObj":'.json_encode($results).',"status":"SUCCESS"}}';
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