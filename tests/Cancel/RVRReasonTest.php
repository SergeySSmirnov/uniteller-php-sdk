<?php
/**
 * Created by Roquie.
 * E-mail: roquie0@gmail.com
 * GitHub: Roquie
 * Date: 17/05/2017
 */

namespace Rusproj\Uniteller\Tests\Cancel;

use Rusproj\Uniteller\Cancel\RVRReason;
use Rusproj\Uniteller\Tests\TestCase;

class RVRReasonTest extends TestCase
{
    public function testConstValuesEqualsDocumentationValues()
    {
        $this->assertEquals(RVRReason::SHOP, 1);
        $this->assertEquals(RVRReason::CARDHOLDER, 2);
        $this->assertEquals(RVRReason::FRAUD, 3);
    }
}