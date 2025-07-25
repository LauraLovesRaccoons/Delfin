# Delfin

## Version 1.8.6.3

Guide for Windows x64 Machines   (folder batch_files [Windows Only] has everything you need)

-> ubuntu_info.txt might help you

---

you need to have docker installed (and running)  
    - Docker Engine (Linux)  
    - Docker Desktop (beware of licensing - Windows with WSL)  
    - Rancher Desktop [dockerd(moby):] (Windows with WSL)  

terminal move into root directory (Delfin)

docker will LOCK the active TERMINAL window!

---

###### REF Folder is   [batch_files]

---

###### if composer isn't installed   [_install_composer.bat]

  (if you use Linux, Mac or even FreeBSD , well these commands won't install composer)

    (also you need internet access , duh ; even on Windows)

---

---

### FIRST RUN:

###### setup [.env] - [root]

###### [first_run.bat]

followed by:

###### [setup_db_query] - (run all 3 sql files in phpmyadmin)

  example password is: Super

---

### Normal Stuff:

###### [normal_start.bat]

###### [normal_shutdown.bat]


---

### Admin Stuff:

(phpMyAdmin)     

###### Enable:      [enable_PMA.bat]

###### Disable:     [disable_PMA.bat]

###### Changes to the .env file?   [refresh_env.bat]

---

database backups are in the docker volume delfin_db_backup as sql files zipped/compressed in .gz form

---

-d means detached mode ; this allows chaining of commands

---

---

In case the container or other things crash during a batch job the job locking flag might become stuck
In that case only, you have to enable phpmyadmin (batch file) and visit it on port 8080 and in delfin_db look for the Job_Lock table
Each active field should be set to 0 if it's set to 1 or anything else (don't touch the ID!)
If this is too difficult for you, import ./batch_files/setup_db_query/Job_Lock.sql into phpmyadmin and that will recreate the table with its default unlocked values

---

---

## Version Number for Releases Info

If the version number changes any of the first 3 numbers, those are probably relevant to you
IF the first number changes, that's an entire overhaul and that might break your workflow so test if that one works for your workflow before updating
(IF there is a 4th or even a 5th number that changes, well those are "mostly" irrelevant releases)

---

---

## Rancher Desktop Database Backups (WSL directory)

    \\wsl$\rancher-desktop-data\var\lib\docker\volumes

---
