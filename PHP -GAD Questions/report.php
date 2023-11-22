<?php
error_reporting(0);
// include the config file
include_once(__DIR__ . '/../config.php');
// start the session
session_start();

// check if the user is logged in
if(!isset($_SESSION['user_id'])){
   // if not logged in, redirect to the login page
   header('location:login.php');
   exit(); // terminate script execution
}

// get the user ID from the session
$user_id = $_SESSION['user_id'];

// fetch the user's name from the database
$stmt = mysqli_prepare($conn, "SELECT name FROM `user_form` WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $username);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// define the score ranges for each level of depression and anxiety
$phq_score_ranges = array(
    array('range' => array(0, 4), 'level' => 'Minimal'),
    array('range' => array(5, 9), 'level' => 'Mild'),
    array('range' => array(10, 14), 'level' => 'Moderate'),
    array('range' => array(15, 19), 'level' => 'Moderately Severe'),
    array('range' => array(20, 27), 'level' => 'Severe')
);

$gad_score_ranges = array(
    array('range' => array(0, 4), 'level' => 'Minimal'),
    array('range' => array(5, 9), 'level' => 'Mild'),
    array('range' => array(10, 14), 'level' => 'Moderate'),
    array('range' => array(15, 21), 'level' => 'Severe')
);

// function to calculate the level of depression and anxiety based on the scores
function calculateLevel($score, $score_ranges) {
    foreach ($score_ranges as $score_range) {
        if ($score >= $score_range['range'][0] && $score <= $score_range['range'][1]) {
            return $score_range['level'];
        }
    }
}

// open the scores.csv file for reading
$scores_file = 'scores.csv';
if (file_exists($scores_file) && ($handle = fopen($scores_file, "r")) !== FALSE) {
    $phq_score_first = '';
    $phq_score_last = '';
    try {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // check if the username matches
            if ($data[1] == $username) {
                $phq_scores[] = $data;
                if (empty($phq_score_first)) {
                    $phq_score_first = $data[2];
                }
                $phq_score_last = $data[2];
            }
        }
    } catch (Exception $e) {
        echo 'Error reading PHQ scores file: '.$e->getMessage();
    }
    fclose($handle);
    // calculate the level of depression based on the first and last score
    $phq_level_first = calculateLevel($phq_score_first, $phq_score_ranges);
    $phq_level_last = calculateLevel($phq_score_last, $phq_score_ranges);
}

// open the gad_scores.csv file for reading
$gad_scores_file = 'gad_scores.csv';
if (file_exists($gad_scores_file) && ($handle = fopen($gad_scores_file, "r")) !== FALSE) {
    $gad_score_first = '';
$gad_score_last = '';
try {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        // check if the username matches
        if ($data[1] == $username) {
            $gad_scores[] = $data;
            if (empty($gad_score_first)) {
                $gad_score_first = $data[2];
            }
            $gad_score_last = $data[2];
        }
    }
} catch (Exception $e) {
    echo 'Error reading GAD scores file: '.$e->getMessage();
}
fclose($handle);
// calculate the level of anxiety based on the first and last score
$gad_level_first = calculateLevel($gad_score_first, $gad_score_ranges);
$gad_level_last = calculateLevel($gad_score_last, $gad_score_ranges);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        h1 {
            color: #333;
            font-size: 36px;
            margin-bottom: 20px;
        }
        h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }
        p {
            color: #666;
            font-size: 18px;
            line-height: 1.5;
            margin-bottom: 10px;
        }
        a {
            color: #333;
            text-decoration: none;
            font-weight: bold;
            border-bottom: 2px solid #333;
            padding-bottom: 2px;
        }
        a:hover {
            border-bottom-color: #666;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome <?php echo $username; ?></h1>
        <h2>Your PHQ-9 scores</h2>
    <?php if (empty($phq_scores)) { ?>
        <p>You have not taken the PHQ-9 questionnaire yet.</p>
    <?php } else { ?>
        <p>Your first PHQ-9 score was <?php echo $phq_score_first; ?>, which was in the <?php echo $phq_level_first; ?> range.</p>
        <p>Your latest PHQ-9 score is <?php echo $phq_score_last; ?>, which is in the <?php echo $phq_level_last; ?> range.</p>
    <?php } ?>
    <h2>Your GAD-7 scores</h2>
    <?php if (empty($gad_scores)) { ?>
        <p>You have not taken the GAD-7 questionnaire yet.</p>
    <?php } else { ?>
        <p>Your first GAD-7 score was <?php echo $gad_score_first; ?>, which was in the <?php echo $gad_level_first; ?> range.</p>
        <p>Your latest GAD-7 score is <?php echo $gad_score_last; ?>, which is in the <?php echo $gad_level_last; ?> range.</p>
    <?php } ?>
    <p><a href="progress.php">Go back</a></p>
</body>
</html>
   
