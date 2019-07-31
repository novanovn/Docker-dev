Example Docker with OCI8 PHP 7
=========================

--> install Docker
--------------------
-> windows
https://docs.docker.com/docker-for-windows/install/
-> Linux Ubuntu
https://docs.docker.com/install/linux/docker-ce/ubuntu/

-> compile container
#compile di root app
docker-compose up --build -d
-> cek list container 
sudo docker container ls
-> akses cli container
sudo docker exec -it (nama container) bash
Example : sudo docker exec -it docker_php7 bash
