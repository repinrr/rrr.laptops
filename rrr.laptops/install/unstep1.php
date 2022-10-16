<?php

global $APPLICATION;

use Bitrix\Main\Localization\Loc; ?>
<form action="<?
echo $APPLICATION->GetCurPage() ?>">
    <?= bitrix_sessid_post() ?>
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
    <input type="hidden" name="id" value="form">
    <input type="hidden" name="uninstall" value="Y">
    <input type="hidden" name="step" value="2">
    <input type="hidden" name="id" value="rrr.laptops">
    <?
    echo CAdminMessage::ShowMessage(Loc::getMessage("MOD_UNINST_WARN")) ?>
    <p><input type="checkbox" name="delete_table" id="delete_table" value="Y"
              checked><label for="delete_table"><?
            echo Loc::getMessage("DELETE_TABLE") ?></label></p>
    <input type="submit" name="inst" value="<?
    echo Loc::getMessage("MOD_UNINST_DEL") ?>">
</form>