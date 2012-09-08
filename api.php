<?php
/**
 *                    Jojo CMS
 *                ================
 *
 * Copyright 2007-2008 Harvey Kane <code@ragepank.com>
 * Copyright 2007-2008 Michael Holt <code@gardyneholt.co.nz>
 * Copyright 2007 Melanie Schulz <mel@gardyneholt.co.nz>
 *
 * See the enclosed file license.txt for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author  Harvey Kane <code@ragepank.com>
 * @author  Michael Cochrane <mikec@jojocms.org>
 * @license http://www.fsf.org/copyleft/lgpl.html GNU Lesser General Public License
 * @link    http://www.jojocms.org JojoCMS
 */

$_provides['fieldTypes'] = array(
        'jaijaz_newsletter_preview'     => 'Jaijaz Newletter - Preview',
        'jaijaz_newsletter_sendpreview' => 'Jaijaz Newletter - Send Preview',
        'jaijaz_newsletter_send'        => 'Jaijaz Newletter - Send',
        'jaijaz_newsletter_stats'       => 'Jaijaz Newletter - Stats',
        'jaijaz_newsletter_messages'    => 'Jaijaz Newletter - Messages List',
        'userloginlink'                 => 'User Login Link details'
);


$_provides['pluginClasses'] = array(
        'Jojo_Plugin_Jaijaz_Newsletter' => 'Jaijaz Newsletter View pages',
        'Jojo_Plugin_Jaijaz_newsletter_subscribe' => 'Jaijaz Newsletter Subscriber',
        'Jojo_Plugin_Jaijaz_newsletter_unsubscriber' => 'Jaijaz Newsletter Unsubscriber',
        'Jojo_Plugin_Jaijaz_newsletter_admin_stats' => 'Jaijaz Newsletter Admin Stats'
        );

// subscribe hook
Jojo::addHook('contact_form_success', 'contact_form_success', 'jaijaz_newsletter_subscribe');

Jojo::addFilter('formfields_last', 'formfields_last', 'jaijaz_newsletter_subscribe');

/* Register URI handlers */
Jojo::registerUri('/newsletters/[id:integer]/[string]',  'Jojo_Plugin_Jaijaz_Newsletter');
Jojo::registerUri('/subscription/[action:string]/[token:[a-zA-Z0-9]{20}]',  'Jojo_Plugin_Jaijaz_newsletter_subscribe');


$_options[] = array(
    'id'        => 'jaijaz_newsletter_fromaddress',
    'category'  => 'Newsletter',
    'label'     => 'Newsletter "from" address',
    'description' => 'Address newsletters will appear to come from and bounce to eg noreply@example.com',
    'type'      => 'text',
    'default'   => '',
    'options'   => '',
    'plugin'    => 'jaijaz_newsletter'
);

$_options[] = array(
    'id'        => 'jaijaz_newsletter_fromname',
    'category'  => 'Newsletter',
    'label'     => 'Newsletter "from" name',
    'description' => 'Name newsletters will appear to come from',
    'type'      => 'text',
    'default'   => '',
    'options'   => '',
    'plugin'    => 'jaijaz_newsletter'
);


