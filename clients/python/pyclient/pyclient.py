#!/usr/bin/python
import MySQLdb

db=MySQLdb.connect("localhost","deltasqluser","deltapass","deltasql")

c=db.cursor()
c.execute('select versionnr from tbsynchronize where versionnr = (select max(versionnr) from tbsynchronize);')
ver=c.fetchone()

versionnr= ver[0]
print versionnr

db.close()
