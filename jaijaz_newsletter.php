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
        $id = Jojo::getFormData('id', 0);

        if ($id) {
            $content = self::getNewsletterHtml($id, true);
            
            // send it to the browser
            header('Content-Type: text/html');
            header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
            header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
            echo $content;
            exit;

        } else {
            // get all the newsletter and display them in a list
            $newsletters = Jojo::selectQuery("SELECT * FROM {newsletter_messages} WHERE status = ?", 'sent');
            foreach ($newsletters as $n => $newsletter) {
                $newsletters[$n]['url'] = Jojo::rewrite('newsletters', $newsletter['newsletter_messageid'], $newsletter['subject'], '');
            }
            $smarty->assign('newsletters', $newsletters);

            $content['content']  = $smarty->fetch('newsletter_index.tpl');
        }
        
        return $content;
    }

    function getCorrectUrl()
    {
        //Assume the URL is correct
        return _PROTOCOL.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }

    /** 
     * function to get a full newsletter html
     * 
     * @param $id array
     * @param $online boolean
     * 
     * @return $content
     */
    function getNewsletterHtml($id, $online = false) {
        
        global $smarty;
        // get the newsletter and display it on the page with a back link
        $newsletter = Jojo::selectRow("SELECT * FROM {newsletter_messages} WHERE newsletter_messageid = ?", $id);
        $smarty->assign('newsletter', $newsletter);

        if ($online) {
            // check to see if this came from index page. if so then provide a back link to it
            $referer = $_SERVER['HTTP_REFERER'];
            if (strstr($referer, _SITEURL)) {
                $smarty->assign('referer', $referer);
                $smarty->assign('emailerTop', $smarty->fetch('newsletter_online_header.tpl'));
                $smarty->assign('emailerBottom', $smarty->fetch('newsletter_online_header.tpl'));
            }
        } else {
            $url = _SITEURL . '/' . Jojo::rewrite('newsletters', $id, $newsletter['subject'], '');
            $smarty->assign('url', $url);
            $smarty->assign('emailerTop', $smarty->fetch('newsletter_email_header.tpl'));
        }

        $body = $smarty->fetch('newsletter_body.tpl');
        $smarty->assign('content', $body);
        
        // get the template and merge it in
        $template = Jojo::selectRow("SELECT * FROM {email_template} WHERE email_templateid = ?", $newsletter['template']);
        return $smarty->fetch($template['tpl_filename']);
    }

    /** 
     * function to process events for the newsletter
     * 
     * @param $data array
     * 
     * @return $success
     */
    function processEvent($data) {
        $newsletter = Jojo::selectRow("SELECT * FROM {newsletter_messages} WHERE newsletter_messageid = ?", $data['newsletter_messageid']);
        if (!$newsletter) {
            return false;
        }
        if ($newsletter['status'] == "queued") {
            Jojo::updateQuery("UPDATE {newsletter_messages} SET status = ? WHERE newsletter_messageid = ?", array('sent', $data['newsletter_messageid']));
        }
        $query = "";
        if ($data['event'] != 'open') {
            $query = "UPDATE {newsletter_messages} SET " . $data['event'] . " = " . $data['event'] . "+1 WHERE newsletter_messageid = ?";
        } elseif ($data['justOpened'] === true) {
            $query = "UPDATE {newsletter_messages} SET open = open +1 WHERE newsletter_messageid = ?";
        }
        if ($query != "") {
            Jojo::updateQuery($query, $data['newsletter_messageid']);
        }
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
        global $smarty;

        // TODO: check other plugins for content
        
        $smarty->assign('newsletter', $newsletter);
        $html = $smarty->fetch('newsletter_body.tpl');
        // return the html
        return $html;
    }
    
    /** 
     * compile the text for the newsletter
     * 
     * @param $newsletter array
     * 
     * @return $text string
     */
    function assementText($newsletter = false)
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
            $scheduledate = strtotime('-1 second');
        
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
        $receiptiants = Jojo::selectQuery("SELECT DISTINCT s.* FROM {newsletter_subscribers} s LEFT JOIN {newsletter_list_subscribers} ls ON s.newsletter_subscriberid = ls.newsletter_subscriberid LEFT JOIN {newsletter_message_lists} ml ON ls.newsletter_listid = ml.newsletter_listid WHERE s.status = ? AND ml.newsletter_messageid = ?", array('active', $id));
        //var_dump($receiptiants);
        if (!$receiptiants) {
            $return['result'] = false;
            $return['message'] = "Couldn't find and people to send it to. Make sure you have selected a list.";
            return $return;
        }
        
        // loop through receipiants and schedule the email
        foreach ($receiptiants as $r => $recipiant) {
            $res = self::queueNewsletter($newsletter, $recipiant, $scheduledate);
            
        }
        $return['message'] = "Newsletter has been queued";
        $return['result'] = true;
        // if scheduled date in the past call the send process
        if ($scheduledate <= time()) {
            $res = Jojo_Plugin_Jaijaz_emailer::sendQueuedEmails();
            if ($res) {
                $return['message'] = "Newsletter has started sending";
                $return['result'] = true;
                Jojo::updateQuery("UPDATE {newsletter_messages} SET status = ?, send_date = ? WHERE newsletter_messageid = ?", array('sent', $scheduledate, $id));
            } else {
                $return['message'] = "Newsletter has not started sending";
                $return['result'] = false;
                Jojo::updateQuery("UPDATE {newsletter_messages} SET status = ?, send_date = ? WHERE newsletter_messageid = ?", array('scheduled', $scheduledate, $id));
            }
        } else {
            Jojo::updateQuery("UPDATE {newsletter_messages} SET status = ?, send_date = ? WHERE newsletter_messageid = ?", array('scheduled', $scheduledate, $id));
        }

        
        return $return;
    }
    
    /**
     * queue an email into the emailer plugin
     * 
     * @param $newsletter array
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
        $email->to_address      = $recipiant['email'];
        $email->to_name         = $recipiant['firstname'] . " " . $recipiant['lastname'];
        $email->from_address    = Jojo::either(Jojo::getOption('jaijaz_newsletter_fromaddress'), _FROMADDRESS, _CONTACTADDRESS, _WEBMASTERADDRESS);
        $email->from_name       = Jojo::either(Jojo::getOption('jaijaz_newsletter_fromname'), _FROMNAME, _CONTACTNAME, _SITETITLE);
        $email->templateid      = $newsletter['template'];
        $email->subject         = $newsletter['subject'];
        $email->message_html    = self::assementHtml($newsletter);
        $email->merge_fields    = array( 'firstname' => $recipiant['firstname'], 'unsubscribe' => '' );
        $email->smtpapi         = array( 'newsletter_messageid' => $newsletter['newsletter_messageid'] );
        $email->send_embargo    = $scheduledate;
        //var_dump($email);
        // check not a duplicate
        if ($email->checkNotDuplicate()) {
            // save object
            return $email->saveToDb();
        } else {
            return false;
        }
    }

    /**
     * create an array of stats for a newsletter mesage
     * 
     * @param $newsletter array
     * @param $stats array
     * 
     */
    function getStats($newsletter = false)
    {
        if (!$newsletter)
            return false;

        $stats = array();
        // get the number of messages from the email_queue
        $sent = Jojo::selectQuery("SELECT email_queueid FROM {email_queue} WHERE messageid = ? AND plugin = ?", array($newsletter['newsletter_messageid'], 'jaijaz_newsletter'));
        $stats['sent'] = count($sent);

        // get the event type values and set the percentages were needed
        $stats['processed'] = $newsletter['processed'];
        $stats['processedPercent'] = ($newsletter['processed'] / $stats['sent']) * 100;
        $stats['dropped'] = $newsletter['dropped'];
        $stats['droppedPercent'] = ($newsletter['dropped'] / $stats['sent']) * 100;
        $stats['delivered'] = $newsletter['delivered'];
        $stats['deliveredPercent'] = ($newsletter['delivered'] / $stats['sent']) * 100;
        $stats['bounce'] = $newsletter['bounce'];
        $stats['bouncePercent'] = ($newsletter['bounce'] / $stats['sent']) * 100;
        $stats['open'] = $newsletter['open'];
        $stats['openPercent'] = ($newsletter['open'] / $stats['sent']) * 100;
        $stats['click'] = $newsletter['click'];
        $stats['spamreport'] = $newsletter['spamreport'];
        $stats['spamreportPercent'] = ($newsletter['spamreport'] / $stats['sent']) * 100;
        $stats['unsubscribe'] = $newsletter['unsubscribe'];
        $stats['unsubscribePercent'] = ($newsletter['unsubscribe'] / $stats['sent']) * 100;

        return $stats;
    }

}
