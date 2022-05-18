#!/bin/sh
lastbackup=20200130 #2020-01-30

while true
do
   now=$(date +"%Y%m%d");
   if [ $now -gt $lastbackup ]
   then
     /bin/sh /app/backup.sh
     lastbackup=$now;
   fi
   sleep 12h;
done
