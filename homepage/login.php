<?php
session_start();
    
$username = $_POST['username'];
$password = $_POST['password'];

$conn = new mysqli('localhost', 'root','','laundry_db');
if($conn->connect_error){
    die('Failed to connect : '.$conn->connect_error);
} else {
    //stmt means statement
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt_result = $stmt->get_result();

    if($stmt_result->num_rows > 0) {
        $data = $stmt_result->fetch_assoc();

       //if more than 1 ang rows use while loop instead of if-else
        if($data['password'] === $password){
            $_SESSION['user_role'] = $data['user_status'];
            $_SESSION['username'] = $data['username']; 
            header('location: /laundry_system/dashboard/dashboard.php'); 
        } else {
            echo "<script>alert('Invalid Username or Password')</script>";
        }
    }else {
        echo "<script>alert('Invalid Username or Password')</script>";
        }
    }
?>