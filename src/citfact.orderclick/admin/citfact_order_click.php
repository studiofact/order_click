<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");
CModule::IncludeModule("iblock");
IncludeModuleLangFile(__FILE__);

$sModuleId = 'citfact.orderclick';

// $IBLOCK_ID = IBLOCK_CATALOG;
// $IBLOCK_ID = COption::GetOptionString( $sModuleId, 'id_block_trade_filtersorter');

CJSCore::Init(array("jquery"));?>


<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");

$aTabs = array(
    array("DIV" => "edit1", "TAB" => GetMessage("FACT_TAB1_HEADER"), "TITLE" => GetMessage("FACT_TAB1_HEADER")),
);
$tabControl = new CAdminTabControl("tabControl", $aTabs);
?>

<form method="post" action="<? echo $APPLICATION->GetCurPage() ?>" enctype="multipart/form-data" name="post_form"
      id="post_form">

    <?
    echo bitrix_sessid_post();
    $tabControl->Begin();
    ?>

    <? $tabControl->BeginNextTab(); ?>
    <tr>
        <td>

            <a href="/bitrix/admin/userfield_admin.php?lang=<?= LANGUAGE_ID ?>&set_filter=Y&find=ORDER_CLICK_1&find_type=ENTITY_ID&back_url=<?= urlencode($APPLICATION->GetCurPageParam()) ?>"><?= GetMessage("FACT_ORDER_CLICK_VIEW_USER_PROP") ?></a><br/>
            <a href="/bitrix/admin/userfield_edit.php?lang=<?= LANGUAGE_ID ?>&ENTITY_ID=ORDER_CLICK_1&back_url=<?= urlencode($APPLICATION->GetCurPageParam()) ?>"><?= GetMessage("FACT_ORDER_CLICK_CREATE_USER_PROP") ?></a>


        </td>
    </tr>

    <? $tabControl->Buttons(); ?>
    <? /* <input  class="adm-btn" type="submit" name="Update" value="<?=GetMessage("FACT_SAVE"); ?>" title="<?=GetMessage("FACT_SAVE"); ?>"> */ ?>
    <? $tabControl->End(); ?>

    <? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php"); ?>

</form>