<?php

global $APPLICATION;

use Bitrix\Main\Localization\Loc; ?>
<form action="<?
echo $APPLICATION->GetCurPage() ?>" name="form1">
    <?= bitrix_sessid_post() ?>
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
    <input type="hidden" name="id" value="form">
    <input type="hidden" name="install" value="Y">
    <input type="hidden" name="step" value="2">
    <input type="hidden" name="id" value="rrr.laptops">
    <script language="JavaScript">

        function ChangeInstallPublic(val) {
            document.form1.public_dir.disabled = !val;
            document.form1.public_rewrite.disabled = !val;
        }

    </script>

    <table cellpadding="3" cellspacing="0" border="0" width="0%">
        <tr>
            <td><input type="checkbox" name="delete_table" value="Y"
                       id="id_delete_table"
                       onClick="ChangeInstallPublic(this.checked)"></td>
            <td><p><label for="id_delete_table"><?= Loc::getMessage(
                          "DELETE_TABLE_AND_CREATE_NEW"
                        ) ?></label></p></td>
        </tr>
    </table>

    <script language="JavaScript">
        <!--
        ChangeInstallPublic(false);
        //-->
    </script>
    <br>
    <input type="submit" name="inst"
           value="<?= Loc::getMessage("MOD_INSTALL") ?>">
</form>