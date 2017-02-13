import paho.mqtt.client as mqtt
import MySQLdb

# The callback for when the client receives a CONNACK response from the server.
def on_connect(client, userdata, flags, rc):
    print("Connected with result code "+str(rc))

    # Subscribing in on_connect() means that if we lose the connection and
    # reconnect then subscriptions will be renewed.
    client.subscribe("topic/test")
    client.subscribe("topic/test1")
# The callback for when a PUBLISH message is received from the server.
def on_message(client, userdata, msg):
    #print(msg.topic+" "+str(msg.payload))
     #print(len(msg.payload))
     payload = str(msg.payload)
     payload = payload[2:len(payload)-1]
    #if str(msg.payload) == "b'end'":
     #print (msg.topic)
     #print (msg.qos)
     list = [1,2,3,4,5,6,7,8,9]
     count = iter(list)
     text = "";
     payload_list = []
     for i in range(len(payload)):
       if payload[i] == ",":
        print (next(count))
        payload_list.append(text)
        text=""
       else:
        text += payload[i]
        if i == len(payload)-1:
         payload_list.append(text)
         print("ok")
     on_database(payload_list)
     #s = msg.payload
     #s = s[2:5]
     #print (s)
    #else:
     # total = str(msg.payload)
     #print ("Continue")

# Connect Database
def on_database(payload_list):

    db = MySQLdb.connect("localhost","sitita","x]vf4ypfu","iot" )
    cursor = db.cursor()
    sql = """INSERT INTO iot_data (data_humidity,data_temp,data_mac,data_ip,data_time) VALUES(%s, %s, %s, %s, NOW())"""
    sql2 = """INSERT INTO iot_inventory (`int_mac`) SELECT * FROM (SELECT %s) AS tmp WHERE NOT EXISTS ( SELECT `int_mac` FROM iot_inventory WHERE `int_mac` = %s) LIMIT 1;"""
    #print(sql,(payload_list[0],payload_list[1],payload_list[2],payload_list[3]))
    cursor.execute(sql,(payload_list))
    cursor.execute(sql2,(payload_list[2],payload_list[2]))
    db.commit()
    db.close()

client = mqtt.Client()
client.on_connect = on_connect
client.on_message = on_message

client.username_pw_set("sitita", "password")
client.connect("localhost", 1883, 60)

# Blocking call that processes network traffic, dispatches callbacks and
# handles reconnecting.
# Other loop*() functions are available that give a threaded interface and a
# manual interface.
client.loop_forever()
