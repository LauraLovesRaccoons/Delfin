ECHO This Will Take A While
ECHO --------------------------------
cd ../
docker compose --profile pma down
timeout /t 10
docker compose up -d
ECHO --------------------------------
ECHO Docker Job Complete
PAUSE
