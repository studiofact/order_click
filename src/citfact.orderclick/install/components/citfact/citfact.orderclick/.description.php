<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arComponentDescription = array(
    "NAME" => GetMessage("T_IBLOCK_DESC_LIST"),
    "DESCRIPTION" => GetMessage("T_IBLOCK_DESC_LIST_DESC"),
    "ICON" => "/images/orderclick.gif",
    "SORT" => 20,
    "CACHE_PATH" => "Y",
    "PATH" => array(
        "ID" => "citfact",
        "NAME" => GetMessage("CITFACT_NAME"),
    ),
);

?>