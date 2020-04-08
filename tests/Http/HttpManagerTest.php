<?php
/**
 * Created by Roquie.
 * E-mail: roquie0@gmail.com
 * GitHub: Roquie
 * Date: 17/05/2017
 */

namespace Rusproj\Uniteller\Tests\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Rusproj\Uniteller\Exception\AuthConfirmIsNotAllowedException;
use Rusproj\Uniteller\Exception\AuthenticationException;
use Rusproj\Uniteller\Exception\UnitellerException;
use Rusproj\Uniteller\Http\HttpManager;
use Rusproj\Uniteller\Request\RequestInterface;
use Rusproj\Uniteller\Tests\TestCase;

class HttpManagerTest extends TestCase
{
    public function testCanBuildRequestToExecute()
    {
        $manager = $this->http([
            new Response(200, [], $this->getStubContents('cancel')),
        ]);

        $this->assertEquals(
            $this->getStubContents('cancel'),
            $manager->request(RequestInterface::REQUEST_CANCEL)
        );
    }

    public function testBehaviorIfServerReturnError()
    {
        $this->expectException(UnitellerException::class);

        $manager = $this->http([
            new RequestException(
                'Error Communicating with Server',
                new Request('GET', 'test'),
                new Response(500)
            )
        ]);

        $manager->request(RequestInterface::REQUEST_CANCEL);
    }

    public function testCreatingExceptionsFromPayloadErrorText()
    {
        $this->expectException(AuthConfirmIsNotAllowedException::class);

        $manager = $this->http([
            new Response(200, [], 'ERROR: Authorization confirm is not allowed')
        ]);

        $manager->request(RequestInterface::REQUEST_CANCEL);
    }

    public function testCreatingExceptionsFromXmlResponse()
    {
        $this->expectException(AuthenticationException::class);

        $manager = $this->http([
            new Response(200, [], $this->getStubContents('error'))
        ]);

        $manager->request(RequestInterface::REQUEST_CANCEL);
    }

    public function testThrownBasicExceptionIfStatusNotIncludedInTheRange()
    {
        $this->expectException(UnitellerException::class);

        $manager = $this->http([new Response(302, [])]);

        $manager->request(RequestInterface::REQUEST_CANCEL);
    }

    /**
     * @param $queue
     * @return \Rusproj\Uniteller\Http\HttpManager
     */
    protected function http($queue)
    {
        $mock = new MockHandler($queue);

        $httpClient = new GuzzleAdapter(new GuzzleClient([
            'handler' => HandlerStack::create($mock)
        ]));

        return new HttpManager($httpClient, [
            'base_uri' => '',
            'shop_id'  => '',
            'login'    => '',
            'password' => '',
        ]);
    }
}