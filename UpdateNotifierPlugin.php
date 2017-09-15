<?php
/**
 * Update Notifier plugin for Craft CMS
 *
 * a craft cms plugin that checks for updates in craft core and installed plugins and sends out notifications (via email)
 *
 * @author    Fork Unstable Media GmbH
 * @copyright Copyright (c) 2017 Fork Unstable Media GmbH
 * @link      http://fork.de
 * @package   UpdateNotifier
 * @since     1.0.0
 */

namespace Craft;

class UpdateNotifierPlugin extends BasePlugin
{
    /**
     * @return mixed
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return mixed
     */
    public function getName()
    {
         return Craft::t('Update Notifier');
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return Craft::t('a craft cms plugin that checks for updates in craft core and installed plugins and sends out notifications (via email)');
    }

    /**
     * @return string
     */
    public function getDocumentationUrl()
    {
        return 'https://github.com/fork/craft-updatenotifier/blob/master/README.md';
    }

    /**
     * @return string
     */
    public function getReleaseFeedUrl()
    {
        return 'https://raw.githubusercontent.com/fork/craft-updatenotifier/master/releases.json';
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return '1.0.1';
    }

    /**
     * @return string
     */
    public function getSchemaVersion()
    {
        return '1.0.0';
    }

    /**
     * @return string
     */
    public function getDeveloper()
    {
        return 'Fork Unstable Media GmbH';
    }

    /**
     * @return string
     */
    public function getDeveloperUrl()
    {
        return 'http://fork.de';
    }

    /**
     * @return bool
     */
    public function hasCpSection()
    {
        return false;
    }

    /**
     */
    public function onBeforeInstall()
    {
    }

    /**
     */
    public function onAfterInstall()
    {
    }

    /**
     */
    public function onBeforeUninstall()
    {
    }

    /**
     */
    public function onAfterUninstall()
    {
    }

    /**
     * @return array
     */
    protected function defineSettings()
    {
        return array(
            'notificationEmails' => array(AttributeType::String, 'label' => 'Notification Email Addresses (comma separated)', 'default' => ''),
            'alternativeEmailSubject' => array(AttributeType::String, 'label' => 'If a custom Email Subject needs to be set (otherwise a generic one with the Site name included is used)', 'default' => ''),
        );
    }

    /**
     * @return mixed
     */
    public function getSettingsHtml()
    {
       return craft()->templates->render('updatenotifier/UpdateNotifier_Settings', array(
           'settings' => $this->getSettings()
       ));
    }

    /**
     * @param mixed $settings  The plugin's settings
     *
     * @return mixed
     */
    public function prepSettings($settings)
    {
        // Modify $settings here...

        return $settings;
    }

}