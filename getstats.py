#OpenHost Project
#daknob@tolabaki.gr

def getint(filep):
	f = open(filep, "a+")
	s = f.read()
	s = s.replace("\n", "")
	try:
		s = float(s)
	except:
		s = 0
	f.close()
	return s

def setint(filep, intn):
	f = open(filep, "w+")
	f.write(str(intn))
	f.close()

sessions = getint("session")
print("HOSTNAME\tUPTIME")
for host in open("hosts", "r"):
	host = host.replace("\n", "")
	print(host + "\t\t" + str(float(getint("uptimes/"+host)/sessions*100))+"%")
