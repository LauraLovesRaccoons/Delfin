@ECHO OFF
ECHO Disable phpMyAdmin
ECHO The Entire Docker Container Will Restart
ECHO --------------------------------
cd ../
docker compose --profile pma stop
timeout /t 10
docker compose up -d
ECHO Docker Job Complete
ECHO --------------------------------
PAUSE
