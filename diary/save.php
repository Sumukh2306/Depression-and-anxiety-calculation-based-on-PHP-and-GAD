<?php
include_once(__DIR__ . '/../config.php');
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    die('User not logged in');
}

$name = mysqli_real_escape_string($conn, $_POST['name']);
$date = mysqli_real_escape_string($conn, $_POST['date']);
$content = mysqli_real_escape_string($conn, $_POST['content']);

// Append the data to the CSV file
$file = fopen("diary.csv","a");
$data = array($name, $date, $content);
fputcsv($file, $data);
fclose($file);

echo 'Diary entry saved successfully';
?>
