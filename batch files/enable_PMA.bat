@ECHO OFF
ECHO Enable phpMyAdmin
ECHO --------------------------------
cd ../
docker compose --profile pma up -d
ECHO --------------------------------
ECHO Docker Job Complete
PAUSE
