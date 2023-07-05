<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Сделка");
use Bitrix\Main\IO,
    Bitrix\Main\Application,
    Bitrix\Main\Web\Uri;


$MESS['MIBOK_HISTORY_TITLE'] = 'История платежей';
$MESS['MIBOK_NO_RIGHTS_FOR_VIEWING'] = 'Доступ закрыт';
$MESS['MIBOK_MODULE_NOT_INCLUDED'] = 'Решение не установлено';

$MESS['MIBOK_PAY_INFO_ID'] = 'ID платежа на сайте: ';
$MESS['MIBOK_PAY_INFO_HASH'] = 'Ключ идемпотентности: ';
$MESS['MIBOK_PAY_INFO_TYPE'] = 'Тип платежной системы: ';
$MESS['MIBOK_PAY_INFO_TYPE_PAY'] = 'Инициатор оплаты: ';
$MESS['MIBOK_PAY_INFO_SHOP_ID'] = 'ID магазина: ';
$MESS['MIBOK_PAY_INFO_DATE_CREATE'] = 'Создан: ';
$MESS['MIBOK_PAY_INFO_DATE_CHANGE'] = 'Последнее изменение: ';
$MESS['MIBOK_PAY_INFO_ID_YOOKASSA'] = 'ID оплаты в Яндексе: ';
$MESS['MIBOK_PAY_INFO_ORDER_ID'] = 'ID заказа на сайте: ';
$MESS['MIBOK_PAY_INFO_SUMMA'] = 'Сумма заказа: ';
$MESS['MIBOK_PAY_INFO_STATUS_YOOKASSA'] = 'Статус: ';
$MESS['MIBOK_PAY_INFO_PAID'] = 'Оплачено: ';
$MESS['MIBOK_PAY_INFO_TEST'] = 'Тестовый заказ: ';
$MESS['MIBOK_PAY_INFO_DESCRIPTION'] = 'Описание заказа: ';
$MESS['MIBOK_PAY_INFO_CONFIRMATION_URL'] = 'Ссылка на оплату: ';
$MESS['MIBOK_PAY_INFO_REFUNDABLE'] = 'Возможность возврата: ';
$MESS['MIBOK_PAY_INFO_USER_ID'] = 'ID пользователя: ';
$MESS['MIBOK_PAY_INFO_USER_FIO'] = 'Покупатель: ';
$MESS['MIBOK_PAY_INFO_USER_EMAIL'] = 'E-mail: ';
$MESS['MIBOK_PAY_INFO_USER_PHONE'] = 'Телефон: ';
$MESS['MIBOK_PAY_INFO_USER_INN'] = 'ИНН: ';
$MESS['MIBOK_PAY_INFO_ITEMS'] = 'Состав заказа: ';

$MESS['MIBOK_PAY_HISTORY_HEAD_GENERAL'] = 'Общая информация';
$MESS['MIBOK_PAY_HISTORY_HEAD_ORDER'] = 'Информация о заказе';
$MESS['MIBOK_PAY_HISTORY_HEAD_USER'] = 'Информация о покупателе';
$MESS['MIBOK_PAY_HISTORY_HEAD_OTHER'] = 'Другое';
$MESS['MIBOK_PAY_HISTORY_HEAD_RECEIPT'] = 'Чеки зачета предоплаты';
$MESS['MIBOK_PAY_HISTORY_HEAD_REFUND_ITEMS'] = 'История возвратов';

$MESS['from'] = 'с';
$MESS['to'] = 'по';

$MESS['MIBOK_PAY_TITLE_HISTORY'] = 'Информация о платеже №';
$MESS['MIBOK_PAY_HISTORY_BACK_LIST'] = 'Список платежей';
$MESS['MIBOK_PAY_HISTORY_BACK_LIST_TITLE'] = 'Перейти в список платежей';
$MESS['MIBOK_PAY_HISTORY_DATA'] = 'Данные о платеже';
$MESS['MIBOK_PAY_HISTORY_ERROR_FIND'] = 'Информация о данном платеже отсутствует';

$MESS['MIBOK_PAY_HISTORY_CHECK'] = 'Чеки';
$MESS['MIBOK_PAY_HISTORY_CHECK_BUY'] = 'Чек о покупке';
$MESS['MIBOK_PAY_HISTORY_CHECK_REFUND'] = 'Чек о возврате';
$MESS['MIBOK_PAY_HISTORY_CHECK_SEPPLEMENTS'] = 'Чек зачета предоплаты';
$MESS['MIBOK_PAY_HISTORY_SEND_SETTLEMENT'] = 'Отправить чек зачета предоплаты';
$MESS['MIBOK_PAY_HISTORY_GET_ALL_RECEIPTS'] = 'Актуализировать чеки';

$MESS['MIBOK_PAID_ALL'] = 'Все';
$MESS['MIBOK_PAID_YES'] = 'Да';
$MESS['MIBOK_PAID_NO'] = 'Нет';

$MESS['MIBOK_CAPTURE_TITLE'] = 'Подтверждение оплаты';
$MESS['MIBOK_CAPTURE_TYPE'] = 'Выберите тип списания:';
$MESS['MIBOK_CAPTURE_TYPE1'] = 'полное';
$MESS['MIBOK_CAPTURE_TYPE2'] = 'частичное';
$MESS['MIBOK_CAPTURE_SUMMA'] = 'Оплачено клиентом:';
$MESS['MIBOK_CAPTURE_SUMMA_INPUT'] = 'Оплачено клиентом:';
$MESS['MIBOK_CAPTURE_SUMMA_INPUT'] = 'Списать с платежа:';
$MESS['MIBOK_CAPTURE_ITEMS'] = 'Товары для<br>формирования чека';
$MESS['MIBOK_PAY_INFO_CAPTURE_WAITING'] = 'Подтвердить списание';
$MESS['MIBOK_PAY_INFO_CAPTURE_CHECK'] = 'Заполните данные для чека';
$MESS['MIBOK_PAY_INFO_CAPTURE_ATTENTION'] = "<b>Внимание!</b><br>Вам необходимо ввести корректные данные для нового чека";

