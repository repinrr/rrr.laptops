<?

use Bitrix\Main\Loader;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/** @var array $arCurrentValues */

if (!Loader::includeModule('rrr.laptops')) {
    return false;
}

$namespase = "Rrr\Laptops\\";
$entity    = $namespase.($arCurrentValues["ENTITY_NAME"]
    ? $arCurrentValues["ENTITY_NAME"] : "BrandTable");

if (!class_exists($entity)) {
    $arProperty = [];
} else {
    $arMapEntity = $entity::getMap();
    $arProperty  = [];
    foreach ($arMapEntity as $colomn) {
        if ($colomn->getTypeMask()
            == Bitrix\Main\ORM\Fields\FieldTypeMask::SCALAR
        ) {
            $arProperty[$colomn->getName()] = GetMessage(
              "P_LAPTOP_LIST_".$colomn->getName()
            );
        }
    }
}

$arComponentParameters = [
  "GROUPS"     => [
  ],
  "PARAMETERS" => [
    "ENTITY_NAME"   => [
      "PARENT"  => "BASE",
      "NAME"    => GetMessage("P_LAPTOP_LIST_ENTITY_NAME"),
      "TYPE"    => "STRING",
      "DEFAULT" => "BrandsTable",
      "REFRESH" => "Y",
    ],
    "FILTER_NAME"   => [
      "PARENT"  => "BASE",
      "NAME"    => GetMessage("P_LAPTOP_LIST_FILTER"),
      "TYPE"    => "STRING",
      "DEFAULT" => "",
    ],
    "DETAIL_URL"    => [
      "PARENT"  => "BASE",
      "NAME"    => GetMessage("P_LAPTOP_LIST_DETAIL_URL"),
      "TYPE"    => "STRING",
      "DEFAULT" => "#CODE#/",
    ],
    "PROPERTY_CODE" => [
      "PARENT"   => "BASE",
      "NAME"     => GetMessage("P_LAPTOP_LIST_PROPERTY_CODE"),
      "TYPE"     => "LIST",
      "MULTIPLE" => "Y",
      "VALUES"   => $arProperty,
    ],
  ],
];