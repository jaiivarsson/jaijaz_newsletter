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

//////////////////////jaijaz_newsletter_stats//////////////////////
class Jojo_Field_jaijaz_newsletter_stats extends Jojo_Field
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
        $id = $this->table->getRecordID();
        $newsletter = Jojo::selectRow("SELECT * FROM {newsletter_messages} WHERE newsletter_messageid = ?", $id);
        $stats = Jojo_Plugin_jaijaz_newsletter::getStats($newsletter);

        $smarty->assign('fd_field', $this->fd_field);
        $smarty->assign('newsletterid', $id);
        $smarty->assign('stats', $stats);
        $smarty->assign('status', $this->table->getFieldValue('status'));
        $smarty->assign('value', htmlentities($this->value, ENT_COMPAT, 'UTF-8'));
        return $smarty->fetch('admin/fields/jaijaz_newsletter_stats.tpl');
    }

    function setvalue($newvalue)
    {
    }

}
