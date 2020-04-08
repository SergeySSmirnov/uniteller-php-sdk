<?php
/**
 * Created by Roquie.
 * E-mail: roquie0@gmail.com
 * GitHub: Roquie
 * Date: 17/05/2017
 */

namespace Rusproj\Uniteller\Tests\Exception;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Rusproj\Uniteller\Exception\AuthConfirmIsNotAllowedException;
use Rusproj\Uniteller\Exception\AuthenticationException;
use Rusproj\Uniteller\Exception\BadFieldFormatException;
use Rusproj\Uniteller\Exception\ErrorException;
use Rusproj\Uniteller\Exception\ExceptionFactory;
use Rusproj\Uniteller\Exception\MandatoryParameterException;
use Rusproj\Uniteller\Exception\NotSupportedSFieldException;
use Rusproj\Uniteller\Exception\OperationFailedException;
use Rusproj\Uniteller\Tests\TestCase;

class ExceptionFactoryTest extends TestCase
{
    /**
     * @return array
     */
    public function provideErrorMessages()
    {
        return [
            [AuthConfirmIsNotAllowedException::class, 'Authorization confirm is not allowed'],
            [AuthenticationException::class, 'Authentication error'],
            [BadFieldFormatException::class, 'Field %fieldName% has bad format'],
            [MandatoryParameterException::class, 'Mandatory parameter \'%fieldName%\' is not present in the request'],
            [MandatoryParameterException::class, 'Mandatory parameter \'%fieldName%\''],
            [NotSupportedSFieldException::class, 'S_FIELDS contains field \'%name%\' which is not allowed'],
            [NotSupportedSFieldException::class, 'S_FIELDS contains field \'%name%\''],
            [OperationFailedException::class, 'The operation failed'],
            [ErrorException::class, null],
        ];
    }

    /**
     * @dataProvider provideErrorMessages
     * @param $e
     * @param $message
     * @throws \ErrorException
     */
    public function testItShouldBeCreateExceptionFromMessage($e, $message)
    {
        $this->expectException($e);

        throw ExceptionFactory::createFromMessage(
            $message,
            $this->createMock(RequestInterface::class),
            $this->createMock(ResponseInterface::class)
        );
    }
}