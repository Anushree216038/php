<?php
// Validate form inputs
if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_FILES['profile_picture']['name'])) {
    die('Error: All fields are required.');
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    die('Error: Invalid email format.');
}

// Upload profile picture
$uploads_dir = 'uploads/';
$profile_picture_name = uniqid() . '_' . $_FILES['profile_picture']['name'];
$profile_picture_tmp_name = $_FILES['profile_picture']['tmp_name'];
move_uploaded_file($profile_picture_tmp_name, $uploads_dir . $profile_picture_name);

// Save user data to CSV file
$user_data = [
    $_POST['name'],
    $_POST['email'],
    $profile_picture_name,
    date('Y-m-d H:i:s')
];
$file = fopen('users.csv', 'a');
fputcsv($file, $user_data);
fclose($file);

// Set cookie and start session
session_start();
setcookie('name', $_POST['name']);

// Redirect to success page
header('Location: success.html');
exit;
?>
