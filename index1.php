<?php
session_start();
$user_id = $_SESSION['user_id'];

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Mental Health Assessment</title>
   
   <!-- CSS styles -->
   <style>
      /* Navigation bar styles */
      nav {
         display: flex;
         justify-content: space-between;
         align-items: center;
         background-color: #333;
         padding: 10px;
         color: #fff;
      }
      nav a {
         color: #fff;
         text-decoration: none;
         margin: 0 10px;
      }
      nav a:hover {
         text-decoration: underline;
      }

      /* Custom styles */
      body {
   margin: 0;
   font-family: Arial, sans-serif;
   font-size: 16px;
   background-image: url('images/Mind-Matters-blog-banner.jpg');
   background-repeat: no-repeat;
   background-size: cover;
   background-position: center;
   color: #333;
}
      .center {
         display: flex;
         flex-direction: column;
         justify-content: center;
         align-items: center;
         min-height: calc(100vh - 60px);
         padding: 20px;
         text-align: center;
      }
      h1 {
         font-size: 3em;
         margin-top: 0;
      }
      p {
         font-size: 1.2em;
         margin-bottom: 20px;
      }
      button {
         padding: 10px 20px;
         border: none;
         background-color: #333;
         color: #fff;
         font-size: 1.2em;
         border-radius: 5px;
         cursor: pointer;
         transition: background-color 0.2s;
      }
      button:hover {
         background-color: #444;
      }
      /* Dropdown styles */
      .dropdown {
         position: relative;
         display: inline-block;
      }
      .dropdown-content {
         display: none;
         position: absolute;
         z-index: 1;
      }
      .dropdown:hover .dropdown-content {
         display: block;
      }
      .dropdown-content a {
         color: #333;
         padding: 12px 16px;
         text-decoration: none;
         display: block;
      }
      .dropdown-content a:hover {
         background-color: #f1f1f1;
      }
      /* Dropdown options styles */
      .dropdown-content {
         background-color: #fff;
         min-width: 160px;
         box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
         border-radius: 5px;
      }
      .dropdown-content a {
         color: #333;
         padding: 12px 16px;
         text-decoration: none;
         display: block;
      }
      .dropdown-content a:hover {
         background-color: #f1f1f1;
      }
      * {box-sizing: border-box}
body {font-family: Verdana, sans-serif; margin:0}

/* Slideshow container */
.slideshow-container {
  position: relative;
  background: #f1f1f1f1;
}

/* Slides */
.mySlides {
  display: none;
  padding: 80px;
  text-align: center;
}

/* Next & previous buttons */
.prev, .next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  margin-top: -30px;
  padding: 16px;
  color: #888;
  font-weight: bold;
  font-size: 20px;
  border-radius: 0 3px 3px 0;
  user-select: none;
}

/* Position the "next button" to the right */
.next {
  position: absolute;
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover, .next:hover {
  background-color: rgba(0,0,0,0.8);
  color: white;
}

/* The dot/bullet/indicator container */
.dot-container {
    text-align: center;
    padding: 20px;
    background: #ddd;
}

/* The dots/bullets/indicators */
.dot {
  cursor: pointer;
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

/* Add a background color to the active dot/circle */
.active, .dot:hover {
  background-color: #717171;
}

/* Add an italic font style to all quotes */
q {font-style: italic;}

/* Add a blue color to the author */
.author {color: cornflowerblue;}
</style>
</head>
<body>
   <!-- Navigation bar -->
   <nav>
      <h3>Mental Health Assessment</h3>
      <div>
         <div class="dropdown">
            <a href="#">Activities</a>
            <div class="dropdown-content">
               <a href="http://localhost/Login/meditation/meditation.html">Meditation</a>
               <a href="game.html">Games</a>
               <a href="http://localhost/Login/yoga/yoa.html">Yoga</a>
            </div>
         </div>
         <div class="dropdown">
            <a href="#">Menu</a>
            <div class="dropdown-content">
               <a href="home.php">Profile</a>
               <a href="http://localhost/Login/diary/diary.php">Dairy</a>
               <a href="http://localhost/Login/discussion/discussion.php">Discussion</a>
               <a href="http://localhost/Login/questions/doctor.html">Doctor Info</a>
            </div>
         </div>
         <a href="http://localhost/Login/questions/progress.php">View Report</a>
         <a href="index.php?logout=<?php echo $user_id; ?>">Logout</a>
      </div>
   </nav>
   
   <!-- Center content -->
   <div class="center">
      <h1></h1>
      <button onclick="window.open('assessment.php')">Take Assessment</button>
   </div>
<footer>
<div class="slideshow-container">

<div class="mySlides">
  <q>"You don’t have to control your thoughts. You just have to stop letting them control you." </q>
  <p class="author">— Dan Millman</p>
</div>


<div class="mySlides">
  <q>"There is a crack in everything, that’s how the light gets in." </q>
  <p class="author">― Leonard Cohen</p>
</div>

<div class="mySlides">
  <q>"Deep breathing is our nervous system’s love language."</q>
  <p class="author"> — Dr. Lauren Fogel Mersy</p>
</div>

<div class="mySlides">
  <q>"I think it’s really important to take the stigma away from mental health… My brain and my heart are really important to me. I don’t know why I wouldn’t seek help to have those things be as healthy as my teeth."</q>
  <p class="author"> —Kerry Washington</p>
</div>

<div class="mySlides">
  <q>"It is not the bruises on the body that hurt. It is the wounds of the heart and the scars on the mind."</q>
  <p class="author"> — Aisha Mirza</p>
</div>
<div class="mySlides">
  <q>"Mental health…is not a destination, but a process. It’s about how you drive, not where you’re going."</q>
  <p class="author"> — Noam Shpancer</p>
</div>
<div class="mySlides">
  <q>"Not until we are lost do we begin to understand ourselves."</q>
  <p class="author"> ― Henry David Thoreau</p>
</div>
<div class="mySlides">
  <q>"You are not your illness. You have an individual story to tell. You have a name, a history, a personality. Staying yourself is part of the battle."</q>
  <p class="author">  — Julian Seifter</p>
</div>
<div class="mySlides">
  <q>"Happiness can be found even in the darkest of times, if one only remembers to turn on the light."</q>
  <p class="author">  — Albus Dumbledore</p>
</div>
<a class="prev" onclick="plusSlides(-1)">❮</a>
<a class="next" onclick="plusSlides(1)">❯</a>

</div>

<div class="dot-container">
  <span class="dot" onclick="currentSlide(1)"></span> 
  <span class="dot" onclick="currentSlide(2)"></span> 
  <span class="dot" onclick="currentSlide(3)"></span> 
</div>

</footer>
   <script>
var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}
</script>

</body>
</html>
