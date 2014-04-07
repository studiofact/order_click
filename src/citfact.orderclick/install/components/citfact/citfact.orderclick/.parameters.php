<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arCurrentValues */


CModule::IncludeModule("sale");
//return false;

$db_ptype = CSalePersonType::GetList(Array("SORT" => "ASC"), Array());
while ($ptype = $db_ptype->Fetch()) {
    $PersonType[$ptype["ID"]] = sprintf('[%d] %s', $ptype['ID'], $ptype['NAME']);
}

$rsGroups = CGroup::GetList(($by = "c_sort"), ($order = "desc"), $filter); // выбираем группы
while ($arGroup = $rsGroups->Fetch()) {
    $UserGroup[$arGroup["ID"]] = sprintf('[%d] %s', $arGroup['ID'], $arGroup['NAME']);
}

$rsUsers = CUser::GetList(($by = "login"), ($order = "asc"), array());
while ($arUserList = $rsUsers->Fetch()) {
    $UserList[$arUserList["LOGIN"]] = sprintf('[%d] %s', $arUserList['ID'], $arUserList['LOGIN']);
}

$arResUserType = CUserTypeEntity::GetList(array($by => "name"), array());
while ($arResUserTypeList = $arResUserType->Fetch()) {
    if (empty($ObjectUserFilds[$arResUserTypeList["ENTITY_ID"]])) {
        $ObjectUserFilds[$arResUserTypeList["ENTITY_ID"]] = $arResUserTypeList["ENTITY_ID"];
    }

}

$arResUserTypeName = CUserTypeEntity::GetList(array($by => "name"), array("ENTITY_ID" => $arCurrentValues["OBJECT_USER_FILDS"]));
while ($arResUserTypeNameList = $arResUserTypeName->Fetch()) {
    $arResUserTypeNameListResult[$arResUserTypeNameList["FIELD_NAME"]] = $arResUserTypeNameList["FIELD_NAME"];
}


$arComponentParameters = array(
    'PARAMETERS' => array(
        'PERSON_TYPE' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage("PERSON_TYPE"),
            'TYPE' => 'LIST',
            'ADDITIONAL_VALUES' => 'Y',
            'VALUES' => $PersonType,
        ),
        'USER_GROUP' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage("USER_GROUP"),
            'TYPE' => 'LIST',
            'ADDITIONAL_VALUES' => 'Y',
            'VALUES' => $UserGroup,
            'MULTIPLE' => 'Y'
        ),
        'DOMAIN_USER_MAIL' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage("DOMAIN_USER_MAIL"),
            'TYPE' => 'TEXT',
            'VALUES' => '',
            'DEFAULT' => 'studiofact.ru'
        ),
        'BUY_USER' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage("BUY_USER"),
            'TYPE' => 'LIST',
            'VALUES' => $UserList,
            'ADDITIONAL_VALUES' => 'Y',
        ),
        'OBJECT_USER_FILDS' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage("OBJECT_USER_FILDS"),
            'TYPE' => 'LIST',
            'VALUES' => $ObjectUserFilds,
            'REFRESH' => 'Y',
            'MULTIPLE' => 'N',
            'ADDITIONAL_VALUES' => 'Y',
        ),
        'EMAIL_USER_FILDS' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage("EMAIL_USER_FILDS"),
            'TYPE' => 'LIST',
            'VALUES' => $arResUserTypeNameListResult,
        ),
        'LOGIN_USER_FILDS' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage("LOGIN_USER_FILDS"),
            'TYPE' => 'LIST',
            'VALUES' => $arResUserTypeNameListResult,
        ),
        'PHONE_USER_FILDS' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage("PHONE_USER_FILDS"),
            'TYPE' => 'LIST',
            'VALUES' => $arResUserTypeNameListResult,
        ),
        'NAME_USER_FILDS' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage("NAME_USER_FILDS"),
            'TYPE' => 'LIST',
            'VALUES' => $arResUserTypeNameListResult,
        ),
        'CONTEYNER_ID_ELEMENT' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage("CONTEYNER_ID_ELEMENT"),
            'TYPE' => 'TEXT',
            'VALUES' => '',
        ),
        'CONTEYNER_ID_OFFER' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage("CONTEYNER_ID_OFFER"),
            'TYPE' => 'TEXT',
            'VALUES' => '',
        ),
        'CONTEYNER_ID_QUANTITY' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage("CONTEYNER_ID_QUANTITY"),
            'TYPE' => 'TEXT',
            'VALUES' => '',
        ),
        'BUTTON_NAME' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage("BUTTON_NAME"),
            'TYPE' => 'TEXT',
            'VALUES' => '',
            'DEFAULT' => GetMessage('BY'),
        ),
        'CLASS_BUTTON_BUY_ONE_CLICK' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage("CLASS_BUTTON_BUY_ONE_CLICK"),
            'TYPE' => 'TEXT',
            'VALUES' => '',
            'DEFAULT' => 'factOrderClick',
        ),
        'CLASS_INPUT_TYPE_TEXT' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage("CLASS_INPUT_TYPE_TEXT"),
            'TYPE' => 'TEXT',
            'VALUES' => '',
            'DEFAULT' => '',
        ),
        'OTHER_PROP' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage("OTHER_PROP"),
            'TYPE' => 'TEXT',
            'VALUES' => '',
            'DEFAULT' => '',
        ),
        'CLEAR_CART' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage("CLEAR_CART"),
            'TYPE' => 'TEXT',
            'VALUES' => '',
            'DEFAULT' => 'Y',
        ),
        'SELECT_PLACEHOLDER' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage("SELECT_PLACEHOLDER"),
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => '',
        ),

    )
);
?>
