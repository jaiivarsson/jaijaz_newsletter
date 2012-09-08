{if $status == 'sent'}
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Stat type</th>
				<th>Number</th>
				<th>Percentage</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Sent</td>
				<td>{$stats.sent}</td>
				<td></td>
			</tr>
			<tr>
				<td>Processed</td>
				<td>{$stats.processed}</td>
				<td>{$stats.processedPercent}%</td>
			</tr>
			<tr>
				<td>Dropped</td>
				<td>{$stats.dropped}</td>
				<td>{$stats.droppedPercent}%</td>
			</tr>
			<tr>
				<td>Delivered</td>
				<td>{$stats.delivered}</td>
				<td>{$stats.deliveredPercent}%</td>
			</tr>
			<tr>
				<td>Bounce</td>
				<td>{$stats.bounce}</td>
				<td>{$stats.bouncePercent}%</td>
			</tr>
			<tr>
				<td>Spam reported</td>
				<td>{$stats.spamreport}</td>
				<td>{$stats.spamreportPercent}%</td>
			</tr>
			<tr>
				<td>Unsubcribed</td>
				<td>{$stats.unsubscribe}</td>
				<td>{$stats.unsubscribePercent}%</td>
			</tr>
			<tr>
				<td>Opened</td>
				<td>{$stats.open}</td>
				<td>{$stats.openPercent}%</td>
			</tr>
			<tr>
				<td>Links clicked</td>
				<td>{$stats.click}</td>
				<td></td>
			</tr>
		</tbody>
	</table>
{else}Newsletter hasn't been sent yet so no stats{/if}