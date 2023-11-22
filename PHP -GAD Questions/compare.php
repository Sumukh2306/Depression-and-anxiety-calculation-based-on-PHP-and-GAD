<!DOCTYPE html>
<html>
<head>
    <title>User Scores</title>
    <style>
        /* Style for the body */
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            margin: 0;
        }

        /* Style for the container */
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        /* Style for the table */
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            margin-bottom: 40px;
        }

        /* Style for the table header */
        th {
            background-color: #4CAF50;
            color: #fff;
            font-weight: bold;
            text-align: left;
            padding: 12px;
            border: 1px solid #ccc;
        }

        /* Style for the table rows */
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Style for the table data */
        td {
            padding: 12px;
            border: 1px solid #ccc;
        }

        /* Style for the table data links */
        td a {
            color: #0070c0;
            text-decoration: none;
        }

        /* Style for the table data links on hover */
        td a:hover {
            text-decoration: underline;
        }

        /* Style for the table data score cells */
        .score {
            font-weight: bold;
            color: #008000;
        }

        /* Style for the table data username cells */
        .username {
            font-weight: bold;
        }

        /* Style for the table data rank cells */
        .rank {
            font-weight: bold;
            color: #a9a9a9;
        }

        /* Style for the table data date cells */
        .date {
            font-style: italic;
            color: #a9a9a9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Scores</h1>
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

// get the user ID and name from the session
$user_id = $_SESSION['user_id'];

// fetch the user's name from the database
$stmt = mysqli_prepare($conn, "SELECT name FROM `user_form` WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $name_from_db);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// read the scores from the scores.csv file
$scores = [];
if (($handle = fopen("scores.csv", "r")) !== false) {
    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
        if ($data[1] == $name_from_db) {
            $scores[] = $data[2];
        }
    }
    fclose($handle);
}

if ($scores) {
    $actual_score = end($scores);
    // read the predicted score from the predicted_phq_score.csv file
    $predicted_score_file = file("predicted_phq_score.csv");
    $predicted_score = end($predicted_score_file);
    // check if the name in the predicted_phq_score.csv file matches the name in the scores.csv file
    $predicted_score_arr = str_getcsv($predicted_score);
    if ($predicted_score_arr[0] == $name_from_db) {
        $predicted_score_value = $predicted_score_arr[1];
        // display the actual score and predicted score
        echo "PHQ Scores Comaprision for $name_from_db:<br>";
        echo "Actual PHQ Score : $actual_score<br>";
        echo "Predicted PHQ Score : $predicted_score_value<br><br>";
    } else {
        echo "Error: Name in predicted_phq_score.csv does not match name in scores.csv";
    }
} else {
    echo "No scores found for $name_from_db";
}

$scores = [];
if (($handle = fopen("gad_scores.csv", "r")) !== false) {
    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
        if ($data[1] == $name_from_db) {
            $scores[] = $data[2];
        }
    }
    fclose($handle);
}

if ($scores) {
    $actual_score = end($scores);
    // read the predicted score from the predicted_phq_score.csv file
    $predicted_score_file = file("predicted_gad_score.csv");
    $predicted_score = end($predicted_score_file);
    // check if the name in the predicted_phq_score.csv file matches the name in the scores.csv file
    $predicted_score_arr = str_getcsv($predicted_score);
    if ($predicted_score_arr[0] == $name_from_db) {
        $predicted_score_value = $predicted_score_arr[1];
        // display the actual score and predicted score
        echo "GAD Scores Comaprision for $name_from_db:<br>";
        echo "Actual GAD Score : $actual_score<br>";
        echo "Predicted GAD Score : $predicted_score_value<br><br>";
    } else {
        echo "Error: Name in predicted_phq_score.csv does not match name in scores.csv";
    }
} else {
    echo "No scores found for $name_from_db";
}

?>
    </div>
</body>
</html>
