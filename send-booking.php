<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/phpmailer/Exception.php';
require __DIR__ . '/phpmailer/PHPMailer.php';
require __DIR__ . '/phpmailer/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

// collect inputs
$name     = htmlspecialchars(trim($_POST['name'] ?? ''));
$email    = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$phone    = htmlspecialchars(trim($_POST['phone'] ?? ''));
$city     = htmlspecialchars(trim($_POST['city'] ?? ''));
$event    = htmlspecialchars(trim($_POST['event'] ?? ''));
$date     = htmlspecialchars(trim($_POST['date'] ?? ''));
$time     = htmlspecialchars(trim($_POST['time'] ?? ''));
$location = htmlspecialchars(trim($_POST['location'] ?? ''));
$venue    = htmlspecialchars(trim($_POST['venue'] ?? ''));
$crowd    = htmlspecialchars(trim($_POST['crowd'] ?? ''));
$details  = htmlspecialchars(trim($_POST['details'] ?? ''));

$mail = new PHPMailer(true);

try {
    // Gmail SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'gokul5257kk@gmail.com';        // your Gmail
    $mail->Password   = 'Kavi7871288';       // Gmail App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // From must be your Gmail
    $mail->setFrom('gokul5257kk@gmail.com', 'KMo Infotech Bookings');
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mail->addReplyTo($email, $name);
    }

    // Receiver
    $mail->addAddress('gokul5257kk@gmail.com');
    $mail->Subject = "New Booking: {$name} — {$event} on {$date}";

    // Body
    $body  = "Booking Details:\n\n";
    $body .= "Name: {$name}\n";
    $body .= "Email: {$email}\n";
    $body .= "Phone: {$phone}\n";
    $body .= "City: {$city}\n";
    $body .= "Event: {$event}\n";
    $body .= "Date: {$date}\n";
    $body .= "Time: {$time}\n";
    $body .= "Location: {$location}\n";
    $body .= "Venue: {$venue}\n";
    $body .= "Crowd Strength: {$crowd}\n\n";
    $body .= "Details:\n{$details}\n";

    $mail->Body = $body;
    $mail->send();

    // ✅ Success Page
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

  var_dump($e);
  exit();
    // ❌ Error Page
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
?>