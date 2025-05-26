<div class="also-in-this-collection-widget-form">
	<p>
		<label><?php _e( 'Select collection', 'also-in-this-collection' ) ?></label>
		<select id="<?php echo $this->get_field_id( 'collection-slug' ) ?>" name="<?php echo $this->get_field_name( 'collection-slug' ) ?>">
			<option value=""><?php _e( 'Use Current Post Collection', 'also-in-this-collection' ) ?></option>
			<optgroup label="<?php _e( 'Available Collections', 'also-in-this-collection' ) ?>">
			<?php foreach( $collections as $c ) : ?>
				<option value="<?php echo esc_attr( $c->slug ) ?>" <?php selected( $c->slug, $collectionslug ) ?>><?php echo esc_html( $c->name ) ?></option>
			<?php endforeach ?>
			</optgroup>
		</select>
	</p>
	<p>
		<label><?php _e( 'Title wrap', 'also-in-this-collection' ) ?></label>
		<select id="<?php echo $this->get_field_id( 'collection-title-wrap' ) ?>" name="<?php echo $this->get_field_name( 'collection-title-wrap' ) ?>">
			<option value=""><?php _e( 'Default', 'also-in-this-collection' ) ?></option>
			<option value="h1" <?php selected( $titlewrap, 'h1' ) ?>><?php _e( 'h1', 'also-in-this-collection' ) ?></option>
			<option value="h2" <?php selected( $titlewrap, 'h2' ) ?>><?php _e( 'h2', 'also-in-this-collection' ) ?></option>
			<option value="h3" <?php selected( $titlewrap, 'h3' ) ?>><?php _e( 'h3', 'also-in-this-collection' ) ?></option>
			<option value="span" <?php selected( $titlewrap, 'span' ) ?>><?php _e( 'span', 'also-in-this-collection' ) ?></option>
		</select>
	</p>
	<p>
		<label><?php _e( 'Title template', 'also-in-this-collection' ) ?></label>
		<select id="<?php echo $this->get_field_id( 'collection-title-template' ) ?>" name="<?php echo $this->get_field_name( 'collection-title-template' ) ?>">
			<option value=""><?php _e( 'Default', 'also-in-this-collection' ) ?></option>
			<option value="also-in" <?php selected( $titletemplate, 'also-in' ) ?>><?php _e( 'Also In Collection Name', 'also-in-this-collection' ) ?></option>
			<option value="ordinal" <?php selected( $titletemplate, 'ordinal' ) ?>><?php _e( 'This is part n of m in Collection Name', 'also-in-this-collection' ) ?></option>
			<option value="none" <?php selected( $titletemplate, 'none' ) ?>><?php _e( 'No Title', 'also-in-this-collection' ) ?></option>
		</select>
	</p>
	<p>
		<label><?php _e( 'Window collection listing?', 'also-in-this-collection' ) ?></label>
		<select id="<?php echo $this->get_field_id( 'collection-use-frame' ) ?>" name="<?php echo $this->get_field_name( 'collection-use-frame' ) ?>">
			<option value=""><?php _e( 'Default', 'also-in-this-collection' ) ?></option>
			<option value="yes" <?php selected( $useframe, 'yes' ) ?>><?php _e( 'yes' ) ?></option>
			<option value="no" <?php selected( $useframe, 'no' ) ?>><?php _e( 'no' ) ?></option>
		</select>
	</p>
	<p>
		<label><?php _e( 'Set window size', 'also-in-this-collection' ) ?></label>
		<input
			type="number"
			id="<?php echo $this->get_field_id( 'collection-frame-width' ) ?>"
			name="<?php echo $this->get_field_name( 'collection-frame-width' ) ?>"
			value="<?php echo esc_attr( $framewidth ) ?>"
			placeholder="Leave blank for default setting"
			min="1"
		/>
	</p>
	<p>
		<label><?php _e( 'Collection listing order', 'also-in-this-collection' ) ?></label>
		<select id="<?php echo $this->get_field_id( 'collection-sort-order' ) ?>" name="<?php echo $this->get_field_name( 'collection-sort-order' ) ?>">
			<option value=""><?php _e( 'Default', 'also-in-this-collection' ) ?></option>
			<option value="asc" <?php selected( $sortorder, 'asc' ) ?>><?php _e( 'Oldest to newest', 'also-in-this-collection' ) ?></option>
			<option value="desc" <?php selected( $sortorder, 'desc' ) ?>><?php _e( 'Newest to oldest', 'also-in-this-collection' ) ?></option>
		</select>
	</p>
	<p>
		<label><?php _e( 'Display collection listing?', 'also-in-this-collection' ) ?></label>
		<select id="<?php echo $this->get_field_id( 'collection-hide-listing' ) ?>" name="<?php echo $this->get_field_name( 'collection-hide-listing' ) ?>">
			<option value="default"><?php _e( 'Default', 'also-in-this-collection' ) ?></option>
			<option value="no" <?php selected( $hidecollectionlisting, 'no' ) ?>><?php _e( 'yes' ) ?></option>
			<option value="yes" <?php selected( $hidecollectionlisting, 'yes' ) ?>><?php _e( 'no' ) ?></option>
		</select>
	</p>
	<p>
		<label><?php _e( 'Always show collection link?', 'also-in-this-collection' ) ?></label>
		<select id="<?php echo $this->get_field_id( 'collection-always-link' ) ?>" name="<?php echo $this->get_field_name( 'collection-always-link' ) ?>">
			<option value="default"><?php _e( 'Default', 'also-in-this-collection' ) ?></option>
			<option value="yes" <?php selected( $alwayslinkcollection, 'yes' ) ?>><?php _e( 'yes' ) ?></option>
			<option value="no" <?php selected( $alwayslinkcollection, 'no' ) ?>><?php _e( 'no' ) ?></option>
		</select>
	</p>
</div>