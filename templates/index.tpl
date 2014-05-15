{include file='modules_header.tpl'}

  <table cellpadding="0" cellspacing="0" class="margin_bottom_large">
  <tr>
    <td width="45"><img src="images/icon_swift_mailer.gif" width="34" height="34" /></td>
    <td class="title">{$L.module_name|upper}</td>
  </tr>
  </table>

	{include file='tabset_open.tpl'}

		{if $page == "settings"}
			{include file='../../modules/swift_mailer/templates/tab_settings.tpl'}
		{elseif $page == "test"}
			{include file='../../modules/swift_mailer/templates/tab_test.tpl'}
		{else}
			{include file='../../modules/swift_mailer/templates/tab_settings.tpl'}
		{/if}

	{include file='tabset_close.tpl'}

{include file='modules_footer.tpl'}