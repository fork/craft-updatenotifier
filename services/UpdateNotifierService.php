<?php
/**
 * Update Notifier plugin for Craft CMS
 *
 * UpdateNotifier Service
 *
 * @author    Fork Unstable Media GmbH
 * @copyright Copyright (c) 2017 Fork Unstable Media GmbH
 * @link      http://fork.de
 * @package   UpdateNotifier
 * @since     1.0.0
 */

namespace Craft;

class UpdateNotifierService extends BaseApplicationComponent
{
    /**
     * checks for updates in core and/or plugins and sends notification mails to email addresses set up in the settings
     */
    public function checkUpdates()
    {
        $settings = craft()->plugins->getPlugin('UpdateNotifier')->getSettings();
        $notificationEmails = preg_split("/[\s,]+/", $settings->getAttribute('notificationEmails'));

        // check if emails are set
        if (empty(reset($notificationEmails))) {
            $error = 'no notifcation email adresses specified!';
            UpdateNotifierPlugin::log($error, LogLevel::Error);
            echo $error;
            craft()->end(1);
        }

        // retrieve updates data
        $updateModel = craft()->updates->getUpdates(true);
        $updates = $updateModel->getAttributes();

        $content = '';

        // core
        $content .= $this->getCoreUpdates($updates);

        // plugins
        $content .= $this->getPluginUpdates($updates);

        // return if no updates available
        if (empty($content)) {
            $info = 'no updates available';
            UpdateNotifierPlugin::log($info, LogLevel::Info);
            echo $info;
            craft()->end();
        }

        // craft renders the content in twig if htmlBody is set. this allows twig expressions in update notes without evaluating them
        $content = '{% verbatim %}' . $content . '{% endverbatim %}';

        // use craft email template
        craft()->templates->setTemplateMode(TemplateMode::CP);
        $template = '_special/email';

        $content = "{% extends '{$template}' %}\n".
            "{% set body %}\n".
            $content.
            "{% endset %}\n";

        $subject = $settings->getAttribute('alternativeEmailSubject') ?: 'Craft Update Notifier ' . craft()->getSiteName();

        foreach ($notificationEmails as $notificationEmail) {
            $mail = new EmailModel();
            $mail->toEmail = $notificationEmail;
            $mail->subject = $subject;
            $mail->htmlBody = $content;

            craft()->email->sendEmail($mail);
        }
    }

    private function getCoreUpdates($updates)
    {
        /** @var AppUpdateModel $core */
        $core = $updates['app'];
        $coreUpdateAvailable = $core->getAttribute('versionUpdateStatus') == VersionUpdateStatus::UpdateAvailable;

        if (!$coreUpdateAvailable) {
            return;
        }

        $content = '<h2>Core</h2>';

        foreach ($core->getAttribute('releases') as $release) {
            $content .= $this->getReleaseHtml($release);
        }

        return $content;
    }

    private function getPluginUpdates($updates)
    {
        $content = '';
        /** @var PluginUpdateModel $update */
        foreach ($updates['plugins'] as $update) {
            $releases = $update->getAttribute('releases');
            if (empty($releases)) {
                continue;
            }

            $content .= '<h3>' . $update->getAttribute('displayName') . '</h3>';

            foreach ($update->getAttribute('releases') as $release) {
                $content .= $this->getReleaseHtml($release);
            }
        }
        if (!empty($content)) {
            return '<h2>Plugins</h2>' . $content;
        }
    }

    private function getReleaseHtml($release) {
        /** @var AppNewReleaseModel $release */
        $content = '';

        $headline = $release->getAttribute('version');
        if ($release->getAttribute('critical')) {
            $headline .= ' | CRITICAL!';
        }
        if ($release->getAttribute('manual')) {
            $headline .= ' | MANUAL UPDATE NEEDED!';
        }
        $content .= '<h3>' . $headline . '</h3>';
        $content .= '<p>' . $release->getAttribute('localizedDate') . '</p>';

        $download = $release->getAttribute('manualDownloadEndpoint');
        if ($download) {
            $content .= "<p><a href=\"$download\" target=\"_blank\">$download</a></p>";
        }

        $content .= $release->getAttribute('notes');

        return $content;
    }
}