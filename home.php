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


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profile</title>

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/profile.css">

</head>
<body>
   
<div class="container">

   <div class="profile">
      <?php
         $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select) > 0){
            $fetch = mysqli_fetch_assoc($select);
         }
         if($fetch['image'] == ''){
            echo '<img src="images/default-avatar.png">';
         }else{
            echo '<img src="uploaded_img/'.$fetch['image'].'">';
         }
      ?>
      <h3><?php echo $fetch['name']; ?></h3>
      <p>Email: <?php echo $fetch['email']; ?></p>
      <p>Age: <?php echo $fetch['age']; ?></p>
      <p>Gender: <?php echo $fetch['gender']; ?></p>
      <p>Employment Status: <?php echo $fetch['employment_status']; ?></p>
      <p>Relationship Status: <?php echo $fetch['relationship_status']; ?></p>
      <a href="update_profile.php" class="btn">Update Profile</a>
      <p><a href="index1.php">Go back</a></p>
   </div>

</div>

</body>
</html>
