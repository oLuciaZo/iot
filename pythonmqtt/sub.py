#!/usr/bin/env python3

import paho.mqtt.client as mqtt
import datetime

# This is the Subscriber

def on_connect(client, userdata, flags, rc):
  print("Connected with result code "+str(rc))
  client.subscribe("topic/test")

#def on_message(client, userdata, msg):
#  if msg.payload.decode() == "Hello world!":
#    print("Yes!")
#    client.disconnect()
def on_message(client, userdata, msg):
    now=datetime.datetime.now()
    print("{}-{}-{},{}:{}:{},".format(now.year,now.month,now.day,now.hour,now.minute,now.second),end="")
    print(msg.topic+" "+str(msg.payload))
    with open("PenHosMon02.iot","a") as file:
        file.write("{}-{}-{},{}:{}:{},".format(now.year,now.month,now.day,now.hour,now.minute,now.second)+msg.topic+","+str(msg.payload)+"\n")

client = mqtt.Client()
client.username_pw_set("sitita", "password")
client.connect("localhost",1883,60)

client.on_connect = on_connect
client.on_message = on_message

client.loop_forever()
