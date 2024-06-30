from korean_lunar_calendar import KoreanLunarCalendar

calendar = KoreanLunarCalendar()

# params : year(년), month(월), day(일)
calendar.setSolarDate(2024, 5, 14)

# Lunar Date (ISO Format)
print(calendar.LunarIsoFormat())

# Korean GapJa String
print(calendar.getGapJaString())

# Chinese GapJa String
print(calendar.getChineseGapJaString())
