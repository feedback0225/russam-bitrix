<?php
//require($_SERVER["DOCUMENT_ROOT"] . "/local/vendor/autoload.php");
require($_SERVER["DOCUMENT_ROOT"] . "/local/lib/autoload.php");

use App\Bitrix24\Bitrix24API;
use App\Bitrix24\Bitrix24APIException;
use Bitrix\Sale\Order;

class Bitrix24CustomApi
{
    function __construct()
    {
//        $this->webhookURL = '';
        $this->webURL = 'https://russam.bitrix24.ru/rest/';
        $this->keyApi = '1/rgv8t2cgwgx3cj6p/';
        $this->webhookURL  = $this->webURL.$this->keyApi;
    }

    public function updateMarketOrderB24(){
        CModule::IncludeModule('sale');
        // Получаем список заказов по которым есть тип площадки
        $orderFilter = array(
            '>ID' => 303,
            'PROP_EXTERNAL_STATUS' => false,
            '!PROP_MARKET_TYPE' => false,
        );
        $order_list = [];
        $params = array(
            'filter' => $orderFilter,
            'select' => array(
                'ID',
                'XML_ID',
                'ACCOUNT_NUMBER',
                'DATE_INSERT',
                'STATUS_ID',
                'PROP_EXTERNAL_STATUS' => 'EXTERNAL_STATUS.VALUE',
                'PROP_MARKET_TYPE' => 'MARKET_TYPE.VALUE',
            ),
            'order' => ['ID' => 'DESC']
            //  'limit' => 200
        );
        $params['runtime'] = array(
            new \Bitrix\Main\Entity\ReferenceField(
                'EXTERNAL_STATUS',
                '\Bitrix\Sale\Internals\OrderPropsValueTable',
                array(
                    '=this.ID' => 'ref.ORDER_ID',
                    '=ref.CODE' => new \Bitrix\Main\DB\SqlExpression('?s', 'EXTERNAL_STATUS')
                )
            ),
            new \Bitrix\Main\Entity\ReferenceField(
                'MARKET_TYPE',
                '\Bitrix\Sale\Internals\OrderPropsValueTable',
                array(
                    '=this.ID' => 'ref.ORDER_ID',
                    '=ref.CODE' => new \Bitrix\Main\DB\SqlExpression('?s', 'MARKET_TYPE')
                )
            ),
        );
        $rs = \Bitrix\Sale\Internals\OrderTable::getList($params);

        while ($findOrder = $rs->fetch()) {
            $order_list[] = $findOrder['ID'];
        }
//        print_r('<pre>');
//        print_r($order_list);
//        print_r("</pre>\n");
//        die();

        if (!empty($order_list)) {
            foreach ($order_list as $id_order) {
                $this->updateMarketInfoDealList($id_order);
            }
        }
    }
    public function findSendUpdateB24()
    {
        CModule::IncludeModule('sale');
        // Получаем список заказов по которым не отправляли UTM метки
        $orderFilter = array(
            'ID' => 135,
//            'PROP_B24_ID' => false,
        );
        $order_list = [];
        $params = array(
            'filter' => $orderFilter,
            'select' => array(
                'ID',
                'XML_ID',
                'ACCOUNT_NUMBER',
                'DATE_INSERT',
                'STATUS_ID',
                'PAYED',
                'CANCELED',
                'PAY_SYSTEM_ID',
                'PROP_B24_STATUS' => 'B24_STATUS.VALUE',
//                'PROP_UTM_S' => 'utm_source.VALUE',
            ),
            'order' => ['ID' => 'DESC']
            //  'limit' => 200
        );
        $params['runtime'] = array(
            new \Bitrix\Main\Entity\ReferenceField(
                'B24_STATUS',
                '\Bitrix\Sale\Internals\OrderPropsValueTable',
                array(
                    '=this.ID' => 'ref.ORDER_ID',
                    '=ref.CODE' => new \Bitrix\Main\DB\SqlExpression('?s', 'B24_STATUS')
                )
            ),
        );
        $rs = \Bitrix\Sale\Internals\OrderTable::getList($params);

        while ($findOrder = $rs->fetch()) {
            $order_list[] = $findOrder['ID'];
        }


        if (!empty($order_list)) {
            foreach ($order_list as $id_order) {
                $this->updateUTMtagDealList($id_order);
            }
        }
    }

