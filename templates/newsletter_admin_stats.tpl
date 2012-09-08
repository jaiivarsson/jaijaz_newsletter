{include file="admin/header.tpl"}

<table>
	<tr>
		<td><strong>Name</strong></td>
		<td><strong>Subject</strong></td>
		<td><strong>Send Date</strong></td>
		<td><strong>Sent</strong></td>
		<td><strong>Processed</strong></td>
		<td><strong>Dropped</strong></td>
		<td><strong>Delivered</strong></td>
		<td><strong>Bounce</strong></td>
		<td><strong>Spam reported</strong></td>
		<td><strong>Unsubcribed</strong></td>
		<td><strong>Opened</strong></td>
		<td><strong>Links clicked</strong></td>
	</tr>
	{foreach $newsletters n}
	<tr>
		<td>{$n.name}</td>
		<td>{$n.subject}</td>
		<td>{$n.send_date|date_format:"%d-%m-%Y %T"}</td>
		<td>{$n.sent}</td>
		<td>{$n.processed} - {$n.processedPercent}</td>
		<td>{$n.dropped} - {$n.droppedPercent}</td>
		<td>{$n.delivered} - {$n.deliveredPercent}</td>
		<td>{$n.bounce} - {$n.bouncePercent}</td>
		<td>{$n.spamreport} - {$n.spamreportPercent}</td>
		<td>{$n.unsubscribe} - {$n.unsubscribePercent}</td>
		<td>{$n.open} - {$n.openPercent}</td>
		<td>{$n.click}</td>
	</tr>
	{/foreach}
</table>

{include file="admin/footer.tpl"}