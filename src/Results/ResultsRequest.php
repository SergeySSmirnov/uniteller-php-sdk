<?php
/**
 * Created by Roquie.
 * E-mail: roquie0@gmail.com
 * GitHub: Roquie
 */

namespace Rusproj\Uniteller\Results;

use Rusproj\Uniteller\Http\HttpManagerInterface;
use Rusproj\Uniteller\Order\Order;
use Rusproj\Uniteller\Request\RequestInterface;
use Rusproj\Uniteller;

/**
 * Class ResultsRequest
 *
 * @package Rusproj\Uniteller\Results
 */
class ResultsRequest implements RequestInterface
{
    /**
     * Выполнение запроса к шлюзу.
     *
     * @param \Rusproj\Uniteller\Http\HttpManagerInterface $httpManager
     * @param array $parameters
     * @return mixed
     */
    public function execute(HttpManagerInterface $httpManager, array $parameters = [])
    {
        $response = $httpManager->request('results', 'POST', http_build_query($parameters));
        $xml      = new \SimpleXMLElement($response);

        $array = [];
        foreach ($xml->orders->order as $item) {
            $array[] = (new Order())
                ->setAddress(Uniteller\xml_get($item, 'address'))
                ->setApprovalCode(Uniteller\xml_get($item, 'approvalcode'))
                ->setBankName(Uniteller\xml_get($item, 'bankname'))
                ->setBillNumber(Uniteller\xml_get($item, 'billnumber'))
                ->setBookingcomId(Uniteller\xml_get($item, 'bookingcom_id'))
                ->setBookingcomPincode(Uniteller\xml_get($item, 'bookingcom_pincode'))
                ->setCardIdp(Uniteller\xml_get($item, 'card_idp'))
                ->setCardHolder(Uniteller\xml_get($item, 'cardholder'))
                ->setCardNumber(Uniteller\xml_get($item, 'cardnumber'))
                ->setCardType(Uniteller\xml_get($item, 'cardtype'))
                ->setComment(Uniteller\xml_get($item, 'comment'))
                ->setCurrency(Uniteller\xml_get($item, 'currency'))
                ->setCvc2((bool)Uniteller\xml_get($item, 'cvc2'))
                ->setDate(Uniteller\xml_get($item, 'date'))
                ->setEmail(Uniteller\xml_get($item, 'email'))
                ->setEMoneyType(Uniteller\xml_get($item, 'emoneytype'))
                ->setEOrderData(Uniteller\xml_get($item, 'eorderdata'))
                ->setErrorCode(Uniteller\xml_get($item, 'error_code'))
                ->setErrorComment(Uniteller\xml_get($item, 'error_comment'))
                ->setFirstName(Uniteller\xml_get($item, 'firstname'))
                ->setGdsPaymentPurposeId(Uniteller\xml_get($item, 'gds_payment_purpose_id'))
                ->setIData(Uniteller\xml_get($item, 'idata'))
                ->setIp(Uniteller\xml_get($item, 'ipaddress'))
                ->setLastName(Uniteller\xml_get($item, 'lastname'))
                ->setLoanId(Uniteller\xml_get($item, 'loan_id'))
                ->setMessage(Uniteller\xml_get($item, 'message'))
                ->setMiddleName(Uniteller\xml_get($item, 'middlename'))
                ->setNeedConfirm((bool) Uniteller\xml_get($item, 'need_confirm'))
                ->setOrderNumber(Uniteller\xml_get($item, 'ordernumber'))
                ->setParentOrderNumber(Uniteller\xml_get($item, 'parent_order_number'))
                ->setPaymentType(Uniteller\xml_get($item, 'paymenttype'))
                ->setPhone(Uniteller\xml_get($item, 'phone'))
                ->setPtCode(Uniteller\xml_get($item, 'pt_code'))
                ->setRecommendation(Uniteller\xml_get($item, 'recommendation'))
                ->setResponseCode(Uniteller\xml_get($item, 'response_code'))
                ->setStatus(Uniteller\xml_get($item, 'status'))
                ->setTotal(Uniteller\xml_get($item, 'total'))
                ->setPacketDate(Uniteller\xml_get($item, 'packetdate'))
            ;
        }

        return $array;
    }
}