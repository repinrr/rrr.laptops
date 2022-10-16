<?php

use Bitrix\Main\Grid\Options as GridOptions;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI\PageNavigation;

class CLaptopsList extends CBitrixComponent
{

    public function executeComponent()
    {
        global $APPLICATION;
        if (!Loader::includeModule('rrr.laptops')) {
            return false;
        }

        if ($this->arParams["FILTER_NAME"] == ''
            || !preg_match(
            "/^[A-Za-z_][A-Za-z01-9_]*$/",
            $this->arParams["FILTER_NAME"]
          )
        ) {
            $arrFilter = [];
        } else {
            $arrFilter = $GLOBALS[$this->arParams["FILTER_NAME"]];
            if (!is_array($arrFilter)) {
                $arrFilter = [];
            }
        }


        $namespase = "Rrr\Laptops\\";
        if (!$this->arParams["ENTITY_NAME"]
            || empty($this->arParams["ENTITY_NAME"])
        ) {
            $this->arParams["ENTITY_NAME"] = "BrandTable";
        }

        if (count($this->arParams["PROPERTY_CODE"]) == 0) {
            $this->arParams["PROPERTY_CODE"] = ["ID", "NAME"];
        }

        $entity = $namespase.$this->arParams["ENTITY_NAME"];

        $list_id = 'list';

        $grid_options = new GridOptions($list_id);
        $sort         = $grid_options->GetSorting(
          [
            'sort' => ['ID' => 'ASC'],
            'vars' => ['by' => 'by', 'order' => 'order'],
          ]
        );
        $nav_params   = $grid_options->GetNavParams();

        $nav = new PageNavigation('request_list');
        $nav->allowAllRecords(true)
            ->setPageSize($nav_params['nPageSize'])
            ->initFromUri();

        $parameters = [
          'select'      => [
            "*",
          ],
          "count_total" => true,
          'offset'      => $nav->getOffset(),
          'limit'       => $nav->getLimit(),
          'order'       => $sort['sort'],
        ];
        if (count($arrFilter) > 0) {
            $parameters['filter'] = $arrFilter;
        }


        $res           = $entity::getList($parameters);
        $countElements = $res->getCount();

        if ($countElements <= 0) {
            if (!defined("ERROR_404")) {
                define("ERROR_404", "Y");
            }

            CHTTP::setStatus("404 Not Found");

            if ($APPLICATION->RestartWorkarea()) {
                $APPLICATION->SetTitle("404 Not Found");
                die();
            }
        }

        $arElements = $res->fetchAll();
        $nav->setRecordCount($countElements);


        $columns = [];
        $keys    = array_keys($arElements[0]);
        foreach ($keys as $key) {
            if (in_array($key, $this->arParams["PROPERTY_CODE"])) {
                $columns[] = [
                  'id'      => $key,
                  'name'    => Loc::getMessage("C_LAPTOPS_LIST_".$key),
                  'sort'    => $key,
                  'default' => true,
                ];
            }
        }


        foreach ($arElements as $element) {
            $element["DETAIL_URL"] = $this->arParams["DETAIL_URL"];

            foreach ($element as $key => $val) {
                $element["DETAIL_URL"] = str_replace(
                  "#$key#",
                  $val,
                  $element["DETAIL_URL"]
                );
            }

            $listElements[] = [
              "data" => $element,
              'link' => $element["DETAIL_URL"],

            ];
        }

        $this->arResult["list"]    = $listElements;
        $this->arResult["list_id"] = $list_id;
        $this->arResult["columns"] = $columns;
        $this->arResult["nav"]     = $nav;

        $this->includeComponentTemplate();
    }

}