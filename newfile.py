#!/usr/bin/env python2
# -*- coding: utf-8 -*-


from os import listdir
from os.path import isfile, join
onlyfiles = [f for f in listdir('/home/abhi/Downloads/Sorted Connection Histories') if isfile(join('/home/tanuj/Downloads/Sorted Connection Histories', f))]
for f in onlyfiles:
    str = '/home/abhi/Downloads/Sorted Connection Histories/' + f
    
    f = open(str)
    csv_f = csv.reader(f)
    
    
    set1 = {}
    temp =0
    for row in csv_f:
        if row[3] == "Connected":
             day = int(row[2][0:2])
             month = int(row[2][3:5])
             year = int(row[2][6:10])
             a = datetime.datetime(year, month, day)
             if temp != row[1] and temp != 0 :
                 temp = 0
                 
            
             if temp == row[1]:
                 diff_calendar_days = pd.date_range(b, a)
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
            if temp == 0:
                 day = int(row[2][0:2])
                 month = int(row[2][3:5])
                 year = int(row[2][6:10])
                 b = datetime.datetime(year, month, day)
                 temp = row[1]
                    
    print(set1)
         
     

   