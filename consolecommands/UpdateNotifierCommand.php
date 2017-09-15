<?php
/**
 * Update Notifier plugin for Craft CMS
 *
 * UpdateNotifier Command
 *
 * @author    Fork Unstable Media GmbH
 * @copyright Copyright (c) 2017 Fork Unstable Media GmbH
 * @link      http://fork.de
 * @package   UpdateNotifier
 * @since     1.0.0
 */

namespace Craft;

class UpdateNotifierCommand extends BaseCommand
{
    /**
     */
    public function actionCheck()
    {
        // emulate env
        $_SERVER['HTTP_HOST']       = 'craft.local';
        $_SERVER['REQUEST_URI']     = '/';
        $_SERVER['HTTP_USER_AGENT'] = 'Craft/'.craft()->getVersion();
        $_SERVER['REMOTE_ADDR']     = 1;

        // emulate session methods (e.g. used in site/craft/app/etc/et/Et.php phoneHome() method)
        craft()->attachBehavior('session', UpdateNotifierSessionBehaviour::class);

        // call update service method
        craft()->updateNotifier->checkUpdates();
    }
}

class UpdateNotifierSessionBehaviour extends BaseBehavior
{
    public function open() {}
    public function close() {}
}