@ECHO OFF
ECHO Normal Shutdown
ECHO --------------------------------
cd ../
docker compose --profile pma stop
ECHO --------------------------------
ECHO Docker Job Complete
PAUSE
