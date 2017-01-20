<?php
namespace SvenJuergens\ExtensionInfo\Utility;

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
use Symfony\Component\DomCrawler\Crawler;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class AskTypo3
{

    public static function forExtensionInfo($extKey)
    {
        $host = 'https://typo3.org';
        $client = new Client();
        $crawler = $client->request(
            'GET',
            'https://typo3.org/extensions/repository/view/' . $extKey
        );

        $nodeValues = $crawler->filter('.ter-ext-info tr')->each(function (Crawler $node, $i) {
            $first = $node->children()->first()->text();
            $firstContent = GeneralUtility::underscoredToLowerCamelCase(str_replace(' ', '_', $first));
            $last = $node->children()->last();
            $lastContent = $last->filter('a')->count() ? $last->getUri() : $last->text();
            return array($firstContent, $lastContent);
        });

        $extensionInfo = [];
        $extensionInfo['name'] = trim($crawler->filter('h1')->text());
        if (is_array($nodeValues)) {
            foreach ($nodeValues as $nodeValue) {
                $extensionInfo[trim($nodeValue[0])] = trim($nodeValue[1]);
            }
        }
        $extensionInfo['download'] = [
            't3x' => $host . $crawler->filter('.ter-ext-single-download a')->first()->attr('href'),
            'zip' => $host . $crawler->filter('.ter-ext-single-download a')->last()->attr('href')
        ];
        $extensionInfo['lastUploadComment'] =
            $crawler->filter('.ter-ext-single-lastUploadComment > p')->html();
        return $extensionInfo;
    }
}