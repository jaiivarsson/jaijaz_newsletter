Schedule email send:<br/>
{if $newsletterid && $status == 'draft'}<input type="text" size="25" name="fm_{$fd_field}" id="fm_{$fd_field}" class="date{if $error != ""} error{/if}" value="{$send_date}"  title="{$fd_help}" /> <a href="#" onclick="$('#fm_{$fd_field}').val('');return false;">clear</a>{else}{$send_date}{/if}
&nbsp;<span id="fm_{$fd_field}Msg">{if $printabledate}{$printabledate}{else}&nbsp;{/if}</span>
<input id="fm_{$fd_field}_send" {if !$newsletterid || $status != 'draft'}disabled="disabled"{/if} type="button" value="{if !$newsletterid}Save Newsletter to Schedule Send{elseif $status != 'draft'}{$status}{else}Schedule Send Now{/if}"  />
