<!DOCTYPE html>
<html>
  <head>
    <title>Progress Page</title>
    <style>
      /* Reset default styles */
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

/* Style for the body */
body {
  font-family: Arial, sans-serif;
  background-color: #f7f7f7; /* Set the background color of the body */
}

/* Style for the container */
.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

/* Style for the heading */
h1 {
  font-size: 3em;
  font-weight: bold;
  text-align: center;
  margin: 0 auto 20px;
  color: #333;
  text-shadow: 1px 1px #fff; /* Add a subtle text shadow to the heading */
}

/* Style for the subheading */
h2 {
  font-size: 1.8em;
  font-weight: bold;
  margin: 20px 0;
  color: #666;
  text-shadow: 1px 1px #fff; /* Add a subtle text shadow to the subheading */
}

/* Style for the list items */
ol {
  list-style: none;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Use CSS Grid to create a responsive grid of links */
  gap: 20px;
  padding: 0;
  margin: 0;
}

ol li {
  font-size: 1.2em;
  margin-bottom: 10px;
  background-color: #fff;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Add a subtle shadow to the list items */
  overflow: hidden; /* Hide any overflowing content */
}

/* Style for the links */
a {
  display: block;
  padding: 20px;
  color: #333;
  text-decoration: none;
  font-weight: bold;
  transition: color 0.3s ease; /* Add a smooth transition effect when the link color changes */
}

/* Style for the links when hovered */
a:hover {
  color: #999;
  text-decoration: none;
}

/* Style for the back link */
p a {
  font-size: 1.2em;
  font-weight: bold;
  text-decoration: none;
}

/* Media queries for responsive design */
@media screen and (max-width: 767px) {
  h1 {
    font-size: 2.5em;
  }
  h2 {
    font-size: 1.5em;
  }
  ol li {
    font-size: 1em;
  }
}
    </style>
  </head>
  
  <body>
    <h1>Welcome to your progress page</h1>
    <h2>Choose a Progress Report:</h2>
    <ol>
      <li>
        <a href="phq-progress-report.php">Progress Report of PHQ(Patient Health Questionnaire)</a>
      </li>
      <li>
        <a href="gad-progress-report.php">Progress Report of GAD(Generalized Anxiety Disorder)</a>
      </li>
      <li>
        <a href="http://localhost//Login/diary/sentiment.php">Diary log with sentiment analysis</a>
      </li>
      <li><a href="report.php">PHQ & GAD initial and latest score comparition</a>
      </li>
      </li>
      <li><a href="predict.php">Predict next PHQ & GAD score</a>
      </li>
      <li><a href="compare.php">Comparison between Actual score and Predicted score </a>
      </li>
    </ol>
    <p><a href="http://localhost//Login/index1.php">Go back</a></p>
  </body>
</html>