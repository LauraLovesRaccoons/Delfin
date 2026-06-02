@ECHO OFF
ECHO Disable phpMyAdmin
ECHO --------------------------------
cd ../
docker compose stop phpmyadmin
ECHO --------------------------------
ECHO Docker Job Complete
PAUSE
