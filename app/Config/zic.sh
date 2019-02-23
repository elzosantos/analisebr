#!/bin/bash



#CREATE ZIC FILE
ZIC_FILE_PATH="/usr/share/zoneinfo/America/Sao_Paulo.zic"
ZIC_DIR="/usr/share/zoneinfo/America/"
ZIC_FILE="Sao_Paulo.zic"
cat >  $ZIC_FILE_PATH << EOF
Rule    BrazilSP  2013    only    -       Oct     20      0:00    1:00    S
Rule    BrazilSP  2014    only    -       Feb     16      1:00    0       -

# Zone  NAME                    GMTOFF  RULES/SAVE      FORMAT  [UNTIL]
Zone    America/Sao_Paulo       -3:00   BrazilSP        BR%sT
EOF
cd $ZIC_DIR
zic Sao_Paulo.zic

#BACKUP LOCALTIME
#cp /etc/localtime /etc/localtime.backup
LOCALTIME_FILE="/etc/localtime"
LOCALTIME_BACKUP="/etc/localtime.backup_`date +"%Y%m%d_%H%M"`"
/bin/cp -f $LOCALTIME_FILE $LOCALTIME_BACKUP

#COPY SAO PAULO TIMEZONE
#cp /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime
SAO_PAULO_LOCALTIME="/usr/share/zoneinfo/America/Sao_Paulo"
/bin/cp -f $SAO_PAULO_LOCALTIME $LOCALTIME_FILE

