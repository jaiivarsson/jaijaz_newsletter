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


class Jojo_Plugin_Jaijaz_newsletter_admin_stats extends Jojo_Plugin
{
    function _getContent()
    {
        global $smarty;
        $content = array();
        jojo_plugin_Admin::adminMenu();

        $newsletters = Jojo::selectQuery("SELECT * FROM {newsletter_messages} WHERE status = ?", 'sent');

        foreach ($newsletters as $n => $newsletter) {
            $newsletters[$n]['stats'] = Jojo_Plugin_Jaijaz_newsletter::getStats($newsletter);
        }
        $smarty->assign('newsletters', $newsletters);
        $smarty->assign('title', "Newsletter Statistics");

        $content['content']  = $smarty->fetch('admin/newsletter_admin_stats.tpl');
        return $content;
    }

    function getCorrectUrl()
    {
        //Assume the URL is correct
        return _PROTOCOL.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }

    

}