$MESS['MIBOK_REFUNDABLE_TITLE'] = "Сделать возврат денежных средств";
$MESS['MIBOK_REFUNDABLE_TYPE'] = 'Выберите тип возврата:';
$MESS['MIBOK_REFUNDABLE_TYPE1'] = 'полный';
$MESS['MIBOK_REFUNDABLE_TYPE2'] = 'частичный';
$MESS['MIBOK_REFUNDABLE_SUMMA_INPUT'] = 'Вернуть клиенту:';
$MESS['MIBOK_REFUNDABLE_ITEMS'] = 'Возвращаемые товары для<br>формирования чека';

$MESS['MIBOK_PAY_CAPTURE_ERROR_summa_big'] = "Сумма списания платежа не может быть больше оплаченной суммы";
$MESS['MIBOK_PAY_CAPTURE_ERROR_summa_null'] = "Сумма списания платежа не может быть нулевой";
$MESS['MIBOK_PAY_CAPTURE_ERROR_summa_small'] = "Сумма списания платежа не может быть меньше суммы товаров в чеке";
$MESS['MIBOK_PAY_CAPTURE_ERROR_summa_big_product'] = "Сумма списания платежа должна быть равна  суммы товаров в чеке";
$MESS['MIBOK_PAY_CAPTURE_ERROR_quantity_big'] = "Количество товара не может быть больше указанного в изначальном чеке";
$MESS['MIBOK_PAY_CAPTURE_ERROR_quantity_null'] = "Количество товара не может быть нулевым";
$MESS['MIBOK_PAY_CAPTURE_ERROR_amount_big'] = "Стоимость товара не может быть больше указанной в изначальном чеке";
$MESS['MIBOK_PAY_CAPTURE_ERROR_item_N'] = "В чеке должен быть указан хотя бы один товар";

$MESS['MIBOK_PAY_REFUND_ERROR_summa_big'] = "Сумма возврата платежа не может быть больше оплаченной суммы";
$MESS['MIBOK_PAY_REFUND_ERROR_summa_null'] = "Сумма возврата не может быть нулевой";
$MESS['MIBOK_PAY_REFUND_ERROR_summa_small'] = "Сумма возврата не может быть меньше суммы товаров в чеке";
$MESS['MIBOK_PAY_REFUND_ERROR_summa_refund'] = "Сумма возврата не может быть меньше 1 рубля";
$MESS['MIBOK_PAY_REFUND_ERROR_summa_balance'] = "Сумма остатка не может быть меньше 1 рубля";
$MESS['MIBOK_PAY_REFUND_ERROR_quantity_big'] = "Количество товара не может быть больше указанного в изначальном чеке";
$MESS['MIBOK_PAY_REFUND_ERROR_quantity_null'] = "Количество товара не может быть нулевым";
$MESS['MIBOK_PAY_REFUND_ERROR_amount_big'] = "Стоимость товара не может быть больше указанной в изначальном чеке";
$MESS['MIBOK_PAY_REFUND_ERROR_item_N'] = "В чеке должен быть указан хотя бы один товар";

CJSCore::Init(array("popup", "jquery"));

