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
            $mail->Username = 'lovestudio.trichy@gmail.com'; // replace
            $mail->Password = 'Lovestudiolalgudi999.'; // use app password for Gmail
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Email setup
            $mail->setFrom($email, $fname . " " . $lname);
            $mail->addAddress('lovestudio.trichy@gmail.com'); // replace with your email
            $mail->Subject = "New Job Application - $fname $lname";
            $mail->Body = "Name: $fname $lname\nEmail: $email\nPhone: $phone\nMessage: $message";

            // Attach resume
            $mail->addAttachment($targetFilePath);

            $mail->send();
            echo "
            <html>
            <head>
              <title>Booking Successful</title>
              <style>
                body { font-family: Arial, sans-serif; background:#f7f7f7; margin:0; padding:0; }
                .container { max-width:600px; margin:80px auto; background:#fff; padding:40px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1); text-align:center; }
                h2 { color:#28a745; }
                p { font-size:16px; color:#333; }
                a { display:inline-block; margin-top:20px; padding:10px 20px; background:#007bff; color:#fff; text-decoration:none; border-radius:6px; }
                a:hover { background:#0056b3; }
              </style>
            </head>
            <body>
              <div class='container'>
                <h2>✅ Thank you, {$name}!</h2>
                <p>Your booking request has been sent successfully.<br>We will contact you shortly.</p>
                <a href='book-us-now.html'>Go Back</a>
              </div>
            </body>
            </html>";
        } catch (Exception $e) {
            echo "
            <html>
            <head>
              <title>Booking Failed</title>
              <style>
                body { font-family: Arial, sans-serif; background:#f7f7f7; margin:0; padding:0; }
                .container { max-width:600px; margin:80px auto; background:#fff; padding:40px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1); text-align:center; }
                h2 { color:#dc3545; }
                p { font-size:16px; color:#333; }
                a { display:inline-block; margin-top:20px; padding:10px 20px; background:#007bff; color:#fff; text-decoration:none; border-radius:6px; }
                a:hover { background:#0056b3; }
              </style>
            </head>
            <body>
              <div class='container'>
                <h2>❌ Oops! Something went wrong</h2>
                <p>We couldn’t send your booking right now.<br>Please try again later.</p>
                <a href='book-us-now.html'>Go Back</a>
              </div>
            </body>
            </html>";
        }
    } else {

        echo "
    <html>
    <head>
      <title>Booking Failed</title>
      <style>
        body { font-family: Arial, sans-serif; background:#f7f7f7; margin:0; padding:0; }
        .container { max-width:600px; margin:80px auto; background:#fff; padding:40px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1); text-align:center; }
        h2 { color:#dc3545; }
        p { font-size:16px; color:#333; }
        a { display:inline-block; margin-top:20px; padding:10px 20px; background:#007bff; color:#fff; text-decoration:none; border-radius:6px; }
        a:hover { background:#0056b3; }
      </style>
    </head>
    <body>
      <div class='container'>
        <h2>❌ Oops! File upload failed.</h2>
        <p>We couldn’t send your booking right now.<br>Please try again later.</p>
        <a href='book-us-now.html'>Go Back</a>
      </div>
    </body>
    </html>";
    }
}
