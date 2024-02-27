Api Realizada en laravel junto con docker y docker compose

A continuacion se da una brebe descripcion de lo necesario para correr la app

1.- Tener instalado docker en su laptop ya se (MAC, Windows o linux) de no tener instalada la aplicacion se puede descargar el proyecto independiente.
2.- Base de datos creada en PostgresSQL de ser necesario correr en MySQL hacer las confifuraciones pertinentes
3.- En caso de tener instalado docker en la maquina descargar el repo del siguiente enlace https://github.com/JACClockdown/CidarGroup hay se encontrara un archivo llamado docker-compose.yml el cual al ejecutar el siguiente comando "docker compose up -d --build"
    ejecutara toda la aplicacion tanto el backend como la base de datos esto creara migraciones en dicha base de datos
