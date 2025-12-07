<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/phpmailer/Exception.php';
require __DIR__ . '/phpmailer/PHPMailer.php';
require __DIR__ . '/phpmailer/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname   = $_POST['fname'];
    $lname   = $_POST['lname'];
    $email   = $_POST['email'];
    $phone   = $_POST['phone'];
    $message = $_POST['message'];

    // File upload
    $targetDir = "uploads/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    $fileName = basename($_FILES["resume"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["resume"]["tmp_name"], $targetFilePath)) {
        $mail = new PHPMailer(true);
        try {
            // SMTP Settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // or smtp.hostinger.com
            $mail->SMTPAuth = true;
            $mail->Username = 'gokul5257kk@gmail.com'; // replace
            $mail->Password = 'Kavi7871288'; // use app password for Gmail
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Email setup
            $mail->setFrom($email, $fname . " " . $lname);
            $mail->addAddress('gokul5257kk@gmail.com'); // replace with your email
            $mail->Subject = "New Job Application - $fname $lname";
            $mail->Body = "Name: $fname $lname\nEmail: $email\nPhone: $phone\nMessage: $message";

            // Attach resume
            $mail->addAttachment($targetFilePath);

            $mail->send();
            echo "Application submitted successfully!";
        } catch (Exception $e) {
            echo "Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "File upload failed.";
    }
}
?>
