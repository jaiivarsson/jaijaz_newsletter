<?php
/**
 *                    Jojo CMS
 *                ================
 *
 * Copyright 2008 Michael Cochrane <mikec@joojcms.org>
 *
 * See the enclosed file license.txt for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author  Michael Cochrane <mikec@jojocms.org>
 * @license http://www.fsf.org/copyleft/lgpl.html GNU Lesser General Public License
 * @link    http://www.jojocms.org JojoCMS
 */

$o=0;

$table = 'newsletter_messages';

$default_td[$table] = array(
        'td_name' => "newsletter_messages",
        'td_displayname' => "Newsletter",
        'td_primarykey' => "newsletter_messageid",
        'td_displayfield' => "name",
        'td_deleteoption' => "yes",
        'td_orderbyfields' => "date DESC",
        'td_menutype' => "list",
        'td_help' => "Newsletters are managed from here.",
        'td_defaultpermissions' => "everyone.show=1\neveryone.view=1\neveryone.edit=1\neveryone.add=1\neveryone.delete=1\nadmin.show=1\nadmin.view=1\nadmin.edit=1\nadmin.add=1\nadmin.delete=1\nnotloggedin.show=0\nnotloggedin.view=0\nnotloggedin.edit=0\nnotloggedin.add=0\nnotloggedin.delete=0\nregistered.show=1\nregistered.view=1\nregistered.edit=1\nregistered.add=1\nregistered.delete=1\nsysinstall.show=1\nsysinstall.view=1\nsysinstall.edit=1\nsysinstall.add=1\nsysinstall.delete=1\n",
    );

$default_fd[$table]['newsletter_messageid'] = array(
        'fd_name' => "ID",
        'fd_type' => "readonly",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "1. Newsletter",
    );

$default_fd[$table]['name'] = array(
        'fd_name' => "Campaign name",
        'fd_type' => "text",
        'fd_size' => "40",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "1. Newsletter",
    );

$default_fd[$table]['subject'] = array(
        'fd_name' => "Email Subject",
        'fd_type' => "text",
        'fd_size' => "40",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "1. Newsletter",
    );

$default_fd[$table]['template'] = array(
        'fd_name' => "Template",
        'fd_type' => "dblist",
        'fd_options' => "email_template",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "1. Newsletter",
    );

$default_fd[$table]['date'] = array(
        'fd_name' => "Date",
        'fd_type' => "unixdate",
        'fd_help' => "The Date the Newsletter Was Made",
        'fd_order' => $o++,
        'fd_tabname' => "1. Newsletter",
    );

$default_fd[$table]['body'] = array(
        'fd_name' => "Introduction",
        'fd_type' => "hidden",
        'fd_size' => "0",
        'fd_rows' => "6",
        'fd_cols' => "40",
        'fd_order' => $o++,
        'fd_tabname' => "1. Newsletter",
    );

// Intro Field
$default_fd[$table]['body_code'] = array(
        'fd_name' => "Intro",
        'fd_type' => "texteditor",
        'fd_options' => "body",
        'fd_order' => $o++,
        'fd_tabname' => "1. Newsletter",
    );

$default_fd[$table]['lists'] = array(
        'fd_name' => "Email List",
        'fd_type' => "many2many",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "3. Lists",
        'fd_m2m_linktable' => "newsletter_message_lists",
        'fd_m2m_linkitemid' => "newsletter_messageid",
        'fd_m2m_linkcatid' => "newsletter_listid",
        'fd_m2m_cattable' => "newsletter_lists",
    );

$default_fd[$table]['preview'] = array(
        'fd_name' => "Preview newsletter",
        'fd_type' => "jaijaz_newsletter_preview",
        'fd_showlabel' => "no",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "4. Send",
    );

$default_fd[$table]['sendpreview'] = array(
        'fd_name' => "Send Preview",
        'fd_type' => "jaijaz_newsletter_sendpreview",
        'fd_showlabel' => "no",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "4. Send",
    );

$default_fd[$table]['send'] = array(
        'fd_name' => "Newsletter Delivery",
        'fd_type' => "jaijaz_newsletter_send",
        'fd_showlabel' => "no",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "4. Send",
    );

