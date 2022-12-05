#!/usr/bin/env python3
import traceback
import time
from typing import List

basePath = "/var/www/html/openWB"
ramdiskPath = basePath + "/ramdisk"
logFilename = ramdiskPath + "/ledDaemon.log"
led_gpio = [
    {"gpio": 24},
    {"gpio": 23},
    {"gpio":  4}
]
led_mode = "aus"
loglevel = 1


# handling of all logging statements
def log_debug(level: int, msg: str, traceback_str: str = None) -> None:
    if level >= loglevel:
        with open(logFilename, 'a') as log_file:
            log_file.write(time.ctime() + ': ' + msg + '\n')
            if traceback_str is not None:
                log_file.write(traceback_str + '\n')


# read value from file in ramdisk
def read_from_ramdisk(filename: str) -> str:
    with open(ramdiskPath + "/" + filename, "r") as file:
        return file.readline().rstrip("\n ")


def init():
    GPIO.setwarnings(False)
    GPIO.setmode(GPIO.BCM)
    for led in led_gpio:
        GPIO.setup(led["gpio"], GPIO.OUT)
    led_off()


def led_off(set_led_list: List = [0, 1, 2]) -> None:
    for set_led in set_led_list:
        GPIO.output(led_gpio[set_led]["gpio"], GPIO.LOW)


def led_on(set_led_list: List = [0, 1, 2]) -> None:
    for set_led in set_led_list:
        GPIO.output(led_gpio[set_led]["gpio"], GPIO.HIGH)


try:
    import RPi.GPIO as GPIO
except ModuleNotFoundError:
    exit("Module RPi.GPIO missing! Maybe we are not running on supported hardware?")
log_debug(2, "led daemon starting")
try:
    init()
    log_debug(1, "led daemon initialized, running loop")
    while True:
        try:
            new_led_mode = read_from_ramdisk("ledstatus")
        except FileNotFoundError:
            log_debug(2, "cannot read led status file from ramdisk")
            new_led_mode = led_mode
        if led_mode != new_led_mode:
            log_debug(1, "mode change detected: %s->%s" % (led_mode, new_led_mode))
        requested_led_list = [int(s)-1 for s in new_led_mode if s.isdigit()]
        if len(requested_led_list) == 0:
            requested_led_list = [0, 1, 2]
        if new_led_mode == "startup":
            led_off()
            n = 0
            while n < 5:
                led_on()
                time.sleep(2)
                led_off()
                time.sleep(2)
                n += 1
            time.sleep(1)
            led_on([0])
            time.sleep(3)
            led_on([1])
            time.sleep(3)
            led_on([2])
            time.sleep(3)
            led_off([0])
            time.sleep(3)
            led_off([1])
            time.sleep(3)
            led_off([2])
            time.sleep(2)
        elif "aus" in new_led_mode:
            led_off(requested_led_list)
            time.sleep(2)
        elif "an" in new_led_mode:
            led_off()
            led_on(requested_led_list)
            time.sleep(2)
        elif "blink" in new_led_mode:
            led_off()
            led_on(requested_led_list)
            time.sleep(2)
            led_off(requested_led_list)
            time.sleep(2)
        elif "flash" in new_led_mode:
            led_off()
            led_on(requested_led_list)
            time.sleep(0.1)
            led_off(requested_led_list)
            time.sleep(0.1)
        else:
            log_debug(2, "unsupported led mode: %s" % (new_led_mode))
            led_off()
            time.sleep(2)
        led_mode = new_led_mode
except Exception as e:
    log_debug(2, "ERROR in led daemon: " + str(e), traceback.format_exc())
finally:
    led_off()
    # No cleanup here! Keep state of output, low for all used GPIOs
    # GPIO.cleanup()
    log_debug(2, "led daemon stopped")
