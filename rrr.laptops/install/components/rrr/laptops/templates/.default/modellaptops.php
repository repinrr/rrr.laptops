<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>
<?
global $arFilter;

$APPLICATION->SetTitle(
  $arResult["VARIABLES"]["BRAND"]." ".$arResult["VARIABLES"]["MODEL"]
);

$APPLICATION->AddChainItem(
  Loc::getMessage("T_LAPTOPS_MODELLAPTOPS_BRAND"),
  $arResult["FOLDER"]
);
$APPLICATION->AddChainItem(
  $arResult["VARIABLES"]["BRAND"],
  $arResult["FOLDER"].$arResult["VARIABLES"]["BRAND"]."/"
);
$APPLICATION->AddChainItem(
  $arResult["VARIABLES"]["MODEL"],
  $arResult["FOLDER"].$arResult["VARIABLES"]["BRAND"]."/"
  .$arResult["VARIABLES"]["MODEL"]."/"
);
?>
<?
$APPLICATION->IncludeComponent(
  "bitrix:breadcrumb",
  "",
  [
    "START_FROM" => "0",
    "PATH"       => "",
    "SITE_ID"    => "s1",
  ]
);

$arFilter = [
  "MODEL.CODE" => $arResult["VARIABLES"]["MODEL"],
];
$APPLICATION->IncludeComponent(
  "rrr:laptops.list",
  "",
  [
    "ENTITY_NAME" => $arParams["ENTITY_NAME_LAPTOP"],
    "PROPERTY_CODE" => $arParams["PROPERTY_CODE_LAPTOP"],
    "DETAIL_URL" => $arResult["FOLDER"]."detail/#CODE#/",
    "FILTER_NAME" => "arFilter",

  ],
  $component
); ?>