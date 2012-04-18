#!/usr/bin/python
import MySQLdb

db=MySQLdb.connect("localhost","deltauser","deltapass","deltasql")

c=db.cursor()
c.execute('SELECT * FROM tbsynchronize')

c.fetchall()

db.close()
