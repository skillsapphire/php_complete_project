
<?php
header("Access-Control-Allow-Origin: *");
require('mailer/class.phpmailer.php');
require 'codeguy-Slim/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
use \Slim\Slim AS Slim;

// create new Slim instance
$app = new Slim();


$app->get("/f2", function () {
    echo "<h1>f2 service</h1>";
});

$app->post('/contactus',
function () use ($app) {
   try{
   $request = $app->request();
   $queryDetails = json_decode($request->getBody());
   $uname = $queryDetails->name;
   $email = $queryDetails->email;
   $phone = $queryDetails->phone ;
   $timeToContact = $queryDetails->timeToContact;
   $contactWay = $queryDetails->contactWay;
   $query = $queryDetails->query;

$message = "<div style='border:2px dotted red'><b>Name :</b> ".$uname." <br><b>Phone : </b>".$phone." <br><b>Email : </b>".$email."
 <br><b>Best way to contact : </b>".$contactWay. "<br><b>Best time to contact : </b>".$timeToContact." 
 <br><b>Message : </b>".$query."</div>";
//echo $message;
   try {
   $mail = new PHPMailer();
      $mail->IsSMTP();
	  $mail->SMTPAuth = true;
	  $mail->SMTPSecure = 'ssl';
	  //$mail->SMTPDebug = 1;
	  $mail->Host = 'smtp.gmail.com';
	  $mail->Port       = 465;
	  $mail->Username = 'rpmrecycling2014@gmail.com';
	  $mail->Password = 'rpmrecycling7';
	//  $mail->Username = 'alishapatel2006@gmail.com';
	//  $mail->Password = 'Alisha#154190';
	  $mail->SetFrom($email, $uname);
	  $mail->AddReplyTo($email, 'Reply to ');

	  //$mail->AddAddress('daneshmehta30@gmail.com', 'Danesh');
	  //$mail->AddAddress('itsdiggu@gmail.com', 'Digamber');
	  $mail->AddAddress('alishapatel2006@gmail.com', 'Alisha');
	  $mail->AddAddress('ranjanpandey2006@gmail.com', 'Ranjan');

	  $mail->Subject = 'Message from Arizona Systems raised by : '.$uname;
	  $mail->Body    = $message;
	  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	  if(!$mail->Send())
	  {
	  //   echo 'Message could not be sent. <p>';
	  //   echo 'Mailer Error: ' . $mail->ErrorInfo;
	     exit;
	  }

	  //echo 'Message has been sent';

	  echo true;

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
