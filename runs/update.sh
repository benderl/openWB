#!/bin/bash
OPENWBBASEDIR=$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)

source "$OPENWBBASEDIR/loadconfig.sh"

# set mode to stop and flags in ramdisk and broker to indicate current update state
mosquitto_pub -t "openWB/set/ChargeMode" -r -m "3"
mosquitto_pub -t "openWB/system/updateInProgress" -r -m "1"
echo 1 >"$RAMDISKDIR/updateinprogress"
echo 1 >"$RAMDISKDIR/bootinprogress"
UPDATEMESSAGE="Update wird ausgeführt, bitte warten bis die Meldung nicht mehr sichtbar ist"
echo "$UPDATEMESSAGE" >"$RAMDISKDIR/lastregelungaktiv"
mosquitto_pub -t "openWB/global/strLastmanagementActive" -r -m "$UPDATEMESSAGE"
echo "$UPDATEMESSAGE" >"$RAMDISKDIR/mqttlastregelungaktiv"
chmod 666 "$RAMDISKDIR/mqttlastregelungaktiv"

# The update might replace a number of files which might currently be in use by the continuously running legacy-run
# server. If we replace the source files while the process is running, funny things might happen.
# Thus we shut-down the legacy run server before performing the update.
pkill -u pi -f "$OPENWBBASEDIR/packages/legacy_run_server.py"

# force lower case on releasetrain for comparison
if [[ "${releasetrain,,}" == "stable" ]]; then
	train=stable17
else
	train=$releasetrain
fi

# check for ext openWB on configured charge points and start update
if [[ "$evsecon" == "extopenwb" ]]; then
	echo "starting update on extOpenWB on LP1"
	mosquitto_pub -t openWB/set/system/releaseTrain -r -h "$chargep1ip" -m "$releasetrain"
	mosquitto_pub -t openWB/set/system/PerformUpdate -r -h "$chargep1ip" -m "1"
fi
if [[ $lastmanagement == "1" ]]; then
	if [[ "$evsecons1" == "extopenwb" ]]; then
		echo "starting update on extOpenWB on LP2"
		mosquitto_pub -t openWB/set/system/releaseTrain -r -h "$chargep2ip" -m "$releasetrain"
		mosquitto_pub -t openWB/set/system/PerformUpdate -r -h "$chargep2ip" -m "1"
	fi
fi
if [[ $lastmanagements2 == "1" ]]; then
	if [[ "$evsecons2" == "extopenwb" ]]; then
		echo "starting update on extOpenWB on LP3"
		mosquitto_pub -t openWB/set/system/releaseTrain -r -h "$chargep3ip" -m "$releasetrain"
		mosquitto_pub -t openWB/set/system/PerformUpdate -r -h "$chargep3ip" -m "1"
	fi
fi
for i in $(seq 4 8); do
	lastmanagementVar="lastmanagementlp$i"
	evseconVar="evseconlp$i"
	if [[ ${!lastmanagementVar} == "1" ]]; then
		if [[ ${!evseconVar} == "extopenwb" ]]; then
			echo "starting update on extOpenWB on LP$i"
			chargepIpVar="chargep${i}ip"
			mosquitto_pub -t openWB/set/system/releaseTrain -r -h "${!chargepIpVar}" -m "$releasetrain"
			mosquitto_pub -t openWB/set/system/PerformUpdate -r -h "${!chargepIpVar}" -m "1"
		fi
	fi
done

# Wait for regulation loop(s) and cron jobs to end, but with timeout in case a script hangs
pgrep -f "$OPENWBBASEDIR/(regel\\.sh|runs/cron5min\\.sh|runs/cronnightly\\.sh)$" |
	timeout 15 xargs -n1 -I'{}' tail -f --pid="{}" /dev/null

# backup some files before fetching new release
# module soc_eq
cp "$OPENWBBASEDIR/modules/soc_eq/soc_eq_acc_lp1" /tmp/soc_eq_acc_lp1
cp "$OPENWBBASEDIR/modules/soc_eq/soc_eq_acc_lp2" /tmp/soc_eq_acc_lp2
cp "$OPENWBBASEDIR/openwb.conf" /tmp/openwb.conf

# fetch new release from GitHub
git -C "$OPENWBBASEDIR" fetch origin
git -C "$OPENWBBASEDIR" reset --hard "origin/$train"

# set permissions
sudo chown -R pi:pi "$OPENWBBASEDIR"
cp /tmp/openwb.conf "$OPENWBBASEDIR/openwb.conf"

# restore saved files after fetching new release
# module soc_eq
cp /tmp/soc_eq_acc_lp1 "$OPENWBBASEDIR/modules/soc_eq/soc_eq_acc_lp1"
cp /tmp/soc_eq_acc_lp2 "$OPENWBBASEDIR/modules/soc_eq/soc_eq_acc_lp2"

# set permissions
sudo chmod 666 "$OPENWBBASEDIR/openwb.conf"
sudo chmod +x "$OPENWBBASEDIR/modules/"*
sudo chmod +x "$OPENWBBASEDIR/runs/"*
sudo chmod +x "$OPENWBBASEDIR/"*.sh
sudo chmod 666 "$RAMDISKDIR/"*
sleep 2

# now treat system as in booting state
nohup "$OPENWBBASEDIR/runs/atreboot.sh" >>/var/log/openWB.log 2>&1 &
