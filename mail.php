<?php
//PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

//PHPMailer
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();                                      
    $mail->Host       = 'smtp.gmail.com';               
    $mail->SMTPAuth   = true;                            
    $mail->Username   = 'mail@gmail.com';         
    $mail->Password   = 'password';                
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;                             

    // Sender
    $mail->setFrom('mail@gmail.com', 'Sender'); 
    $mail->addAddress('example@mail.com', 'Reciever'); 

    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
        $mail->addAttachment($_FILES['attachment']['tmp_name'], $_FILES['attachment']['name']); // Вложение
    }

    
    $mail->isHTML(true);                                  
    $mail->Subject = $_POST['subject'];
    $mail->Body    = $_POST['body'];
    $mail->AltBody = strip_tags($_POST['body']);

    
    $mail->send();
    echo 'The email was successfully sent';
} catch (Exception $e) {
    echo "Error when sending an e-mail: {$mail->ErrorInfo}";
}
?>
