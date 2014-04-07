order_click
===========

Заказ в один клик



<?$APPLICATION->IncludeComponent("citfact:citfact.orderclick", ".default", array(
	"PERSON_TYPE" => "1",
	"USER_GROUP" => array(
		0 => "5",
		1 => "",
	),
	"DOMAIN_USER_MAIL" => "studiofact.ru",
	"BUY_USER" => "",
	"OBJECT_USER_FILDS" => "ORDER_CLICK_1",
	"EMAIL_USER_FILDS" => "UF_PHONE",
	"LOGIN_USER_FILDS" => "UF_PHONE",
	"PHONE_USER_FILDS" => "UF_PHONE",
	"NAME_USER_FILDS" => "UF_NAME",
	"CONTEYNER_ID_ELEMENT" => "data-idelement",
	"CONTEYNER_ID_OFFER" => "data-offer",
	"CONTEYNER_ID_QUANTITY" => "productQuantity_",
	"OTHER_PROP" => "",
	"BUTTON_NAME" => "Купить",
	"CLASS_BUTTON_BUY_ONE_CLICK" => "factOrderClick",
	"CLASS_INPUT_TYPE_TEXT" => "",
	"SELECT_PLACEHOLDER" => "Y", 
	"CLEAR_CART" => "Y",
	),
	false
);?>
