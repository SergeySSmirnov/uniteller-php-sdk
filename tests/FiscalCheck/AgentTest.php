<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\Tests\FiscalCheck;

use PHPUnit\Framework\TestCase;
use Rusproj\Uniteller\FiscalCheck\Agent;

/**
 * Agent test case.
 */
class AgentTest extends TestCase
{

    /**
     * @return \Rusproj\Uniteller\FiscalCheck\Agent
     */
    public static function createTestAgentInstance()
    {
        $_agent = new Agent();
        $_agent
            ->setAccopphone('+1234657890')
            ->setAgentattr('AGENT_ATTR')
            ->setAgentphone('+4567891320')
            ->setOpaddress('Somewhere')
            ->setOperation('Abcd')
            ->setOpinn('12345678901')
            ->setOpname('OP_NAME')
            ->setOpphone('OP_HOME')
            ->setSupplierinn('098765432109')
            ->setSuppliername('SUP_NAME')
            ->setSupplierphone('+6789043165');
        return $_agent;
    }

    public function testAgentObjectable()
    {
        $_agent = self::createTestAgentInstance();

        $_objectableResult = $_agent->toObject();
        $this->assertInstanceOf(\stdClass::class, $_objectableResult);
        $this->assertTrue(count((array)$_objectableResult) === 11);

        $this->assertObjectHasAttribute('accopphone', $_objectableResult);
        $this->assertTrue($_objectableResult->accopphone === '+1234657890');
        $this->assertObjectHasAttribute('agentattr', $_objectableResult);
        $this->assertTrue($_objectableResult->agentattr === 'AGENT_ATTR');
        $this->assertObjectHasAttribute('agentphone', $_objectableResult);
        $this->assertTrue($_objectableResult->agentphone === '+4567891320');
        $this->assertObjectHasAttribute('opaddress', $_objectableResult);
        $this->assertTrue($_objectableResult->opaddress === 'Somewhere');
        $this->assertObjectHasAttribute('operation', $_objectableResult);
        $this->assertTrue($_objectableResult->operation === 'Abcd');
        $this->assertObjectHasAttribute('opinn', $_objectableResult);
        $this->assertTrue($_objectableResult->opinn === '12345678901');
        $this->assertObjectHasAttribute('opname', $_objectableResult);
        $this->assertTrue($_objectableResult->opname === 'OP_NAME');
        $this->assertObjectHasAttribute('opphone', $_objectableResult);
        $this->assertTrue($_objectableResult->opphone === 'OP_HOME');
        $this->assertObjectHasAttribute('supplierinn', $_objectableResult);
        $this->assertTrue($_objectableResult->supplierinn === '098765432109');
        $this->assertObjectHasAttribute('suppliername', $_objectableResult);
        $this->assertTrue($_objectableResult->suppliername === 'SUP_NAME');
        $this->assertObjectHasAttribute('supplierphone', $_objectableResult);
        $this->assertTrue($_objectableResult->supplierphone === '+6789043165');
    }

}
