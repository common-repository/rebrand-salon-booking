<div class="salon-wl-settings-header">
	<h3><?php _e('Rebrand Salon Booking', 'bzsalon'); ?></h3>
</div>
<div class="salon-wl-settings-wlms">

	<div class="salon-wl-settings">
		<form method="post" id="form" enctype="multipart/form-data">

			<?php wp_nonce_field( 'salon_wl_nonce', 'salon_wl_nonce' ); ?>

			<div class="salon-wl-setting-tabs-content">

				<div id="salon-wl-branding" class="salon-wl-setting-tab-content active">
					<h3 class="bzsalon-section-title"><?php esc_html_e('Branding', 'bzsalon'); ?></h3>
					<p><?php esc_html_e('You can white label the plugin as per your requirement.', 'bzsalon'); ?></p>
					<table class="form-table salon-wl-fields">
						<tbody>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="salon_wl_plugin_name"><?php esc_html_e('Plugin Name', 'bzsalon'); ?></label>
								</th>
								<td>
									<input id="salon_wl_plugin_name" name="salon_wl_plugin_name" type="text" class="regular-text" value="<?php echo esc_attr($branding['plugin_name']); ?>" placeholder="" />
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="salon_wl_plugin_desc"><?php esc_html_e('Plugin Description', 'bzsalon'); ?></label>
								</th>
								<td>
									<input id="salon_wl_plugin_desc" name="salon_wl_plugin_desc" type="text" class="regular-text" value="<?php echo esc_attr($branding['plugin_desc']); ?>"/>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="salon_wl_plugin_author"><?php esc_html_e('Developer / Agency', 'bzsalon'); ?></label>
								</th>
								<td>
									<input id="salon_wl_plugin_author" name="salon_wl_plugin_author" type="text" class="regular-text" value="<?php echo esc_attr($branding['plugin_author']); ?>"/>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="salon_wl_plugin_uri"><?php esc_html_e('Website URL', 'bzsalon'); ?></label>
								</th>
								<td>
									<input id="salon_wl_plugin_uri" name="salon_wl_plugin_uri" type="text" class="regular-text" value="<?php echo esc_attr($branding['plugin_uri']); ?>"/>
								</td>
							</tr>
                           <tr valign="top">
								<th scope="row" valign="top">
									<label for="salon_wl_whitelabel_assistants"><?php esc_html_e('Whitelabel "Assistants"', 'bzsalon'); ?></label>
								</th>
								<td>
									<input id="salon_wl_whitelabel_assistants" name="salon_wl_whitelabel_assistants" type="text" class="regular-text" value="" placeholder="" disabled />
									<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="salon_wl_whitelabel_assistant"><?php esc_html_e('Whitelabel "Assistant"', 'bzsalon'); ?></label>
								</th>
								<td>
									<input id="salon_wl_whitelabel_assistant" name="salon_wl_whitelabel_assistant" type="text" class="regular-text" value="" placeholder="" disabled />
									<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="salon_wl_primary_color"><?php esc_html_e('Primary Color', 'bzsalon'); ?></label>
								</th>
								<td>
									<input id="salon_wl_primary_color" name="salon_wl_primary_color" type="text" class="salon-wl-color-picker" value="" disabled />
									<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
								</td>
							</tr>
							
														
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="salon_menu_icon"><?php esc_html_e('Menu Icon', 'bzsalon'); ?></label>
								</th>
								<td>
									<input class="regular-text" name="salon_menu_icon" id="salon_menu_icon" type="text" value="" disabled />
									<input class="button dashicons-picker" type="button" value="Choose Icon" data-target="#salon_menu_icon" disabled />
									<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
								</td>
							</tr>
							
							<tr valign="top">
									<th scope="row" valign="top">
										<label for="salon_wl_hide_help_button"><?php echo esc_html_e('Hide Help Button', 'bzrap'); ?></label>
									</th>
									<td>
										<input id="salon_wl_hide_help_button" name="salon_wl_hide_help_button" type="checkbox" class="" value="on" disabled />
										<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
									</td>
							</tr>
							
							<tr valign="top">
									<th scope="row" valign="top">
										<label for="salon_wl_hide_admin_banner"><?php echo esc_html_e('Hide Admin Banner (Settings page sidebar)', 'bzrap'); ?></label>
									</th>
									<td>
										<input id="salon_wl_hide_admin_banner" name="salon_wl_hide_admin_banner" type="checkbox" class="" value="on" disabled />
										<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
									</td>
							</tr>
							
							<tr valign="top">
									<th scope="row" valign="top">
										<label for="salon_wl_hide_support_tab"><?php echo esc_html_e('Hide Support Tab', 'bzrap'); ?></label>
									</th>
									<td>
										<input id="salon_wl_hide_support_tab" name="salon_wl_hide_support_tab" type="checkbox" class="" value="on" disabled />
										<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
									</td>
							</tr>
							
							<tr valign="top">
									<th scope="row" valign="top">
										<label for="salon_wl_hide_support_tab"><?php echo esc_html_e('Hide Subscription update notice', 'bzrap'); ?></label>
									</th>
									<td>
										<input id="salon_wl_hide_support_tab" name="salon_wl_hide_update_notice" type="checkbox" class="" value="on" disabled />
										<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
									</td>
							</tr>
							
						</tbody>
					</table>
				</div>
				
				<div class="salon-wl-setting-footer">
					<p class="submit">
						<input type="submit" name="salon_submit" id="salon_save_branding" class="button button-primary bzsalon-save-button" value="<?php esc_html_e('Save Settings', 'bzsalon'); ?>" />
					</p>
				</div>
			</div>
		</form>
	</div>
</div>
