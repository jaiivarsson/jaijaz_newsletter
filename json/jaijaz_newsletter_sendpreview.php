<?php
/**
 *                     Jaijaz newsletter module
 *                =================================
 *
 * Copyright 2010 Jaijaz <info@jaijaz.co.nz>
 *
 * See the enclosed file license.txt for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author  Jai Ivarsson <jai@jaijaz.co.nz>
 * @link    http://www.jaijaz.co.nz
 */

/* Ensure users of this function have access to the admin page */
$page = Jojo_Plugin::getPage(Jojo::parsepage('admin'));
if (!$page->perms->hasPerm($_USERGROUPS, 'view')) {
    echo "Permission Denied";
    exit;
}

$id = Util::getFormData('id');
$email = Util::getFormData('email');
if (!$id || !$email) {
    echo "not saved or no email";
    exit;
}

$newsletter = Jojo::selectRow("SELECT * FROM {newsletter_messages} WHERE newsletter_messageid = ?", $id);
$html = Jojo_Plugin_Jaijaz_newsletter::getNewsletterHtml($id);
$from_name = Jojo::either(Jojo::getOption('jaijaz_newsletter_fromname'), Jojo::getOption('fromname'), _CONTACTNAME);
$from_address = Jojo::either(Jojo::getOption('jaijaz_newsletter_fromaddress'), Jojo::getOption('fromaddress'), _CONTACTADDRESS);

/* include the swiftmailer classes */
foreach (Jojo::listPlugins('external/swiftmailer/lib/swift_required.php') as $pluginfile) {
    require_once($pluginfile);
    break;
}

/* build the swiftmailer transport object */
$hostname = Jojo::either(Jojo::getOption('emailer_smtpserver'), Jojo::getOption('smtp_mail_host'));
$hostport = Jojo::either(Jojo::getOption('emailer_smtpport'), Jojo::getOption('smtp_mail_port', 25));
$hostuser = Jojo::either(Jojo::getOption('emailer_smtpuser'), Jojo::getOption('smtp_mail_user'));
$hostpass = Jojo::either(Jojo::getOption('emailer_smtppwd'), Jojo::getOption('smtp_mail_pass'));

$transport = Swift_SmtpTransport::newInstance($hostname, $hostport, 'ssl')
        ->setUsername($hostuser)
        ->setPassword($hostpass)
;

/* create the mailer */
$mailer = Swift_Mailer::newInstance($transport);

/* set the bounce path */
$bounce = Jojo::getOption('emailer_bounce', _WEBMASTERADDRESS);

/* build message */
$emailPreview = Swift_Message::newInstance()
    ->setSubject($newsletter['subject'])
    ->setFrom(array($from_address => $from_name))
    ->setTo(array($email))
    ->setBody($html, 'text/html')
    ->setReturnPath($bounce)
    ;

/* send the email */
$result = $mailer->send($emailPreview);

if ($result) {
    $return['message'] = "Preview sent";
    $return['result'] = true;
} else {
    $return['message'] = "Preview was unable to send";
    $return['result'] = false;
}

header('Content-type: application/json');
echo json_encode($return);
exit;
