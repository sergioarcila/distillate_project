@echo off & setlocal EnableDelayedExpansion 

set pre_ext=AUS_Jewelry_3K
set ext=csv
set a=1
for /f "delims=" %%i in ('dir /b *.!ext!') do (
  ren "%%i" "!pre_ext!_!a!.!ext!"
  set /a a+=1
) 