<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $age = mysqli_real_escape_string($conn, $_POST['age']);
   $gender = mysqli_real_escape_string($conn, $_POST['gender']);
   $employmentStatus = mysqli_real_escape_string($conn, $_POST['employment_status']);
   $relationshipStatus = mysqli_real_escape_string($conn, $_POST['relationship_status']);
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $message[] = 'user already exist'; 
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }elseif($image_size > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $insert = mysqli_query($conn, "INSERT INTO `user_form` (name, email, password, age, gender, employment_status, relationship_status, image) VALUES ('$name', '$email', '$pass', '$age', '$gender', '$employmentStatus', '$relationshipStatus', '$image')") or die('query failed');

         if($insert){
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'registered successfully!';
            header('location:index1.php');
         }else{
            $message[] = 'registeration failed!';
         }
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
   <title>register</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/register.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>register now</h3>
      <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
      <input type="text" name="name" placeholder="enter username" class="box" required>
      <input type="email" name="email" placeholder="enter email" class="box" required>
      <input type="password" name="password" placeholder="enter password" class="box" required>
      <input type="password" name="cpassword" placeholder="confirm password" class="box" required>
      <input type="number" name="age" placeholder="enter age" class="box" required>
      <select name="gender" class="box" required>
         <option value="">Select Gender</option>
         <option value="Male">Male</option>
         <option value="Female">Female</option>
         <option value="Other">Other</option>
      </select>
      <select name="employment_status" id="employment_status" class="box" required>
         <option value="">Select Employment Status</option>
         <option value="employed">Employed</option>
         <option value="unemployed">Unemployed</option>
         <option value="self_employed">Self-employed</option>
         <!-- Add more options as needed -->
      </select>
      <select name="relationship_status" id="relationship_status" class="box" required>
         <option value="">Select Relationship Status</option>
         <option value="single">Single</option>
         <option value="married">Married</option>
         <option value="divorced">Divorced</option>
         <!-- Add more options as needed -->
      </select>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png" required>
      <input type="submit" name="submit" value="register" class="btn">
   </form>
</div>
</body>
</html>
