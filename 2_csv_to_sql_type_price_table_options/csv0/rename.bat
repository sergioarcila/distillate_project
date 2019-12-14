@echo off & setlocal EnableDelayedExpansion 

set pre_ext=
set ext=csv
set a=1
for /f "delims=" %%i in ('dir /b *.!ext!') do (
  ren "%%i" "!pre_ext!!a!.!ext!"
  set /a a+=1
) 