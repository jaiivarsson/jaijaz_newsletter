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
		<td>{$n.stats.sent}</td>
		<td>{$n.stats.processed} - {$n.stats.processedPercent}%</td>
		<td>{$n.stats.dropped} - {$n.stats.droppedPercent}%</td>
		<td>{$n.stats.delivered} - {$n.stats.deliveredPercent}%</td>
		<td>{$n.stats.bounce} - {$n.stats.bouncePercent}%</td>
		<td>{$n.stats.spamreport} - {$n.stats.spamreportPercent}%</td>
		<td>{$n.stats.unsubscribe} - {$n.stats.unsubscribePercent}%</td>
		<td>{$n.stats.open} - {$n.stats.openPercent}%</td>
		<td>{$n.stats.click}</td>
	</tr>
	{/foreach}
</table>

{include file="admin/footer.tpl"}