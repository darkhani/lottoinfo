import pandas as pd
from lunardate import LunarDate

# 양력 날짜 데이터를 읽어들임
input_file = "/mnt/data/양력data.txt"
output_file = "/mnt/data/query.sql"

# 데이터를 DataFrame으로 변환
solar_dates = pd.read_csv(input_file, header=None, names=['solar_date'])

# 음력 날짜로 변환하는 함수
def convert_solar_to_lunar(solar_date):
    year, month, day = map(int, solar_date.split('-'))
    lunar_date = LunarDate.fromSolarDate(year, month, day)
    return f"{lunar_date.year}-{lunar_date.month:02d}-{lunar_date.day:02d}"

# DataFrame에 음력 날짜 열 추가
solar_dates['lunar_date'] = solar_dates['solar_date'].apply(convert_solar_to_lunar)

# SQL 쿼리 생성
sql_statements = []
for index, row in solar_dates.iterrows():
    solar_date = row['solar_date']
    lunar_date = row['lunar_date']
    sql_statements.append(f"UPDATE lottery SET fmdate = '{lunar_date}' WHERE fdate = '{solar_date}';")

# SQL 쿼리를 파일로 저장
with open(output_file, 'w', encoding='utf-8') as file:
    file.write('\n'.join(sql_statements))

print(f"SQL 쿼리가 {output_file}에 저장되었습니다.")

