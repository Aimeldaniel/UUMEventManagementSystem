<?php
// Include PHPMailer library
require 'phpmailer/PHPMailerAutoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user's email from the form
    $email = $_POST['email'];

    // Generate a random temporary password (you can customize this)
    $tempPassword = bin2hex(random_bytes(8)); // 16-character random password

    // Hash the temporary password before storing it in the database
    $hashedPassword = password_hash($tempPassword, PASSWORD_DEFAULT);

    // Update the user's password in the database
    $servername = "localhost"; // Replace with your database server name
    $username = "your_username"; // Replace with your database username
    $password = "your_password"; // Replace with your database password
    $dbname = "eventapprovalsystem"; // Replace with your database name

    // Create a connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update the user's password with the temporary password
    $sql = "UPDATE users SET password = '$hashedPassword' WHERE email = '$email'";

    if ($conn->query($sql) === TRUE) {
        // Password updated successfully, now send an email with the temporary password
        $mail = new PHPMailer;

        // Configure email server settings
        $mail->isSMTP();
        $mail->Host = 'your_email_server.com'; // Replace with your email server
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'your_email@example.com'; // Replace with your email address
        $mail->Password = 'your_email_password'; // Replace with your email password
        $mail->setFrom('your_email@example.com', 'Your Name'); // Replace with your name and email
        $mail->addAddress($email); // Recipient email address

        // Email subject and message
        $mail->Subject = 'Password Reset';
        $mail->Body = 'Your temporary password is: ' . $tempPassword;

        if ($mail->send()) {
            // Email sent successfully
            echo "Password reset instructions sent to your email.";
        } else {
            // Email sending failed
            echo "Error sending password reset instructions: " . $mail->ErrorInfo;
        }
    } else {
        echo "Error updating password: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
