#! /bin/bash

backupdir=/usr/local/bin/backup
dirlist=${backupdir}/bin/dirlist.conf
numbackups=$(ls ${backupdir}/archive/*.tar.gz | wc -l)
numtokeep=10

if [ ${numbackups} -gt $(( ${numtokeep} - 1)) ];
then
	numtodelete=$(( ${numbackups} - $(( ${numtokeep} - 1 )) ))
	rm $(ls -t ${backupdir}/archive/*.tar.gz | tail -${numtodelete})
fi

tar cvzf ${backupdir}/archive/libjpel_$(date '+%F').tar.gz $(cat ${dirlist})
