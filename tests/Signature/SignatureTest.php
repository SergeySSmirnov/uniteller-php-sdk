<?php
/**
 * Created by Roquie.
 * E-mail: roquie0@gmail.com
 * GitHub: Roquie
 *
 * Modified by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Tests\Signature;

use Rusproj\Uniteller\Signature\SignatureCallback;
use Rusproj\Uniteller\Signature\SignatureRecurrent;
use Rusproj\Uniteller\Tests\TestCase;
use Rusproj\Uniteller\Signature\SignatureHandler;
use Rusproj\Uniteller\Tests\Payment\FiscaliationPaymentBuilderTest;
use Rusproj\Uniteller\Payment\PaymentBuilder;
use Rusproj\Uniteller\Enum\CurrencyTypes;

class SignatureTest extends TestCase
{

    public function testSignatureHandlerForFiscaliationPaymentBuilder()
    {
        $_signatureHandler = new SignatureHandler();
        $_keys = $_signatureHandler->sign(FiscaliationPaymentBuilderTest::createFiscaliationPaymentBuilderTestInstance(), 'Some passwd');

        $this->assertTrue(is_array($_keys));
        $this->assertArrayHasKey('Receipt', $_keys);
        $this->assertArrayHasKey('ReceiptSignature', $_keys);
        $this->assertArrayHasKey('Shop_IDP', $_keys);
        $this->assertArrayHasKey('Order_IDP', $_keys);
        $this->assertArrayHasKey('Subtotal_P', $_keys);
        $this->assertArrayHasKey('Signature', $_keys);
        $this->assertArrayHasKey('URL_RETURN_OK', $_keys);
        $this->assertArrayHasKey('URL_RETURN_NO', $_keys);
        $this->assertArrayHasKey('Currency', $_keys);
        $this->assertArrayHasKey('IsRecurrentStart', $_keys);
        $this->assertTrue($_keys['Receipt'] === 'eyJjdXN0b21lciI6eyJwaG9uZSI6Iis3MTIzNDU2Nzg5MCIsImVtYWlsIjoidGVzdEB0ZXN0LnR0IiwiaWQiOjEyMzQ1LCJuYW1lIjoiQ2xpZW50IiwiaW5uIjoiMTIzNDU2Nzg5MDEyIn0sImNhc2hpZXIiOnsibmFtZSI6IkNhc2hpZXIiLCJpbm4iOiIxMjM0NTY3ODkwMTIifSwidGF4bW9kZSI6MCwibGluZXMiOlt7Im5hbWUiOiJQcm9kdWN0IE5hbWUiLCJwcmljZSI6IjUwLjA0IiwicXR5IjoiNSIsInN1bSI6IjEyMi40IiwidmF0IjoxMjAsInBheWF0dHIiOjUsImxpbmVhdHRyIjoxMiwicHJvZHVjdCI6eyJrdCI6IlJVIiwiZXhjIjoi0JDQutGG0LjQtyIsImNvYyI6ItCa0L7QtCDRgtC+0LLQsNGA0LAiLCJuY2QiOiIxMjM0NTYifSwiYWdlbnQiOnsiYWdlbnRhdHRyIjoiQUdFTlRfQVRUUiIsImFnZW50cGhvbmUiOiIrNDU2Nzg5MTMyMCIsImFjY29wcGhvbmUiOiIrMTIzNDY1Nzg5MCIsIm9wcGhvbmUiOiJPUF9IT01FIiwib3BuYW1lIjoiT1BfTkFNRSIsIm9waW5uIjoiMTIzNDU2Nzg5MDEiLCJvcGFkZHJlc3MiOiJTb21ld2hlcmUiLCJvcGVyYXRpb24iOiJBYmNkIiwic3VwcGxpZXJuYW1lIjoiU1VQX05BTUUiLCJzdXBwbGllcmlubiI6IjA5ODc2NTQzMjEwOSIsInN1cHBsaWVycGhvbmUiOiIrNjc4OTA0MzE2NSJ9fSx7Im5hbWUiOiJQcm9kdWN0IE5hbWUiLCJwcmljZSI6IjUwLjA0IiwicXR5IjoiNSIsInN1bSI6IjEyMi40IiwidmF0IjoxMjAsInBheWF0dHIiOjUsImxpbmVhdHRyIjoxMiwicHJvZHVjdCI6eyJrdCI6IlJVIiwiZXhjIjoi0JDQutGG0LjQtyIsImNvYyI6ItCa0L7QtCDRgtC+0LLQsNGA0LAiLCJuY2QiOiIxMjM0NTYifSwiYWdlbnQiOnsiYWdlbnRhdHRyIjoiQUdFTlRfQVRUUiIsImFnZW50cGhvbmUiOiIrNDU2Nzg5MTMyMCIsImFjY29wcGhvbmUiOiIrMTIzNDY1Nzg5MCIsIm9wcGhvbmUiOiJPUF9IT01FIiwib3BuYW1lIjoiT1BfTkFNRSIsIm9waW5uIjoiMTIzNDU2Nzg5MDEiLCJvcGFkZHJlc3MiOiJTb21ld2hlcmUiLCJvcGVyYXRpb24iOiJBYmNkIiwic3VwcGxpZXJuYW1lIjoiU1VQX05BTUUiLCJzdXBwbGllcmlubiI6IjA5ODc2NTQzMjEwOSIsInN1cHBsaWVycGhvbmUiOiIrNjc4OTA0MzE2NSJ9fV0sIm9wdGlvbmFsIjp7InZhbCI6IlNvbWUgbWVyY2hhbnQgZGF0YSJ9LCJwYXJhbXMiOnsicGxhY2UiOiJJVkEifSwicGF5bWVudHMiOlt7ImtpbmQiOjEsInR5cGUiOjQsImlkIjoiMDAzNTQ2NCIsImFtb3VudCI6IjE1Mi42NSJ9XSwidG90YWwiOiI5OC4zMiJ9');
        $this->assertTrue($_keys['ReceiptSignature'] === '9E9BEAC5318A56D011C3F66BC8E05B0CF94325A2B2B360678948F069766F8633');
        $this->assertTrue($_keys['Shop_IDP'] === '012345-67890');
        $this->assertTrue($_keys['Order_IDP'] === '12345');
        $this->assertTrue($_keys['Subtotal_P'] === '100.30');
        $this->assertTrue($_keys['Signature'] === '7F7D0EB7F1CBA8485AF1EC4FF7B1CA2C');
        $this->assertTrue($_keys['URL_RETURN_OK'] === 'http://mysite.com/success');
        $this->assertTrue($_keys['URL_RETURN_NO'] === 'http://mysite.com/error');
        $this->assertTrue($_keys['Currency'] === 'RUB');
        $this->assertTrue($_keys['IsRecurrentStart'] === '');
    }

    public function testSignatureHandlerForPaymentBuilder()
    {
        $_builder = new PaymentBuilder();
        $_builder
            ->setCurrency(CurrencyTypes::RUB)
            ->setOrderIdp('FOO')
            ->setShopIdp('ACME')
            ->setSubtotalP('100')
            ->setLifetime('300')
            ->setCustomerIdp('short_shop_string')
            ->setUrlReturnOk('http://mysite.com/success')
            ->setUrlReturnNo('http://mysite.com/error');

        $_signatureHandler = new SignatureHandler();
        $_keys = $_signatureHandler->sign($_builder, 'LONG-PWD');

        $this->assertTrue(is_array($_keys));

        $this->assertArrayHasKey('Signature', $_keys);
        $this->assertTrue($_keys['Signature'] === '3D1D6F830384886A81AD672F66392B03');

        $this->assertArrayHasKey('Shop_IDP', $_keys);
        $this->assertArrayHasKey('Customer_IDP', $_keys);
        $this->assertArrayHasKey('Order_IDP', $_keys);
        $this->assertArrayHasKey('Subtotal_P', $_keys);
        $this->assertArrayHasKey('Lifetime', $_keys);
        $this->assertArrayHasKey('URL_RETURN_OK', $_keys);
        $this->assertArrayHasKey('URL_RETURN_NO', $_keys);
        $this->assertArrayHasKey('Currency', $_keys);
        $this->assertArrayHasKey('IsRecurrentStart', $_keys);
        $this->assertTrue($_keys['Shop_IDP'] === 'ACME');
        $this->assertTrue($_keys['Customer_IDP'] === 'short_shop_string');
        $this->assertTrue($_keys['Order_IDP'] === 'FOO');
        $this->assertTrue($_keys['Subtotal_P'] === '100');
        $this->assertTrue($_keys['Lifetime'] === '300');
        $this->assertTrue($_keys['URL_RETURN_OK'] === 'http://mysite.com/success');
        $this->assertTrue($_keys['URL_RETURN_NO'] === 'http://mysite.com/error');
        $this->assertTrue($_keys['Currency'] === 'RUB');
        $this->assertTrue($_keys['IsRecurrentStart'] === '');
    }

    public function testRecurrentSignatureCreation()
    {
        $sig = (new SignatureRecurrent())
            ->setShopIdp('ACME')
            ->setOrderIdp('FOO')
            ->setSubtotalP(100)
            ->setParentOrderIdp('BAR')
            ->setPassword('LONG-PWD')
            ->create();

        $this->assertSame('A5FE1C95A2819EBACFC2145EE83742F6', $sig);
    }

    public function testCallbackSignatureCreation()
    {
        $sig = (new SignatureCallback())
            ->setOrderId('FOO')
            ->setStatus('paid')
            ->setPassword('LONG-PWD')
            ->create();

        $this->assertSame('3F728AA479E50F5B10EE6C20258BFF88', $sig);
    }

    public function testCallbackSignatureCreationWithFields()
    {
        $sig = (new SignatureCallback())
            ->setOrderId('FOO')
            ->setStatus('paid')
            ->setFields([
                'AcquirerID'   => 'fOO',
                'ApprovalCode' => 'BaR',
                'BillNumber'   => 'baz',
            ])
            ->setPassword('LONG-PWD')
            ->create();

        $this->assertSame('1F4E3B63AE408D0BE1E33965E6697236', $sig);
    }

    public function testRecurrentSignatureVerifying()
    {
        $sig = (new SignatureRecurrent())
            ->setShopIdp('ACME')
            ->setOrderIdp('FOO')
            ->setSubtotalP(100)
            ->setParentOrderIdp('BAR')
            ->setPassword('LONG-PWD');

        $this->assertTrue($sig->verify('A5FE1C95A2819EBACFC2145EE83742F6'));
    }

    public function testCallbackSignatureVerifying()
    {
        $sig = (new SignatureCallback())
            ->setOrderId('FOO')
            ->setStatus('paid')
            ->setPassword('LONG-PWD');

        $this->assertTrue($sig->verify('3F728AA479E50F5B10EE6C20258BFF88'));
    }

    public function testCallbackSignatureVerifyingWithFields()
    {
        $sig = (new SignatureCallback())
            ->setOrderId('FOO')
            ->setStatus('paid')
            ->setFields([
                'AcquirerID'   => 'fOO',
                'ApprovalCode' => 'BaR',
                'BillNumber'   => 'baz',
            ])
            ->setPassword('LONG-PWD');

        $this->assertTrue($sig->verify('1F4E3B63AE408D0BE1E33965E6697236'));
    }
}