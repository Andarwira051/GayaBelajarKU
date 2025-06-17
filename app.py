from flask import Flask, request, jsonify
import numpy as np
import pickle
import pandas as pd

app = Flask(__name__)

# Load model Decision Tree
with open('model.pkl', 'rb') as file:
    model = pickle.load(file)

# Nama fitur yang digunakan dalam model
feature_names = ["Amount Visual", "Amount Auditorial", "Amount Kinestetik", "Average Per Study Style"]

def convert_output(label_array):
    labels = ["Visual", "Auditorial", "Kinestetik"]
    indices = [i for i, value in enumerate(label_array) if value == 1]
    return " dan ".join([labels[i] for i in indices]) if indices else "Tidak Diketahui"

@app.route('/predict', methods=['POST'])
def predict():
    data = request.json  # Data dari Laravel

    # Ambil nilai langsung dari request
    score_visual = data['visual']
    score_auditorial = data['auditory']
    score_kinestetik = data['kinesthetic']
    apss = data['average']


    # Format data untuk model
    df_input = pd.DataFrame([[score_visual, score_auditorial, score_kinestetik, apss]],columns=feature_names)

    # **🛠 Debugging: Cek data sebelum masuk ke model**
    print("Data yang dikirim ke model:")
    print(df_input)

    # Prediksi gaya belajar
    prediksi = model.predict(df_input)
    output_label = convert_output(prediksi[0])

    # **🛠 Debugging: Cek output mentah model**
    print("Model Output (Raw):", prediksi[0])
    print("Label Prediksi:", output_label)

    return jsonify({'prediction': output_label})

if __name__ == '__main__':
    app.run(host="0.0.0.0", port=5000, debug=True)
