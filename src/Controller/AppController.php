<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/5/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');

        // Load the Recaptcha component with the required configuration
        $this->loadComponent('Recaptcha.Recaptcha', [
            'enable' => true,
            'sitekey' => '6LcJWf8qAAAAANpSKxeAZsKTjpBc8Pne7J6k3HXn',
            'secret' => '6LcJWf8qAAAAACY_L4rx244YAMJW2aaNtFxjkXDR',
            'type' => 'image',
            'theme' => 'light',
            'lang' => 'en',
            'size' => 'normal',
            'callback' => null,
            'scriptBlock' => true,
        ]);

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/5/en/controllers/components/form-protection.html
         */
        $this->loadComponent('FormProtection');

        $this->loadComponent('Authentication.Authentication');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        // Skip age verification for AJAX requests
        if ($this->request->is('ajax')) {
            return;
        }

        $session = $this->request->getSession();

        if ($this->request->is('post') && $this->request->getData('age_confirmed')) {
            $ageConfirmed = $this->request->getData('age_confirmed');
            if ($ageConfirmed === 'yes') {
                $session->write('age_verified', true);
                return $this->redirect($this->request->getRequestTarget());
            } else {
                $this->set('ageRestricted', true);
            }
        }

        if (!$session->read('age_verified')) {
            $this->set('showAgePopup', true);
        } else {
            $this->set('showAgePopup', false);
        }
    }
}