$default_fd[$table]['send_date'] = array(
        'fd_name' => "Status",
        'fd_type' => "hidden",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "4. Send",
    );

$default_fd[$table]['status'] = array(
        'fd_name' => "Status",
        'fd_type' => "hidden",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "4. Send",
    );

$default_fd[$table]['stats'] = array(
        'fd_name' => "Send statistics",
        'fd_type' => "jaijaz_newsletter_stats",
        'fd_showlabel' => "no",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "5. Stats",
    );

$default_fd[$table]['processed'] = array(
        'fd_type' => "hidden",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "5. Stats",
    );

$default_fd[$table]['dropped'] = array(
        'fd_type' => "hidden",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "5. Stats",
    );

$default_fd[$table]['delivered'] = array(
        'fd_type' => "hidden",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "5. Stats",
    );

$default_fd[$table]['bounce'] = array(
        'fd_type' => "hidden",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "5. Stats",
    );

$default_fd[$table]['open'] = array(
        'fd_type' => "hidden",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "5. Stats",
    );

$default_fd[$table]['click'] = array(
        'fd_type' => "hidden",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "5. Stats",
    );

$default_fd[$table]['spamreport'] = array(
        'fd_type' => "hidden",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "5. Stats",
    );

$default_fd[$table]['unsubscribe'] = array(
        'fd_type' => "hidden",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "5. Stats",
    );



$o=0;

$table = 'newsletter_lists';

$default_td[$table] = array(
        'td_name' => "newsletter_lists",
        'td_displayname' => "Newsletter Lists",
        'td_primarykey' => "newsletter_listid",
        'td_displayfield' => "name",
        'td_deleteoption' => "yes",
        'td_orderbyfields' => "name",
        'td_menutype' => "list",
        'td_help' => "Newsletters lists are managed from here.",
        'td_defaultpermissions' => "everyone.show=1\neveryone.view=1\neveryone.edit=1\neveryone.add=1\neveryone.delete=1\nadmin.show=1\nadmin.view=1\nadmin.edit=1\nadmin.add=1\nadmin.delete=1\nnotloggedin.show=0\nnotloggedin.view=0\nnotloggedin.edit=0\nnotloggedin.add=0\nnotloggedin.delete=0\nregistered.show=1\nregistered.view=1\nregistered.edit=1\nregistered.add=1\nregistered.delete=1\nsysinstall.show=1\nsysinstall.view=1\nsysinstall.edit=1\nsysinstall.add=1\nsysinstall.delete=1\n",
    );

$default_fd[$table]['newsletter_listid'] = array(
        'fd_name' => "ID",
        'fd_type' => "readonly",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "Details",
    );

$default_fd[$table]['name'] = array(
        'fd_name' => "List name",
        'fd_type' => "text",
        'fd_size' => "40",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "Details",
    );

// Layout Field
$default_fd[$table]['public'] = array(
        'fd_name' => "Public",
        'fd_type' => "radio",
        'fd_options' => "no\nyes",
        'fd_default' => 'no',
        'fd_help' => "Is this list displayed to the public for them to subscribe to",
        'fd_order' => $o++,
        'fd_tabname' => "Details",
    );

// Layout Field
$default_fd[$table]['active'] = array(
        'fd_name' => "Active",
        'fd_type' => "radio",
        'fd_options' => "no\nyes",
        'fd_default' => 'no',
        'fd_help' => "Is this list active. Inactive lists can't be sent to.",
        'fd_order' => $o++,
        'fd_tabname' => "Details",
    );

$default_fd[$table]['subscribers'] = array(
        'fd_name' => "Subscribers",
        'fd_type' => "many2many",
        'fd_showlabel' => "no",
        'fd_readonly' => "1",
        'fd_help' => "This is a list of subscribers to this list. To add someone to this list go to the subscriber under edit subscribers",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "Subscribers",
        'fd_m2m_linktable' => "newsletter_list_subscribers",
        'fd_m2m_linkitemid' => "newsletter_listid",
        'fd_m2m_linkcatid' => "newsletter_subscriberid",
        'fd_m2m_cattable' => "newsletter_subscribers",
    );






$o=0;

$table = 'newsletter_subscribers';

