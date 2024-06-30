#판다스 설치필요
import pandas as pd
# Generate SQL update queries for the entire dataset
def generate_update_queries(df):
    queries = []
    for index, row in df.iterrows():
        query = f"""
        UPDATE lottery
        SET
            winner1 = {row['winner1']},
            amount1 = {int(row['amount1'].replace(',', ''))},
            winner2 = {row['winner2']},
            amount2 = {int(row['amount2'].replace(',', ''))},
            winner3 = {int(row['winner3'].replace(',', ''))},
            amount3 = {int(row['amount3'].replace(',', ''))},
            winner4 = {int(row['winner4'].replace(',', ''))},
            amount4 = {int(row['amount4'].replace(',', ''))},
            winner5 = {int(row['winner5'].replace(',', ''))},
            amount5 = {int(row['amount5'].replace(',', ''))}
        WHERE round = {row['round']};
        """
        print(query)
        queries.append(query.strip())
    return queries

# CSV 파일 경로
file_path = 'lotto_data_info_1108_1126.csv'

# CSV 파일을 DataFrame으로 읽기
df = pd.read_csv(file_path)

# DataFrame의 첫 몇 줄 출력
#print(df.head())

update_queries = generate_update_queries(df)

# Display all the generated update queries
update_queries[:5]  # Displaying the first 5 queries for brevity

