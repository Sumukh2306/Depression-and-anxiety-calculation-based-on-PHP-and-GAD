<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(isset($_POST['update_profile'])){

   $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
   $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
   $update_age = mysqli_real_escape_string($conn, $_POST['update_age']);
   $update_gender = mysqli_real_escape_string($conn, $_POST['update_gender']);

   mysqli_query($conn, "UPDATE `user_form` SET name = '$update_name', email = '$update_email', age = '$update_age', gender = '$update_gender' WHERE id = '$user_id'") or die('query failed');

   $old_pass = $_POST['old_pass'];
   $update_pass = mysqli_real_escape_string($conn, md5($_POST['update_pass']));
   $new_pass = mysqli_real_escape_string($conn, md5($_POST['new_pass']));

   if(!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)){
      if($update_pass != $old_pass){
         $message[] = 'old password not matched!';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'confirm password not matched!';
      }else{
         mysqli_query($conn, "UPDATE `user_form` SET password = '$confirm_pass' WHERE id = '$user_id'") or die('query failed');
         $message[] = 'password updated successfully!';
      }
   }

   $update_image = $_FILES['update_image']['name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_folder = 'uploaded_img/'.$update_image;

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image is too large';
      }else{
         $image_update_query = mysqli_query($conn, "UPDATE `user_form` SET image = '$update_image' WHERE id = '$user_id'") or die('query failed');
         if($image_update_query){
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
         }
         $message[] = 'image updated succssfully!';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update profile</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/update.css">

</head>
<body>
   
<div class="update-profile">

   <?php
      $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select) > 0){
         $fetch = mysqli_fetch_assoc($select);
      }
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      <?php
         if($fetch['image'] == ''){
            echo '<img src="images/default-avatar.png">';
         }
         else{
            echo '<img src="uploaded_img/'.$fetch['image'].'">';
         }
      ?>
      <div class="form-group">
         <label for="update_image">Update Profile Image</label>
         <input type="file" name="update_image" id="update_image">
      </div>
      <div class="form-group">
         <label for="update_name">Name</label>
         <input type="text" name="update_name" id="update_name" value="<?php echo $fetch['name']; ?>">
      </div>
      <div class="form-group">
         <label for="update_email">Email</label>
         <input type="email" name="update_email" id="update_email" value="<?php echo $fetch['email']; ?>">
      </div>
      <div class="form-group">
         <label for="update_age">Age</label>
         <input type="number" name="update_age" id="update_age" value="<?php echo $fetch['age']; ?>">
      </div>
      <div class="form-group">
         <label for="update_gender">Gender</label>
         <select name="update_gender" id="update_gender">
            <option value="Male" <?php if($fetch['gender'] == 'Male'){echo 'selected';} ?>>Male</option>
            <option value="Female" <?php if($fetch['gender'] == 'Female'){echo 'selected';} ?>>Female</option>
         </select>
      </div>
      <div class="form-group">
         <label for="old_pass">Old Password</label>
         <input type="password" name="old_pass" id="old_pass">
      </div>
      <div class="form-group">
         <label for="update_pass">New Password</label>
         <input type="password" name="update_pass" id="update_pass">
      </div>
      <div class="form-group">
         <label for="new_pass">Confirm Password</label>
         <input type="password" name="new_pass" id="new_pass">
      </div>
      <div class="form-group">
      <input type="submit" value="update profile" name="update_profile" class="btn">
      <a href="home.php" class="delete-btn">go back</a>
      </div>
      <?php
         if(isset($message)){
            foreach($message as $msg){
               echo '<div class="error">'.$msg.'</div>';
            }
         }
      ?>
    