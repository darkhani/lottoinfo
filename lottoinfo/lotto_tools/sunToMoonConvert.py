from lunardate import LunarDate

# 양력 날짜 데이터를 읽어들임
input_file = "sundata.txt"
output_file = "stm_query.sql"

# 양력 날짜 파일 읽기
with open(input_file, 'r', encoding='utf-8') as file:
    solar_dates = file.readlines()

# 양력 날짜를 음력 날짜로 변환하는 함수
def convert_solar_to_lunar(solar_date):
    year, month, day = map(int, solar_date.strip().split('-'))
    lunar_date = LunarDate.fromSolarDate(year, month, day)
    return f"{lunar_date.year}-{lunar_date.month:02d}-{lunar_date.day:02d}"

# SQL 쿼리 생성
sql_statements = []
for solar_date in solar_dates:
    solar_date = solar_date.strip()
    lunar_date = convert_solar_to_lunar(solar_date)
    sql_statements.append(f"UPDATE lottery SET fmdate = '{lunar_date}' WHERE fdate = '{solar_date}';")

# SQL 쿼리를 파일로 저장
with open(output_file, 'w', encoding='utf-8') as file:
    file.write('\n'.join(sql_statements))

print(f"SQL 쿼리가 {output_file}에 저장되었습니다.")

