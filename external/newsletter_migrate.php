<?php
/**
 * This is a script to migrate from a phplist based newsletter sytem to jaijaz_newsletter
 *
 * NOTE: this has customisations for acres in it
 */
$canRun = false;
if (!$canRun) {
	echo "turned off";
	die();
}

// transfer all the newsletters
$newsletters = Jojo::selectQuery('SELECT * FROM {newsletter}');
echo "<h2>Starting Newsletters</h2>";
if ($newsletters) {
	echo 'found ' . count($newsletters) . ' newsletters <br />';
	foreach ($newsletters as $newsletter) {
		$new = Jojo::selectRow('SELECT * FROM {newsletter_messages} WHERE newsletter_messageid = ?', $newsletter['id']);
		if (!$new) {
			$status = ($sentdate > 0) ? 'sent' : 'draft';
			$res = Jojo::insertQuery("INSERT INTO {newsletter_messages} SET
					newsletter_messageid = ?,
					name = ?,
					subject = ?,
					template = ?,
					date = ?,
					intro = ?,
					outro = ?,
					intro_code = ?,
					outro_code = ?,
					listing_id = ?,
					send_date = ?,
					status = ?
				",
				array(
					$newsletter['id'],
					$newsletter['name'],
					$newsletter['name'],
					$newsletter['template'],
					$newsletter['date'],
					$newsletter['intro'],
					$newsletter['outro'],
					$newsletter['intro_code'],
					$newsletter['outro_code'],
					$newsletter['listing_id'],
					$newsletter['sentdate'],
					$status
					)
				);
			if ($res) {
				echo "Success - inserted " . $res . "--" . $newsletter['name'] . '<br />';
			} else {
				echo "<strong style=\"color:red;\">Failed</strong> - " . $res . "--" . $newsletter['name'] . '<br />';
			}
		} else { echo $newsletter['id'] . "-- already existed  <br />"; }
	}
} else { echo "No Newsletters found <br/>"; }

// transfer the lists
$lists = Jojo::selectQuery("SELECT * FROM {phplist_list}");
echo "<h2>Starting Lists</h2>";
if ($lists) {
	echo 'found ' . count($lists) . ' lists <br />';
	foreach ($lists as $list) {
		$new = Jojo::selectRow("SELECT * FROM {newsletter_lists} WHERE newsletter_listid = ?", $list['id']);
		if (!$new) {
			$public = ($list['name'] == 'newsletter previewer') ? 'no' : 'yes';
			$active = ($list['active'] === 1) ? 'yes' : 'no';
			$res = Jojo::insertQuery("INSERT INTO {newsletter_lists} SET
					newsletter_listid = ?,
					name = ?,
					public = ?,
					active = ?
				",
				array(
					$list['id'],
					$list['name'],
					$public,
					$active
					)
				);
			if ($res) {
				echo "Success - inserted " . $res . "--" . $list['name'] . '<br />';
			} else {
				echo "<strong style=\"color:red;\">Failed</strong> - " . $res . "--" . $list['name'] . '<br />';
			}
		} else { echo $list['id'] . "-- already existed  <br />"; }
	}
} else { echo "No Lists found <br/>"; }

// transfer the subscribers
$subscribers = Jojo::selectQuery('SELECT * FROM {user} where us_login =""');
echo "<h2>Starting Subscribers</h2>";
if ($subscribers) {
	echo 'found ' . count($subscribers) . ' subscribers <br />';
	foreach ($subscribers as $sub) {
		$new = Jojo::selectRow('SELECT * FROM {newsletter_subscribers} WHERE newsletter_subscriberid = ?', $sub['userid']);
		if (!$new) {
			$res = Jojo::insertQuery("INSERT INTO {newsletter_subscribers} SET
					newsletter_subscriberid = ?,
					firstname = ?,
					lastname = ?,
					email = ?,
					organisation = ?,
					streetaddress = ?,
					suburb = ?,
					city = ?,
					postcode = ?,
					phone = ?,
					mobile = ?,
					confirmed = ?,
					status = ?
				",
				array(
					$sub['userid'],
					$sub['us_firstname'],
					$sub['us_lastname'],
					$sub['us_email'],
					($sub['us_organisation']) ? $sub['us_organisation'] : "",
					($sub['us_streetaddress']) ? $sub['us_streetaddress'] : "",
					($sub['us_suburb']) ? $sub['us_suburb'] : "",
					($sub['us_city']) ? $sub['us_city'] : "",
					($sub['us_postcode']) ? $sub['us_postcode'] : "",
					($sub['us_phone']) ? $sub['us_phone'] : "",
					($sub['us_mobile']) ? $sub['us_mobile'] : "",
					'yes',
					'active'
					)
				);
			echo "res is " . $res . "<br/>";
			if ($res) {
				echo "Success - inserted " . $res . "--" . $sub['us_firstname'] . " " . $sub['us_lastname'] . '<br />';
			} else {
				echo "<strong style=\"color:red;\">Failed</strong> - " . $res . "--" . $sub['us_firstname'] . " " . $sub['us_lastname'] . '<br />';
			}
		} else { echo $sub['userid'] . "-- already existed  <br />"; }
	}
} else { echo "No Subscribers found <br/>"; }

