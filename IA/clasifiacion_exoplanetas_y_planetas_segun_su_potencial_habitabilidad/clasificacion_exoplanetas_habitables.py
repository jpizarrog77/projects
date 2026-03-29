# Flask --> crea la aplicación web
# request → permite recibir datos que envía el usuario (JSON)
# jsonify → convierte la respuesta de Python en JSON, que es el formato estándar en APIs
from flask import Flask, request, jsonify
# joblib sirve para cargar objetos guardados previamente. En el caso el modelo y el escalador
import joblib
import numpy as np

# Crear aplicación Flask
app = Flask(__name__)

# Cargar modelo y escalador
model = joblib.load("modelo_exoplanetas.pkl")
scaler = joblib.load("scaler_exoplanetas.pkl")

# ENDPOINT Principal
@app.route("/") # define ruta accesible desde el navegador
def home(): # al acceder devuelve ese texto
    return "API de clasificación de habitabilidad de exoplanetas"

# Define un ENDPOINT llamado /predict que solo acepta peticiones post
    # POST --> para enviar datos al servidor
@app.route("/predict", methods=["POST"])
def predict(): # funcion que se ejecuta cuando alguien llama a /predict
    data = request.get_json() # obtiene los datos enviados por el usuario en formato json y se guardan en el diccionario data

    features = np.array([[
        data["pl_rade"],
        data["pl_bmasse"],
        data["pl_eqt"],
        data["pl_insol"],
        data["pl_orbper"],
        data["pl_volume"],
        data["pl_density"]
    ]])

    features_scaled = scaler.transform(features) # apliica el mismo escalado que se uso para el entrenamiento
    prediction = model.predict(features_scaled)[0] # el modelo hace la prediccion

    return jsonify({ # respuesta que se da al usuauario
        "habitabilidad": int(prediction),
        "resultado": "Potencialmente habitable" if prediction == 1 else "No habitable"
    })

if __name__ == "__main__":
    app.run(debug=True)
