<?php
/**
 * Created by Sergey S. Smirnov
 * E-mail: sergeyssmirnov@mail.ru
 * Github: SergeySSmirnov
 */

namespace Rusproj\Uniteller\FiscalCheck;

use Rusproj\Uniteller\ClassConversion\ObjectableInterface;

/**
 * Дополнительные сведения о продукте.
 * Этот блок может отсутствовать целиком
 * (опциональный блок).
 *
 * @package Rusproj\Uniteller\FiscalCheck
 */
class AdditionalProductInfo implements ObjectableInterface
{

    /*
     * Импорт метода toObject().
     */
    use \Rusproj\Uniteller\ClassConversion\ObjectableTrait;

    /**
     * Код товара.
     *
     * @var string
     */
    private $kt = '';

    /**
     * Акциз.
     *
     * @var string
     */
    private $exc = '';

    /**
     * Код страны происхождения товара.
     *
     * @var string
     */
    private $coc = '';

    /**
     * Номер таможенной декларации.
     *
     * @var string
     */
    private $ncd = '';

    /**
     * Код товара.
     *
     * @return string
     */
    public function getKt()
    {
        return $this->kt;
    }

    /**
     * Код товара.
     *
     * @param string $kt
     * @return $this
     */
    public function setKt($kt)
    {
        $this->kt = $kt;
        return $this;
    }

    /**
     * Акциз.
     *
     * @return string
     */
    public function getExc()
    {
        return $this->exc;
    }

    /**
     * Акциз.
     *
     * @param string $exc
     * @return $this
     */
    public function setExc($exc)
    {
        $this->exc = $exc;
        return $this;
    }

    /**
     * Код страны происхождения товара.
     *
     * @return string
     */
    public function getCoc()
    {
        return $this->coc;
    }

    /**
     * Код страны происхождения товара.
     *
     * @param string $coc
     * @return $this
     */
    public function setCoc($coc)
    {
        $this->coc = $coc;
        return $this;
    }

    /**
     * Номер таможенной декларации.
     *
     * @return string
     */
    public function getNcd()
    {
        return $this->ncd;
    }

    /**
     * Номер таможенной декларации.
     *
     * @param string $ncd
     * @return $this
     */
    public function setNcd($ncd)
    {
        $this->ncd = $ncd;
        return $this;
    }

}

