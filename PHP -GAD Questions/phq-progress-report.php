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

?>
<!DOCTYPE html>
<html>
  <head>
    <title>PHQ Progress Report</title>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  </head>
  <body>
    <h1>PHQ Progress Report</h1>
    <?php
      // Open the CSV file for reading
      $file = fopen('scores.csv', 'r');
      // Create an array to store the score data
  $scores = array();

  // Loop through the CSV data and add the score data to the array
  while (($data = fgetcsv($file)) !== FALSE) {
    // check if the fetched name matches the name in the second column
    if ($data[1] === $name_from_db) {
      // Get the date and score
      $date = $data[0];
      $score = intval($data[2]);

      // Add the score to the array
      $scores[$date] = $score;
    }
  }

  // Close the CSV file
  fclose($file);

  // Create an array to store the chart data
  $chart_data = array(
    'labels' => array(),
    'data' => array()
  );

  // Loop through the score data and add it to the chart data array
  foreach ($scores as $date => $score) {
    $chart_data['labels'][] = $date;
    $chart_data['data'][] = $score;
  }

  // Create a new Chart.js line chart
  echo '<canvas id="chart"></canvas>';
  echo '<script>';
  echo 'var ctx = document.getElementById("chart").getContext("2d");';
  echo 'var chart = new Chart(ctx, {';
  echo 'type: "line",';
  echo 'data: {';
  echo 'labels: '.json_encode($chart_data['labels']).',';
  echo 'datasets: [{';
  echo 'label: "PHQ Score",';
  echo 'data: '.json_encode($chart_data['data']).',';
  echo 'borderColor: "rgba(255, 99, 132, 1)",';
  echo 'backgroundColor: "rgba(255, 99, 132, 0.2)"';
  echo '}]';
  echo '},';
  echo 'options: {';
  echo 'scales: {';
  echo 'yAxes: [{';
  echo 'ticks: {';
  echo 'beginAtZero: true';
  echo '}';
  echo '}]';
  echo '}';
  echo '}';
  echo '});';
  echo '</script>';
  ?>
  <h2>Welcome,</h2>
  <p>Below is your PHQ-9 score progress over time:</p>
  <table>
  <thead>
  <tr>
  <th>Date</th>
  <th>Score</th>
  </tr>
  </thead>
  <tbody>
  <?php
         // Loop through the score data and display it in the table
         foreach ($scores as $date => $score) {
           echo '<tr>';
           echo '<td>' . $date . '</td>';
           echo '<td>' . $score . '</td>';
           echo '</tr>';
         }
       ?>
  </tbody>
  </table>
    </body>
  </html> 