<?php
/**
     *                     Jaijaz newsletter module
     *                ==================================
     *
     * Copyright 2010 Jaijaz <info@jaijaz.co.nz>
     *
     * See the enclosed file license.txt for license information (LGPL). If you
     * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
     *
     * @author  Jai Ivarsson <jai@jaijaz.co.nz>
     * @link    http://www.jaijaz.co.nz
     */

//////////////////////jaijaz_newsletter_messages//////////////////////
class Jojo_Field_jaijaz_newsletter_messages extends Jojo_Field
{
    var $rows;
    var $options;

    function checkvalue()
    {
        return true;
    }

    function displayedit()
    {
        global $smarty;
        $smarty->assign('fd_field', $this->fd_field);
        $smarty->assign('newsletterid', $this->table->getRecordID());
        $smarty->assign('value', htmlentities($this->value, ENT_COMPAT, 'UTF-8'));
        return $smarty->fetch('admin/fields/jaijaz_newsletter_messages.tpl');
    }

    function setvalue($newvalue)
    {
    }
}
