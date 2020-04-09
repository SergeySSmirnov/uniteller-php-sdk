<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Tests\FiscalCheck;

use PHPUnit\Framework\TestCase;
use Rusproj\Uniteller\FiscalCheck\ProductLine;
use Rusproj\Uniteller\Exception\FieldIncorrectValueException;
use Rusproj\Uniteller\Enum\CalculationSubjectTypes;
use Rusproj\Uniteller\Enum\CalculationMethodTypes;
use Rusproj\Uniteller\Enum\VatRateTypes;

/**
 * ProductLine test case.
 */
class ProductLineTest extends TestCase
{

    /**
     * @return \Rusproj\Uniteller\FiscalCheck\ProductLine
     */
    public static function getProductLineTestInstance()
    {
        $_productLine = new ProductLine();
        $_productLine
            ->setName('Product Name')
            ->setLineattr(CalculationSubjectTypes::CALC_SUBJECT_12)
            ->setPayattr(CalculationMethodTypes::CALC_METHOD_5)
            ->setPrice('50.04')
            ->setQty('5')
            ->setSum('122.4')
            ->setVat(VatRateTypes::VAT_20_120)
            ->setProduct(AdditionalProductInfoTest::getAdditionalProductInfoTestInstance())
            ->setAgent(AgentTest::getTestAgentInstance());
        return $_productLine;
    }

    public function testWrongValForNameSetter()
    {
        $_name = '';
        for ($_i = 0; $_i < 130; $_i++) {
            $_name .= rand(0, 9);
        }

        $this->expectException(FieldIncorrectValueException::class);
        $_productLine = new ProductLine();
        $_productLine->setName($_name);
    }

    public function testProductLineTestObjectable()
    {
        $_productLine = self::getProductLineTestInstance();

        $_objectableResult = $_productLine->toObject();
        $this->assertTrue($_objectableResult instanceof \stdClass);
        $this->assertTrue(count((array)$_objectableResult) === 9);

        $this->assertObjectHasAttribute('name', $_objectableResult);
        $this->assertTrue($_objectableResult->name === 'Product Name');
        $this->assertObjectHasAttribute('lineattr', $_objectableResult);
        $this->assertTrue($_objectableResult->lineattr === CalculationSubjectTypes::CALC_SUBJECT_12);
        $this->assertObjectHasAttribute('payattr', $_objectableResult);
        $this->assertTrue($_objectableResult->payattr === CalculationMethodTypes::CALC_METHOD_5);
        $this->assertObjectHasAttribute('price', $_objectableResult);
        $this->assertTrue($_objectableResult->price === '50.04');
        $this->assertObjectHasAttribute('qty', $_objectableResult);
        $this->assertTrue($_objectableResult->qty === '5');
        $this->assertObjectHasAttribute('sum', $_objectableResult);
        $this->assertTrue($_objectableResult->sum === '122.4');
        $this->assertObjectHasAttribute('vat', $_objectableResult);
        $this->assertTrue($_objectableResult->vat === VatRateTypes::VAT_20_120);

        $this->assertObjectHasAttribute('product', $_objectableResult);
        $this->assertTrue($_objectableResult->product instanceof  \stdClass);
        $this->assertTrue(count((array)$_objectableResult->product) === 4);

        $this->assertObjectHasAttribute('agent', $_objectableResult);
        $this->assertTrue($_objectableResult->agent instanceof  \stdClass);
        $this->assertTrue(count((array)$_objectableResult->agent) === 11);
    }

}
