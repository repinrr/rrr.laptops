<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

$arDefaultUrlTemplates404 = [
  "brands"       => "", //Список производителей
  "models"       => "#BRAND#/", //список моделей производителя
  "detail"       => "detail/#NOTEBOOK#/", //детальная страница ноутбука
  "modellaptops" => "#BRAND#/#MODEL#/", //список ноутбуков модели

];

$arDefaultVariableAliases404 = [];
$arDefaultVariableAliases    = [];

$arComponentVariables = [
  "BRAND",
  "MODEL",
  "NOTEBOOK",
];


$arVariables = [];

$arUrlTemplates    = CComponentEngine::makeComponentUrlTemplates(
  $arDefaultUrlTemplates404,
  $arParams["SEF_URL_TEMPLATES"]
);
$arVariableAliases = CComponentEngine::makeComponentVariableAliases(
  $arDefaultVariableAliases404,
  $arParams["VARIABLE_ALIASES"]
);

$engine = new CComponentEngine($this);


$componentPage = $engine->guessComponentPath(
  $arParams["SEF_FOLDER"],
  $arUrlTemplates,
  $arVariables
);

if (!$componentPage) {
    $componentPage = "brands";
}


CComponentEngine::initComponentVariables(
  $componentPage,
  $arComponentVariables,
  $arVariableAliases,
  $arVariables
);


$arResult = [
  "FOLDER"        => $arParams["SEF_FOLDER"],
  "URL_TEMPLATES" => $arUrlTemplates,
  "VARIABLES"     => $arVariables,
  "ALIASES"       => $arVariableAliases,
];


$this->includeComponentTemplate($componentPage);