    public function updateMarketInfoDealList($id_order){
        try {

            $bx24 = new Bitrix24API($this->webhookURL);
            $update_prop = [
                'MARKET_TYPE' => 'UF_CRM_1647997591103',
                'DATE_PLAN' => 'UF_CRM_1647997718938',
                'MARKET_BARCODE' => 'UF_CRM_1647997739488',
                'MARKET_LABEL' => 'UF_CRM_1647997759319',
            ];
            $SOURCE_ID_val = [
                'OZON' => '72',
            ];

            // Загружаем все сделки используя быстрый метод при работе с большими объемами данных
            //array $filter = [], array $select = [], array $order = []
            $generator = $bx24->fetchDealList(
                [
                    'ORIGIN_ID' => $id_order
                ],
                [],
                []
            );

            $find_deal = [];
            foreach ($generator as $deals) {
                foreach ($deals as $deal) {
                    if ($id_order == $deal['ORIGIN_ID']) {
                        $find_deal = $deal;
                    }
                }
            }

            if (!empty($find_deal)) {
                // Обновляем свойства
                $update_data_deal = [];
                $update_data_deal_file = [];
                $order = \Bitrix\Sale\Order::load($id_order);
                $propertyCollection = $order->getPropertyCollection();
                foreach ($propertyCollection as $propertyItem) {
                    $code_order = $propertyItem->getField("CODE");
                    if (!empty($update_prop[$code_order])) {
                        // Ищем данные в куках
                        $valueMeta = $propertyItem->getField("VALUE");

                        if (!empty($valueMeta)) {
                            if($code_order == 'MARKET_LABEL'){
                                $update_data_deal_file[$update_prop[$code_order]] = $valueMeta;
                            } elseif($code_order == 'MARKET_TYPE') {
                                $update_data_deal[$update_prop[$code_order]] = $valueMeta;
                                // Плюс другие 2 свойства ИСТОЧНИК
                                $update_data_deal['SOURCE_ID'] = $SOURCE_ID_val[$valueMeta];
                                $update_data_deal['UF_CRM_1611585862'] = $SOURCE_ID_val[$valueMeta];
                            } else {
                                $update_data_deal[$update_prop[$code_order]] = $valueMeta;
                            }
                        }
                    }
                }

                if (!empty($update_data_deal)) {
                    // Обновляем существующую сделку
                    $res_update = $bx24->updateDeal($find_deal['ID'], $update_data_deal);
                    if(!empty($update_data_deal_file)){
                        foreach ($update_data_deal_file as $userFieldId => $fileContent){
                            $send_file = base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'] .$fileContent['SRC']));
                            $res_update = $bx24->setDealFile($find_deal['ID'], $userFieldId, $fileContent['ORIGINAL_NAME'], $send_file, true );

                        }
                    }
                    if ($res_update != 1) {
                        AddMessage2Log('Обновления МЕТА данных в Б24 у заказа - ' . $id_order, "sale");
                        AddMessage2Log($update_data_deal, "sale");
                    } else {
                        $propertyCollection = $order->getPropertyCollection();
                        foreach ($propertyCollection as $propertyItem) {
                            $code_order = $propertyItem->getField("CODE");
                            if ($code_order == 'EXTERNAL_STATUS') {
                                // Ищем данные в куках
                                $propertyItem->setValue('N'); // Заказ отправлен
                            }
                        }
                        $order->save();
                    }
                }
            }
        } catch (Bitrix24APIException $e) {
            AddMessage2Log($e->getMessage(), "sale");
//            printf('Ошибка 1 (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
        } catch (Exception $e) {
            AddMessage2Log($e->getMessage(), "sale");
//            printf('Ошибка 2 (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
        }
    }
    public function updateUTMtagDealList($id_order)
    {

        try {

            $bx24 = new Bitrix24API($this->webhookURL);

            $update_prop = [
                'UF_CRM_1645997353551' => [
                    'CODE' => 'PAYED',
                    'TYPE' => 'list',
                    'VALUE' => [
                        'Y' => '375',
                        'N' => '377',
                    ],
                ],
                'STAGE_ID' => [
                    'CODE' => 'STATUS_ID',
                    'TYPE' => 'list',
                    'VALUE' => [
                        'N' => 'C19:NEW', // Новая
                        'P' => 'C19:EXECUTING', // Оплата прошла - В работе
                        'C' => 'C19:LOSE', // Заказ отменен - Сделка провалена
                    ],
                ],
//                'utm_source' => 'UTM_SOURCE',
//                'utm_medium' => 'UTM_MEDIUM',
//                'utm_campaign' => 'UTM_CAMPAIGN',
//                'utm_content' => 'UTM_CONTENT',
//                'utm_term' => 'UTM_TERM',
            ];

            // Загружаем все сделки используя быстрый метод при работе с большими объемами данных
            //array $filter = [], array $select = [], array $order = []
            $generator = $bx24->fetchDealList(
                [
//                    'ORIGIN_ID' => $id_order
                    'ID' => 137685 // 135
                ],
                [],
                []
            );

            $find_deal = [];
            foreach ($generator as $deals) {
                foreach ($deals as $deal) {
                    if (true || $id_order == $deal['ORIGIN_ID']) {
                        $find_deal = $deal;
                    }
                }
            }


            if (!empty($find_deal)) {

                // Обновляем свойства
                $update_data_deal = [];
                $order = \Bitrix\Sale\Order::load($id_order);
                $propertyCollection = $order->getPropertyCollection();

                foreach ($update_prop as $code_prop => $prop_data){
                    switch ($prop_data['CODE']){
                        case 'STATUS_ID':
                            $cur_val = $order->getField('STATUS_ID');

                            if(is_array($prop_data['VALUE'])){
                                if(!empty($prop_data['VALUE'][$cur_val])){
                                    $update_data_deal[$code_prop] = $prop_data['VALUE'][$cur_val];
                                }
                            }
                            break;
                        case 'PAYED':
                            $cur_val = $order->isPaid();
                            if($cur_val){
                                $cur_val = 'Y';
                            } else {
                                $cur_val = 'N';
                            }


                            if(is_array($prop_data['VALUE'])){
                               if(!empty($prop_data['VALUE'][$cur_val])){
                                   $update_data_deal[$code_prop] = $prop_data['VALUE'][$cur_val];
                               }
                            }
                            break;
                    }
                }
//                foreach ($propertyCollection as $propertyItem) {
//                    $code_order = $propertyItem->getField("CODE");
//                    if (!empty($update_prop[$code_order])) {
////                        // Ищем данные в куках
////                        $valueMeta = $propertyItem->getField("VALUE");
////
////                        if (!empty($valueMeta)) {
////                            $update_data_deal[$update_prop[$code_order]] = $valueMeta;
////                        }
//                    }
//                }

                if (!empty($update_data_deal)) {
                    // Обновляем существующую сделку
                    $res_update = $bx24->updateDeal($find_deal['ID'], $update_data_deal);
                    if ($res_update != 1) {
                        AddMessage2Log('Обновления МЕТА данных в Б24 у заказа - ' . $id_order, "sale");
                        AddMessage2Log($update_data_deal, "sale");
                    } else {
                        $propertyCollection = $order->getPropertyCollection();
                        foreach ($propertyCollection as $propertyItem) {
                            $code_order = $propertyItem->getField("CODE");
                            if ($code_order == 'B24_STATUS') {
                                // Ищем данные в куках
                                $propertyItem->setValue('N'); // Заказ отправлен
                            }
                        }
                        $order->save();
                    }
                }
            }
        } catch (Bitrix24APIException $e) {
            AddMessage2Log($e->getMessage(), "sale");
//            printf('Ошибка 1 (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
        } catch (Exception $e) {
            AddMessage2Log($e->getMessage(), "sale");
//            printf('Ошибка 2 (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
        }
    }
}