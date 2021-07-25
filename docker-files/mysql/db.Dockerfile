FROM mariadb:10.5.6

COPY ./docker-files/mysql/my.cnf /etc/mysql/my.cnf

COPY ./docker-files/data /var/lib/mysql/