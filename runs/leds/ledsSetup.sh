#!/bin/bash
OPENWBBASEDIR=$(cd "$(dirname "$0")/../../" && pwd)
RAMDISKDIR="${OPENWBBASEDIR}/ramdisk"
# try to load config
. "$OPENWBBASEDIR/loadconfig.sh"
# load helperFunctions
. "$OPENWBBASEDIR/helperFunctions.sh"
# load ledsHelper
. "$OPENWBBASEDIR/runs/leds/ledsHelper.sh"

ledsSetup "$ledsakt" 0
