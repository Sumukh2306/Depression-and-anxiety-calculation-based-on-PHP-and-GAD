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

// get the user ID and name from the session
$user_id = $_SESSION['user_id'];

// fetch the user's name from the database
$stmt = mysqli_prepare($conn, "SELECT name FROM `user_form` WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $name_from_db);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Diary Sentiment Analysis</title>
    <style>
      table {
        border-collapse: collapse;
        width: 100%;
      }
      th, td {
        text-align: left;
        padding: 8px;
        border-bottom: 1px solid #ddd;
      }
      th {
        background-color: #f2f2f2;
      }
      tr:hover {
        background-color: #f5f5f5;
      }
      canvas {
        max-width: 800px;
        margin: 0 auto;
      }
    </style>
  </head>
  <body>
    <?php
    // read diary data from csv file
    $diary_data = array(); // to store diary data
    if (($handle = fopen("diary.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $diary_data[] = $data;
        }
        fclose($handle);
    }

    // display diary entries for the fetched name
    echo "<h1>Diary Sentiment Analysis</h1>";
    if ($name_from_db) { // if the name was fetched successfully
        $matching_rows = array_filter($diary_data, function ($row) use ($name_from_db) {
            return $row[0] == $name_from_db;
        });
        // display matching rows
        if (!empty($matching_rows)) {
            echo "<table>";
            echo "<tr><th>Name</th><th>Date</th><th>Content</th><th>Sentiment</th></tr>";
            $sentiment_counts = array(); // to store sentiment counts
            foreach ($matching_rows as $row) {
                // display each row
                echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td></tr>";
                // count the sentiment
                if (isset($sentiment_counts[$row[3]])) {
                    $sentiment_counts[$row[3]]++;
                } else {
                    $sentiment_counts[$row[3]] = 1;
                }
            }
            echo "</table>";
            // display pie chart
            echo "<canvas id='sentiment-chart'></canvas>";
            echo "<script src='https://cdn.jsdelivr.net/npm/chart.js'></script>";
            echo "<script>";
            echo "var ctx = document.getElementById('sentiment-chart').getContext('2d');";
            echo "var chart = new Chart(ctx, {";
            echo "type: 'pie',";
            echo "data: {";
              echo "labels: [";
              foreach ($sentiment_counts as $sentiment => $count) {
              echo "'".$sentiment."',";
              }
              echo "],";
              echo "datasets: [{";
              echo "data: [";
              foreach ($sentiment_counts as $sentiment => $count) {
              echo $count.",";
              }
              echo "],";
              echo "backgroundColor: [";
              // generate random colors for each slice of the pie chart
              for ($i=0; $i<count($sentiment_counts); $i++) {
              echo "'rgb(".rand(0, 255).",".rand(0, 255).",".rand(0, 255).")',";
              }
              echo "],";
              echo "borderWidth: 1";
              echo "}]";
              echo "},";
              echo "options: {";
              echo "responsive: false,";
              echo "title: {";
              echo "display: true,";
              echo "text: 'Sentiment Analysis for ".$name_from_db."'";
              echo "}";
              echo "}";
              echo "});";
              echo "</script>";
              } else {
              echo "<p>No diary entries found for ".$name_from_db.".</p>";
              }
              } else {
              echo "<p>Error: Failed to fetch name from database.</p>";
              }
              ?>
              
                </body>
              </html>
