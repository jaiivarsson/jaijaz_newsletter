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
/*
$data = Jojo::selectQuery("SELECT pageid FROM {page} WHERE pg_link='Jojo_Plugin_Jojo_Newsletter_Subscribe'");
if (!count($data)) {
    echo "Adding <b>Subscribe to a Newsletter</b> Page to menu<br />";
    Jojo::insertQuery("INSERT INTO {page} SET pg_title='Subscribe to a Newsletter', pg_link='Jojo_Plugin_Jojo_Newsletter_Subscribe', pg_url='subscribe'");
}
*/

/* add newsletter unsubscribe page */
/*
$data = Jojo::selectQuery("SELECT pageid FROM {page} WHERE pg_link='Jojo_Plugin_Jojo_Newsletter_Unsubscribe'");
if (!count($data)) {
    echo "Adding <b>Unsubscribe From Newsletter</b> Page to menu<br />";
    Jojo::insertQuery("INSERT INTO {page} SET pg_title='Unsubscribe From Newsletter', pg_link='Jojo_Plugin_Jojo_Newsletter_Unsubscribe', pg_url='unsubscribe'");
}
*/

/* add newsletter viewing page */
/*
$data = Jojo::selectRow("SELECT pageid FROM {page} WHERE pg_link='jojo_plugin_jojo_newsletter'");
if (!count($data)) {
    echo "Adding <b>Newsletter Online</b> Page to menu<br />";
    Jojo::insertQuery("INSERT INTO {page} SET pg_title='Newsletter', pg_link='jojo_plugin_jojo_newsletter', pg_url='newsletter', pg_status='hidden'");
}
*/


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

/* Add Edit subscribers Page */
$data = Jojo::selectQuery("SELECT pageid FROM {page} WHERE pg_url='admin/newsletter/preview'");
if (!count($data)) {
    echo "Adding <b>Edit Subscribers</b> Page to menu<br />";
    Jojo::insertQuery("INSERT INTO {page} SET pg_title='Newsletter Preview', pg_link='jojo_plugin_jaijaz_newsletter_preview', pg_url='admin/newsletter/preview', pg_parent = ?, pg_order = 4", $_ADMIN_NEWSLETTER_ID);
}