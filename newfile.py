import pandas as pd
import datetime


import csv
f = open('/home/tanuj/Downloads/Sorted Connection Histories/ConnectionList(1-50Meters).csv')
csv_f = csv.reader(f)
set1 = {}
temp =0
for row in csv_f:
    if row[3] == "Connected":
         day = int(row[2][0:2])
         month = int(row[2][3:5])
         year = int(row[2][6:10])
         a = datetime.datetime(year, month, day)
         if temp == 1:
             diff_calendar_days = pd.date_range(a, b)
             diff_calendar_days = diff_calendar_days[1:-1]
             if row[1] in set1:
                 temp_list = []
                 temp_list = set1[(row[1])]
                 set1[(row[1])] = temp_list.append(diff_calendar_days)
                 temp =0
             else:
                set1[(row[1])] = diff_calendar_days
                temp=0
             
    if row[3] == "Disconnected":
         day = int(row[2][0:2])
         month = int(row[2][3:5])
         year = int(row[2][6:10])
         b = datetime.datetime(year, month, day)
         temp =1 
print(set1)