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

$app->get("/products/:userid", function ($userid) {
    try{
    
       try {
            $db = getDB();
            $sql ="SELECT * FROM products WHERE login_id=?";
            $query= $db -> prepare($sql);
            $query-> bindParam(1, $userid, PDO::PARAM_INT);

            $query-> execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
         if($results != null){
             $result =  '{"resultObj":{"products":'.json_encode($results).',"status":"SUCCESS"}}';
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