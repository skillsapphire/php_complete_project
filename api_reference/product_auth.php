<?php
include 'db.php';
require 'codeguy-Slim/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
use \Slim\Slim AS Slim;
// create new Slim instance
$app = new Slim();

$app->get("/f2", function () {
    echo "<h1>f2 product service</h1>";
});
$app->get('/f3/:name', function ($name) {
    echo "Hello, $name";
});

$app->post('/register',
function () use ($app) {
   try{
   $request = $app->request();
   $user = json_decode($request->getBody());
   $username = $user->username;
   $email = $user->email;
   $password = $user->password;
   $name = $user->name;

   $sql = "INSERT INTO login (`name`,`email`,`username`,`password`)
   VALUES ('$name','$email','$username','$password')";
   try {
      $db = getDB();
      $stmt = $db->prepare($sql);
      $res = $stmt->execute();

      $db = null;
      $result = null;
      if ($res !=0 ) {
         $result = '{"resultObj":{"userObj":'.json_encode($res).',"status":"SUCCESS"}}';
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

$app->post('/login',
function () use ($app) {

   try{
	$request = $app->request();
	$user = json_decode($request->getBody());

   try {
		$db = getDB();
		$username = $user->username;
		$password=md5($user->password);
		$sql ="SELECT id, username,password FROM login WHERE username=:username and password=:password";
		$query= $db -> prepare($sql);
		$query-> bindParam(':username', $username, PDO::PARAM_STR);
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