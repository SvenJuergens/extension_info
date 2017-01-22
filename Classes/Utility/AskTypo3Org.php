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
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class AskTypo3Org
{

    public static function forExtensionInfo($extKey)
    {
        $cacheManager = GeneralUtility::makeInstance(CacheManager::class)->getCache('extension_info');
        $entry  = $cacheManager->get(sha1($extKey));
        if ($entry !== false) {
            return $entry;
        }

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

            if ($firstContent == 'dependencies') {
                $lastContent = $last->filter('li')->each(function (Crawler $node, $i) {
                    return $node->text();
                });
            } else {
                $lastContent = $last->filter('a')->count() ? $last->filter('a')->attr('href') : $last->text();
            }
            return array($firstContent, $lastContent);
        });

        $extensionInfo = [];
        $extensionInfo['name'] = trim($crawler->filter('h1')->text());
        if (is_array($nodeValues)) {
            foreach ($nodeValues as $nodeValue) {
                if (is_array($nodeValue[1])) {
                    $extensionInfo[trim($nodeValue[0])] = array_map('trim', $nodeValue[1]);
                } else {
                    $extensionInfo[trim($nodeValue[0])] = trim($nodeValue[1]);
                }
            }
        }

        $extensionInfo['t3x'] = $host . $crawler->filter('.ter-ext-single-download a')->first()->attr('href');
        $extensionInfo['zip'] = $host . $crawler->filter('.ter-ext-single-download a')->last()->attr('href');

        $extensionInfo['lastUploadComment'] =
            $crawler->filter('.ter-ext-single-lastUploadComment > p')->html();

        if (!empty($extensionInfo['name'])) {
            $cacheManager->set(sha1($extKey), $extensionInfo, ['extension_info'], 86400);
        }
        return $extensionInfo;
    }
}