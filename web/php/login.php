<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    $sql = "SELECT id, password FROM users WHERE email = '$email' AND user_type = '$user_type'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $row['id'];
            // Redirect based on user type
            if ($user_type == 'admin') {
                header("Location: admin_page.php");
            } else {
                header("Location: user_page.php");
            }
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "No user found";
    }
    $conn->close();
}
?>
