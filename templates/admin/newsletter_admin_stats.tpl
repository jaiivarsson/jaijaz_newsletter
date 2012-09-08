{include file="admin/header.tpl"}

<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Subject</th>
			<th>Send Date</th>
			<th>Sent</th>
			<th>Processed</th>
			<th>Dropped</th>
			<th>Delivered</th>
			<th>Bounce</th>
			<th>Spam reported</th>
			<th>Unsubcribed</th>
			<th>Opened</th>
			<th>Links clicked</th>
		</tr>
	</thead>
	<tbody>
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
	</tbody>
</table>

{include file="admin/footer.tpl"}