<div align="center">
  <a href="https://www.fork.de">
    <img src="./assets/fork-logo.png" width="156" height="30" alt="Fork Logo" />
  </a>
</div>

# Project discontinued! (its Craft 2...)
But if you need an easy way to retrieve updates, here's a cronjob command:

```
0 8 * * 1-5 printf "From: My Website <my-website@example.com>\nTo: Me <me@example.com>\nSubject: Available Craft Updates\n$(~/my-project/site/craft update/info)" | /usr/sbin/sendmail -t
```
---
# Update Notifier plugin for Craft CMS

a craft cms plugin that checks for updates in craft core and installed plugins and sends out notifications (via email)

## Installation

To install Update Notifier, follow these steps:

1. Download & unzip the file and place the `craft-updatenotifier` directory into your `craft/plugins` directory as `updatenotifier`.
2. -OR- do a `git clone https://github.com/fork/craft-updatenotifier.git` directly into your `craft/plugins` folder and rename it to `updatenotifier`. You can then update it with `git pull`
3. Install plugin in the Craft Control Panel under Settings > Plugins
4. The plugin folder should be named `updatenotifier` for Craft to see it.

## Configuring Update Notifier

1. Setup your notification email adresses as a comma separated list in the plugin settings.
2. Setup a cronjob in the crontab to run the update check command (for example daily). use `which php` to find your php executable path.

```
0 0 * * * /usr/local/bin/php /var/www/my-site/craft/app/etc/console/yiic updatenotifier check
```

if you have a custom config path (which includes the necessary license.key file for the update check) you can tell yiic:

```
0 0 * * * /usr/local/bin/php /var/www/my-site/craft/app/etc/console/yiic --configPath=/var/www/my-site/craft/config/custom-dir/ updatenotifier check
```

---

<div align="center">
  <img src="./assets/heart.png" width="38" height="41" alt="Fork Logo" />

  <p>Brought to you by <a href="https://www.fork.de">Fork Unstable Media GmbH</a></p>
</div>
