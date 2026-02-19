<?php
require_once 'config.php';

if (isset($_GET['code'])) {

    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    $google_service = new Google_Service_Oauth2($client);
    $data = $google_service->userinfo->get();

    $google_id = $data->id;
    $name = $data->name;
    $email = $data->email;
    $picture = $data->picture;

    // Check if user exists
    $check = $conn->prepare("SELECT * FROM users WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (google_id, name, email, profile_pic) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $google_id, $name, $email, $picture);
        $stmt->execute();
        $_SESSION['user_id'] = $stmt->insert_id;
    }

    header("Location: dashboard.php");
    exit();
}
