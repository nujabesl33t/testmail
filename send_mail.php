<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Подключаем PHPMailer
require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем сообщение из формы
    $message = htmlspecialchars(trim($_POST['message']));
    
    // Проверяем, что сообщение не пустое
    if (!empty($message)) {
        // Настраиваем PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Настройки SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // SMTP сервер (например, smtp.gmail.com)
            $mail->SMTPAuth = true;
            $mail->Username = 'mailtecninco@gmail.com'; // Ваш SMTP логин (например, ваш email)
            $mail->Password = 'Tecninco77!'; // Ваш SMTP пароль
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Шифрование
            $mail->Port = 587; // Порт

            // Настройка отправителя и получателя
            $mail->setFrom('anonymous@example.com', 'Аноним');
            $mail->addAddress('timur.kengessov@tecninco.kz'); // Email начальства

            // Тема и текст письма
            $mail->isHTML(false); // Письмо в формате текста
            $mail->Subject = 'Анонимное письмо';
            $mail->Body    = $message;

            // Проверка на наличие вложения
            if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
                $uploadfile = tempnam(sys_get_temp_dir(), sha1($_FILES['attachment']['name']));
                if (move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadfile)) {
                    $mail->addAttachment($uploadfile, $_FILES['attachment']['name']);
                } else {
                    throw new Exception('Ошибка загрузки файла.');
                }
            }

            // Отправка письма
            if ($mail->send()) {
                echo 'Письмо отправлено!';
            } else {
                echo 'Ошибка при отправке письма.';
            }

        } catch (Exception $e) {
            echo "Ошибка при отправке письма: {$mail->ErrorInfo}";
        }
    } else {
        echo "Пожалуйста, введите сообщение.";
    }
}
?>
