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


class Jojo_Plugin_Jaijaz_newsletter_unsubscribe extends Jojo_Plugin
{
	function _getContent()
    {
        global $smarty;
        $content = array();
        $id = Jojo::getFormData('id', '');
        $token  = Jojo::getFormData('token', '');
        $email  = Jojo::getFormData('email', '');
        if ($id != '' && $token != '') {
            self::addUnsubcribe($id);
            $user = Jojo::selectRow("SELECT * FROM {newsletter_subscribers} WHERE token = ?", $token);
            if ($user) {
                self::unsubscribeUser($user['newsletter_subscriberid']);
            }

            $content['title'] = "Unsubscribe success";
            $content['content'] = "The address " . $user['email'] . " has been unsubscribed.";

        } elseif ($_POST['submit'] == "Submit" && $email != '') {
            if ($id != '') self::addUnsubcribe($id);
            $user = Jojo::selectRow("SELECT * FROM {newsletter_subscribers} WHERE email = ?", $email);
            if ($user) {
                self::unsubscribeUser($user['newsletter_subscriberid']);
            }

            $content['title'] = "Unsubscribe success";
            $content['content'] = "The address " . $user['email'] . " has been unsubscribed.";
        } else {
            if ($id != '') {
                $smarty->assign('id', $id);
            }
            $content['title'] = "Unsubscribe";
            $content['content'] = $smarty->fetch('newsletter_unsubscribe.tpl');
        }

        return $content;
    }

    function getCorrectUrl()
    {
        //Assume the URL is correct
        return _PROTOCOL.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }

    function addUnsubcribe($newsletterid)
    {
        Jojo::updateQuery("UPDATE {newsletter_messages} SET unsubscribe = unsubscribe+1 WHERE newsletter_messageid = ?", $newsletterid);
    }

    function unsubscribeUser($id)
    {
        Jojo::updateQuery("UPDATE {newsletter_subscribers} SET status = ?, unsubscribed_date = ? WHERE newsletter_subscriberid = ?", array('unsubscribed', time(), $id));
    }
}