<?php
// PHPMailer SMTP contact form for Ionos

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require_once __DIR__ . '/../.smtp_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = filter_var(trim($_POST['subject']), FILTER_SANITIZE_STRING);
    $message = trim($_POST['message']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        die("All fields are required");
    }

    $mail = new PHPMailer(true);
    try {
        // SMTP config
        $mail->isSMTP();
        $mail->Host = 'smtp.ionos.co.uk';
        $mail->SMTPAuth = true;
        $mail->Username = 'anuoluwapo@elizabethosunsanwo.co.uk';
        // Store SMTP password in an environment variable for security
        $mail->Password = $smtp_password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;


        // Sender/recipient
        $mail->setFrom('anuoluwapo@elizabethosunsanwo.co.uk', 'Portfolio Contact');
        $mail->addAddress('anuoluwapo@elizabethosunsanwo.co.uk');
        $mail->addReplyTo($email, $name);

        // Content
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = "Portfolio contact form submission.\n\n"
            . "Name: $name\n"
            . "Email: $email\n"
            . "Subject: $subject\n\n"
            . "Message:\n$message\n";

        $mail->send();
        echo "OK";
    } catch (Exception $e) {
        echo "Failed to send email. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    die("Invalid request method");
}
?>
