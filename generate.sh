#!/bin/sh

host="localhost"
db="bsphabba"
usr="root"
pwd="mysql"

echo "CREATE DATABASE IF NOT EXISTS $db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;" | /usr/bin/mysql -u$usr -p$pwd

php insert_book.php $host $db $usr $pwd
