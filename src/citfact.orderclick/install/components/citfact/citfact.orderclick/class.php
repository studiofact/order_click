<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class OrderClick
{

    private function GeneratePassword($number)
    {
        $arr = array('a', 'b', 'c', 'd', 'e', 'f',
            'g', 'h', 'i', 'j', 'k', 'l',
            'm', 'n', 'o', 'p', 'r', 's',
            't', 'u', 'v', 'x', 'y', 'z',
            'A', 'B', 'C', 'D', 'E', 'F',
            'G', 'H', 'I', 'J', 'K', 'L',
            'M', 'N', 'O', 'P', 'R', 'S',
            'T', 'U', 'V', 'X', 'Y', 'Z',
            '1', '2', '3', '4', '5', '6',
            '7', '8', '9', '0');
        $pass = "";
        for ($i = 0; $i < $number; $i++) {
            $index = rand(0, count($arr) - 1);
            $pass .= $arr[$index];
        }
        return $pass;
    }

    public static function UserCreate($name, $phone, $domen, $login, $group) //$name - string, $phone - string, $domen - string, $login - string, $group - array
    {

        if (CUser::IsAuthorized()) {
            $userId = CUser::GetID();
            return (int)$userId;
        } else {
            $usersCheck = CUser::GetByLogin($login);
            if ($arUser = $usersCheck->Fetch()) {
                return (int)$arUser["ID"];
            } else {
                $password = OrderClick::GeneratePassword(10);
                $user = new CUser;
                $arFields = Array(
                    "NAME" => $name,
                    "EMAIL" => $phone . "@" . $domen,
                    "LOGIN" => $phone,
                    "ACTIVE" => "N", // Делаю пользователя не активным
                    "GROUP_ID" => $group,
                    "PASSWORD" => $password,
                    "CONFIRM_PASSWORD" => $password,
                );
                return $user->Add($arFields);
            }
        }

    }

    public static function AddProduct($idProduct, $quantity, $arRewriteFields, $arProductParams, $userId, $currency, $personType, $clearCart)
    {
        if (CModule::IncludeModule("catalog")) {

            if ($clearCart == "Y") {
                CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());
            }

            if (Add2BasketByProductID($idProduct, $quantity, $arRewriteFields, $arProductParams)) { // В корзину

                // Получаю параметры корзины
                $dbBasketItems = CSaleBasket::GetList(array("NAME" => "ASC", "ID" => "ASC"), array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "ORDER_ID" => "NULL"), false, false, array("ID", "PRODUCT_ID", "QUANTITY", "DELAY", "CAN_BUY", "PRICE"));
                while ($arItems = $dbBasketItems->Fetch()) {
                    $arBasketItems[] = $arItems;
                }

                foreach ($arBasketItems as $valBasketItems) {
                    $productPriceSumm = $productPriceSumm + ((int)$valBasketItems["QUANTITY"] * (int)$valBasketItems["PRICE"]);
                }


                // Создаю заказ
                $arOrderFields = array(
                    "LID" => SITE_ID,
                    "PERSON_TYPE_ID" => $personType,
                    "PAYED" => "N",
                    "CANCELED" => "N",
                    "STATUS_ID" => "N",
                    "PRICE" => $productPriceSumm,
                    "CURRENCY" => $currency,
                    "USER_ID" => $userId,
                    "USER_DESCRIPTION" => "",
                    "ADDITIONAL_INFO" => ""
                );

                $ORDER_ID = CSaleOrder::Add($arOrderFields);

                // Привязываем товары из корзины текущего пользователя к заказу

                CSaleBasket::OrderBasket($ORDER_ID, CSaleBasket::GetBasketUserID(), SITE_ID, false);

                return CSaleBasket::GetBasketUserID();

            }


        } else {
            return false;
        }
    }

    	public static function UserFieldsInterface ($arRequest, $objectUserFilds, $placeholder, $inputClass) {
		
		global $APPLICATION;// TO DO
		
		
		
		$UserFilds = $GLOBALS['USER_FIELD_MANAGER']->GetUserFields($objectUserFilds, 0, LANGUAGE_ID);
		
		$offerRequest = (int)$arRequest["OFFER"];
		$elementRequest = (int)$arRequest["ELEMENT"];
		$quantityRequest = (int)$arRequest["QUANTITY"];
		
		if ($offerRequest && $elementRequest) {
			$interface["ELEMENT"] = $offerRequest;
		} elseif (!$offerRequest && $elementRequest) {
			$interface["ELEMENT"] = $elementRequest;
		} elseif ($offerRequest && !$elementRequest) {
			$interface["ELEMENT"] = $offerRequest;
		} else {
			$interface["ELEMENT"] = false;
		}
		
		$interface["QUANTITY"] = ($quantityRequest) ? $quantityRequest : 1;

		$errorFlag = false;
		
		foreach ($UserFilds as $keyUserFilds => $UserFildsValue) {
			if ($UserFildsValue["MULTIPLE"] == "N") {
				switch ($UserFildsValue["USER_TYPE"]["USER_TYPE_ID"]) {
					case "string":
						if (isset($arRequest[$keyUserFilds])) {
							$GLOBALS['USER_FIELD_MANAGER']->CheckFields($objectUserFilds, null, $arRequest);
						}
						$interface["INTERFACE"][$keyUserFilds]["VALUE"] = $arRequest[$keyUserFilds];
						$interface["INTERFACE"][$keyUserFilds]["NAME"]= $UserFildsValue["LIST_COLUMN_LABEL"];
						$interface["INTERFACE"][$keyUserFilds]["MANDATORY"] = $UserFildsValue["MANDATORY"];
						break;
				}
			}
		}

		$inputClassValue = ($inputClass) ? "class=\"".$inputClass."\"" : "";
		
		$errorList = $APPLICATION->GetException();
		
		if (is_object($errorList) && $interface["ELEMENT"]) {
			foreach ($interface["INTERFACE"] as $key => $inputValue) {
				$placeholderline = ($placeholder == "Y") ? "placeholder=\"".$interface["INTERFACE"][$key]["NAME"]."\"" : "";
				$interface["INTERFACE"][$key]["OBJECT"] = "<input type=\"text\" ".$placeholderline." ".$inputClassValue." value=\"".$interface["INTERFACE"][$key]["VALUE"]."\" name=\"".$key."\">";

			}
			foreach ($errorList->messages as $errorElement) {
				$interface["INTERFACE"][$errorElement["id"]]["ERROR"]["MESSAGE"] = $errorElement["text"];
				
			}
			$interface["INTERFACE"]["ELEMENT"]["OBJECT"] = '<input type="hidden" name="ELEMENT" value="'.(int)$arRequest["ELEMENT"].'">';
			$interface["INTERFACE"]["OFFER"]["OBJECT"] = '<input type="hidden" name="OFFER" value="'.(int)$arRequest["OFFER"].'">';
			$interface["INTERFACE"]["QUANTITY"]["OBJECT"] = '<input type="hidden" name="QUANTITY" value="'.(int)$arRequest["QUANTITY"].'">';
			$interface["ERROR"] = true;
			
		} else {
			foreach ($interface["INTERFACE"] as $key => $inputValue) {
				$placeholderline = ($placeholder == "Y") ? "placeholder=\"".$interface["INTERFACE"][$key]["NAME"]."\"" : "";
				$interface["INTERFACE"][$key]["OBJECT"] = "<input type=\"text\" ".$placeholderline." ".$inputClassValue." value=\"\" name=\"".$key."\">";

			}
			$interface["INTERFACE"]["ELEMENT"]["OBJECT"] = '<input type="hidden" name="ELEMENT" value="">';
			$interface["INTERFACE"]["OFFER"]["OBJECT"] = '<input type="hidden" name="OFFER" value="">';
			$interface["INTERFACE"]["QUANTITY"]["OBJECT"] = '<input type="hidden" name="QUANTITY" value="">';
			if ($interface["ELEMENT"]) {
				$interface["ERROR"] = false;
			} else {
				$interface["ERROR"] = true;
			}
		}
		
		
		return $interface;
	}

}

?>
