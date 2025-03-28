<?php
/*
Name: 			Contact Form
Written by: 	Okler Themes - (http://www.okler.net)
Theme Version:	10.2.0
*/

namespace PortoContactForm;

session_cache_limiter('nocache');
header('Expires: ' . gmdate('r', 0));

header('Content-type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'php-mailer/src/PHPMailer.php';
require 'php-mailer/src/SMTP.php';
require 'php-mailer/src/Exception.php';

// Step 1 - Enter your email address below.
$email = 'hello@decoramostulocal.com';

// If the e-mail is not working, change the debug option to 2 | $debug = 2;
$debug = 0;

// If contact form doesn't have the subject input change the value of subject here
$subject = ( isset($_POST['subject']) ) ? $_POST['subject'] : 'Contacto de ' . $_POST['name'] . ' desde decoramostulocal.com';

$message = '';

foreach($_POST as $label => $value) {
	// Use the code below to change label texts

	if( $label == 'name' ) {               
		$label = 'Nombre';              
	}

	if( $label == 'phone' ) {               
		$label = 'Teléfono';              
	}

	if( $label == 'email' ) {               
		$label = 'Email';              
	}

	if( $label == 'subject' ) {               
		$label = 'Asunto';              
	}

	if( $label == 'address' ) {		
		$label = 'Dirección';              
	}

	if( $label == 'service' && empty($value) ) {
        continue;
    }

	if( $label == 'service' ) {               
		$label = 'Servicio';              
	}

	if( $label == 'width' && empty($value) ) {
        continue;
    }

	if( $label == 'width' ) {		
		$label = 'Ancho';              
	}

	if( $label == 'height' && empty($value) ) {
        continue;
    }

	if( $label == 'height' ) {		
		$label = 'Alto';              
	}

	if( $label == 'budget' ) {               
		$label = 'Presupuesto estimado';              
	}

	if( $label == 'date' ) {               
		$label = 'Fecha';              
	}

	if( $label == 'message' ) {               
		$label = 'Mensaje';              
	}

	if( $label == 'privacy-policy' ) {               
		$label = 'Política de privacidad';              
	}

	// Checkboxes
	if( is_array($value) ) {
		// Store new value
		$value = implode(', ', $value);
	}

	$message .= $label.": " . nl2br(htmlspecialchars($value, ENT_QUOTES)) . "<br>";
}

$mail = new PHPMailer(true);

try {

	$mail->SMTPDebug = $debug;                                 // Debug Mode

	// Step 2 (Optional) - If you don't receive the email, try to configure the parameters below:

	//$mail->IsSMTP();                                         // Set mailer to use SMTP
	//$mail->Host = 'mail.yourserver.com';				       // Specify main and backup server
	//$mail->SMTPAuth = true;                                  // Enable SMTP authentication
	//$mail->Username = 'user@example.com';                    // SMTP username
	//$mail->Password = 'secret';                              // SMTP password
	//$mail->SMTPSecure = 'tls';                               // Enable encryption, 'ssl' also accepted
	//$mail->Port = 587;   								       // TCP port to connect to

	$mail->AddAddress($email);	 						       // Add another recipient

	//$mail->AddAddress('person2@domain.com', 'Person 2');     // Add a secondary recipient
	//$mail->AddCC('person3@domain.com', 'Person 3');          // Add a "Cc" address. 
	//$mail->AddBCC('person4@domain.com', 'Person 4');         // Add a "Bcc" address. 

	// From - Name
	$fromName = ( isset($_POST['name']) ) ? $_POST['name'] : 'Usuario de la web';
	$mail->SetFrom($email, $fromName);

	// Reply To
	if( isset($_POST['email']) && !empty($_POST['email']) ) {
		$mail->AddReplyTo($_POST['email'], $fromName);
	}

	$mail->IsHTML(true);                                       // Set email format to HTML

	$mail->CharSet = 'UTF-8';

	$mail->Subject = $subject;
	$mail->Body    = $message;

	// Step 3 - If you don't want to attach any files, remove that code below
	// if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
	// 	$mail->AddAttachment($_FILES['attachment']['tmp_name'], $_FILES['attachment']['name']);
	// }

	$mail->Send();
	$arrResult = array ('response'=>'success');

} catch (Exception $e) {
	$arrResult = array ('response'=>'error','errorMessage'=>$e->errorMessage());
} catch (\Exception $e) {
	$arrResult = array ('response'=>'error','errorMessage'=>$e->getMessage());
}

if ($debug == 0) {
	echo json_encode($arrResult);
}