@ECHO OFF
ECHO Normal Shutdown
ECHO --------------------------------
cd ../
:: docker compose --profile pma stop
docker compose stop
ECHO --------------------------------
ECHO Docker Job Complete
PAUSE
