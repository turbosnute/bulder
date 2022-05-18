#!/bin/sh

now=$(date +"%s_%Y-%m-%d")
filename=/backup/${now}_${MYSQL_DATABASE}.sql
echo "backing up to ${filename}"
/usr/bin/mysqldump --opt -h ${MYSQL_HOST} -u ${MYSQL_USER} -p${MYSQL_PASSWORD} ${MYSQL_DATABASE} > "${filename}"
gzip ${filename}