<?php
namespace SvenJuergens\ExtensionInfo\Controller;

/***
 *
 * This file is part of the "Extension Downloads Calc" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017
 *
 ***/

use Goutte\Client;
use SvenJuergens\ExtensionInfo\Utility\AskTypo3;

/**
 * ExtensionController
 */
class ExtensionInfoController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $test = AskTypo3::forExtensionInfo('disable_beuser');
        $this->view->assign('extensionInfos', $test);
    }
}
