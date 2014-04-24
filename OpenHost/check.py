#The OpenHost Project
#daknob@tolabaki.gr

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
			os.system("/bin/echo 1 > status/" + host)
		else:
			#Dead
			f = open("status/" + host)
			if (f.read() == "1\n"):
				f.close()
				os.system("echo \"The host '" + host + "' appears to be offline.\" | mail -s \"[OpenHost] Host offline\" daknob@tolabaki.gr")
			os.system("/bin/echo 0 > status/" + host)
	time.sleep(60)

print("Hang up")
