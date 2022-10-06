#!/bin/bash

ledsteuerung() {
	ledstatus=$(<ramdisk/ledstatus)
	lademodus=$(<ramdisk/lademodus)   # 0="sofort" 1="min pv" 2="nur pv" 3="stop" 4="standby"
	ladestatus=$(<ramdisk/ladestatus) # 1="Ladung freigegeben"
	ledrunning=$(pgrep -f '^python.*ledsDaemon.py')
	if [ -z "$ledrunning" ]; then
		python3 runs/leds/ledsDaemon.py &
	fi
	if ((slavemode == 1)); then
		if ((lp1enabled == 1)) && ((lp2enabled == 1)) && ((lastmanagement == 1)); then
			slaveLedStatus="an12"
		elif ((lp1enabled == 0)) && ((lp2enabled == 1)) && ((lastmanagement == 1)); then
			slaveLedStatus="an2"
		elif ((lp1enabled == 1)) && ((lp2enabled == 0)); then
			slaveLedStatus="an1"
		else
			slaveLedStatus="aus"
		fi
		if [[ $ledstatus != "$slaveLedStatus" ]]; then
			echo "$slaveLedStatus" >ramdisk/ledstatus
		fi
	elif ((ladestatus == 1)); then
		case $lademodus in
		0)
			neuerStatus=$ledsofort
			;;
		1)
			neuerStatus=$ledminpv
			;;
		2)
			neuerStatus=$lednurpv
			;;
		3)
			neuerStatus=$ledstop
			;;
		4)
			neuerStatus=$ledstandby
			;;
		esac
	else
		case $lademodus in
		0)
			neuerStatus=$led0sofort
			;;
		1)
			neuerStatus=$led0minpv
			;;
		2)
			neuerStatus=$led0nurpv
			;;
		3)
			neuerStatus=$led0stop
			;;
		4)
			neuerStatus=$led0standby
			;;
		esac
	fi

	if [[ $ledstatus != "$neuerStatus" ]]; then
		echo "$neuerStatus" >ramdisk/ledstatus
	fi
}
