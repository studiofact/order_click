<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
$arResult = OrderClick::UserFieldsInterface(
    $_REQUEST,
    $arParams["OBJECT_USER_FILDS"],
    $arParams["SELECT_PLACEHOLDER"],
    $arParams["CLASS_INPUT_TYPE_TEXT"]
);

if (!$arResult["ERROR"]) {


    if ($arParams["BUY_USER"]) {
        $buyer = $arParams["BUY_USER"];
    } else {
        $buyer = OrderClick::UserCreate(
            $arResult["INTERFACE"][$arParams["NAME_USER_FILDS"]]["VALUE"], // NAME USER
            $arResult["INTERFACE"][$arParams["PHONE_USER_FILDS"]]["VALUE"], // PHONE USER
            $arParams["DOMAIN_USER_MAIL"], // DOMAIN EMAIL
            $arResult["INTERFACE"][$arParams["LOGIN_USER_FILDS"]]["VALUE"], // LOGIN USER
            $arParams["USER_GROUP"] // GROUP USER
        );
    }

    $currency = CCurrency::GetBaseCurrency();

    $arResult["ORDER_ID"] = OrderClick::AddProduct(
        $arResult["ELEMENT"], // Product ID
        $arResult["QUANTITY"], //QUANTITY
        array(), //arRewriteFields array()*
        false,
        $buyer, // BUYER
        $currency, //CURRENCY
        $arParams["PERSON_TYPE"], //PERSON TYPE
        $arParams["CLEAR_CART"]
    );
}

$ajaxId = new CComponentAjax($this->getName(), $this->getTemplateName(), $arParams, null);
$arResult["AJAX_ID"] = $ajaxId->componentID;


$this->includeComponentTemplate();

?>
