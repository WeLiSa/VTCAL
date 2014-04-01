@echo off&cls

NET USE * /DELETE /YES 

net use T: \\NOM-PC-2\wamp\www\VTCAL\calendar /USER:WORKGROUP\User mdp

setlocal enabledelayedexpansion

set $Source=C:\XXX\radicale\data\user
set $Destination=T:\

:commence
for /f "delims=" %%a in ('dir "%$Source%" /od/b') do (echo Copie du fichier : %%a
xcopy "%$Source%\%%a" /y "%$Destination%")

:Termine
Echo Termin‚
Timeout 10
goto:commence

net use T: /DELETE
