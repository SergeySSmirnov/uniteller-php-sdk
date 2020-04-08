<?php
/**
 * Created by Roquie.
 * E-mail: roquie0@gmail.com
 * GitHub: Roquie
 * Date: 17/05/2017
 */

namespace Rusproj\Uniteller\Tests\Cancel;

use Rusproj\Uniteller\Cancel\CancelBuilder;
use Rusproj\Uniteller\Cancel\RVRReason;
use Rusproj\Uniteller\Tests\TestCase;

class CancelBuilderTest extends TestCase
{
    public function testBuildObject()
    {
        $builder = new CancelBuilder();
        $builder->setBillNumber(1);
        $builder->setCurrency('RUB');
        $builder->setRvrReason(RVRReason::SHOP);
        $builder->setSelectFields([]);
        $builder->setSubtotalP(10);

        $expected = [
            'Billnumber' => 1,
            'Subtotal_P' => 10,
            'Currency'   => 'RUB',
            'RVRReason'  => RVRReason::SHOP,
            'S_FIELDS'   => []
        ];

        $this->assertEquals($expected, $builder->toArray());
    }
}