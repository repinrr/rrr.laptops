<?php

use Bitrix\Main\Application;
use Bitrix\Main\Entity\Base;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);


class rrr_laptops extends CModule
{


    public $MODULE_ID = "rrr.laptops";

    public $MODULE_VERSION;

    public $MODULE_VERSION_DATE;

    public $MODULE_NAME;

    public $MODULE_DESCRIPTION;

    public $MODULE_GROUP_RIGHTS;

    public $errors;

    public $arEntities
      = [
        "BrandTable",
        "ModelTable",
        "LaptopTable",
        "OptionTable",
        "LaptopOptionTable",
      ];

    public $namespase;

    public function __construct()
    {
        $this->MODULE_VERSION      = "1.0.0";
        $this->MODULE_VERSION_DATE = "17.10.2022";
        $this->MODULE_NAME         = "Магазин ноутбуков";
        $this->MODULE_DESCRIPTION
                                   = "Модуль решает проблемы хранения и поиска ноутбуков на сайте интернет-магазина.";

        $this->namespase = str_replace(".", "\\", $this->MODULE_ID)."\\";

        $this->MODULE_GROUP_RIGHTS = "Y";
    }

    public function DoInstall()
    {
        global $step, $APPLICATION, $delete_table;

        $step = IntVal($step);
        if ($step < 2) {
            $APPLICATION->IncludeAdminFile(
              Loc::getMessage("LAPTOPS_INSTALL_TITLE"),
              __DIR__."/step1.php"
            );
        } elseif ($step == 2) {
            RegisterModule($this->MODULE_ID);
            $this->InstallDB($delete_table);
            $this->InstallEvents();
            $this->InstallFiles();
        }
    }

    public function InstallDB($delete = false)
    {
        if ($delete) {
            $this->UnInstallDB($delete);
        }

        if (Loader::includeModule($this->MODULE_ID)) {
            $connection = Application::getConnection();


            foreach ($this->arEntities as $entity) {
                $nameClass = $this->namespase.$entity;
                if (!class_exists($nameClass)) {
                    return false;
                }


                if (!$this->checkEntity($nameClass)) {
                    $nameClass::getEntity()
                              ->createDbTable();

                    $this->installDemo($entity);
                }
            }
        }
    }

    public function UnInstallDB()
    {
        if (Loader::includeModule($this->MODULE_ID)) {
            $connection = Application::getInstance()->getConnection();
            foreach ($this->arEntities as $entity) {
                $nameClass = $this->namespase.$entity;


                if (!class_exists($nameClass)) {
                    return false;
                }

                if ($this->checkEntity($nameClass)) {
                    $connection->dropTable(
                      $nameClass::getTableName()
                    );
                }
            }
        }
    }

    public function checkEntity($entityName)
    {
        return Application::getConnection()->isTableExists(
          Base::getInstance($entityName)->getDBTableName()
        );
    }

    public function installDemo($entity)
    {
        $nameClass         = $this->namespase.$entity;
        $arParamsTranslite = ["replace_space" => "_", "replace_other" => "_"];

        $data = json_decode(
          file_get_contents(__DIR__."/demo/$entity.json"),
          true
        );


        foreach ($data as $element) {
            $entityObject = $nameClass::createObject();

            foreach ($element as $attrName => $value) {
                $entityObject->set($attrName, $value);
            }

            $entityObject->save();
        }
    }

    public function InstallEvents()
    {
        return true;
    }

    public function InstallFiles()
    {
        CopyDirFiles(
          $_SERVER["DOCUMENT_ROOT"]."/local/modules/rrr.laptops/install/components/",
          $_SERVER["DOCUMENT_ROOT"]."/local/components",
          true, true
        );

        CopyDirFiles(
          $_SERVER["DOCUMENT_ROOT"]."/local/modules/rrr.laptops/install/templates/",
          $_SERVER["DOCUMENT_ROOT"]."/local/templates",
          true, true
        );

        return true;
    }

    public function DoUninstall()
    {
        global $step, $APPLICATION, $delete_table;

        $step = IntVal($step);
        if ($step < 2) {
            $APPLICATION->IncludeAdminFile(
              Loc::getMessage("LAPTOPS_INSTALL_TITLE"),
              __DIR__."/unstep1.php"
            );
        } elseif ($step == 2) {
            if ($delete_table) {
                $this->UnInstallDB();
            }

            UnRegisterModule($this->MODULE_ID);
        }
    }

    public function UnInstallEvents()
    {
        return true;
    }

    public function UnInstallFiles()
    {
        return true;
    }

    public function GetModuleRightList()
    {
        $arr = [
          "reference_id" => ["D", "R", "W"],
          "reference"    => [
            "[D] ".Loc::getMessage("LAPTOPS_DENIED"),
            "[R] ".Loc::getMessage("LAPTOPS_OPENED"),
            "[W] ".Loc::getMessage("LAPTOPS_FULL"),
          ],
        ];
        return $arr;
    }

}