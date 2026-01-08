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
    $mailTo = "anuoluwapo@elizabethosunsanwo.co.uk";

    $headers = "Reply-To: " . $name . " <" . $email . ">\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    $emailBody = "You have received a message from " . $name . ".\n\n";
    $emailBody .= "Name: " . $name . "\n";
    $emailBody .= "Email: " . $email . "\n";
    $emailBody .= "Subject: " . $subject . "\n\n";
    $emailBody .= "Message:\n" . $message . "\n";

    // Send email
 
    $envelopeSender = $mailTo;
    if (mail($mailTo, $subject, $emailBody, $headers, "-f " . $envelopeSender)) {
        echo "OK"; 
    } else {
        echo "Failed to send email. Please try again.";
    }
} else {
    die("Invalid request method");
}
?>
