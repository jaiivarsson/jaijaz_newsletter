$(document).ready(function(){ldelim}
    $('#fm_{$fd_field}_send').click(function(){ldelim}
        var button = $(this);
        button.val('Processing...');
        var data = {ldelim}
            id: {if $newsletterid}{$newsletterid}{else}0{/if},
            scheduledate: $('#fm_{$fd_field}').val()
        {rdelim};
        parent.$.post(
            '{$SITEURL}/json/jaijaz_newsletter_send.php',
            data,
            function(data){ldelim}
                if (data.result) {ldelim}
                    button.val(data.message);
                    button..attr("disabled", "disabled");
                {rdelim} else {ldelim}
                    alert('An error happened. Please try again later.');
                    button.val(data.message);
                {rdelim}
            {rdelim}
        );
    {rdelim});
{rdelim});
