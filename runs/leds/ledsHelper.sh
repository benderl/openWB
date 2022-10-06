#!/bin/bash
if [[ -z "$OPENWBBASEDIR" ]]; then
	OPENWBBASEDIR=$(cd "$(dirname "$0")/../../" && pwd)
fi
if [[ -z "$RAMDISKDIR" ]]; then
	RAMDISKDIR="${OPENWBBASEDIR}/ramdisk"
fi

declare -F openwbDebugLog &>/dev/null || {
	. "$OPENWBBASEDIR/helperFunctions.sh"
}

ledsStart() {
	if pgrep -f '^python.*ledsDaemon.py' >/dev/null; then
		openwbDebugLog "MAIN" 2 "leds handler already running"
	else
		openwbDebugLog "MAIN" 1 "leds handler not running! starting process"
		echo "startup" >"$RAMDISKDIR/ledstatus"
		python3 "$OPENWBBASEDIR/runs/leds/ledsDaemon.py" >>"$RAMDISKDIR/openWB.log" 2>&1 &
	fi
}

ledsStop() {
	if pgrep -f '^python.*ledsDaemon.py' >/dev/null; then
		openwbDebugLog "MAIN" 1 "leds handler running but not configured. killing handler"
		sudo pkill -f '^python.*ledsDaemon.py'
	fi
}

ledsSetup() {
	local enabled=$1
	local forceRestart=$2

	if ((forceRestart == 1)); then
		openwbDebugLog "MAIN" 2 "leds handler restart forced! killing handler"
		ledsStop
	fi
	if ((enabled == 1)); then
		openwbDebugLog "MAIN" 1 "leds enabled"
		ledsStart
	else
		openwbDebugLog "MAIN" 1 "leds disabled"
		ledsStop
	fi
}
export -f ledsSetup
