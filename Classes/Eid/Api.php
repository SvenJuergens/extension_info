<?php
namespace SvenJuergens\ExtensionInfo\Eid;

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

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SvenJuergens\ExtensionInfo\Utility\AskTypo3Org;

class Api
{
    /**
     * TYPO3 Infos from:
     * https://www.typo3lexikon.de/typo3-tutorials/ajax/eid-beispiele.html
     *
     * ResponseInterface
     * https://www.slimframework.com/docs/objects/response.html
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function processRequest(ServerRequestInterface $request, ResponseInterface $response)
    {
        $extKey = $request->getQueryParams()['key'];
        $newResponse = $response->withHeader('Content-type', 'application/json');
        $newResponse->getBody()->write(json_encode(AskTypo3Org::forExtensionInfo($extKey)));
        return $newResponse;
    }
}