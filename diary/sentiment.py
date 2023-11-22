import pandas as pd
from textblob import TextBlob

# Load the CSV file into a Pandas DataFrame
diary = pd.read_csv('diary.csv')

# Use the TextBlob library to perform sentiment analysis on each row in the DataFrame
diary['Sentiment'] = diary['Content'].apply(lambda text: TextBlob(text).sentiment.polarity)

# Classify the sentiment as positive, negative, or neutral based on the polarity score
diary['Sentiment'] = diary['Sentiment'].apply(lambda score: 'positive' if score > 0 else 'negative' if score < 0 else 'neutral')

# Save the updated DataFrame to a CSV file
diary.to_csv('diary.csv', index=False)
