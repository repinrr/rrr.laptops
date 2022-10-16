<?php

use Bitrix\Main\Loader;

class CLaptopsDetail extends CBitrixComponent
{


    public function executeComponent()
    {
        global $APPLICATION;
        if (!Loader::includeModule('rrr.laptops')) {
            return false;
        }

        $namespase = "Rrr\Laptops\\";
        $entity = $namespase.$this->arParams["ENTITY_NAME"];

        $parameters = [
          'select' => [
            "*",
            "OPTIONS",
            "MODEL",
            "MODEL.BRAND",
          ],
          'filter' => ["CODE" => $this->__parent->arResult["VARIABLES"]["NOTEBOOK"]],
        ];

        $res       = $entity::getList($parameters);
        $arElement = $res->fetchObject();

        if (!$arElement) {
            if (!defined("ERROR_404")) {
                define("ERROR_404", "Y");
            }

            CHTTP::setStatus("404 Not Found");

            if ($APPLICATION->RestartWorkarea()) {
                $APPLICATION->SetTitle("404 Not Found");
                die();
            }
        }

        $APPLICATION->AddChainItem(
          $arElement->getModel()->getBrand()->getCode(),
          $this->__parent->arResult["FOLDER"].$arElement->getModel()
                                                        ->getBrand()
                                                        ->getCode()."/"
        );
        $APPLICATION->AddChainItem(
          $arElement->getModel()->getName(),
          $this->__parent->arResult["FOLDER"].$arElement->getModel()
                                                        ->getBrand()
                                                        ->getCode().
          "/".$arElement->getModel()->getCode()."/"
        );

        $APPLICATION->SetTitle($arElement->getName());

        $this->arResult["ELEMENT"] = $arElement;

        $this->includeComponentTemplate();
    }

    public function format_price($value)
    {
        $value = number_format($value, 2, ',', ' ');
        $value = str_replace(',00', '', $value);

        if (!empty($unit)) {
            $value .= ' '.$unit;
        }

        return $value;
    }

}