@ECHO OFF
ECHO First Startup
ECHO This Will Take A While
ECHO --------------------------------
cd ../
docker compose --profile pma up -d --build
composer install
timeout /t 10
docker compose --profile pma stop
timeout /t 10
docker compose up -d
ECHO --------------------------------
ECHO Docker Job Complete
PAUSE
