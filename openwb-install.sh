#/bin/bash

echo "update system"
apt-get update

echo "check for vim"
if ! [ -x "$(command -v vim)" ]; then
	apt-get -qq install -y vim
	echo "... installed"
else
	echo "...ok"
fi

echo "check for timezone"
if  grep -Fxq "Europe/Berlin" /etc/timezone
then
	echo "...ok"
else
	echo 'Europe/Berlin' > /etc/timezone
	dpkg-reconfigure -f noninteractive tzdata
	cp /usr/share/zoneinfo/Europe/Berlin /etc/localtime
	echo "...changed"
fi

echo "check for bc"
if ! [ -x "$(command -v bc)" ];then
	apt-get -qq install -y bc
	echo "...installed"
else
	echo "...ok"
fi

echo "check for apache"
if ! [ -x "$(command -v apachectl)" ]; then
	apt-get -qq install -y apache2 php php-gd php7.0-xml php-curl libapache2-mod-php7.0 jq raspberrypi-kernel-headers
	sleep 2
	echo "... installed"
else
	echo "...ok"
fi

echo "check for i2c bus"
if grep -Fxq "i2c-bcm2835" /etc/modules
then
	echo "...ok"
else
	echo "i2c-dev" >> /etc/modules
	echo "i2c-bcm2708" >> /etc/modules
	echo "snd-bcm2835" >> /etc/modules
	echo "dtparam=i2c1=on" >> /etc/modules
	echo "dtparam=i2c_arm=on" >> /etc/modules
fi

echo "check for i2c package"
if ! [ -x "$(command -v i2cdetect)" ]; then
	apt-get -qq install -y i2c-tools
	echo "... installed"
else
	echo "...ok"
fi

echo "check for git"
if ! [ -x "$(command -v git)" ]; then
	apt-get -qq install -y git
	echo "... installed"
else
	echo "...ok"
fi

echo "check for initial git clone"
if [ ! -d /var/www/html/openWB/web ]; then
	cd /var/www/html/
	git clone https://github.com/snaptec/openWB.git --branch master
	chown -R pi:pi openWB 
	echo "... git cloned"
else
	echo "...ok"
fi
if ! grep -Fq "bootmodus=" /var/www/html/openWB/openwb.conf
then
	echo "bootmodus=3" >> /var/www/html/openWB/openwb.conf
fi
echo "check for ramdisk" 
if grep -Fxq "tmpfs /var/www/html/openWB/ramdisk tmpfs nodev,nosuid,size=32M 0 0" /etc/fstab 
then
	echo "...ok"
else
	mkdir -p /var/www/html/openWB/ramdisk
	echo "tmpfs /var/www/html/openWB/ramdisk tmpfs nodev,nosuid,size=32M 0 0" >> /etc/fstab
	mount -a
	echo "0" > /var/www/html/openWB/ramdisk/ladestatus
	echo "0" > /var/www/html/openWB/ramdisk/llsoll
	echo "0" > /var/www/html/openWB/ramdisk/soc
	echo "...created"
fi

echo "check for socat"
if ! [ -x "$(command -v socat)" ]; then
	apt-get -qq install -y socat
	echo "... installed"
else
	echo "...ok"
fi

echo "check for sshpass"
if ! [ -x "$(command -v sshpass)" ];then
	apt-get -qq install -y sshpass
	echo "... installed"
else
	echo "...ok"
fi

echo "check for mosquitto"
if [ ! -f /etc/mosquitto/mosquitto.conf ]; then
	sudo apt-get -qq install -y mosquitto mosquitto-clients
	sudo service mosquitto restart
	echo "... installed"
else
	echo "...ok"
fi

echo "check for openwb specific mosquitto configuration"
if [ ! -f /etc/mosquitto/conf.d/openwb.conf ]; then
	sudo cp /var/www/html/openWB/web/files/mosquitto.conf /etc/mosquitto/conf.d/openwb.conf
	sudo service mosquitto restart
	echo "... installed"
else
	echo "...ok"
fi

echo "check for chromium-browser"
if ! [ -x "$(command -v chromium-browser)" ];then
	apt-get -qq install -y lxde-session chromium-browser chromium-browser-l10n
	echo "... installed"
else
	echo "...ok"
fi

echo "disable cronjob logging"
if grep -Fxq "EXTRA_OPTS=\"-L 0\"" /etc/default/cron
then
	echo "...ok"
else
	echo "EXTRA_OPTS="-L 0"" >> /etc/default/cron
fi

echo "check for crontab"
if [ -f "/etc/cron.d/openwb" ]; then
	echo "...ok"
else
	echo "@reboot root /var/www/html/openWB/runs/atreboot.sh" > /etc/cron.d/openwb
	echo "1 0 * * * pi /var/www/html/openWB/runs/cronnightly.sh >> /var/log/openWB.log 2>&1" >> /etc/cron.d/openwb
	echo "*/5 * * * * pi /var/www/html/openWB/runs/cron5min.sh >> /var/log/openWB.log 2>&1" >> /etc/cron.d/openwb
	echo "* * * * * pi /var/www/html/openWB/regel.sh >> /var/log/openWB.log 2>&1" >> /etc/cron.d/openwb
	echo "* * * * * pi sleep 10 && /var/www/html/openWB/regel.sh >> /var/log/openWB.log 2>&1" >> /etc/cron.d/openwb
	echo "* * * * * pi sleep 20 && /var/www/html/openWB/regel.sh >> /var/log/openWB.log 2>&1" >> /etc/cron.d/openwb
	echo "* * * * * pi sleep 30 && /var/www/html/openWB/regel.sh >> /var/log/openWB.log 2>&1" >> /etc/cron.d/openwb
	echo "* * * * * pi sleep 40 && /var/www/html/openWB/regel.sh >> /var/log/openWB.log 2>&1" >> /etc/cron.d/openwb
	echo "* * * * * pi sleep 50 && /var/www/html/openWB/regel.sh >> /var/log/openWB.log 2>&1" >> /etc/cron.d/openwb
	echo "...added"
fi

sudo /bin/su -c "echo 'upload_max_filesize = 300M' > /etc/php/7.0/apache2/conf.d/20-uploadlimit.ini"
sudo /bin/su -c "echo 'post_max_size = 300M' >> /etc/php/7.0/apache2/conf.d/20-uploadlimit.ini"

echo "installing required python modules"
sudo apt-get -qq install -y python-pip
sudo apt-get -qq install -y python3-pip
sudo pip install evdev
sudo pip install pymodbus
sudo pip install adafruit-mcp4725
sudo pip3 install paho-mqtt
sudo pip3 install docopt
sudo pip3 install certifi
sudo pip3 install aiohttp
sudo pip3 install pymodbus

echo "www-data ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers.d/010_pi-nopasswd

chmod 777 /var/www/html/openWB/openwb.conf
chmod +x /var/www/html/openWB/modules/*
chmod +x /var/www/html/openWB/runs/*
touch /var/log/openWB.log
chmod 777 /var/log/openWB.log
# /var/www/html/openWB/runs/atreboot.sh
