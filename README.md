# Depression-and-anxiety-calculation-based-on-PHP-and-GAD
Depression and anxiety calculation based on PHP and GAD and other ML techniques


This code snippet demonstrates the use of linear regression for predicting the next PHQ-9 (Patient Health Questionnaire-9) and GAD-7 (Generalized Anxiety Disorder-7) scores for a user. Let's break down the code and explain its functionality:

1.Importing Libraries:
The necessary libraries are imported, including mysql.connector, csv, warnings, pandas, numpy, and various modules from the sklearn library for machine learning.

2.PHQ-9 Severity Level Mapping:
A helper function called get_phq_severity is defined, which maps a PHQ-9 score to its corresponding severity level. The function takes a score as input and returns a severity level based on specific score ranges.

3.Database Connection:
A connection is established to a MySQL database using the mysql.connector library. The connection parameters include the host, database name, username, and password.

4.Retrieving User Information:
The code retrieves the name of the user from the user_form table in the database based on the provided user_id.

5.Loading and Filtering the Dataset:
A CSV file named 'scores.csv' is loaded into a pandas DataFrame called dataset.
The dataset is filtered based on the retrieved username to obtain the user's specific data.
The last 7 entries of the user's dataset are extracted into a new DataFrame called user_dataset_last_7.

6.Feature Extraction and Target Variable:
The relevant features (such as score, gender, age, employment status, and relationship status) are extracted from the user_dataset_last_7 DataFrame.
The target variable (PHQ-9 score) is also extracted.

7.Data Preprocessing:
Categorical features are converted into numerical values using one-hot encoding with pd.get_dummies() function.
The feature names are stored in a list called feature_names.

8.Train-Test Split:
The dataset is split into training and testing sets using the train_test_split() function from sklearn.model_selection.
The testing set size is set to 20% of the data, and a random seed is used for reproducibility.
Linear Regression Model Initialization and Training:

An instance of the Linear Regression model is created using LinearRegression() from sklearn.linear_model.
The model is trained on the training data using the fit() method.

9.Prediction:
The next PHQ-9 score is predicted using the test set's last entry (X_test.iloc[-1:]) and the trained model's predict() method.
The predicted score is rounded to the nearest integer.

10.Actual Score and Severity Level:
The actual next PHQ-9 score is retrieved from the test set (y_test.iloc[-1]).
The predicted score is mapped to a severity level using the get_phq_severity() function.

11.Result Printing:
The predicted next PHQ-9 score, severity level, and actual score are printed.
The prediction accuracy is calculated using the root mean squared error (RMSE) between the predicted and actual scores and printed.

12.Storing Predicted Data:
The predicted score, username, and severity level are stored in a new DataFrame called predicted_data.
The predicted_data DataFrame is saved as a CSV file named 'predicted_phq_score.csv'.

13.Storing Predicted Data:
The predicted score, username, and severity level are stored in a new DataFrame called predicted_data.
The predicted_data DataFrame is saved as a CSV file named 'predicted_phq_score.csv'.

14.Similar Steps for GAD-7 Score Prediction:
The same set of steps (4-13) is repeated for GAD-7 score prediction using a different CSV file named 'gad_scores.csv'.
The GAD-7 score prediction results are printed and stored in a CSV file named 'predicted_gad_score.csv'.


Sentiment Analysis code:

Importing Libraries:
The necessary libraries are imported, including pandas and TextBlob.
pandas is a popular data manipulation library, and TextBlob is a library used for natural language processing tasks like sentiment analysis.

Loading the CSV File:
The code loads a CSV file named 'diary.csv' into a Pandas DataFrame called diary.

Sentiment Analysis using TextBlob:
TextBlob is a powerful library that provides a simple API for common natural language processing tasks. In this code, TextBlob is used to perform sentiment analysis on the text content of each row in the DataFrame.
The apply() function is used to iterate over each row's 'Content' column in the diary DataFrame.
For each row, the lambda function lambda text: TextBlob(text).sentiment.polarity is applied to calculate the polarity score (ranging from -1 to 1) using the sentiment.polarity property of the TextBlob object. The polarity score represents the sentiment or emotional tone of the text.

Classifying Sentiment:
After calculating the polarity score for each row, the next step is to classify the sentiment as positive, negative, or neutral based on the polarity score.
The apply() function is used again, this time on the 'Sentiment' column of the diary DataFrame.
For each score, the lambda function lambda score: 'positive' if score > 0 else 'negative' if score < 0 else 'neutral' is applied to classify the sentiment as 'positive' if the score is greater than 0, 'negative' if the score is less than 0, and 'neutral' if the score is exactly 0.

Updating the DataFrame and Saving to CSV:
The 'Sentiment' column in the diary DataFrame is updated with the classified sentiment values.
The updated DataFrame is then saved to the same CSV file ('diary.csv') using the to_csv() function with the index=False parameter to exclude the index column from the saved file.

In summary, this code performs sentiment analysis on the text content of each row in the 'diary.csv' file using the TextBlob library. It calculates the polarity score to determine the sentiment (positive, negative, or neutral) of each entry and updates the DataFrame accordingly. Finally, the updated DataFrame is saved back to the CSV file. This sentiment analysis can help analyze the overall sentiment of the diary entries and gain insights into the writer's emotions or attitudes.



