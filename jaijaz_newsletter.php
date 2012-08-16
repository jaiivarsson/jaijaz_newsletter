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


class Jojo_Plugin_Jaijaz_newsletter extends Jojo_Plugin
{
    function _getContent()
    {
        global $smarty;
        $content = array();

        //$content['title']      = 'TITLE HERE';     //optional title, will be displayed as the H1 heading, amongst other uses. Defaults to whatever was entered in the admin section.
        //$content['seotitle']   = 'SEO TITLE HERE'; //optional SEO title, will be displayed as the main title for the page, and in Google results. Defaults to whatever was entered in the admin section.
        //$content['css']        = '';               //need some CSS code just for this page? Add the code to this variable and it will be included in the document head, just for this page. <style> tags are not required.
        //$content['javascript'] = '';               //Same as for CSS - <script> tags are not required.
        $content['content']  = $smarty->fetch('empty_plugin.tpl');
        return $content;
    }

    function getCorrectUrl()
    {
        //Assume the URL is correct
        return _PROTOCOL.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }
    
    /** 
     * compile the html for the newsletter
     * 
     * @param $newsletter array
     * 
     * @return $html string
     */
    function assementHtml($newsletter = false)
    {
        if (!$newsletter)
            return "";
        
        $html = "";
        // TODO: check other plugins for content
        
        $html .= $newsletter['body'];
        // return the html
        return $html;
    }
    
    /** 
     * send a newsletter to the emailer plugin to schedule the sending
     * 
     * @param $id int the newsletter id to be scheduled
     * @param $scheduledate int the unix timestamp of when you wish the newsletter to be sent
     * 
     * @return $result array whether it was successfully sceduled and a message
     */
    function sendNewsletter($id = 0, $scheduledate = false)
    {
        if (!$scheduledate)
            $scheduledate = time();
        
        // setup the return array
        $return = array();
        // get the newsletter
        $newsletter = Jojo::selectRow("SELECT * FROM {newsletter_messages} WHERE newsletter_messageid =?", $id);
        if (!$newsletter) {
            $return['result'] = false;
            $return['message'] = "Couldn't find the newsletter to send";
            return $return;
        }
            
        
        // get the list of people to receive the newsletter
        $receiptiants = Jojo::selectQuery("SELECT DISTINCT s.* FROM {newsletter_subscribers} s LEFT JOIN {newsletter_list_subscribers} ls ON s.newsletter_subscriberid = ls.newsletter_subscriberid LEFT JOIN {newsletter_message_lists} ml ON ls.newsletter_listid = ml.newsletter_listid WHERE ml.newsletter_messageid = ?", $id);
        var_dump($receiptiants);
        if (!$receiptiants) {
            $return['result'] = false;
            $return['message'] = "Couldn't find and people to send it to. Make sure you have selected a list.";
            return $return;
        }
        
        // loop through receipiants and schedule the email
        foreach ($receiptiants as $r => $recipiant) {
            $res = self::queueNewsletter($newsletter, $recipiant, $scheduledate);
            if ($res) {
                $return['message'] = "Newsletter has been queued";
                $return['result'] = true;
            } else {
                $return['message'] = "Newsletter has not been queued";
                $return['result'] = false;
            }
        }
        // if scheduled date in the past call the send process
        if ($scheduledate <= time()) {
            $res = Jojo_Plugin_Jaijaz_emailer::sendQueuedEmails();
            if ($res) {
                $return['message'] = "Newsletter has started sending";
                $return['result'] = true;
            } else {
                $return['message'] = "Newsletter has not started sending";
                $return['result'] = false;
            }
        }
        
        return $return;
    }
    
    /**
     * queue an email into the emailer plugin
     * 
     * @param $newslettter array
     * @param $recipiant array
     * 
     */
    function queueNewsletter($newsletter = false, $recipiant = false, $scheduledate = false)
    {
        if (!$newsletter || !$recipiant) {
            return false;
        }
            
        if (!$scheduledate)
            $scheduledate = time();
        
        // include the emailer class
        foreach (Jojo::listPlugins('classes/jaijaz_emailer_email.class.php') as $pluginfile) {
            require_once($pluginfile);
            break;
        }
        
        // create emailer object and set everything
        $email = new Jaijaz_Emailer_Email();
        $email->receiverid      = $recipiant['newsletter_subscriberid'];
        $email->messageid       = $newsletter['newsletter_messageid'];
        $email->plugin          = "jaijaz_newsletter";
        $email->to_address      = $recipiant['newsletter_subscriberid'];
        $email->to_name         = $recipiant['firstname'] . " " . $recipiant['lastname'];
        $email->from_address    = Jojo::either(Jojo::getOption('jaijaz_newsletter_fromaddress'), _FROMADDRESS, _CONTACTADDRESS, _WEBMASTERADDRESS);
        $email->from_name       = Jojo::either(Jojo::getOption('jaijaz_newsletter_fromname'), _FROMNAME, _CONTACTNAME, _SITETITLE);
        $email->templateid      = $newsletter['template'];
        $email->subject         = $newsletter['subject'];
        $email->message_html    = self::assementHtml($newsletter);
        $email->merge_fields    = array( 'firstname' => $recipiant['firstname'] );
        $email->smtpapi         = array( 'newsletter_messageid' => $newsletter['newsletter_messageid'] );
        $email->send_embargo    = $scheduledate;
        
        // check not a duplicate
        if ($email->checkNotDuplicate()) {
            // save object
            return $email->saveToDb();
        } else {
            return false;
        }
    }

}