<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\FiscalCheck;

use Rusproj\Uniteller\ClassConversion\ObjectableInterface;


// TODO: Добавить валидацию полей ИНН и номеров телефонов.


/**
 * Данные агента.
 * Этот блок может отсутствовать целиком
 * (опциональный блок).
 *
 * @package Rusproj\Uniteller\FiscalCheck
 */
class Agent implements ObjectableInterface
{

    /*
     * Импорт метода toObject().
     */
    use \Rusproj\Uniteller\ClassConversion\ObjectableTrait;

    /**
     * Признак агента.
     *
     * @var string
     */
    private $agentattr = '';

    /**
     * Телефон платежного агента.
     *
     * @var string
     */
    private $agentphone = '';

    /**
     * Телефон оператора по приему платежей.
     *
     * @var string
     */
    private $accopphone = '';

    /**
     * Телефон оператора перевода.
     *
     * @var string
     */
    private $opphone = '';

    /**
     * Наименование оператора перевода.
     *
     * @var string
     */
    private $opname = '';

    /**
     * ИНН оператора перевода.
     *
     * @var string
     */
    private $opinn = '';

    /**
     * Адрес оператора перевода.
     *
     * @var string
     */
    private $opaddress = '';

    /**
     * Операция платежного агента.
     *
     * @var string
     */
    private $operation = '';

    /**
     * Наименование поставщика.
     *
     * @var string
     */
    private $suppliername = '';

    /**
     * ИНН поставщика.
     *
     * @var string
     */
    private $supplierinn = '';

    /**
     * Телефон поставщика.
     *
     * @var string
     */
    private $supplierphone = '';

    /**
     * Признак агента.
     *
     * @return string
     */
    public function getAgentattr()
    {
        return $this->agentattr;
    }

    /**
     * Признак агента.
     *
     * @param string $agentattr
     * @return $this
     */
    public function setAgentattr($agentattr)
    {
        $this->agentattr = $agentattr;
        return $this;
    }

    /**
     * Телефон платежного агента.
     *
     * @return string
     */
    public function getAgentphone()
    {
        return $this->agentphone;
    }

    /**
     * Телефон платежного агента.
     *
     * @param string $agentphone
     * @return $this
     */
    public function setAgentphone($agentphone)
    {
        $this->agentphone = $agentphone;
        return $this;
    }

    /**
     * Телефон оператора по приему платежей.
     *
     * @return string
     */
    public function getAccopphone()
    {
        return $this->accopphone;
    }

    /**
     * Телефон оператора по приему платежей.
     *
     * @param string $accopphone
     * @return $this
     */
    public function setAccopphone($accopphone)
    {
        $this->accopphone = $accopphone;
        return $this;
    }

    /**
     * Телефон оператора перевода.
     *
     * @return string
     */
    public function getOpphone()
    {
        return $this->opphone;
    }

    /**
     * Телефон оператора перевода.
     *
     * @param string $opphone
     * @return $this
     */
    public function setOpphone($opphone)
    {
        $this->opphone = $opphone;
        return $this;
    }

    /**
     * Наименование оператора перевода.
     *
     * @return string
     */
    public function getOpname()
    {
        return $this->opname;
    }

    /**
     * Наименование оператора перевода.
     *
     * @param string $opname
     * @return $this
     */
    public function setOpname($opname)
    {
        $this->opname = $opname;
        return $this;
    }

    /**
     * ИНН оператора перевода.
     *
     * @return string
     */
    public function getOpinn()
    {
        return $this->opinn;
    }

    /**
     * ИНН оператора перевода.
     *
     * @param string $opinn
     * @return $this
     */
    public function setOpinn($opinn)
    {
        $this->opinn = $opinn;
        return $this;
    }

    /**
     * Адрес оператора перевода.
     *
     * @return string
     */
    public function getOpaddress()
    {
        return $this->opaddress;
    }

    /**
     * Адрес оператора перевода.
     *
     * @param string $opaddress
     * @return $this
     */
    public function setOpaddress($opaddress)
    {
        $this->opaddress = $opaddress;
        return $this;
    }

    /**
     * Операция платежного агента.
     *
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Операция платежного агента.
     *
     * @param string $operation
     * @return $this
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;
        return $this;
    }

    /**
     * Наименование поставщика.
     *
     * @return string
     */
    public function getSuppliername()
    {
        return $this->suppliername;
    }

    /**
     * Наименование поставщика.
     *
     * @param string $suppliername
     * @return $this
     */
    public function setSuppliername($suppliername)
    {
        $this->suppliername = $suppliername;
        return $this;
    }

    /**
     * ИНН поставщика.
     *
     * @return string
     */
    public function getSupplierinn()
    {
        return $this->supplierinn;
    }

    /**
     * ИНН поставщика.
     *
     * @param string $supplierinn
     * @return $this
     */
    public function setSupplierinn($supplierinn)
    {
        $this->supplierinn = $supplierinn;
        return $this;
    }

    /**
     * Телефон поставщика.
     *
     * @return string
     */
    public function getSupplierphone()
    {
        return $this->supplierphone;
    }

    /**
     * Телефон поставщика.
     *
     * @param string $supplierphone
     * @return $this
     */
    public function setSupplierphone($supplierphone)
    {
        $this->supplierphone = $supplierphone;
        return $this;
    }

}
