# Update Notifier plugin for Craft CMS

a craft cms plugin that checks for updates in craft core and installed plugins and sends out notifications (via email)

## Installation

To install Update Notifier, follow these steps:

1. Download & unzip the file and place the `craft-updatenotifier` directory into your `craft/plugins` directory as `updatenotifier`.
2.  -OR- do a `git clone https://github.com/fork/craft-updatenotifier.git` directly into your `craft/plugins` folder and rename it to `updatenotifier`.  You can then update it with `git pull`
3. Install plugin in the Craft Control Panel under Settings > Plugins
5. The plugin folder should be named `updatenotifier` for Craft to see it.

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




Brought to you by [Fork Unstable Media GmbH](http://fork.de)
