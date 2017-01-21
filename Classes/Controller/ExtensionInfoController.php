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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * ExtensionController
 */
class ExtensionInfoController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    public function initializeListAction()
    {
        if (isset($this->settings['extKeys'])) {
            $this->settings['extKeys'] = explode(PHP_EOL, $this->settings['extKeys']);
        }
    }

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $extensionInfos = [];
        if (is_array($this->settings['extKeys'])) {
            foreach ($this->settings['extKeys'] as $extKey) {
                $extensionInfos[] = AskTypo3::forExtensionInfo($extKey);
            }
        }
        $this->view->assign('extensionInfos', $extensionInfos);
    }
}
