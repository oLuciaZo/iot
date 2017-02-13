#!/usr/bin/env python3

import paho.mqtt.client as mqtt

# This is the Publisher

client = mqtt.Client()
client.username_pw_set("sitita", "password")
client.connect("localhost",1883,60)
client.publish("topic/test", "Hello world!");
client.disconnect();
