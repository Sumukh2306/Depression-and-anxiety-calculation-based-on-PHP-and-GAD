<?php

include_once(__DIR__ . '/../config.php');
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   if (basename($_SERVER['PHP_SELF']) != 'register.php') {
      header('location:login.php');
   } else {
      header('location:register.php');
   }
}

$select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
if (mysqli_num_rows($select) > 0) {
   $fetch = mysqli_fetch_assoc($select);
   $name = $fetch['name'];
   $employment_status = $fetch['employment_status'];
   $age = $fetch['age'];
   $gender = $fetch['gender'];
   $relationship_status = $fetch['relationship_status'];
}

// get the current date
$date = date('Y-m-d');

// get the values of all questions from the form
$q1 = $_POST['q1'];
$q2 = $_POST['q2'];
$q3 = $_POST['q3'];
$q4 = $_POST['q4'];
$q5 = $_POST['q5'];
$q6 = $_POST['q6'];
$q7 = $_POST['q7'];
$q8 = $_POST['q8'];
$q9 = $_POST['q9'];

// calculate the total score
$total_score = $q1 + $q2 + $q3 + $q4 + $q5 + $q6 + $q7 + $q8 + $q9;

// open the CSV file for writing
$file = 'scores.csv';
$handle = fopen($file, 'a');

// write the new score, name, date, age, gender, employment status, and relationship status to the CSV file
$data = array($date, $name, $total_score, $age, $gender, $employment_status, $relationship_status);
fputcsv($handle, $data);

// close the CSV file
fclose($handle);

// redirect to assessment.php
header("Location: http://localhost//Login/assessment.php");
exit;
?>
