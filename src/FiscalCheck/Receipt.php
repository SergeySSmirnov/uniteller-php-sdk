<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\FiscalCheck;

use Rusproj\Uniteller\ClassConversion\ObjectableInterface;
use Rusproj\Uniteller\Exception\FieldIncorrectValueException;

/**
 * Чек для фискализации для API v. 2.
 *
 * @package Rusproj\Uniteller\FiscalCheck
 */
class Receipt implements ObjectableInterface, ReceiptInterface
{

    /*
     * Импорт метода toObject().
     */
    use \Rusproj\Uniteller\ClassConversion\ObjectableTrait;

    /**
     * Контакты плательщика для отправки текста фискального чека.
     * Этот блок может отсутствовать целиком, или в нем могут отсутствовать какие-то элементы.
     *
     * @var \Rusproj\Uniteller\FiscalCheck\Customer
     */
    private $customer;

    /**
     * [* Опционально]
     * Блок данных кассира.
     *
     * @var null|\Rusproj\Uniteller\FiscalCheck\Cashier
     */
    private $cashier = null;

    /**
     * Код системы налогообложения.
     *
     * Для указания значения используйте {@see \Rusproj\Uniteller\Enum\TaxModeTypes}.
     *
     * @var integer
     */
    private $taxmode = -1000;

    /**
     * Массив товарных позиций в чеке.
     * Должен содержать хотя бы один элемент.
     * Общая сумма по всем позициям должна быть равна общей сумме чека.
     *
     * @var \Rusproj\Uniteller\FiscalCheck\ProductLine[]
     */
    private $lines = [];

    /**
     * [* Опционально]
     * Опциональный параметр с произвольными данными от мерчанта.
     * Транслируется в неизменном виде во всех фискализированных
     * чеках, созданных в процессе оплаты по данному чеку.
     * Формат: объект произвольной внутренней структуры.
     *
     * @var null|object
     */
    private $optional = null;

    /**
     * [* Опционально]
     * Дополнительные параметры платежа.
     * Этот блок может отсутствовать целиком, или в нем могут отсутствовать какие-то элементы.
     *
     * @var null|object
     */
    private $params = null;

    /**
     * Информации об оплате дополнительными платежными средствами.
     *
     * @var \Rusproj\Uniteller\FiscalCheck\Payment[]
     */
    private $payments = [];

    /**
     * Итоговая сумма чека.
     *
     * @var float
     */
    private $total = 0;

    /**
     * Инициализирует экземпляр класса {@see \Rusproj\Uniteller\Payment\Receipt}.
     */
    public function __construct()
    {
        $this->customer = new Customer();
        $this->lines = [];
    }

    /**
     * Контакты плательщика для отправки текста фискального чека.
     * Этот блок может отсутствовать целиком, или в нем могут отсутствовать какие-то элементы.
     *
     * @return \Rusproj\Uniteller\FiscalCheck\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Контакты плательщика для отправки текста фискального чека.
     * Этот блок может отсутствовать целиком, или в нем могут отсутствовать какие-то элементы.
     *
     * @param \Rusproj\Uniteller\FiscalCheck\Customer $customer
     * @return $this
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * [* Опционально]
     * Блок данных кассира.
     *
     * @return \Rusproj\Uniteller\FiscalCheck\Cashier
     */
    public function getCashier()
    {
        return $this->cashier;
    }

    /**
     * [* Опционально]
     * Блок данных кассира.
     *
     * @param \Rusproj\Uniteller\FiscalCheck\Cashier $cashier
     * @return $this
     */
    public function setCashier($cashier)
    {
        $this->cashier = $cashier;
        return $this;
    }

    /**
     * Код системы налогообложения.
     *
     * Для указания значения используйте {@see \Rusproj\Uniteller\Enum\TaxModeTypes}.
     *
     * @return number
     */
    public function getTaxmode()
    {
        return $this->taxmode;
    }

    /**
     * Код системы налогообложения.
     *
     * Для указания значения используйте {@see \Rusproj\Uniteller\Enum\TaxModeTypes}.
     *
     * @param number $taxmode
     * @return $this
     */
    public function setTaxmode($taxmode)
    {
        $this->taxmode = $taxmode;
        return $this;
    }

