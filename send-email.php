<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ✅ Make sure these files exist:
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// 🧠 This is where PHPMailer is used correctly:
$mail = new PHPMailer(true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'imdigitalankush@gmail.com';
        $mail->Password   = 'ofxttdwscfbielbl'; // Your App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Form data
        $name     = strip_tags(trim($_POST["name"]));
        $email    = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $number   = strip_tags(trim($_POST["number"]));
        $service  = strip_tags(trim($_POST["service"]));
        $message  = strip_tags(trim($_POST["message"]));

        // Email content
        $mail->setFrom('imdigitalankush@gmail.com', 'Sleek Print Website');
        $mail->addAddress('imdigitalankush@gmail.com');
        $mail->isHTML(true);
        $mail->Subject = "New Quote Request with File - Sleek Print";
        $mail->Body = "
            <h2>New Inquiry</h2>
            <p><strong>Name:</strong> {$name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Phone:</strong> {$number}</p>
            <p><strong>Service:</strong> {$service}</p>
            <p><strong>Message:</strong><br>{$message}</p>
        ";

        // 📎 File upload (optional)
        if (!empty($_FILES['upload']['tmp_name'])) {
            $mail->addAttachment($_FILES['upload']['tmp_name'], $_FILES['upload']['name']);
        }

        $mail->send();
        echo "<script>alert('✅ Message sent successfully!'); window.history.back();</script>";

    } catch (Exception $e) {
        echo "<script>alert('❌ Mail Error: {$mail->ErrorInfo}'); window.history.back();</script>";
    }
} else {
    header("Location: index.html");
    exit;
}
?>
