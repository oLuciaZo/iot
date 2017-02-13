#!/usr/bin/python3
import datetime
import MySQLdb
# Open database connection
payload_list = ["HI","aa:bb:cc:dd:ee:ff",3,4]
db = MySQLdb.connect("localhost","sitita","x]vf4ypfu","iot" )

# prepare a cursor object using cursor() method
cursor = db.cursor()
your_date = "2017-01-12 19:51:44"
# execute SQL query using execute() method.

sql = """INSERT INTO iot_inventory (`int_mac`) SELECT * FROM (SELECT %s) AS tmp WHERE NOT EXISTS ( SELECT `int_mac` FROM iot_inventory WHERE `int_mac` = %s) LIMIT 1;"""
cursor.execute(sql,(payload_list[1],payload_list[1]))

# Fetch a single row using fetchone() method.
db.commit()

# disconnect from server
db.close()