    /**
     * Массив товарных позиций в чеке.
     * Должен содержать хотя бы один элемент.
     * Общая сумма по всем позициям должна быть равна общей сумме чека.
     *
     * @return \Rusproj\Uniteller\FiscalCheck\ProductLine[]
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * Массив товарных позиций в чеке.
     * Должен содержать хотя бы один элемент.
     * Общая сумма по всем позициям должна быть равна общей сумме чека.
     *
     * @param \Rusproj\Uniteller\FiscalCheck\ProductLine[] $lines
     * @return $this
     * @throws \Rusproj\Uniteller\Exception\FieldIncorrectValueException Исключение будет сгенерировано в том случае, если значение параметра не является массивом.
     */
    public function setLines($lines)
    {
        if (!is_array($lines)) {
            throw new FieldIncorrectValueException('Значение параметра должно быть массивом элементов ProductLine.');
        }
        $this->lines = $lines;
        return $this;
    }

    /**
     * [* Опционально]
     * Опциональный параметр с произвольными данными от мерчанта.
     * Транслируется в неизменном виде во всех фискализированных
     * чеках, созданных в процессе оплаты по данному чеку.
     * Формат: объект произвольной внутренней структуры.
     *
     * @return object
     */
    public function getOptional()
    {
        return $this->optional;
    }

    /**
     * [* Опционально]
     * Опциональный параметр с произвольными данными от мерчанта.
     * Транслируется в неизменном виде во всех фискализированных
     * чеках, созданных в процессе оплаты по данному чеку.
     * Формат: объект произвольной внутренней структуры.
     *
     * @param object $optional
     * @return $this
     */
    public function setOptional($optional)
    {
        $this->optional = $optional;
        return $this;
    }

    /**
     * [* Опционально]
     * Дополнительные параметры платежа.
     * Этот блок может отсутствовать целиком, или в нем могут отсутствовать какие-то элементы.
     *
     * @return object
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * [* Опционально]
     * Дополнительные параметры платежа.
     * Этот блок может отсутствовать целиком, или в нем могут отсутствовать какие-то элементы.
     *
     * @param object $params
     * @return $this
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * Место расчета.
     *
     * В этом параметре можно указать url одного из сайтов, перечисленных в Личном кабинете налоговой мерчанта.
     * Данное значение будет помещено в свойство {@see $this->getParams}.
     *
     * @return string
     */
    public function getPlace()
    {
        return is_null($this->params) ? null : $this->params->place;
    }

    /**
     * Место расчета.
     *
     * В этом параметре можно указать url одного из сайтов, перечисленных в Личном кабинете налоговой мерчанта.
     * Данное значение будет помещено в свойство {@see $this->getParams}.
     *
     * @param string $place
     * @return $this
     */
    public function setPlace($place)
    {
        $_params = (array)$this->params;
        $_params['place'] = $place;
        $this->params = (object)$_params;
        return $this;
    }

    /**
     * Информации об оплате дополнительными платежными средствами.
     *
     * @return \Rusproj\Uniteller\FiscalCheck\Payment[]
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * Информации об оплате дополнительными платежными средствами.
     *
     * @param \Rusproj\Uniteller\FiscalCheck\Payment[] $payments
     * @return $this
     * @throws \Rusproj\Uniteller\Exception\FieldIncorrectValueException Исключение будет сгенерировано в том случае, если значение параметра не является массивом.
     */
    public function setPayments($payments)
    {
        if (!is_array($payments)) {
            throw new FieldIncorrectValueException('Значение параметра должно быть массивом элементов Payment.');
        }
        $this->payments = $payments;
        return $this;
    }

    /**
     * Итоговая сумма чека.
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Итоговая сумма чека.
     *
     * @param float $total
     * @return $this
     */
    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }

    /**
     * {@inheritDoc}
     * @see \Rusproj\Uniteller\FiscalCheck\ReceiptInterface::generate()
     */
    public function generate()
    {
        return json_encode($this->toObject(), JSON_UNESCAPED_UNICODE);
    }

}
