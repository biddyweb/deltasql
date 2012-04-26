#!/usr/bin/python
import MySQLdb
import SimpleConfigParser

cp = SimpleConfigParser.SimpleConfigParser()
cp.read('config.ini')
print 'getoptionslist():', cp.getoptionslist()
for option in cp.getoptionslist():
    print "getoption('%s') = '%s'" % (option, cp.getoption(option))
print "hasoption('wrongname') =", cp.hasoption('wrongname')

db=MySQLdb.connect(cp.getoption('host'),cp.getoption('username'),
                   cp.getoption('password'),cp.getoption('database'))

c=db.cursor()
c.execute('select versionnr from tbsynchronize where versionnr = (select max(versionnr) from tbsynchronize);')
ver=c.fetchone()

versionnr= ver[0]
print versionnr

db.close()
