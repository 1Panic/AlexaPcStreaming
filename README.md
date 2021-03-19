# PC to Amazon Alexa streaming
Send your PC Audio to Amazon Alexa **with Multiroom support!**

## How it works?
Its easy!
1. redirect a TuneIn stream to your local PC with a Modded StreamWhatYouHear (https://github.com/StreamWhatYouHear/SWYH) instance.
2. Call Alexa to open that stream. **Enjoy!**


## Requirements  
1. A Router that supports **LAN DNS Resolution / Conditional DNS Forwarding** (for example DrayTek Vigor Series, a Linux router, etc.)
2. A PC that is running a Modded version of StreamWhatYouHear (https://github.com/1Panic/SWYH/releases/)
3. Capture the tcp communication between your Alexa and your Internet to find a TuneIn DNS request that you can redirect to your PC (or use: streams.harmonyfm.de)
4. Say "Alexa play HarmonyFM everywhere" and enjoy

### (Optional) If You like to switch the PC that streams to Alexa, you can add a http Server in your LAN that redirect any requests to your active pc:
5. A HTTP Webserver in your LAN (i use my Synology Nas)
6. A small php script to redirect the http request


## Let's get it started
**1. Setup SWYH**
- Install StreamWhatYouHear/SWYH on your PC (http://www.streamwhatyouhear.com/download/) and **replace it with the Modded version** (https://github.com/1Panic/SWYH/releases/)
- Set the Listning Port from SWYH to 80, optional activate run at logon, **restart SWYH!**
![SWYH Config](https://github.com/1Panic/AlexaPcStreaming/raw/main/img/SWYHConfig.png?raw=true)

- Pay audio(Spotify, Twitch, Youtube, Winamp ...) with **high volume** (SWYH capture your default output device)
- Open your stream on a other device (PC, Handy, Tablet, etc.) http://PC-IP/teststream.mp3 (e.g. http://192.168.0.50/stream.mp3)
(The modded Version of SWYH accepts any url, so if you redirect a domain to you PC, Alexa always get a working stream regardless of the original destination)  
- If you hear your audio, your done on the PC side.

**2. Find a Domain**
- You need to capture the communication between your Alexa and TuneIn to get a DNS request that you can redirect.
- I use WireShark (https://www.wireshark.org/#download) to capture the trafic from my Linux router.
- Get the MAC adress from your Alexa (you can find it in the Info Tab on your Alexa APP at your Device list) so its easier to filter the traffic (Wireshark filter: eth.addr == xx:xx:xx:xx:xx:xx)
- Say to your Alexa it shouldt play a TuneIn stream (or via Alexa APP) **that you normaly not use** and search for the request in Wireshark.
**Tipp: Look for a radio station with its own domain that doesn't change often. Bigger stations are more stable.**
- Search for an HTTP request to **opml.radiotime.com** like:
```
opml.radiotime.com/Tune.ashx?id=e9311784&sid=s846&formats=aac,mp3,hls&partnerId=!EALLOjB&serial=G2PK3SH77AXEXQFTOW7YA
```
- Open that in you browser and look in the Tune.m3u file.
- Now you see the url to the original stream that Alexa would play (e.g. http://streams.harmonyfm.de/harmonyfm/aac/playerid:RTFFHTunein/hqlivestream.aac).
- In this example we need to redirect the domain **streams.harmonyfm.de** to your streaming PC.

**3. Redirect DNS**
- On your router add a custom DNS resolution to your PC that runs SWYH.
![Router Config](https://github.com/1Panic/AlexaPcStreaming/raw/main/img/RouterConfig.png?raw=true)

- Check your router manual if you don't know how.

**4. Alexa play HarmonyFM**
- **Don't forget to restart (Power cycle) your Alexa to clear the DNS cache!**
- Say ***"Alexa play HarmonyFM everywhere"***
Enjoy!


# Optional add an HTTP Server to easy switch between your streaming PC's
- You need a HTTP Server 
(I use nginx on my Snology NAS, you need to free port 80 for it: http://tonylawrence.com/posts/unix/synology/freeing-port-80/)
- Config your HTTP Server that every request that normally get a 404 gets now handled by the index.php
for nginx on Synology:
```
    location / {
      rewrite ^([^.]*[^/])$ $1/ permanent;
      try_files $uri $uri/ /index.php =404;
      include fastcgi_params;
      fastcgi_pass unix:/run/php-fpm/php-c955c07d-aa67-4013-bcda-4189fb9a1f34.sock;
      fastcgi_index index.php;
      fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
      fastcgi_intercept_errors on;
   }
```

- Add the PHP Scripts (https://github.com/1Panic/AlexaPcStreaming/tree/main/webserver) to your root of your Webserver
- Run the update.php from the streaming PC and update the ip. http://webserverIP/update.php
![Update ip](https://github.com/1Panic/AlexaPcStreaming/raw/main/img/update.php.png?raw=true)

- Update the IP for the DNS redirect on your Router to your HTTP Server
- Test it, **(don't forget to clear the DNS cache!)**
In our example, open http://streams.harmonyfm.de/harmonyfm/aac/playerid:RTFFHTunein/hqlivestream.aac on any device in your LAN/WLAN 
and you should hear the audio from your PC.


# If you like it, buy me a coffee
https://www.paypal.com/paypalme/ipanic
bitcoin:bc1q70dnwxa7yh7wmq83wasqn2utpkxfxhd6znpxgc

![BTC](https://github.com/1Panic/AlexaPcStreaming/raw/main/img/qrcodeBC.png?raw=true)

# Credits
**Big THX to Sébastien Warin (https://github.com/sebastienwarin) for StreamWhatYouHear/SWYH https://github.com/StreamWhatYouHear/SWYH**

