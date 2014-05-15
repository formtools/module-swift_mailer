
  {include file="messages.tpl"}

  <div class="margin_bottom_large">
    This module enables the <a href="http://swiftmailer.org/" target="_blank">Swift Mailer</a> script to
    send all Form Tools emails, instead of relying on the default PHP <b>mail()</b> function. Your PHP
		version is <b>{$php_version}</b>.
  </div>


  <form action="{$same_page}" method="post" onsubmit="return rsv.validate(this, rules)">

	  <table cellpadding="0" cellspacing="1">
	  <tr>
		  <td width="25">
			  <input type="checkbox" name="swiftmailer_enabled" id="swiftmailer_enabled" value="yes" {if $sm_settings.swiftmailer_enabled == "yes"}checked{/if} 
				  onchange="page_ns.toggle_enabled_fields(this.checked)" />
			</td>
	    <td colspan="2" class="bold"><label for="swiftmailer_enabled">Enable Module</label></td>
	  </tr>
	  <tr>
		  <td> </td>
	    <td width="180" class="medium_grey">SMTP Server</td>
	    <td>
			  <input type="text" name="smtp_server" id="smtp_server" style="width:200px" value="{$sm_settings.smtp_server|escape}" 
  				{if $sm_settings.swiftmailer_enabled != "yes"}disabled{/if} />
			</td>
	  </tr>
	  <tr>
		  <td> </td>
	    <td class="medium_grey">Port</td>
	    <td>
			  <input type="text" name="port" id="port" style="width:35px" value="{$sm_settings.port|escape}" 
  				{if $sm_settings.swiftmailer_enabled != "yes"}disabled{/if} />
			</td>
	  </tr>
	  <tr>
		  <td>
			  <input type="checkbox" name="requires_authentication" id="requires_authentication" value="yes" {if $sm_settings.requires_authentication == "yes"}checked{/if} 
				  onchange="page_ns.toggle_authentication_fields(this.checked)" />
			</td>
	    <td colspan="2" class="bold"><label for="requires_authentication">Use Authentication</label></td>
	  </tr>
	  <tr>
		  <td> </td>
	    <td class="medium_grey">Username</td>
	    <td><input type="text" name="username" id="username" style="width:200px" value="{$sm_settings.username|escape}" 
	      {if $sm_settings.requires_authentication == "no"}disabled{/if} /></td>
	  </tr>
	  <tr>
		  <td> </td>
	    <td class="medium_grey">Password</td>
	    <td><input type="text" name="password" id="password" style="width:200px" value="{$sm_settings.password|escape}" 
	      {if $sm_settings.requires_authentication == "no"}disabled{/if} /></td>
	  </tr>
	  <tr>
		  <td> </td>
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
	  <tr>
		  <td>
			  <input type="checkbox" name="use_encryption" id="use_encryption" value="yes" {if $sm_settings.use_encryption == "yes"}checked{/if} 
				  onchange="page_ns.toggle_encryption_fields(this.checked)" />
			</td>
	    <td colspan="2" class="bold"><label for="use_encryption">Use Encryption</label></td>
	  </tr>
	  <tr>
		  <td> </td>
	    <td class="medium_grey">Encryption Type</td>
	    <td>
	      <input type="radio" name="encryption_type" id="et1" value="SSL" {if $sm_settings.encryption_type == "SSL"}checked{/if}
	        {if $sm_settings.use_encryption != "yes"}disabled{/if} />
	        <label for="et1">SSL</label>
	      <input type="radio" name="encryption_type" id="et2" value="TLS" {if $sm_settings.encryption_type == "TLS"}checked{/if} 
	        {if $sm_settings.use_encryption != "yes"}disabled{/if} />
	        <label for="et2">TLS</label>
	    </td>
	  </tr>
    </table>

		<br />
		
    <div class="grey_box">
      <div style="margin_top">
        <a href="#" onclick="return page_ns.toggle_advanced_settings()">{$LANG.phrase_advanced_settings_rightarrow}</a>
      </div>

      <div {if $remember_advanced_settings == "" || $remember_advanced_settings == "false"}style="display:none"{/if} id="advanced_settings">
     	  <table cellpadding="0" cellspacing="1">
    	  <tr>
    	    <td colspan="2" class="medium_grey" width="205">Server Connection Timeout</td>
    	    <td><input type="text" name="server_connection_timeout" style="width:35px" value="{$sm_settings.server_connection_timeout|escape}" /> seconds</td>
    	  </tr>
    	  <tr>
    	    <td colspan="2" class="medium_grey">Email Charset</td>
    	    <td><input type="text" name="charset" style="width:80px" value="{$sm_settings.charset|escape}" /></td>
    	  </tr>
    	  <tr>
  			  <td width="25">
    			  <input type="checkbox" name="use_anti_flooding" id="use_anti_flooding" value="yes" {if $sm_settings.use_anti_flooding == "yes"}checked{/if} 
    				  onchange="page_ns.toggle_antiflooding_fields(this.checked)" />
  				</td>
    	    <td class="bold" colspan="2"><label for="use_anti_flooding">Use anti-flooding</label></td>
    	  </tr>
  			<tr>
  			  <td> </td>
  				<td class="medium_grey">Email Batch Size</td>
    	    <td class="medium_grey">
  				  <input type="text" name="anti_flooding_email_batch_size" id="anti_flooding_email_batch_size" style="width:35px" 
  					  value="{$sm_settings.anti_flooding_email_batch_size|escape}" 
  					  {if $sm_settings.use_anti_flooding != "yes"}disabled{/if} />
  				</td>
  			</tr>
  			<tr>
  			  <td> </td>
  				<td class="medium_grey">Batch Wait Time</td>
    	    <td class="medium_grey">
  				  <input type="text" name="anti_flooding_email_batch_wait_time" id="anti_flooding_email_batch_wait_time" style="width:35px" 
  					  value="{$sm_settings.anti_flooding_email_batch_wait_time|escape}" 
   					  {if $sm_settings.use_anti_flooding != "yes"}disabled{/if} /> seconds</td>
  			</tr>
        </table>
			</div>

		</div>

		<p>
		  <input type="submit" name="update" value="{$LANG.word_update}" />
		</p>

	</form>
