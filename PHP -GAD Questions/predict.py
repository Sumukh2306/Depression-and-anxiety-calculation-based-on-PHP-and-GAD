import mysql.connector
import csv
import warnings
from mysql.connector import Error
import pandas as pd
import numpy as np
from sklearn.model_selection import train_test_split
from sklearn.linear_model import LinearRegression
from sklearn.metrics import mean_squared_error

# Suppress warning messages
warnings.filterwarnings("ignore")

# PHQ-9 Severity Level Mapping
def get_phq_severity(score):
    if score < 5:
        return "Minimal severity level"
    elif score < 10:
        return "Mild severity level"
    elif score < 15:
        return "Moderate severity level"
    else:
        return "Severe level"
    
# establish a database connection
try:
    conn = mysql.connector.connect(
        host='localhost',
        database='project',
        user='root',
        password=''
    )
    if conn.is_connected():
        user_id = 4  # define the user_id here

        # retrieve the name from the user_form table based on the user_id
        stmt = conn.cursor()
        stmt.execute("SELECT name FROM user_form WHERE id = %s", (user_id,))
        username = stmt.fetchone()[0]
        stmt.close()
        # Load the dataset from the CSV file
        dataset = pd.read_csv('scores.csv')

        # Filter the dataset based on the username
        user_dataset = dataset[dataset['Name'] == username]
        # Retrieve the last 7 entries from the dataset
        user_dataset_last_7 = user_dataset.tail(7)
        # Extract the relevant features and target variable
        features = user_dataset_last_7[['Score', 'Gender', 'Age', 'Employment Status', 'Relation Status']]
        target = user_dataset_last_7['Score']

        # Convert categorical features into numerical using one-hot encoding
        features_encoded = pd.get_dummies(features)

        # Retrieve the feature names after one-hot encoding
        feature_names = features_encoded.columns.tolist()

        # Split the data into train and test sets
        X_train, X_test, y_train, y_test = train_test_split(features_encoded, target, test_size=0.2, random_state=42)

        # Initialize the Linear Regression model
        model = LinearRegression()

        # Fit the model on the training data
        model.fit(X_train, y_train)

        # Predict the next PHQ-9 score using the test set
        next_score = model.predict(X_test.iloc[-1:].values)

        # Convert the predicted score to an integer value
        next_score = int(np.round(next_score[0]))

        # Get the actual next score from the dataset
        actual_score = y_test.iloc[-1]
        # Map the predicted score to severity level
        predicted_severity = get_phq_severity(next_score)
        
        print(f"Predicted next PHQ score for {username} is:", next_score,predicted_severity)
        print("Actual Next PHQ-9 Score:", actual_score)

        # Calculate the prediction accuracy (RMSE)
        rmse = np.sqrt(mean_squared_error([actual_score], [next_score]))
        print("Prediction Accuracy (RMSE):", rmse)

        # Store the predicted score, username, and severity level in a CSV file
        predicted_data = pd.DataFrame({'Username': [username], 'Predicted_PHQ_Score': [next_score], 'Severity_Level': [predicted_severity]})
        predicted_data.to_csv('predicted_phq_score.csv', index=False)
        
        
        
        dataset = pd.read_csv('gad_scores.csv')
        # Filter the dataset based on the username
        user_dataset = dataset[dataset['Name'] == username]
        # Retrieve the last 7 entries from the dataset
        user_dataset_last_7 = user_dataset.tail(7)
        # Extract the relevant features and target variable
        features = user_dataset_last_7[['Score', 'Gender', 'Age', 'Employment Status', 'Relation Status']]
        target = user_dataset_last_7['Score']

        # Convert categorical features into numerical using one-hot encoding
        features_encoded = pd.get_dummies(features)

        # Retrieve the feature names after one-hot encoding
        feature_names = features_encoded.columns.tolist()

        # Split the data into train and test sets
        X_train, X_test, y_train, y_test = train_test_split(features_encoded, target, test_size=0.2, random_state=42)

        # Initialize the Linear Regression model
        model = LinearRegression()

        # Fit the model on the training data
        model.fit(X_train, y_train)

        # Predict the next PHQ-9 score using the test set
        next_score = model.predict(X_test.iloc[-1:].values)

        # Convert the predicted score to an integer value
        next_score = int(np.round(next_score[0]))

        # Get the actual next score from the dataset
        actual_score = y_test.iloc[-1]
        
        # Map the predicted score to severity level
        predicted_severity = get_phq_severity(next_score)
        
        print(f"Predicted next GAD score for {username} is:", next_score,predicted_severity)
        print("Actual Next GAD-7 Score:", actual_score)

        # Calculate the prediction accuracy (RMSE)
        rmse = np.sqrt(mean_squared_error([actual_score], [next_score]))
        print("Prediction Accuracy of GAD(RMSE):", rmse)

        # Store the predicted score, username, and severity level in a CSV file
        predicted_data = pd.DataFrame({'Username': [username], 'Predicted_GAD_Score': [next_score], 'Severity_Level': [predicted_severity]})
        predicted_data.to_csv('predicted_gad_score.csv', index=False)

except Error as e:
    print("Error connecting to the database:", str(e))
