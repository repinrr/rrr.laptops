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
$APPLICATION->SetTitle(Loc::getMessage("T_LAPTOPS_BRANDS_BRAND"));
$APPLICATION->AddChainItem(
  Loc::getMessage("T_LAPTOPS_BRANDS_BRAND"),
  $arResult["FOLDER"]
);
$APPLICATION->IncludeComponent(
  "bitrix:breadcrumb",
  "",
  [
    "START_FROM" => "0",
    "PATH"       => "",
    "SITE_ID"    => "s1",
  ]
);

$APPLICATION->IncludeComponent(
  "rrr:laptops.list",
  "",
  [
    "ENTITY_NAME" => $arParams["ENTITY_NAME_BRAND"],
    "PROPERTY_CODE" => $arParams["PROPERTY_CODE_BRAND"],
    "DETAIL_URL" => "#CODE#/",

  ],
  $component
);
?>