$default_td[$table] = array(
        'td_name' => "newsletter_subscribers",
        'td_displayname' => "Newsletter Subscribers",
        'td_primarykey' => "newsletter_subscriberid",
        'td_displayfield' => "CONCAT(email,' - ',firstname,' ',lastname)",
        'td_deleteoption' => "yes",
        'td_orderbyfields' => "email",
        'td_menutype' => "list",
        'td_help' => "Newsletter subscribers are managed from here.",
        'td_defaultpermissions' => "everyone.show=1\neveryone.view=1\neveryone.edit=1\neveryone.add=1\neveryone.delete=1\nadmin.show=1\nadmin.view=1\nadmin.edit=1\nadmin.add=1\nadmin.delete=1\nnotloggedin.show=0\nnotloggedin.view=0\nnotloggedin.edit=0\nnotloggedin.add=0\nnotloggedin.delete=0\nregistered.show=1\nregistered.view=1\nregistered.edit=1\nregistered.add=1\nregistered.delete=1\nsysinstall.show=1\nsysinstall.view=1\nsysinstall.edit=1\nsysinstall.add=1\nsysinstall.delete=1\n",
    );

$default_fd[$table]['newsletter_subscriberid'] = array(
        'fd_name' => "ID",
        'fd_type' => "readonly",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "Details",
    );

$default_fd[$table]['firstname'] = array(
        'fd_name' => "First name",
        'fd_type' => "text",
        'fd_size' => "40",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "Details",
    );

$default_fd[$table]['lastname'] = array(
        'fd_name' => "Last name",
        'fd_type' => "text",
        'fd_size' => "40",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "Details",
    );

// Email Field
$default_fd[$table]['email'] = array(
        'fd_name' => "Email",
        'fd_type' => "email",
        'fd_required' => "yes",
        'fd_order' => $o++,
        'fd_tabname' => "Details",
    );

$default_fd[$table]['organisation'] = array(
        'fd_name' => "Organisation",
        'fd_type' => "text",
        'fd_size' => "40",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "Details",
    );

// Layout Field
$default_fd[$table]['status'] = array(
        'fd_name' => "Status",
        'fd_type' => "radio",
        'fd_options' => "active\ninactive\nunsubscribed\nblacklisted",
        'fd_default' => 'no',
        'fd_help' => "Active - currently getting email. Inactive - potentially unconfirmed. Unsubscribed - they unsubscribed. Blacklisted - They bounced too many times. ",
        'fd_order' => $o++,
        'fd_tabname' => "Details",
    );

$default_fd[$table]['confirmed'] = array(
        'fd_name' => "Confirmed",
        'fd_type' => "unixdate",
        'fd_readonly' => "1",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "Details",
    );

$default_fd[$table]['confirmed_date'] = array(
        'fd_name' => "Confirmed date",
        'fd_type' => "unixdate",
        'fd_readonly' => "1",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "Details",
    );

$default_fd[$table]['unsubscribed_date'] = array(
        'fd_name' => "Unsubscribed date",
        'fd_type' => "readonly",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "Details",
    );

$default_fd[$table]['token'] = array(
        'fd_type' => "hidden",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "Details",
    );

$default_fd[$table]['lists'] = array(
        'fd_name' => "Email Lists",
        'fd_type' => "many2many",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "Lists",
        'fd_m2m_linktable' => "newsletter_list_subscribers",
        'fd_m2m_linkitemid' => "newsletter_subscriberid",
        'fd_m2m_linkcatid' => "newsletter_listid",
        'fd_m2m_cattable' => "newsletter_lists",
    );

$default_fd[$table]['messages'] = array(
        'fd_name' => "Messages",
        'fd_type' => "jaijaz_newsletter_messages",
        'fd_showlabel' => "no",
        'fd_help' => "A list of all messages this subscriber has been sent",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "Past messages",
    );

$default_fd[$table]['user'] = array(
        'fd_name' => "User",
        'fd_type' => "userloginlink",
        'fd_showlabel' => "no",
        'fd_help' => "Add optionational user login details",
        'fd_size' => "0",
        'fd_rows' => "0",
        'fd_cols' => "0",
        'fd_order' => $o++,
        'fd_tabname' => "User",
    );
