<?php
namespace SvenJuergens\ExtensionInfo\Controller;

/***
 *
 * This file is part of the "Extension Info" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017
 *
 ***/

use SvenJuergens\ExtensionInfo\Utility\AskTypo3Org;

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
                $info = AskTypo3Org::forExtensionInfo($extKey);
                if ($info !== null) {
                    $extensionInfos[] = $info;
                }
            }
        }
        $this->view->assign('extensionInfos', $extensionInfos);
    }
}
