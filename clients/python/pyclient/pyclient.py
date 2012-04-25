#!/usr/bin/python
import MySQLdb

db=MySQLdb.connect("localhost","deltasqluser","deltapass","deltasql")

c=db.cursor()
c.execute('select versionnr from tbsynchronize where versionnr = (select max(versionnr) from tbsynchronize);')
ver=c.fetchall()

print ver

db.close()