// transfer the subscriber to list links
$subToLists = Jojo::selectQuery('SELECT * FROM {phplist_listuser}');
echo "<h2>Starting subscriber to list</h2>";
if ($subToLists) {
	echo "found " . count($subToLists) . 'links <br />';
	foreach ($subToLists as $subList) {
		$new = Jojo::selectRow("SELECT * FROM {newsletter_list_subscribers} WHERE newsletter_subscriberid = ? AND newsletter_listid = ?", array($subList['userid'], $subList['listid']));
		if (!$new) {
			$res = Jojo::insertQuery("INSERT INTO {newsletter_list_subscribers} SET
					newsletter_subscriberid = ?,
					newsletter_listid = ?
				",
				array(
					$subList['userid'],
					$subList['listid']
					)
				);
			if ($res) {
				echo "Success - inserted " . $res . "--" . '<br />';
			} else {
				echo "<strong style=\"color:red;\">Failed</strong> - " . $res . "--" . '<br />';
			}
		} else { echo $subList['userid'] . 'to' . $subList['listid'] . "-- already existed  <br />"; }
	}
} else { echo "No subscriber to list links found <br />"; }


// transfer the newsletter to list links
$messageLists = Jojo::selectQuery("SELECT * FROM {newsletter_list}");
echo "<h2>Starting message list links</h2>";
if ($messageLists) {
	echo "found " . count($messageLists) . " message list links <br />";
	foreach ($messageLists as $mList) {
		$new = Jojo::selectRow('SELECT * FROM {newsletter_message_lists} WHERE newsletter_messageid = ? AND newsletter_listid = ?', array($mList['newsletterid'], $mList['listid']));
		if (!$new) {
			$res = Jojo::insertQuery("INSERT INTO {newsletter_message_lists} SET
					newsletter_messageid = ?,
					newsletter_listid = ?
				",
				array(
					$mList['newsletterid'],
					$mList['listid']
					)
				);
			if ($res) {
				echo "Success - inserted " . $res . "--" . '<br />';
			} else {
				echo "<strong style=\"color:red;\">Failed</strong> - " . $res . "--" . '<br />';
			}
		} else { echo $mList['newsletterid'] . 'to' . $mList['listid'] . "-- already existed  <br />"; }
	}
} else { echo "No message list links <br />"; }


// transfer the newsletter to article links
$messageArticles = Jojo::selectQuery("SELECT * FROM {newsletter_article}");
echo "<h2>Starting message articles links</h2>";
if ($messageArticles) {
	echo "found " . count($messageArticles) . " message articles links <br />";
	foreach ($messageArticles as $mArticle) {
		$new = Jojo::selectRow('SELECT * FROM {newsletter_articles} WHERE newsletter_messageid = ? AND articleid = ?', array($mArticle['newsletterid'], $mArticle['articleid']));
		if (!$new) {
			$res = Jojo::insertQuery("INSERT INTO {newsletter_articles} SET
					newsletter_messageid = ?,
					articleid = ?,
					display_order = ?
				",
				array(
					$mArticle['newsletterid'],
					$mArticle['articleid'],
					$mArticle['order']
					)
				);
			if ($res) {
				echo "Success - inserted " . $res . "--" . '<br />';
			} else {
				echo "<strong style=\"color:red;\">Failed</strong> - " . $res . "--" . '<br />';
			}
		} else { echo $mArticle['newsletterid'] . 'to' . $mArticle['articleid'] . "-- already existed  <br />"; }
	}
} else { echo "No message list links <br />"; }

