<div class="wrap">
	<div id="icon-themes" class="icon32"></div>
	<h2><?php _e( 'Also In This Collection Settings', 'also-in-this-collection' ) ?></h2>
	<form method="post" action="options.php">
	<?php settings_fields( \elicawebservices\wordpress\also_in_this_collection\COLLECTION_SLUG ) ?>
	<?php do_settings_sections( \elicawebservices\wordpress\also_in_this_collection\COLLECTION_SETTINGS_PAGE ) ?>    
	<?php submit_button() ?>
	</form>
</div>
