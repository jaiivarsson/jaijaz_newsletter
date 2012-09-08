<?php
/**
 *                     Jaijaz Newsletter module
 *                ================================
 *
 * Copyright 2010 Jaijaz <info@jaijaz.co.nz>
 *
 * See the enclosed file license.txt for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author  Jai Ivarsson <jai@jaijaz.co.nz>
 * @link    http://www.jaijaz.co.nz
 */

/* add newsletter subscription page */

$data = Jojo::selectQuery("SELECT pageid FROM {page} WHERE pg_link='Jojo_Plugin_Jaijaz_newsletter_subscribe'");
if (!count($data)) {
    echo "Adding <b>Subscription</b> Page to menu<br />";
    Jojo::insertQuery("INSERT INTO {page} SET pg_title='Subscription', pg_link='Jojo_Plugin_Jaijaz_newsletter_subscribe', pg_url='subscription', pg_status='hidden', pg_parent = ?", $_NOT_ON_MENU_ID);
}


/* add newsletter unsubscribe page */
/*
$data = Jojo::selectQuery("SELECT pageid FROM {page} WHERE pg_link='Jojo_Plugin_Jojo_Newsletter_Unsubscribe'");
if (!count($data)) {
    echo "Adding <b>Unsubscribe From Newsletter</b> Page to menu<br />";
    Jojo::insertQuery("INSERT INTO {page} SET pg_title='Unsubscribe From Newsletter', pg_link='Jojo_Plugin_Jojo_Newsletter_Unsubscribe', pg_url='unsubscribe'");
}
*/

/* add newsletter viewing page */

$data = Jojo::selectRow("SELECT pageid FROM {page} WHERE pg_link='Jojo_Plugin_Jaijaz_Newsletter'");
if (!count($data)) {
    echo "Adding <b>Past Newsletters</b> Page to menu<br />";
    Jojo::insertQuery("INSERT INTO {page} SET pg_title='Past Newsletters', pg_link='Jojo_Plugin_Jaijaz_Newsletter', pg_url='newsletters', pg_mainnav = 'no'");
}



/* admin pages */
/* Add Newsletter Section */
$data = Jojo::selectRow("SELECT pageid FROM {page} WHERE pg_url='admin/newsletters'");
if (!$data) {
    echo "Adding <b>Newsletters</b> Page to Admin menu<br />";
    $_ADMIN_NEWSLETTER_ID = Jojo::insertQuery("INSERT INTO {page} SET pg_title='Newsletters', pg_link='', pg_url='admin/newsletters', pg_parent = ?, pg_order = 2, pg_breadcrumbnav='no', pg_footernav='no', pg_sitemapnav='no', pg_xmlsitemapnav='no'", array($_ADMIN_ROOT_ID));
} else {
    $_ADMIN_NEWSLETTER_ID = $data['pageid'];
}

/* Add Edit Newsletter Page */
$data = Jojo::selectQuery("SELECT pageid FROM {page} WHERE pg_url='admin/edit/newsletter_messages'");
if (!count($data)) {
    echo "Adding <b>Edit Newsletters</b> Page to menu<br />";
    Jojo::insertQuery("INSERT INTO {page} SET pg_title='Newsletters', pg_link='jojo_plugin_admin_edit', pg_url='admin/edit/newsletter_messages', pg_parent = ?, pg_order = 1", $_ADMIN_NEWSLETTER_ID);
}

/* Add Edit lists Page */
$data = Jojo::selectQuery("SELECT pageid FROM {page} WHERE pg_url='admin/edit/newsletter_lists'");
if (!count($data)) {
    echo "Adding <b>Edit Newsletters</b> Page to menu<br />";
    Jojo::insertQuery("INSERT INTO {page} SET pg_title='Lists', pg_link='jojo_plugin_admin_edit', pg_url='admin/edit/newsletter_lists', pg_parent = ?, pg_order = 2", $_ADMIN_NEWSLETTER_ID);
}

/* Add Edit subscribers Page */
$data = Jojo::selectQuery("SELECT pageid FROM {page} WHERE pg_url='admin/edit/newsletter_subscribers'");
if (!count($data)) {
    echo "Adding <b>Edit Subscribers</b> Page to menu<br />";
    Jojo::insertQuery("INSERT INTO {page} SET pg_title='Subscribers', pg_link='jojo_plugin_admin_edit', pg_url='admin/edit/newsletter_subscribers', pg_parent = ?, pg_order = 3", $_ADMIN_NEWSLETTER_ID);
}

/* Add newsletter stats Page */
$data = Jojo::selectQuery("SELECT pageid FROM {page} WHERE pg_url='admin/newsletter-stats'");
if (!count($data)) {
    echo "Adding <b>Newsletter Stats</b> Page to menu<br />";
    Jojo::insertQuery("INSERT INTO {page} SET pg_title='Newsletter Stats', pg_link='jojo_plugin_jaijaz_newsletter_admin_stats', pg_url='admin/newsletter-stats', pg_parent = ?, pg_order = 4", $_ADMIN_NEWSLETTER_ID);
}

/* Add Edit subscribers Page */
$data = Jojo::selectQuery("SELECT pageid FROM {page} WHERE pg_url='admin/newsletter/preview'");
if (!count($data)) {
    echo "Adding <b>Edit Subscribers</b> Page to menu<br />";
    Jojo::insertQuery("INSERT INTO {page} SET pg_title='Newsletter Preview', pg_link='jojo_plugin_jaijaz_newsletter_preview', pg_url='admin/newsletter/preview', pg_parent = ?, pg_order = 5, pg_mainnav = 'no'", $_ADMIN_NEWSLETTER_ID);
}

/* setup the subscribe form */
if (!Jojo::selectRow("SELECT pageid FROM {page} WHERE pg_url='subscribe'")) {
    $formpageid = Jojo::insertQuery("INSERT INTO {page} SET pg_title='Subscribe', pg_link='jojo_plugin_jojo_contact', pg_url='subscribe', pg_mainnav = 'no'");
    $formid = Jojo::insertQuery("INSERT INTO {form} (`form_name`, `form_page_id`, `form_success_message`) VALUES ('Newsletter Subscribe', $formpageid, 'Thank you. An email confirmation has been sent to you.')");
    Jojo::insertQuery("INSERT INTO {formfield} (`ff_form_id`, `ff_fieldset`, `ff_fieldname`, `ff_display`, `ff_required`, `ff_validation`, `ff_type`, `ff_size`, `ff_value`, `ff_options`, `ff_rows`, `ff_cols`, `ff_description`, `ff_class`, `ff_is_email`, `ff_is_name`, `ff_showlabel`, `ff_order`) VALUES
        ($formid, '', 'firstname', 'First Name', 1, '', 'text', 30, '', '', 0, 0, '', '', 0, 1, 1, 0),
        ($formid, '', 'lastname', 'Last Name', 1, '', 'text', 30, '', '', 0, 0, '', '', 0, 1, 1, 1),
        ($formid, '', 'email', 'Email', 1, 'email', 'text', 30, '', '', 0, 0, '', '', 1, 0, 1, 2),
        ($formid, '', 'organisation', 'Organisation', 0, '', 'text', 30, '', '', 0, 0, '', '', 0, 0, 1, 3)"
        );
}
