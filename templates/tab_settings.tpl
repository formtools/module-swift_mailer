
  {include file="messages.tpl"}

  <div class="margin_bottom_large">
    This module enables the <a href="http://swiftmailer.org/" target="_blank">Swift Mailer</a> script to
    send all Form Tools emails, instead of relying on the default PHP <b>mail()</b> function.
  </div>


  <form action="{$same_page}" method="post" onsubmit="return rsv.validate(this, rules)">

	  <table cellpadding="0" cellspacing="1">
	  <tr>
	    <td class="medium_grey" width="140">PHP Version</td>
	    <td class="bold">{$php_version}</td>
	  </tr>
	  <tr>
	    <td class="medium_grey">{$LANG.word_enabled}</td>
	    <td>
	      <input type="radio" name="swiftmailer_enabled" id="sme1" value="yes" {if $sm_settings.swiftmailer_enabled == "yes"}checked{/if} />
	        <label for="sme1" class="green">{$LANG.word_yes}</label>
	      <input type="radio" name="swiftmailer_enabled" id="sme2" value="no" {if $sm_settings.swiftmailer_enabled == "no"}checked{/if} />
	        <label for="sme2" class="red">{$LANG.word_no}</label>
	    </td>
	  </tr>
	  <tr>
	    <td class="medium_grey">SMTP Server</td>
	    <td><input type="text" name="smtp_server" style="width:200px" value="{$sm_settings.smtp_server|escape}" /></td>
	  </tr>
	  <tr>
	    <td class="medium_grey">Port</td>
	    <td><input type="text" name="port" style="width:50px" value="{$sm_settings.port|escape}" /></td>
	  </tr>
	  <tr>
	    <td class="medium_grey">Requires authentication</td>
	    <td>
	      <input type="radio" name="requires_authentication" id="re1" value="yes" {if $sm_settings.requires_authentication == "yes"}checked{/if}
	        onchange="page_ns.toggle_authentication_fields(this.value)" />
	        <label for="re1" class="">Yes</label>
	      <input type="radio" name="requires_authentication" id="re2" value="no" {if $sm_settings.requires_authentication == "no"}checked{/if}
	        onchange="page_ns.toggle_authentication_fields(this.value)" />
	        <label for="re2" class="">No</label>
	    </td>
	  </tr>
	  <tr>
	    <td class="medium_grey" width="140">Username</td>
	    <td><input type="text" name="username" id="username" style="width:200px" value="{$sm_settings.username|escape}" 
	      {if $sm_settings.requires_authentication == "no"}disabled{/if} /></td>
	  </tr>
	  <tr>
	    <td class="medium_grey">Password</td>
	    <td><input type="text" name="password" id="password" style="width:200px" value="{$sm_settings.password|escape}" 
	      {if $sm_settings.requires_authentication == "no"}disabled{/if} /></td>
	  </tr>
	  <tr>
	    <td class="medium_grey">Authentication procedure</td>
	    <td>
	      <input type="radio" name="authentication_procedure" id="ap1" value="LOGIN" {if $sm_settings.authentication_procedure == "LOGIN"}checked{/if}
	        {if $sm_settings.requires_authentication == "no"}disabled{/if} />
	        <label for="ap1">LOGIN</label>
	      <input type="radio" name="authentication_procedure" id="ap2" value="PLAIN" {if $sm_settings.authentication_procedure == "PLAIN"}checked{/if} 
	        {if $sm_settings.requires_authentication == "no"}disabled{/if} />
	        <label for="ap2">PLAIN</label>
	      <input type="radio" name="authentication_procedure" id="ap3" value="CRAMMD5" {if $sm_settings.authentication_procedure == "CRAMMD5"}checked{/if} 
	        {if $sm_settings.requires_authentication == "no"}disabled{/if} />
	        <label for="ap3">CRAM-MD5</label>
	    </td>
	  </tr>
	  </table>

		<p>
		  <input type="submit" name="update" value="{$LANG.word_update}" />
		</p>

	</form>
