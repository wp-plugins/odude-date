<?php
function odudedate_register_mysettings()
{	
	register_setting( 'odudedate-settings-group', 'fbid' ,'odude_fb_validate');
	register_setting( 'odudedate-settings-group', 'dfcode');
	register_setting( 'odudedate-settings-group', 'w_thumb_size');
	register_setting( 'odudedate-settings-group', 'h_thumb_size');
	register_setting( 'odudedate-settings-group', 'w_large_size');
	register_setting( 'odudedate-settings-group', 'h_large_size');
	register_setting( 'odudedate-settings-group', 'xmlpwd');
	register_setting( 'odudedate-settings-group', 'xmlon');
	
}


function odude_fb_validate($input) 
{
	return $input;
}

function odudedate_setting() 
{
	?>
<div class="wrap">
<h2>Your Plugin Name</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'odudedate-settings-group' ); ?>
    <?php do_settings_sections( 'odudedate-settings-group' ); ?>
    <table class="form-table">
       
	  
		  <tr valign="top">
        <th scope="row">Default Group Code</th>
        <td><?php echo ODudeGroup('all','all','admin','dfcode'); ?></td>
        </tr>
		
		 <tr valign="top">
        <th scope="row">Facebook ID</th>
        <td><input type="text" name="fbid" value="<?php echo get_option('fbid'); ?>" />
		<span class="description">It is used for facebook share button at article. </span>
		</td>
        </tr>
		
		<tr valign="top">
        <th scope="row">Thumbnail Dimension (px)</th>
        <td>Width: <input type="text" name="w_thumb_size" value="<?php echo get_option('w_thumb_size'); ?>" size="4" maxlength="3" /> Height: <input type="text" name="h_thumb_size" value="<?php echo get_option('h_thumb_size'); ?>" size="4" maxlength="3" /></td>
        </tr>
		
			<tr valign="top">
        <th scope="row">Large Image Dimension (px)</th>
        <td>Width: <input type="text" name="w_large_size" value="<?php echo get_option('w_large_size'); ?>" size="4" maxlength="3" /> Height: <input type="text" name="h_large_size" value="<?php echo get_option('h_large_size'); ?>" size="4" maxlength="3" /></td>
        </tr>
		
			<tr valign="top">
        <th scope="row">Generate iclendar Link</th>
        <td> Enable/Disable: <input type="checkbox" name="xmlon" value="on" <?php if(get_option('xmlon')=='on') echo "checked"; ?>> Filename: <input type="text" name="xmlpwd" value="<?php echo get_option('xmlpwd'); ?>" size="9" maxlength="10"  />
		<br>
										<span class="description">This will generate ical,ics, icalendar link. With this link user can import all the selected events into their own calendar. Either in mobile or desktop. It can be imported in Google calendar and many more. </span>
		</td>
        
		</tr>
		<tr valign="top">
		<th></th><td>
		<?php 
		if(get_option('xmlon')=='on')
		{
			$uploaddir = wp_upload_dir();
			$path = $uploaddir['baseurl'].'/odude-date/'.get_option('xmlpwd').'.xml';
			echo $path;
			
		}
		else
		{
			echo "XML creation is disabled";
		}
		?>
		</td></tr>		
    </table>

    <?php submit_button(); ?>

</form>
</div>
	
	<?php
}
?>