$moduleCode = 'pay';
$moduleID = 'mibok.'.$moduleCode;
if(CModule::IncludeModule($moduleID) && CModule::IncludeModule("main") && CModule::IncludeModule("sale") && CModule::IncludeModule("iblock")):
    $RIGHT = 'W';
    ?>
    <section class="collections g-filters">
        <div class="container collections__container">
            <br>
            <br>
            <br>
            <div>
                <?
                    if(!$ID) $ID = $_GET['id'];
                    $ID = intval($ID);
                    $message = null;
                    $bVarsFromForm = false;
                    $ORDER_ID = \Mibok\Pay\InfoTable::getList(array('select' => array('*'), 'filter' => array("=ID" => $ID), 'order' => array('ID' => 'ASC') ))->fetch()['ORDER_ID'];

                    function mibokCheckDataCapture($obSettlements)
                {
                    /*check data*/

                    $arPostError = false;

                    $postSumma = (float)$_POST['SUMMA'];
                    $postOldSumma = (float)$_POST['old_SUMMA'];

                    if (round($postSumma, 2) > round($postOldSumma, 2)) {
                        $arPostError['summa'] = 'big';
                    } elseif(round($postSumma, 2) <= 0) {
                        $arPostError['summa'] = 'null';
                    }

                    if (!isset($_POST['item']) || count($_POST['item']) == 0) {
                        $arPostError['item'] = 'N'; //нет выбранных товаров
                    } else {
                        $allSumm = 0;
                        foreach ($_POST['item'] as $key => $value)
                        {
                            if ((int)$_POST['quantity'][$key] > (int)$_POST['old_quantity'][$key]) {
                                $arPostError['quantity'] = 'big';
                            } elseif ((int)$_POST['quantity'][$key] <= 0) {
                                $arPostError['quantity'] = 'null';
                            }

                            $postAmount = (float)$_POST['amount'][$key];
                            $postOldAmount = (float)$_POST['old_amount'][$key];

                            if (round($postAmount, 2) > round($postOldAmount, 2)) {
                                $arPostError['amount'] = 'big';
                            } else {
                                $allSumm += $postAmount * (int)$_POST['quantity'][$key];
                            }
    //            elseif((float)$_POST['amount'][$key] <= 0)
    //                $arPostError['amount'] = 'null';
                        }
                        if (round($postSumma, 2) < round($allSumm, 2)) {
                            $arPostError['summa'] = 'small';
                        } elseif (round($postSumma, 2) != round($allSumm, 2)) {
                            $arPostError['summa'] = 'big_product';
                        }

                        if ($_POST['action_refund']) {
                            if ((float)$_POST['SUMMA'] < 1) {
                                $arPostError['summa'] = 'refund';
                            }
                            if (((float)$_POST['old_SUMMA'] - (float)$_POST['SUMMA']) < 1) {
                                $arPostError['summa'] = 'balance';
                            }
                        }
                    }
                    if($arPostError)
                    {
                        if($_POST['action_capture'])
                            $arPostError['action'] = 'capture_error';
                        elseif($_POST['action_refund'])
                            $arPostError['action'] = 'refund_error';
                        $arPostError['ID'] = $_POST['ID'];
                        $request = Application::getInstance()->getContext()->getRequest();
                        $uriString = $request->getRequestUri();
                        $uri = new Uri($uriString);
                        $uri->addParams($arPostError);
                        LocalRedirect($uri->getUri());
                    }
                    else
                    {
                        /*create capture part payment*/
                        $obSettlementsItems = \MibokPay::convertItemstoArray($obSettlements['ITEMS']);
                        $arCustomerReceipt = array();
                        $arItemsReceipt = array();

                        $ID = $_POST['ID'];

                        if(is_array($_POST['item']) && count($_POST['item'] > 0))
                        {
                            $bWin = false;
                            if(LANG_CHARSET == 'windows-1251')
                            {
                                $bWin = true;
                            }
                            foreach($_POST['item'] as $key => $value)
                            {
                                if(isset($_POST['quantity'][$key]) && isset($_POST['amount'][$key]))
                                {
                                    $arItemsReceipt[] = array(
                                        "description" => $bWin ? mb_convert_encoding($value, "UTF-8", "Windows-1251") : $value,
                                        "quantity" => $_POST['quantity'][$key],
                                        "amount" => array("value" => $_POST['amount'][$key], "currency" => ($_POST['currency'][$key] ?: "RUB")),
                                        "vat_code" => $obSettlementsItems[$key]['vat_code'],
                                        "payment_mode" => $obSettlementsItems[$key]['payment_mode'],
                                        "payment_subject" => $obSettlementsItems[$key]['payment_subject']
                                    );
                                    if($bWin)
                                    {
                                        $arItemsReceipt2[] = array(
                                            "description" => $value,
                                            "quantity" => $_POST['quantity'][$key],
                                            "amount" => array("value" => $_POST['amount'][$key], "currency" => ($_POST['currency'][$key] ?: "RUB")),
                                            "vat_code" => $obSettlementsItems[$key]['vat_code'],
                                            "payment_mode" => $obSettlementsItems[$key]['payment_mode'],
                                            "payment_subject" => $obSettlementsItems[$key]['payment_subject']
                                        );
                                    }
                                }
                            }
                            if(!empty($obSettlements["USER_FIO"]))
                                $arCustomerReceipt["full_name"] = $bWin ? mb_convert_encoding($obSettlements["USER_FIO"], "UTF-8", "Windows-1251") : $obSettlements["USER_FIO"];
                            if(!empty($obSettlements["USER_EMAIL"]))
                                $arCustomerReceipt["email"] = $bWin ? mb_convert_encoding($obSettlements["USER_EMAIL"], "UTF-8", "Windows-1251") : $obSettlements["USER_EMAIL"];
                            if(!empty($obSettlements["USER_PHONE"]))
                                $arCustomerReceipt["phone"] = $bWin ? mb_convert_encoding($obSettlements["USER_PHONE"], "UTF-8", "Windows-1251") : $obSettlements["USER_PHONE"];
                            if(!empty($obSettlements["USER_INN"]))
                                $arCustomerReceipt["inn"] = $bWin ? mb_convert_encoding($obSettlements["USER_INN"], "UTF-8", "Windows-1251") : $obSettlements["USER_INN"];

                        }

                        $obPayment = new Mibok\Pay\Yookassa($obSettlements['SHOP_ID']);
                        if($_POST['action_capture'])
                        {
                            $resTable = \Mibok\Pay\InfoTable::update($ID, array('STATUS_YOOKASSA' => 'succeeding', 'DATE_CHANGE' => new \Bitrix\Main\Type\DateTime(), 'SUMMA' => $_POST['SUMMA'], 'ITEMS' => \Bitrix\Main\Web\Json::encode(($bWin ? $arItemsReceipt2 : $arItemsReceipt))));
                            try {
                                $obPayment->capturePayment($obSettlements['ID_YOOKASSA'], $_POST['SUMMA'], $obSettlements['CURRENCY'], $arCustomerReceipt, $arItemsReceipt);
                            } catch (Throwable $t) {
                                $resTable = \Mibok\Pay\InfoTable::update($ID, array('LOG_INFO' => $t->getMessage()));
                            } catch (Exception $e) {
                                $resTable = \Mibok\Pay\InfoTable::update($ID, array('LOG_INFO' => $e->getMessage()));
                            }
                        }
                        elseif($_POST['action_refund'])
                        {
                            foreach($obSettlementsItems as $key => $arSettlementItem)
                            {
                                if(isset($_POST['item'][$key]))
                                {
                                    if((int)$_POST['quantity'][$key] < (int) $arSettlementItem['quantity'])
                                    {
                                        $obSettlementsItems[$key]['quantity'] = (int) $arSettlementItem['quantity'] - (int)$_POST['quantity'][$key];
                                    }
                                    elseif((int)$_POST['quantity'][$key] == (int) $arSettlementItem['quantity'])
                                    {
                                        if((float)$_POST['amount'][$key] < (float) $arSettlementItem['amount']['value'])
                                        {
                                            $obSettlementsItems[$key]['amount']['value'] = (float) $arSettlementItem['amount']['value'] - (float)$_POST['amount'][$key];
                                        }
                                        else
                                        {
                                            unset($obSettlementsItems[$key]);
                                        }
                                    }
                                }
                            }

                            $old_status = $obSettlements['STATUS_YOOKASSA'];
                            $status = '';
                            if(((float)$_POST['old_SUMMA'] - (float)$_POST['SUMMA']) > 1)
                                $newSumma = (float)$_POST['old_SUMMA'] - (float)$_POST['SUMMA'];
                            else
                                $newSumma = (float)$_POST['old_SUMMA'];
                            if($returnRefund['status'] == 'succeeded' && ((float)$_POST['old_SUMMA'] - (float)$_POST['SUMMA']) <= 1)
                                $status = 'refundable';
                            $resTable = \Mibok\Pay\InfoTable::update($ID, array('STATUS_YOOKASSA' => 'refundabling', 'DATE_CHANGE' => new \Bitrix\Main\Type\DateTime(), 'SUMMA' => $newSumma, 'ITEMS' => \Bitrix\Main\Web\Json::encode($obSettlementsItems)));
                            try {
                                $returnRefund = $obPayment->refundPayment($obSettlements['ID_YOOKASSA'], $_POST['SUMMA'], $obSettlements['CURRENCY'], $arCustomerReceipt, $arItemsReceipt);
                            } catch (Throwable $t) {
                                $resTable = \Mibok\Pay\InfoTable::update($ID, array('LOG_INFO' => $t->getMessage()));
                            } catch (Exception $e) {
                                $resTable = \Mibok\Pay\InfoTable::update($ID, array('LOG_INFO' => $e->getMessage()));
                            }

                            $arRefund = array();
                            if(!empty($obSettlements['REFUND_ITEMS']))
                                $arRefund = \Bitrix\Main\Web\Json::decode($obSettlements['REFUND_ITEMS']);
                            if(is_array($returnRefund))
                            {
                                if($returnRefund['status'] == 'succeeded' && ((float)$_POST['old_SUMMA'] - (float)$_POST['SUMMA']) > 1)
                                    $status = 'refundable_part';
                                elseif($returnRefund['status'] == 'succeeded' && ((float)$_POST['old_SUMMA'] - (float)$_POST['SUMMA']) <= 1)
                                    $status = 'refundable';
                                else
                                    $status = $old_status;
    //                if(!empty($arRefund))
    //                    $arRefund = array_merge($returnRefund, $arRefund);
    //                else
                                $arRefund[] = $returnRefund;

                                $resTable = \Mibok\Pay\InfoTable::update($ID, array('STATUS_YOOKASSA' => $status, 'REFUND_ITEMS' => \Bitrix\Main\Web\Json::encode($arRefund), 'DATE_CHANGE' => new \Bitrix\Main\Type\DateTime()));
                                if(Mibok\Pay\Yookassa::countReceipts($obSettlements['ID_YOOKASSA'], 'payment') > 0)
                                    Mibok\Pay\Yookassa::setReceipts($returnRefund['id'], $ID, $obSettlements['SHOP_ID'], 'refund');
                            }
                        }
                        if(Mibok\Pay\Yookassa::countReceipts($obSettlements['ID_YOOKASSA'], 'payment') > 0)
                            Mibok\Pay\Yookassa::setReceipts($obSettlements['ID_YOOKASSA'], $ID, $obSettlements['SHOP_ID']);

                        $request = Application::getInstance()->getContext()->getRequest();
                        $uriString = $request->getRequestUri();
                        $uri = new Uri($uriString);
                        $uri->addParams(array('ID' => $_POST['ID']));
                        LocalRedirect($uri->getUri());
                    }
                }

                    if($REQUEST_METHOD == "GET"){
                        if($_GET['action'] == 'send_settlement_receipt')
                        {
                            $obSettlements = \Mibok\Pay\InfoTable::getList(array('select' => array('IS_SETTLEMENTS', 'SEND_SETTLEMENTS', 'SHOP_ID', 'ID_YOOKASSA'), 'filter' => array("=ID" => $ID), 'order' => array('ID' => 'ASC') ))->fetch();
                            if($obSettlements['IS_SETTLEMENTS'] == 'Y' && $obSettlements['SEND_SETTLEMENTS'] != 'Y')
                            {
                                Mibok\Pay\Yookassa::sendSettlementReceipt($obSettlements['ID_YOOKASSA'], $obSettlements['SHOP_ID']);
                            }
                        }
                        elseif($_GET['action'] == 'get_all_receipts')
                        {
                            $arPay = \Mibok\Pay\InfoTable::getList(array('select' => array('SHOP_ID', 'ID_YOOKASSA', 'REFUND_ITEMS'), 'filter' => array("=ID" => $ID), 'order' => array('ID' => 'ASC') ))->fetch();
                            Mibok\Pay\Yookassa::getAllReceiptsFromPayment($ID, $arPay);
                        }
                        elseif($_GET['action'] == 'check_status')
                        {
                            $obSettlements = \Mibok\Pay\InfoTable::getList(array('select' => array('SHOP_ID', 'ID_YOOKASSA'), 'filter' => array("=ID" => $ID), 'order' => array('ID' => 'ASC') ))->fetch();
                            if(Mibok\Pay\Yookassa::countReceipts($obSettlements['ID_YOOKASSA'], 'payment') > 0)
                                Mibok\Pay\Yookassa::checkReceipts($ID, $obSettlements['SHOP_ID']);
                        }
                        elseif($_GET['action'] == 'cancel_waiting')
                        {
                            $obSettlements = \Mibok\Pay\InfoTable::getList(array('select' => array('SHOP_ID', 'ID_YOOKASSA'), 'filter' => array("=ID" => $ID), 'order' => array('ID' => 'ASC') ))->fetch();
                            $obPayment = new Mibok\Pay\Yookassa($obSettlements['SHOP_ID']);
                            try {
                                $obPayment->cancelPayment($obSettlements['ID_YOOKASSA']);
                            } catch (Throwable $t) {
                                $resTable = \Mibok\Pay\InfoTable::update($ID, array('LOG_INFO' => $t->getMessage()));
                            } catch (Exception $e) {
                                $resTable = \Mibok\Pay\InfoTable::update($ID, array('LOG_INFO' => $e->getMessage()));
                            }


                            writeToLogs('set order status C (Отмена)','orderStatusChange');
                            CSaleOrder::StatusOrder($ORDER_ID, 'C');
                            $resTable = \Mibok\Pay\InfoTable::update($ID, array('STATUS_YOOKASSA' => 'canceling', 'DATE_CHANGE' => new \Bitrix\Main\Type\DateTime()));
                            if(Mibok\Pay\Yookassa::countReceipts($obSettlements['ID_YOOKASSA'], 'payment') > 0) {
                                Mibok\Pay\Yookassa::checkReceipts($ID, $obSettlements['SHOP_ID']);
                            }
            //                        Mibok\Pay\Yookassa::setReceipts($obSettlements['ID_YOOKASSA'], $ID, $obSettlements['SHOP_ID']);
                        }
                        elseif($_GET['action'] == 'capture_waiting')
                        {
                            $obSettlements = \Mibok\Pay\InfoTable::getList(array('select' => array('SHOP_ID', 'ID_YOOKASSA', 'SUMMA', 'CURRENCY'), 'filter' => array("=ID" => $ID), 'order' => array('ID' => 'ASC') ))->fetch();
                            $obPayment = new Mibok\Pay\Yookassa($obSettlements['SHOP_ID']);

                            writeToLogs('set order status PS (Платёж подтвержден)','orderStatusChange');
                            CSaleOrder::StatusOrder($ORDER_ID, 'PS');
                            $resTable = \Mibok\Pay\InfoTable::update($ID, array('STATUS_YOOKASSA' => 'succeeding', 'DATE_CHANGE' => new \Bitrix\Main\Type\DateTime()));

                            try {
                                $obPayment->capturePayment($obSettlements['ID_YOOKASSA'], $obSettlements['SUMMA'], $obSettlements['CURRENCY']);
                            } catch (Throwable $t) {
                                $resTable = \Mibok\Pay\InfoTable::update($ID, array('LOG_INFO' => $t->getMessage()));
                            } catch (Exception $e) {
                                $resTable = \Mibok\Pay\InfoTable::update($ID, array('LOG_INFO' => $e->getMessage()));
                            }

                            if(Mibok\Pay\Yookassa::countReceipts($obSettlements['ID_YOOKASSA'], 'payment') > 0) {
                                Mibok\Pay\Yookassa::setReceipts($obSettlements['ID_YOOKASSA'], $ID, $obSettlements['SHOP_ID']);
                            }
                        }
                        elseif($_GET['action'] == 'refund_all')
                        {
                            $obSettlements = \Mibok\Pay\InfoTable::getList(array('select' => array('SHOP_ID', 'ID_YOOKASSA', 'SUMMA', 'CURRENCY', 'STATUS_YOOKASSA', 'REFUND_ITEMS'), 'filter' => array("=ID" => $ID), 'order' => array('ID' => 'ASC') ))->fetch();
                            $obPayment = new Mibok\Pay\Yookassa($obSettlements['SHOP_ID']);
                            $old_status = $obSettlements['STATUS_YOOKASSA'];
                            $status = '';
                            $resTable = \Mibok\Pay\InfoTable::update($ID, array('STATUS_YOOKASSA' => 'refundabling', 'DATE_CHANGE' => new \Bitrix\Main\Type\DateTime()));
                            try {
                                $returnRefund = $obPayment->refundPayment($obSettlements['ID_YOOKASSA'], $obSettlements['SUMMA'], $obSettlements['CURRENCY']);
                            } catch (Throwable $t) {
                                $resTable = \Mibok\Pay\InfoTable::update($ID, array('LOG_INFO' => $t->getMessage()));
                            } catch (Exception $e) {
                                $resTable = \Mibok\Pay\InfoTable::update($ID, array('LOG_INFO' => $e->getMessage()));
                            }

                            $arRefund = array();
                            if(!empty($obSettlements['REFUND_ITEMS']))
                                $arRefund = \Bitrix\Main\Web\Json::decode($obSettlements['REFUND_ITEMS']);
                            if(is_array($returnRefund))
                            {
                                if($returnRefund['status'] == 'succeeded') {
                                    $status = 'refundable';
                                }
                                else
                                    $status = $old_status;
            //                        if(!empty($arRefund))
            //                            $arRefund = array_merge($returnRefund, $arRefund);
            //                        else
            //                            $arRefund = $returnRefund;
                                $arRefund[] = $returnRefund;
                                writeToLogs('set order status RF (Возврат)','orderStatusChange');
                                if($status == 'refundable'){
                                    CSaleOrder::StatusOrder($ORDER_ID, 'RF');
                                }
                                $resTable = \Mibok\Pay\InfoTable::update($ID, array('STATUS_YOOKASSA' => $status, 'REFUND_ITEMS' => \Bitrix\Main\Web\Json::encode($arRefund), 'DATE_CHANGE' => new \Bitrix\Main\Type\DateTime()));
                                if(Mibok\Pay\Yookassa::countReceipts($obSettlements['ID_YOOKASSA'], 'payment') > 0){
                                    Mibok\Pay\Yookassa::setReceipts($returnRefund['id'], $ID, $obSettlements['SHOP_ID'], 'refund');
                                }
                            }
                            if(Mibok\Pay\Yookassa::countReceipts($obSettlements['ID_YOOKASSA'], 'payment') > 0){
                                Mibok\Pay\Yookassa::setReceipts($obSettlements['ID_YOOKASSA'], $ID, $obSettlements['SHOP_ID']);
                            }
                        }
                        if(in_array($_GET['action'], array('send_settlement_receipt', 'check_status','get_all_receipts', 'cancel_waiting', 'capture_waiting', 'refund_all'/*, 'capture_waiting_part'*/)))
                        {
                            $request = Application::getInstance()->getContext()->getRequest();
                            $uriString = $request->getRequestUri();
                            $uri = new Uri($uriString);
                            $uri->deleteParams(array("action", "action_capture", "action_refund", "sessid"/*, "SUMMA", 'currency', 'amount', 'quantity', 'item'*/));
                            LocalRedirect($uri->getUri());
                        }
                    }

                    if($REQUEST_METHOD == "POST"){
                        if(isset($_POST['action_capture']) && $_POST['action_capture'] == 'capture_waiting_part')
                        {
                            $obSettlements = \Mibok\Pay\InfoTable::getList(array('select' => array('*'), 'filter' => array("=ID" => $ID), 'order' => array('ID' => 'ASC') ))->fetch();
                            mibokCheckDataCapture($obSettlements);
                        }
                        elseif(isset($_POST['action_refund']) && $_POST['action_refund'] == 'refund_part')
                        {
                            $obSettlements = \Mibok\Pay\InfoTable::getList(array('select' => array('*'), 'filter' => array("=ID" => $ID), 'order' => array('ID' => 'ASC') ))->fetch();
                            mibokCheckDataCapture($obSettlements);
                        }
                    }
                    if($ID>0) {
                        $historyData = false;
                        $arInfoPayment = \Mibok\Pay\InfoTable::getList(array('select' => array('*'),'filter' => array('ID' => $ID)))->fetch();
                        $historyData = \Mibok\Pay\InfoTable::getReadableInfo($arInfoPayment, $ID, $RIGHT);

                        $obSettlements = \Mibok\Pay\InfoTable::getList(array('select' => array('IS_SETTLEMENTS', 'SEND_SETTLEMENTS'), 'filter' => array("=ID" => $ID), 'order' => array('ID' => 'ASC') ))->fetch();
                        if($arInfoPayment['STATUS_YOOKASSA'] != 'succeeded' && $arInfoPayment['STATUS_YOOKASSA'] != 'refundable_part')
                        {
                            $obSettlements['IS_SETTLEMENTS'] = 'N';
                            unset($historyData['RECEIPT']);
                        }

                        $arReceipts = array();
                        $obReceipts = \Mibok\Pay\ReceiptTable::getList([
                            'select' => ['*'],
                            'filter' => ["=ID_PAY_INFO" => $ID],
                            'order' => ['TIMESTAMP' => 'ASC', 'FISCAL_DOCUMENT_NUMBER' => 'ASC', 'ID' => 'ASC']
                        ]);
                        while($res = $obReceipts->fetch())
                        {
                            $arReceipts[] = $res;
                        }
                        if(count($arReceipts) > 0)
                        {
                            $aTabs[] = array("DIV" => "edit2", "TAB" => GetMessage("MIBOK_PAY_HISTORY_CHECK"), "ICON"=>"", "TITLE"=>GetMessage("MIBOK_PAY_HISTORY_CHECK"));
                        }
                    }
                    //debug($historyData);
                ?>
                <div id="capturePayment" style="display:none;" class="modalPayment">
                    <form method="post" Action="<?echo $APPLICATION->GetCurPage()?>" ENCTYPE="multipart/form-data" name="post_form">
                        <input type="hidden" name="ID" value='<?=$ID?>'>
                        <input type="hidden" name="sessid" value='<?=bitrix_sessid()?>'>
                        <h2><?=GetMessage('MIBOK_CAPTURE_TITLE')?></h2>
                        <h3><?=GetMessage('MIBOK_CAPTURE_TYPE')?></h3>
                        <div>
                            <input <?=$disabled;?> type="radio" checked="" class="capture_type" name='action_capture' value="capture_waiting" id="capture_all">
                            <label for="capture_all"><?=GetMessage('MIBOK_CAPTURE_TYPE1')?></label>
                            <input <?=$disabled;?> type="radio" class="capture_type" name='action_capture' value="capture_waiting_part" id="capture_part">
                            <label for="capture_part"><?=GetMessage('MIBOK_CAPTURE_TYPE2')?></label>
                        </div>
                        <div class="capture_waiting capture-item">
                            <a href="javascript:window.location='mibok.pay_history_edit.php?ID=<?=$ID?>&action=capture_waiting&<?=bitrix_sessid_get()?>';" class="popup-window-button popup-window-button-accept" title="<?=GetMessage('MIBOK_PAY_INFO_CAPTURE_WAITING')?>" id="btn_capture_waiting"><?=GetMessage('MIBOK_PAY_INFO_CAPTURE_WAITING')?></a>
                        </div>
                        <div class="capture_waiting_part capture-item hidden">
                            <table cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td><?= GetMessage('MIBOK_CAPTURE_SUMMA')?></td>
                                    <td><b><?=$arInfoPayment['SUMMA']?></b> <?=$arInfoPayment['CURRENCY']?></td>
                                </tr>
                                <tr>
                                    <td><?= GetMessage('MIBOK_CAPTURE_SUMMA_INPUT')?></td>
                                    <td><input <?=$disabled;?> type="text" class='valid-amount' name="SUMMA" value="<?=$arInfoPayment['SUMMA']?>"><input type="hidden" name="old_SUMMA" value="<?=$arInfoPayment['SUMMA']?>"> <?=$arInfoPayment['CURRENCY']?></td>
                                </tr>
                                <?if(isset($arInfoPaymentItems[0]['vat_code']) && !empty($arInfoPaymentItems[0]['vat_code'])):?>
                                    <tr>
                                        <td colspan="2"><h3><?=GetMessage('MIBOK_PAY_INFO_CAPTURE_CHECK')?></h3></td>
                                    </tr>
                                    <tr>
                                        <td><?= GetMessage('MIBOK_CAPTURE_ITEMS')?></td>
                                        <td>
                                            <?=\MibokPay::convertItemstoTable($arInfoPayment['ITEMS'], 'yookassa', true)?>
                                        </td>
                                    </tr>
                                <?endif;?>
                            </table>
                            <div class="adm-info-message-yellow">
                                <div class="adm-info-message">
                                    <?= GetMessage('MIBOK_PAY_INFO_CAPTURE_ATTENTION')?>
                                </div>
                            </div>
                            <button <?=$disabled;?> type='submit' class="popup-window-button popup-window-button-accept"><?=GetMessage('MIBOK_PAY_INFO_CAPTURE_WAITING')?></button>
                        </div>

                    </form>
                </div>
                <div id="refundablePayment" style="display:none;" class="modalPayment">
                    <h2>
                        Возврат недоступен!
                    </h2>
                    <?if(false):?>
                        <form method="post" Action="<?echo $APPLICATION->GetCurPage()?>" ENCTYPE="multipart/form-data" name="post_form">
                            <input type="hidden" name="ID" value='<?=$ID?>'>
                            <input type="hidden" name="sessid" value='<?=bitrix_sessid()?>'>
                            <h2><?=GetMessage('MIBOK_REFUNDABLE_TITLE')?></h2>
                            <h3><?=GetMessage('MIBOK_REFUNDABLE_TYPE')?></h3>
                            <div>
                                <input <?=$disabled;?> type="radio" checked="" class="refund_type" name='action_refund' value="refund_all" id="refund_all">
                                <label for="refund_all"><?=GetMessage('MIBOK_REFUNDABLE_TYPE1')?></label>
                                <input <?=$disabled;?> type="radio" class="refund_type" name='action_refund' value="refund_part" id="refund_part">
                                <label for="refund_part"><?=GetMessage('MIBOK_REFUNDABLE_TYPE2')?></label>
                            </div>
                            <div class="refund_all capture-item">
                                <a href="javascript:window.location='mibok.pay_history_edit.php?ID=<?=$ID?>&action=refund_all&<?=bitrix_sessid_get()?>';" class="popup-window-button popup-window-button-accept" title="<?=GetMessage('MIBOK_PAY_INFO_CAPTURE_WAITING')?>" id="btn_refund_all"><?=GetMessage('MIBOK_PAY_INFO_CAPTURE_WAITING')?></a>
                            </div>
                            <div class="refund_part capture-item hidden">
                                <table cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <td><?= GetMessage('MIBOK_CAPTURE_SUMMA')?></td>
                                        <td><b><?=$arInfoPayment['SUMMA']?></b> <?=$arInfoPayment['CURRENCY']?></td>
                                    </tr>
                                    <tr>
                                        <td><?= GetMessage('MIBOK_REFUNDABLE_SUMMA_INPUT')?></td>
                                        <td><input <?=$disabled;?> type="text" class='valid-amount' name="SUMMA" value="<?=$arInfoPayment['SUMMA']?>"><input type="hidden" name="old_SUMMA" value="<?=$arInfoPayment['SUMMA']?>"> <?=$arInfoPayment['CURRENCY']?></td>
                                    </tr>
                                    <?if(isset($arInfoPaymentItems[0]['vat_code']) && !empty($arInfoPaymentItems[0]['vat_code'])):?>
                                        <tr>
                                            <td colspan="2"><h3><?=GetMessage('MIBOK_PAY_INFO_CAPTURE_CHECK')?></h3></td>
                                        </tr>
                                        <tr>
                                            <td><?= GetMessage('MIBOK_REFUNDABLE_ITEMS')?></td>
                                            <td>
                                                <?=\MibokPay::convertItemstoTable($arInfoPayment['ITEMS'], 'yookassa', true)?>
                                            </td>
                                        </tr>
                                    <?endif;?>
                                </table>
                                <div class="adm-info-message-yellow">
                                    <div class="adm-info-message">
                                        <?= GetMessage('MIBOK_PAY_INFO_CAPTURE_ATTENTION')?>
                                    </div>
                                </div>
                                <button <?=$disabled;?> type='submit' class="popup-window-button popup-window-button-accept"><?=GetMessage('MIBOK_PAY_INFO_CAPTURE_WAITING')?></button>
                            </div>
                        </form>
                    <?endif;?>
                </div>
                <form method="POST" Action="<?echo $APPLICATION->GetCurPage()?>" ENCTYPE="multipart/form-data" name="post_form">
                    <input type="hidden" name="lang" value="<?echo LANG?>" />
                    <input type="hidden" name="ID" value="<?echo $ID?>" />
                    <input type="hidden" name="COPY_ID" value="<?echo $COPY_ID?>" />
                    <input type="hidden" name="type" value="<?echo htmlspecialcharsbx($_REQUEST["type"])?>" />
                    <div style="font-size: 18px;color:red;text-align: center;margin-bottom: 50px;">
                        <?
                        if(!$historyData)
                        {
                            echo GetMessage('MIBOK_PAY_HISTORY_ERROR_FIND');
//                        CAdminMessage::ShowMessage(GetMessage('MIBOK_PAY_HISTORY_ERROR_FIND'));
                        }
                        else
                        {
                            if($_GET['action'] == 'capture_error')
                            {
                                unset($_GET['action']);
                                unset($_GET['ID']);
                                foreach($_GET as $keyErr => $valErr){
                                    echo GetMessage('MIBOK_PAY_CAPTURE_ERROR_'.$keyErr.'_'.$valErr);
//                                CAdminMessage::ShowMessage(GetMessage('MIBOK_PAY_CAPTURE_ERROR_'.$keyErr.'_'.$valErr));
                                }
                            }
                            elseif($_GET['action'] == 'refund_error')
                            {
                                unset($_GET['action']);
                                unset($_GET['ID']);
                                foreach($_GET as $keyErr => $valErr)
                                {
                                    echo GetMessage('MIBOK_PAY_REFUND_ERROR_'.$keyErr.'_'.$valErr);
//                                CAdminMessage::ShowMessage(GetMessage('MIBOK_PAY_REFUND_ERROR_'.$keyErr.'_'.$valErr));
                                }
                            }
                        }?>
                    </div>
                    <input type="hidden" name="lang" value="<?=LANG?>">
                </form>
                <div style="font-size: 30px;text-align: center;margin-bottom: 15px">
                    <?=$historyData['ORDER']['100']['NAME']?> <?=$historyData['ORDER']['100']['VALUE']?>
                </div>
                <div style="font-size: 24px;text-align: center">
                    <?=$historyData['GENERAL']['20']['NAME']?> <?=$historyData['GENERAL']['20']['VALUE']?>
                </div>
                <br>
                <div style="font-size: 20px;text-align: center">
                    <?=$historyData['ORDER']['103']['NAME']?> <?=$historyData['ORDER']['103']['VALUE']?> <?=$historyData['ORDER']['108']['VALUE']?>
                </div>
                <br>
                <div style="font-size: 16px;text-align: center">
                    <?=$historyData['ORDER']['110']['NAME']?> <?=$historyData['ORDER']['110']['VALUE']?>
                </div>

                <br>
                <br>
                <br>
                <div class="card__btns" style="max-width: 100%;display: none">
                    <button class="btn-reset g-btn g-btn--black card__btn modal-btn">Подтвердить платёж</button>
                    <button class="btn-reset g-btn g-btn--black card__btn modal-btn">Отменить платёж</button>
                    <button class="btn-reset g-btn g-btn--black card__btn modal-btn" data-graph-animation="fadeInUp" data-graph-path="modal-order" data-graph-speed="500">Возврат</button>
                </div>
            </div>
            <?if(!$ID):?>
                <div style="font-size: 24px;text-align: center">
                    Неверня ссылка!
                </div>
            <?endif;?>
            <?
                //$b24Deal = b24DealList(["ID" => "ASC"],['ORIGIN_ID' => $_GET['order']]);
                //debug($b24Deal);
            ?>
            <br>
            <br>
            <br>
        </div>
    </section>
    <script>
        function ModalPay(type)
        {
            var popup_id = Math.random();

            var oPopup = new BX.PopupWindow('popup_' + popup_id, window, {
                autoHide : true,
                offsetTop : 1,
                offsetLeft : 0,
                lightShadow : true,
                closeIcon : true,
                closeByEsc : true,
                overlay: {
                    backgroundColor: 'grey', opacity: '100'
                }
            });
            oPopup.setContent(BX(type));

            oPopup.show();
        }
        $(document)
            .on('change', '#capturePayment input.capture_type', function () {
                var nameClass = $('#capturePayment input.capture_type:checked').val();
                console.log(nameClass)
                $('#capturePayment .capture-item').addClass('hidden');
                $('#capturePayment .capture-item.' + nameClass).removeClass('hidden');
            })
            .on('change', '#refundablePayment input.refund_type', function () {
                var nameClass = $('#refundablePayment input.refund_type:checked').val();
                console.log(nameClass)
                $('#refundablePayment .capture-item').addClass('hidden');
                $('#refundablePayment .capture-item.' + nameClass).removeClass('hidden');
            })
            .on('input', '.valid-quantity', function () {
                $(this).val($(this).val().replace (/\D/g, ''));
            })
            .on('input', '.valid-amount', function (e) {
                $(this).val($(this).val().replace (/[^\d\.]/g, ''));
                if ($(this).val().indexOf(".") != '-1') {
                    $(this).val($(this).val().substring(0, $(this).val().indexOf(".") + 3));
                }
            });
    </script>
    <style>
        .mibok-round{position: relative;padding-left: 15px;}
        .mibok-round:before{content:''; display: block; width: 10px; height: 10px; border-radius: 100%;  position: absolute; top:6px;left:0;}
        .mibok-round.pending:before{background: orange;}
        .mibok-round.waiting:before{background: hotpink;}
        .mibok-round.succeeded:before{background: limegreen;}
        .mibok-round.succeeding:before{background: lightgreen;}
        .mibok-round.canceled:before{background: grey;}
        .mibok-round.canceling:before{background: lightgray;}
        .mibok-round.error:before{background: red;}
        .mibok-edit-table{margin: 0 auto;border-spacing: 0;border-collapse: collapse;}
        .mibok-edit-table th{padding: 14px; text-align: left; padding-left: 0;}
        .mibok-edit-table td{padding: 7px 14px;border: 1px solid #c4ced2;}
        .action-capture {background: scroll transparent url(/bitrix/images/form/options_buttons.gif) no-repeat 0 0; }
        a.popup-window-button-accept:hover{text-decoration: none;}
        .popup-window-button-accept{border:0; margin-top: 20px}
        .modalPayment{padding: 20px 40px 40px;}
        .modalPayment .capture_all{margin-top: 20px;}
        .modalPayment .capture_part{margin-top: 20px;}
        .hidden{display: none;}
        .capture-item table td{padding: 10px;}
        .capture-item table tr td:first-child{padding-left: 0;}
        .capture-item table {margin-bottom: 0px;}
        .capture_waiting_part h3{margin: 10px 0 0;}
        .capture_waiting_part .mibok-edit-table th{padding-top: 0;}
        .capture_waiting_part{margin-top: 20px;}
        a.disabled {opacity: 0.5; pointer-events: none;cursor: default;}

        #btn_refundable{
            display: none;
        }
    </style>
<?endif;?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
