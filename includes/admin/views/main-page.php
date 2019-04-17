<div class="mx-main-page-text-wrap">
	
	<h1><?php echo __( 'Settings Page', 'mxmph-domain' ); ?></h1>

	<div class="mx-block_wrap">

		<form id="mxmph_form_update" class="mx-settings" method="post" action="">

			<h2>Default script</h2>
			<textarea name="mxmph_some_string" id="mxmph_some_string"></textarea>

			<p class="mx-submit_button_wrap">
				<input type="hidden" id="mxmph_wpnonce" name="mxmph_wpnonce" value="<?php echo wp_create_nonce( 'mxmph_nonce_request' ) ;?>" />
				<input class="button-primary" type="submit" name="mxmph_submit" value="Save" />
			</p>

		</form>

	</div>

</div>