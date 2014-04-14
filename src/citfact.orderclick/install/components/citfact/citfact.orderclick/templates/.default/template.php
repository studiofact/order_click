<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div id="comp_<?= $arResult["AJAX_ID"]; ?>">

    <?if ($_REQUEST["orderclickajax"] == "Y") {
        $APPLICATION->RestartBuffer();
        $window = "style=\"display:block;\"";
    } else {
        $window = "style=\"display:none;\"";
    }?>

    <div id="orderClickModalWindow" <?= $window ?> >
        <div id="orderClickView">
            <a href="#" class="closeModalWindow"></a>

            <form id="orderClickForm" method="post" action="<?=POST_FORM_ACTION_URI?>">
                <?= bitrix_sessid_post() ?>
                <input type="hidden" name="orderclickajax" value="Y">
                <?
                foreach ($arResult["INTERFACE"] as $key => $valueInterface) {
                    // помечаем обязательное поле
                    $mandatory = ($valueInterface["MANDATORY"] == "Y") ? "*" : "";
                    // помечаем поле с ошибкой
                    $error = ($valueInterface["ERROR"]["MESSAGE"]) ? "errorInput" : "";
                    // исключаем служебные поля
                    if ($key != "ELEMENT" && $key != "OFFER" && $key != "QUANTITY") {
                        echo "<div class='input " . $error . "'>" . $valueInterface["OBJECT"] . "</div>";
                    } else {
                        echo $valueInterface["OBJECT"];
                    }
                }

                ?>
                <a href='/' onclick="orderClick(); return false;"
                   class='button center_m'><?= $arParams["BUTTON_NAME"] ?></a>
            </form>
        </div>
    </div>

    <? // создаем переменные javascript ?>

    <script>
        var idElement = "<?=$arParams["CONTEYNER_ID_ELEMENT"]?>";
        var idOffer = "<?=$arParams["CONTEYNER_ID_OFFER"]?>";
        var idQuantity = "<?=$arParams["CONTEYNER_ID_QUANTITY"]?>";
        var classButtonOneClick = "<?=$arParams["CLASS_BUTTON_BUY_ONE_CLICK"]?>";
        var dirScript = "<?=POST_FORM_ACTION_URI?>";
        var ajaxId = "comp_<?=$arResult["AJAX_ID"]?>";
    </script>

    <?if ($_REQUEST["orderclickajax"] == "Y") {
        die();
    }?>

</div>
