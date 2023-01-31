import re

str = '2015 IEEE 27th International Conference on Tools with Artificial, 1-13'
str = str.replace('-','')
str = str.replace(',','')
words = str.split(" ")
str2 = ''
for word in words:
    if not word.isnumeric() :
        if str2 == '':
            str2 = word
        else:
            str2 = str2 + ' ' + word
print(str2)

str2 = re.sub(r'[\d,-]+', '', str)
print(str2)