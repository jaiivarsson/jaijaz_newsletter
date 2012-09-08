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


class Jojo_Plugin_Jaijaz_newsletter_subscribe extends Jojo_Plugin
{
	function _getContent()
    {
        global $smarty;
        $content = array();
        $action = Jojo::getFormData('action', '');
        $token  = Jojo::getFormData('token', '');

        if ($action == "conformation") {
            $res = Jojo::updateQuery("UPDATE {newsletter_subscribers} SET confirmed = ?, confirmed_date = ?, status = ? WHERE token = ?", array('yes', time(), 'active', $token));
            $content['title'] = "Subscription Confirmation";
            $content['content'] = "Thanks for confirming your subscription.";

        } else {
            Jojo::redirect(_SITEURL . "/subscribe/");
        }
        
        return $content;
    }

    function getCorrectUrl()
    {
        //Assume the URL is correct
        return _PROTOCOL.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }

	/** 
     * function to process subscribe form
     * 
     * @param $data array
     * 
     * @return $success
     */
    function contact_form_success($formID, $res) {
        if (self::isSubscribeFrom($formID)) {
        	$formlog = Jojo::selectRow("SELECT * FROM {formsubmission} WHERE formsubmissionid = ?", $res);
        	$data = unserialize($formlog['content']);
        	// var_dump($data);
        	$toInsert = array();
        	foreach ($data as $f => $field) {
        		if ($field['fieldname'] != 'mailing-lists') {
	        		$toInsert[$field['fieldname']] = $field['value'];
        		} else {
        			$listArray = $field['valuearr'];
        		}
        	}
        	$toInsert['token'] = self::newToken();
        	$query = "INSERT INTO {newsletter_subscribers} (";
        	$n = 0;
        	foreach ($toInsert as $key => $value) {
        		$query .= "`" . $key . "`";
        		$n++;
        		if ($n < count($toInsert)) {
        			$query .= ",";
        		}
        	}
        	$query .= ") VALUES (";
        	$n = 0;
        	foreach ($toInsert as $key => $value) {
        		$query .= "'" . $value . "'";
        		$n++;
        		if ($n < count($toInsert)) {
        			$query .= ",";
        		}
        	}
        	$query .= ")";
			$res = Jojo::insertQuery($query);

			// get the list of subscribed to lists and put the link in
			foreach ($listArray as $list) {
				$listId = Jojo::selectRow("SELECT * FROM {newsletter_lists} WHERE name = ?", $list);
				Jojo::insertQuery("INSERT INTO {newsletter_list_subscribers} (`newsletter_subscriberid`,`newsletter_listid`) VALUES (?,?)", array($res, $listId['newsletter_listid']));
			}
			
			// create the conformation email
			// include the emailer class
	        foreach (Jojo::listPlugins('classes/jaijaz_emailer_email.class.php') as $pluginfile) {
	            require_once($pluginfile);
	            break;
	        }
	        global $smarty;
	        $confirmationLink = _SITEURL . "/subscription/conformation/" . $toInsert['token'] . "/";
	        // create emailer object and set everything
	        $email = new Jaijaz_Emailer_Email();
	        $email->receiverid      = $res;
	        $email->messageid       = 1;
	        $email->plugin          = "jaijaz_newsletter_subscribe";
	        $email->to_address      = $toInsert['email'];
	        $email->to_name         = $toInsert['firstname'] . " " . $toInsert['lastname'];
	        $email->from_address    = Jojo::either(Jojo::getOption('jaijaz_newsletter_fromaddress'), _FROMADDRESS, _CONTACTADDRESS, _WEBMASTERADDRESS);
	        $email->from_name       = Jojo::either(Jojo::getOption('jaijaz_newsletter_fromname'), _FROMNAME, _CONTACTNAME, _SITETITLE);
	        $email->templateid      = 1;
	        $email->subject         = _SITETITLE . " Newsletter Subscription Confirmation";
	        $email->message_html    = $smarty->fetch('newsletter_subscribe_confirmation.tpl');
	        $email->merge_fields    = array( 'firstname' => $toInsert['firstname'],
	        									'confirmationLink' => $confirmationLink,
	        									'fromname' => _SITETITLE );
	        $email->smtpapi         = array();
	        $email->send_embargo    = strtotime('-10 seconds');
	        // check not a duplicate
	        if ($email->checkNotDuplicate()) {
	            // save object
	            return $email->sendEmail();
	        } else {
	            return false;
	        }
        }
    }

	/** 
     * function to add custom fields to the subscribe form
     * 
     * @param $data array
     * 
     * @return $success
     */
    function formfields_last($fields, $formID) {
        if (self::isSubscribeFrom($formID)) {
			// var_dump($fields);
			$lists = Jojo::selectQuery("SELECT * FROM {newsletter_lists} WHERE public = ? AND active = ?", array('yes','yes'));
			$n = count($fields);
			$fields[$n]["fieldset"] 	= "";
			$fields[$n]["fieldname"] 	= "mailing-lists";
			$fields[$n]["display"] 		= "Mailing Lists";
			$fields[$n]["placeholder"] 	= "";
			$fields[$n]["required"] 	= "0";
			$fields[$n]["validation"] 	= "";
			$fields[$n]["type"] 		= "checkboxes";
			$fields[$n]["size"] 		= "30";
			$fields[$n]["value"] 		= "checked";
			$listOptions = array();
			foreach ($lists as $l => $list) {
				$listOptions[] = $list['name'];
			}
			$fields[$n]["options"] 		= $listOptions; 
			$fields[$n]["rows"] 		= "0";
			$fields[$n]["cols"] 		= "0";
			$fields[$n]["description"] 	= "";
			$fields[$n]["class"] 		= "";
			$fields[$n]["is_email"] 	= "0";
			$fields[$n]["is_name"] 		= "0";
			$fields[$n]["showlabel"] 	= "1";
			$fields[$n]["order"] 		= "0";
			$fields[$n]["fieldsetid"] 	= "";
			$fields[$n]["field"] 		= "mailing-lists";
        }
        return $fields;
    }

    /**
     * checks to see if this is  the subscibe form
     * 
     * @return $success boolean
     */
    function isSubscribeFrom($formID)
    {
        $form = Jojo::selectRow("SELECT * FROM {form} WHERE form_id = ?", $formID);
        return ($form['form_name'] == 'Newsletter Subscribe');
    }

    /**
     * Generates a new unique token
     */
    function newToken()
    {
        while (true) {
            $token = Jojo::randomstring(20);
            if (!Jojo::selectRow("SELECT token FROM {newsletter_subscribers} WHERE token = ?", $token)) {
                return $token;
            }
        }
    }
}