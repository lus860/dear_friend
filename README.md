## Dear Friend

### Local Setup
```bash
docker run \
--name dear_friend_mysql_8 \
-e MYSQL_ALLOW_EMPTY_PASSWORD=true \
-e MYSQL_ROOT_PASSWORD=Qn5Y1xbABUf7Lk8Sdb \
-e MYSQL_RANDOM_ROOT_PASSWORD=false \
-e MYSQL_DATABASE=mysql_utf8mb4 \
-v /home/developer/dbs/dear-friend/.mysql/lib/mysql:/var/lib/mysql:rw \
-v /home/developer/dbs/dear-friend/.mysql/log/mysql:/var/log/mysql:rw \
-v /home/developer/dbs/dear-friend/.mysql/tmp/db:/tmp/db:rw \
-p 3323:3306 \
-d mysql:latest \
--character-set-server=utf8mb4 \
--collation-server=utf8mb4_unicode_ci
```

- Need to find GENERATED ROOT PASSWORD for mysql
```bash
docker logs -f dear_friend_mysql_8
```

- Example 
> GENERATED ROOT PASSWORD: lg/9rjO2Ij2PTQRT9MA58DEkjeZukkMI

> mysql -h 0.0.0.0 -P 3323 -uroot -p
> CREATE DATABASE dear_friend CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

- Add above details in .env file
