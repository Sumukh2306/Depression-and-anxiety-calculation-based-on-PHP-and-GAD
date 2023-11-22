<?php
include_once(__DIR__ . '/../config.php');
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
<html>
<head>
    <title>My Daily Diary</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>My Daily Diary</h1>
    <form id="diary-form">
        <label for="date">Date:</label>
        <input type="date" name="date" required><br>

        <label for="content">Content:</label>
        <textarea name="content" rows="10" required></textarea><br>

        <input type="hidden" name="name" value="<?php echo $name; ?>">
        <input type="submit" value="Save">
    </form>
    <button><a href="predict.php">Analyze</a></button>
    <button><a href="http://localhost/Login/index1.php">Go Back</a></button>

    <script>
        function goBack() {
            window.history.back();
        }

        $(document).ready(function(){
            $('#diary-form').submit(function(event){
                event.preventDefault(); // prevent the form from submitting normally

                var form_data = $(this).serialize(); // get the form data

                $.ajax({
                    type: 'POST',
                    url: 'save.php',
                    data: form_data,
                    success: function(response){
                        alert(response); // show the response from the server
                    },
                    error: function(){
                        alert('An error occurred while saving the diary entry.'); // show an error message
                    }
                });
            });
        });
    </script>
</body>
</html>
