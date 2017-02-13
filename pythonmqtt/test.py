#!/usr/bin/python
#
# for-loop.py: Sample for loop to print welcome message 3 times
#
s = "Hello,World";
list = [1,2,3,4]
count = iter(list)
text = "";
payload_list = []
for i in range(len(s)):
  if s[i] == ",":
   print (next(count))
   payload_list.append(text)
   text=""
  else:
   text += s[i]
   if i == len(s)-1:
    payload_list.append(text)
    print("ok")
print (payload_list[1])
