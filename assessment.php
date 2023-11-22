<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   if (strpos($_SERVER['REQUEST_URI'], 'register.php') === false) {
      header('location:login.php');
   } else {
      header('location:register.php');
   }
}

$select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
if(mysqli_num_rows($select) > 0){
    $fetch = mysqli_fetch_assoc($select);
    $name = $fetch['name'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Assessment</title>
  <link rel="stylesheet" href="css/style5.css">
</head>
<body>
  <header>
    <h1>Mental Health Assessment for <?php echo $name; ?></h1>
  </header>
  <main>
    <h2>Instructions</h2>
    <p>Please read the following instructions carefully:</p>
    <ol>
      <li>Answer all questions to the best of your ability.</li>
      <li>Take the following assessments: (a.for depression/b.for anxiety)</li>
      <ol type="a">
        <li><a href="questions/phq-9.html">PATIENT HEALTH QUESTIONNAIRE (PHQ-9)</a></li>
        <li><a href="questions/gad-7.html">GENERALISED ANXIETY DISORDER QUESTIONNAIRE (GAD-7)</a></li>
      </ol>
    </ol>
    <h3><a href="http://localhost//Login/questions/result.php">View Results</a></h3>
    <p><a href="javascript:window.close();">Go back</a></p>
  </main>
</body>
</html>
