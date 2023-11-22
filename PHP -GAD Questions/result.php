<?php
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
    $phq_scores = array();
    try {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // check if the date in the file matches the current date and the username matches
            if (date("Y-m-d", strtotime($data[0])) == date("Y-m-d") && $data[1] == $username) {
                $phq_scores[] = $data;
            }
        }
    } catch (Exception $e) {
        echo 'Error reading PHQ scores file: '.$e->getMessage();
    }
    fclose($handle);
}

// open the gad_scores.csv file for reading
$gad_scores_file = 'gad_scores.csv';
if (file_exists($gad_scores_file) && ($handle = fopen($gad_scores_file, "r")) !== FALSE) {
$gad_scores = array();
try {
while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
// check if the date in the file matches the current date and the username matches
if (date("Y-m-d", strtotime($data[0])) == date("Y-m-d") && $data[1] == $username) {
$gad_scores[] = $data;
}
}
} catch (Exception $e) {
echo 'Error reading GAD scores file: '.$e->getMessage();
}
fclose($handle);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Mood Tracker</title>
    <link rel="stylesheet" type="text/css" href="CSS/result.css">

</head>
<body>
    <h1>Welcome, <?php echo $username; ?>!</h1>
    <h2>Today's Scores</h2>
    <table>
        <tr>
            <th>Questionnaire</th>
            <th>Score</th>
            <th>Level</th>
        </tr>
        <tr>
            <td>PHQ-9</td>
            <?php if (empty($phq_scores)): ?>
                <td>No score recorded for today</td>
                <td>N/A</td>
            <?php else: ?>
                <?php $phq_score = end($phq_scores)[2]; ?>
                <td><?php echo $phq_score; ?></td>
                <td><?php echo calculateLevel($phq_score, $phq_score_ranges); ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <td>GAD-7</td>
            <?php if (empty($gad_scores)): ?>
                <td>No score recorded for today</td>
                <td>N/A</td>
            <?php else: ?>
                <?php $gad_score = end($gad_scores)[2]; ?>
                <td><?php echo $gad_score; ?></td>
                <td><?php echo calculateLevel($gad_score, $gad_score_ranges); ?></td>
            <?php endif; ?>
        </tr>
    </table>
    <br>
    <a href="http://localhost/Login/assessment.php">Go Back</a>
    <h2> For Recommendations</h2>
	<p>Choose the severity level given below:</p>
	<select onchange="location = this.value;">
		<option value="">Select severity level</option>
		<option value="mild.html">Mild</option>
		<option value="moderate.html">Moderate</option>
		<option value="severe.html">Severe</option>
	</select>
</body>
</html>
