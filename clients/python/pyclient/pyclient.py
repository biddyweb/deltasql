#!/bin/bash
# A Python client for deltasql
import MySQLdb

conn = MySQLdb.connect (host = "localhost",
                        user = "deltauser",
                        passwd = "deltapass",
                        db = "deltasql")
cursor = conn.cursor ()
cursor.execute ("SELECT VERSION()")
row = cursor.fetchone ()
print "server version:", row[0]
cursor.close ()
conn.close ()
