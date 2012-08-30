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
$scheduledate = Util::getFormData('scheduledate');
if (!$id) {
    echo "not given the id";
    exit;
}
if ($scheduledate == '') {
  $scheduleTimestamp = time();
} else {
  $scheduleTimestamp = strtotime($scheduledate);
}

$return = Jojo_Plugin_Jaijaz_newsletter::sendNewsletter($id, $scheduleTimestamp);
header('Content-type: application/json');
echo json_encode($return);
exit;
