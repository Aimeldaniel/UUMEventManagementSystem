<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $name = $_POST['full_name'];
    $phone = $_POST['phone_number'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing the password
    $user_type = $_POST['user_type_signup'];
    $department = isset($_POST['department']) ? $_POST['department'] : '';

    $sql = "INSERT INTO users (full_name, phone_number, email, password, user_type, department)
    VALUES ('$name', '$phone', '$email', '$password', '$user_type', '$department')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        // Redirect to login page or wherever you want
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
