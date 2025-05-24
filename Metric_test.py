from surprise import Dataset
from surprise.model_selection import train_test_split
from surprise import accuracy

# Charger un jeu de données intégré
data = Dataset.load_builtin('ml-100k')  # MovieLens 100k
trainset, testset = train_test_split(data, test_size=0.25)
from surprise import SVD, KNNBasic, NMF, SlopeOne, BaselineOnly

algorithms = {
    "SVD": SVD(),
    "KNNBasic": KNNBasic(),
    "NMF": NMF(),
    "SlopeOne": SlopeOne(),
    "BaselineOnly": BaselineOnly()
}

results = {}

for name, algo in algorithms.items():
    algo.fit(trainset)
    predictions = algo.test(testset)
    rmse = accuracy.rmse(predictions, verbose=False)
    mae = accuracy.mae(predictions, verbose=False)
    results[name] = {'RMSE': rmse, 'MAE': mae}

# Afficher les résultats
import pandas as pd
pd.DataFrame(results).T

import matplotlib.pyplot as plt

df_results = pd.DataFrame(results).T
df_results.plot(kind='bar', figsize=(10, 6))
plt.title("Comparaison des algorithmes de recommandation")
plt.ylabel("Erreur")
plt.xticks(rotation=45)
plt.grid()
plt.show()

