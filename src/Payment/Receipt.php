<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Tmconsulting\Uniteller\Payment;

use Tmconsulting\Uniteller\ObjectableInterface;

/**
 * Чек для фискализации.
 */
class Receipt implements ReceiptInterface
{

    /**
     * Информация о плательщике.
     *
     * @var \Tmconsulting\Uniteller\Payment\Customer
     */
    private $customer;

    /**
     * Массив товарных позиций в чеке.
     * Должен содержать хотя бы один элемент.
     * Общая сумма по всем позициям должна быть равна общей сумме чека.
     *
     * @var \Tmconsulting\Uniteller\Payment\Product[]
     */
    private $lines;

    /**
     * Опциональный параметр с произвольными данными от мерчанта.
     * Транслируется в неизменном виде во всех фискализированных
     * чеках, созданных в процессе оплаты по данному чеку.
     * Формат: объект произвольной внутренней структуры.
     *
     * @var object
     */
    private $optional;

    /**
     * Дополнительные параметры платежа.
     * Этот блок может отсутствовать целиком, или в нем могут отсутствовать какие-то элементы.
     *
     * @var object
     */
    private $params;

    /**
     * Итоговая сумма чека.
     *
     * @var float
     */
    private $total = 0;

    /**
     * Инициализирует экземпляр класса {@see \Tmconsulting\Uniteller\Payment\Receipt}.
     */
    public function __construct()
    {
        $this->customer = new Customer();
        $this->lines = [];
        $this->optional = (object)[];
        $this->params = (object)[];
    }

    /**
     * Возвращает информацию о плательщике.
     *
     * @return \Tmconsulting\Uniteller\Payment\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Задаёт информацию о плательщике.
     *
     * @param \Tmconsulting\Uniteller\Payment\Customer $customer
     * @return $this
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    /**
     * Возвращает массив товарных позиций в чеке.
     * Должен содержать хотя бы один элемент.
     * Общая сумма по всем позициям должна быть равна общей сумме чека..
     *
     * @return \Tmconsulting\Uniteller\Payment\Product[]
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * Задаёт массив товарных позиций в чеке.
     * Должен содержать хотя бы один элемент.
     * Общая сумма по всем позициям должна быть равна общей сумме чека..
     *
     * @param \Tmconsulting\Uniteller\Payment\Product[] $lines
     * @return $this
     */
    public function setLines($lines)
    {
        $this->lines = $lines;
        return $this;
    }

    /**
     * Возвращает опциональный параметр с произвольными данными от мерчанта.
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
     * Задаёт опциональный параметр с произвольными данными от мерчанта.
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
     * Возвращает дополнительные параметры платежа.
     * Этот блок может отсутствовать целиком, или в нем могут отсутствовать какие-то элементы.
     *
     * @return object
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Задаёт дополнительные параметры платежа.
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
     * Возвращает место расчета.
     *
     * В этом параметре можно указать url одного из сайтов, перечисленных в Личном кабинете налоговой мерчанта.
     * Данное значение будет помещено в свойство {@see $this->getParams}.
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->params->place;
    }

    /**
     * Задаёт есто расчета.
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
     * Возвращает итоговую сумму чека.
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Задаёт итоговую сумму чека.
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
     * @see \Tmconsulting\Uniteller\Payment\ReceiptInterface::generate()
     */
    public function generate()
    {
        $_result = [];

        foreach ($this as $_key => $_val) {
            if (is_object($_val) && (_val instanceof ObjectableInterface)) {
                $_result[] = $_val->toObject();
            }
            else
            {
                $_result[$_key] = $_val;
            }
        }
        return json_encode((object)$_result);
    }

}

