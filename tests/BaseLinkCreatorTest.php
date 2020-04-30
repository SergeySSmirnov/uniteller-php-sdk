<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Tests;

use Rusproj\Uniteller\Http\UriInterface;
use Rusproj\Uniteller\Client;
use Rusproj\Uniteller\Http\LinkCreatorInterface;

/**
 * Базовый класс для тестирования Uri-генераторов
 */
abstract class BaseLinkCreatorTest extends TestCase
{
    private $client;

    protected function doTestBaseBananaLink(LinkCreatorInterface $linkCreator, $expected)
    {
        if (is_null($this->client)) {
            $this->client = new Client();
            $this->client->setBaseUri('https://google.com');
        }

        $_baseUri = $this->client->getBaseUri();
        $_results = $linkCreator->create($_baseUri, ['q' => 'banana']);

        $this->assertInstanceOf(UriInterface::class, $_results);
        $this->assertEquals($expected, $_results->getUri());
    }

}
