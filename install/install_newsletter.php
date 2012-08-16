<?php

$table = 'newsletter_messages';
$query = "
    CREATE TABLE {newsletter_messages} (
        `newsletter_messageid` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL DEFAULT '',
        `subject` varchar(255) NOT NULL DEFAULT '',
        `template` int(11) NOT NULL DEFULT '0',
        `date` bigint(20) NOT NULL,
        `body` text NOT NULL DEFAULT '',
        `body_code` text NOT NULL DEFAULT '',
        `lists` tinyint(4) NOT NULL,
        `preview` tinyint(4) NOT NULL,
        `send` tinyint(4) NOT NULL,
        `status` enum('draft','scheduled','sent') NOT NULL default 'no',
        `send_date` bigint(20) NOT NULL,
        `stats` tinyint(4) NOT NULL,
        PRIMARY KEY (`newsletter_messageid`),
        KEY `sent` (`status`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8";

/* Check table structure */
$result = Jojo::checkTable($table, $query);

/* Output result */
if (isset($result['created'])) {
    echo sprintf("newsletter_messages: Table <b>%s</b> Does not exist - created empty table.<br />", $table);
}

if (isset($result['added'])) {
    foreach ($result['added'] as $col => $v) {
        echo sprintf("newsletter_messages: Table <b>%s</b> column <b>%s</b> Does not exist - added.<br />", $table, $col);
    }
}

if (isset($result['different'])) Jojo::printTableDifference($table,$result['different']);



$table = 'newsletter_message_lists';
$query = "
    CREATE TABLE {newsletter_message_lists} (
        `newsletter_messageid` int(11) NOT NULL DEFAULT '',
        `newsletter_listid` int(11) NOT NULL DEFAULT '',
        PRIMARY KEY (`newsletter_messageid`,`newsletter_listid`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8";

/* Check table structure */
$result = Jojo::checkTable($table, $query);

/* Output result */
if (isset($result['created'])) {
    echo sprintf("newsletter_message_lists: Table <b>%s</b> Does not exist - created empty table.<br />", $table);
}

if (isset($result['added'])) {
    foreach ($result['added'] as $col => $v) {
        echo sprintf("newsletter_message_lists: Table <b>%s</b> column <b>%s</b> Does not exist - added.<br />", $table, $col);
    }
}

if (isset($result['different'])) Jojo::printTableDifference($table,$result['different']);


$table = 'newsletter_lists';
$query = "
    CREATE TABLE {newsletter_lists} (
        `newsletter_listid` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL DEFAULT '',
        `public` enum('no','yes') NOT NULL default 'no',
        `active` enum('no','yes') NOT NULL default 'no',
        `subscribers` tinyint(4) NOT NULL,
        PRIMARY KEY (`newsletter_listid`),
        KEY (`public`),
        KEY (`active`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8";

/* Check table structure */
$result = Jojo::checkTable($table, $query);

/* Output result */
if (isset($result['created'])) {
    echo sprintf("newsletter_lists: Table <b>%s</b> Does not exist - created empty table.<br />", $table);
}

if (isset($result['added'])) {
    foreach ($result['added'] as $col => $v) {
        echo sprintf("newsletter_lists: Table <b>%s</b> column <b>%s</b> Does not exist - added.<br />", $table, $col);
    }
}

if (isset($result['different'])) Jojo::printTableDifference($table,$result['different']);


/* this table logs all event notifications from Send Grid */
$table = 'newsletter_subscribers';
$query = "
    CREATE TABLE {newsletter_subscribers} (
        `newsletter_subscriberid` int(11) NOT NULL AUTO_INCREMENT,
        `firstname` varchar(255) NOT NULL DEFAULT '',
        `lastname` varchar(255) NOT NULL DEFAULT '',
        `email` varchar(255) NOT NULL DEFAULT '',
        `organisation` varchar(255) NOT NULL DEFAULT '',
        `status` enum('active','inactive','unsubscribed','blacklisted') NOT NULL default 'inactive',
        `confirmed` enum('no','yes') NOT NULL default 'no',
        `confirmed_date` bigint(20) NOT NULL,
        `unsubscribed_date` bigint(20) NOT NULL,
        `token` varchar(255) NOT NULL DEFAULT '',
        `lists` tinyint(4) NOT NULL,
        `user` int(11) NOT NULL,
        `messages` tinyint(4) NOT NULL,
        PRIMARY KEY (`newsletter_subscriberid`),
        KEY `email` (`email`),
        KEY `status` (`status`),
        KEY `confirmed` (`confirmed`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8";

/* Check table structure */
$result = Jojo::checkTable($table, $query);

/* Output result */
if (isset($result['created'])) {
    echo sprintf("newsletter_subscribers: Table <b>%s</b> Does not exist - created empty table.<br />", $table);
}

if (isset($result['added'])) {
    foreach ($result['added'] as $col => $v) {
        echo sprintf("newsletter_subscribers: Table <b>%s</b> column <b>%s</b> Does not exist - added.<br />", $table, $col);
    }
}

if (isset($result['different'])) Jojo::printTableDifference($table,$result['different']);


$table = 'newsletter_list_subscribers';
$query = "
    CREATE TABLE {newsletter_list_subscribers} (
        `newsletter_subscriberid` int(11) NOT NULL DEFAULT '',
        `newsletter_listid` int(11) NOT NULL DEFAULT '',
        PRIMARY KEY (`newsletter_subscriberid`,`newsletter_listid`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8";

/* Check table structure */
$result = Jojo::checkTable($table, $query);

/* Output result */
if (isset($result['created'])) {
    echo sprintf("newsletter_list_subscribers: Table <b>%s</b> Does not exist - created empty table.<br />", $table);
}

if (isset($result['added'])) {
    foreach ($result['added'] as $col => $v) {
        echo sprintf("newsletter_list_subscribers: Table <b>%s</b> column <b>%s</b> Does not exist - added.<br />", $table, $col);
    }
}

if (isset($result['different'])) Jojo::printTableDifference($table,$result['different']);