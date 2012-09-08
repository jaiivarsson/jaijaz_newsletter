{foreach $newsletters n}
	<p><a href="{$n.url}"><strong>{$n.subject}</strong></a> - Sent: {$n.send_date|date_format:"%d-%m-%Y"}</p>
{/foreach}