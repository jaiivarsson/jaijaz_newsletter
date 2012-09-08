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

//////////////////////jaijaz_newsletter_send//////////////////////
class Jojo_Field_jaijaz_newsletter_send extends Jojo_Field
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
        $smarty->assign('status', $this->table->getFieldValue('status'));
        $formatteddate = ($this->table->getFieldValue('send_date') > 0) ? strftime("%Y-%m-%d %H:%M", $this->table->getFieldValue('send_date')) : '';
        $smarty->assign('send_date', $formatteddate);
        $smarty->assign('value', htmlentities($this->value, ENT_COMPAT, 'UTF-8'));
        return $smarty->fetch('admin/fields/jaijaz_newsletter_send.tpl');
    }

    function setvalue($newvalue)
    {
    }
    
    function displayJs()
    {
        global $smarty;
        $js = $smarty->fetch('admin/fields/unixdate_js.tpl');
        $js .= $smarty->fetch('admin/fields/jaijaz_newsletter_send_js.tpl');
        return $js;
    }

}
