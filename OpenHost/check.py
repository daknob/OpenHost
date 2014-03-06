#The OpenHost Project
#csd3235@csd.uoc.gr

import os
import time

session = open("session","a+").read()
try:
	session = int(session)
except:
	session = 0

while(1):
	session += 1
	open("session", "w+").write(str(session))
	for host in open("hosts","r"):
		host = host.replace("\n","")
		pingd = open("uptimes/"+host, "a+").read()
		try:		
			pingd = int(pingd)
		except:
			pingd = 0
		pingd = pingd + 1
		if(os.system("ping -c 1 -t 2 " + host) == 0):
			#Alive
			f = open("uptimes/"+host, "w+")
			f.write(str(pingd))
			f.close()	
		else:
			#Dead
			pass
	time.sleep(60)

print("Hang up")
