import pandas as pd
import json
from sklearn.metrics.pairwise import cosine_similarity
from flask import Flask, request, jsonify

if __name__ == "__main__":
    app = Flask(__name__)

    df = pd.read_json('./data2.json')

    store_item_matrix = df.pivot_table(
        index='tienda_id',
        columns='sku_id',
        values='cantidad_venta',
        aggfunc='sum'
    )

    store_item_matrix = store_item_matrix.apply(pd.to_numeric, errors='coerce')
    store_item_matrix = store_item_matrix.applymap(lambda x: 1 if x > 0 else 0)

    user_user_sim_matrix = pd.DataFrame(cosine_similarity(store_item_matrix))

    user_user_sim_matrix['tienda_id'] = store_item_matrix.index
    user_user_sim_matrix = user_user_sim_matrix.set_index('tienda_id')
    user_user_sim_matrix.columns = user_user_sim_matrix.index

    @app.route('/similarity/<int:cliente_a>', methods=['GET'])
    def get_user_user_similarity(cliente_a):
        try:
            similitudes = user_user_sim_matrix.loc[cliente_a].sort_values(ascending=False)

            similares = pd.DataFrame(similitudes)
            similares = similitudes.reset_index()
            similares.rename(columns={similares.columns[0]: "tiendas"}, inplace=True)
            similares.rename(columns={similares.columns[1]: "similitud"}, inplace=True)
            resultado_list = [{"tienda": k, "similitud": v} for k, v in zip(similares["tiendas"].astype(str), similares["similitud"])]
            return jsonify(resultado_list)
        except Exception as e:
            error_message = str(e)
            return jsonify({"error": error_message}), 500  

    @app.route('/recommendations', methods=['GET'])
    def get_recommendations():
        try:
            cliente_a = int(request.args.get('cliente_a'))
            cliente_b = int(request.args.get('cliente_b'))
            
            items_bought_by_A = set(store_item_matrix.loc[cliente_a].iloc[store_item_matrix.loc[cliente_a].to_numpy().nonzero()].index)
            items_bought_by_B = set(store_item_matrix.loc[cliente_b].iloc[store_item_matrix.loc[cliente_b].to_numpy().nonzero()].index)

            items_to_recommend_to_A = items_bought_by_B - items_bought_by_A

            resultado = df.loc[df['sku_id'].isin(items_to_recommend_to_A), ['sku_id', 'sku_nom']].drop_duplicates().set_index('sku_id')
            recomendaciones = resultado.reset_index()
            resultado_list = [{"sku_id": k, "sku_nom": v} for k, v in zip(recomendaciones["sku_id"].astype(str), recomendaciones["sku_nom"])]
            return jsonify(resultado_list)
        except Exception as e:
            error_message = str(e)
            return jsonify({"error": error_message}), 500  

    app.run(host='0.0.0.0', port=5000, debug=True)
