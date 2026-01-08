<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = filter_var(trim($_POST['subject']), FILTER_SANITIZE_STRING);
    $message = trim($_POST['message']);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    // Check for empty fields
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        die("All fields are required");
    }

    // Prepare email
    $mailTo = "leezabethyomi@gmail.com";
    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    $emailBody = "You have received a new message from your portfolio contact form.\n\n";
    $emailBody .= "Name: " . $name . "\n";
    $emailBody .= "Email: " . $email . "\n";
    $emailBody .= "Subject: " . $subject . "\n\n";
    $emailBody .= "Message:\n" . $message . "\n";

    // Send email
    if (mail($mailTo, $subject, $emailBody, $headers)) {
        header("Location: ../index.html?mailsent");
        exit();
    } else {
        echo "Failed to send email. Please try again.";
    }
} else {
    die("Invalid request method");
}
?>
