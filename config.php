<?php
session_start();

require_once 'vendor/autoload.php';

$client = new Google_Client();
$client->setClientId('226081691807-5u81jacfeqe47a0jfohthlmtq2q7r4ni.apps.googleusercontent.com');
$client->setClientSecret('CLIENT_SECRET');
$client->setRedirectUri('http://localhost/google-auth-app/callback.php');
$client->addScope("email");
$client->addScope("profile");

// Database connection
$conn = new mysqli("localhost", "root", "", "google_auth");
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
} 
?>
