<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
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

use Bitrix\Main\Localization\Loc;

Bitrix\Main\UI\Extension::load('ui.bootstrap4');

?>

<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12">
        <h1><?= $arResult["ELEMENT"]->getName(); ?></h1>
        <span>   <h3><?= Loc::getMessage(
                  "T_LAPTOP_DETAIL_PRICE_NAME"
                ) ?> - <?= $component->format_price(
                  $arResult["ELEMENT"]->getPrice()
                ); ?> <?= Loc::getMessage(
                  "T_LAPTOP_DETAIL_PRICE_CURRENCY"
                ) ?></h3></span>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-12 desc">
        <h3>
            <font color="#3AC1EF">
                ▍<?= Loc::getMessage("T_LAPTOP_DETAIL_BRAND") ?> -
                <?= $arResult["ELEMENT"]->getModel()->getBrand()->getName(); ?>
            </font>
        </h3>
        <h3>
            <font color="#3AC1EF">
                ▍<?= Loc::getMessage("T_LAPTOP_DETAIL_MODEL") ?>
                - <?= $arResult["ELEMENT"]->getModel()->getName(); ?>
            </font>
        </h3>
        <p>
        <h4><?= Loc::getMessage("T_LAPTOP_DETAIL_YEAR") ?>
            - <?= $arResult["ELEMENT"]->getYear(); ?></h4>

        </p>
        <p>
        <h4><?= Loc::getMessage("T_LAPTOP_DETAIL_OPTIONS") ?>:</h4>
        <ul class="list-unstyled">
            <?
            foreach ($arResult["ELEMENT"]->getOptions() as $option) {
                echo "<li>".$option->getName()."</li>";
            } ?>
        </ul>
        </p>
    </div>
</div>