<?php
/**
 * Outputs the widget form for "Also In This Collection".
 *
 * This form allows the user to configure collection display options.
 *
 * @package AlsoInThisCollection
 *
 * @phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
 *     Reason: Escaping done inline where appropriate.
 */

?>

<div class="also-in-this-collection-widget-form">

    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'collection-slug' ) ); ?>">
            <?php esc_html_e( 'Select collection', 'also-in-this-collection' ); ?>
        </label>
        <select
            id="<?php echo esc_attr( $this->get_field_id( 'collection-slug' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'collection-slug' ) ); ?>"
            class="widefat"
        >
            <option value="">
                <?php esc_html_e( 'Use Current Post Collection', 'also-in-this-collection' ); ?>
            </option>
            <optgroup label="<?php echo esc_attr_e( 'Available Collections', 'also-in-this-collection' ); ?>">
                <?php foreach ( $collections as $collection ) : ?>
                    <option
                        value="<?php echo esc_attr( $collection->slug ); ?>"
                        <?php selected( $collection->slug, $collectionslug ); ?>
                    >
                        <?php echo esc_html( $collection->name ); ?>
                    </option>
                <?php endforeach; ?>
            </optgroup>
        </select>
    </p>

    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'collection-title-wrap' ) ); ?>">
            <?php esc_html_e( 'Title wrap', 'also-in-this-collection' ); ?>
        </label>
        <select
            id="<?php echo esc_attr( $this->get_field_id( 'collection-title-wrap' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'collection-title-wrap' ) ); ?>"
            class="widefat"
        >
            <option value="">
                <?php esc_html_e( 'Default', 'also-in-this-collection' ); ?>
            </option>
            <option value="h1" <?php selected( $titlewrap, 'h1' ); ?>>
                <?php esc_html_e( 'h1', 'also-in-this-collection' ); ?>
            </option>
            <option value="h2" <?php selected( $titlewrap, 'h2' ); ?>>
                <?php esc_html_e( 'h2', 'also-in-this-collection' ); ?>
            </option>
            <option value="h3" <?php selected( $titlewrap, 'h3' ); ?>>
                <?php esc_html_e( 'h3', 'also-in-this-collection' ); ?>
            </option>
            <option value="span" <?php selected( $titlewrap, 'span' ); ?>>
                <?php esc_html_e( 'span', 'also-in-this-collection' ); ?>
            </option>
        </select>
    </p>

    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'collection-title-template' ) ); ?>">
            <?php esc_html_e( 'Title template', 'also-in-this-collection' ); ?>
        </label>
        <select
            id="<?php echo esc_attr( $this->get_field_id( 'collection-title-template' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'collection-title-template' ) ); ?>"
            class="widefat"
        >
            <option value="">
                <?php esc_html_e( 'Default', 'also-in-this-collection' ); ?>
            </option>
            <option value="also-in" <?php selected( $titletemplate, 'also-in' ); ?>>
                <?php esc_html_e( 'Also In Collection Name', 'also-in-this-collection' ); ?>
            </option>
            <option value="ordinal" <?php selected( $titletemplate, 'ordinal' ); ?>>
                <?php esc_html_e( 'This is part n of m in Collection Name', 'also-in-this-collection' ); ?>
            </option>
            <option value="none" <?php selected( $titletemplate, 'none' ); ?>>
                <?php esc_html_e( 'No Title', 'also-in-this-collection' ); ?>
            </option>
        </select>
    </p>

    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'collection-use-frame' ) ); ?>">
            <?php esc_html_e( 'Window collection listing?', 'also-in-this-collection' ); ?>
        </label>
        <select
            id="<?php echo esc_attr( $this->get_field_id( 'collection-use-frame' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'collection-use-frame' ) ); ?>"
            class="widefat"
        >
            <option value="">
                <?php esc_html_e( 'Default', 'also-in-this-collection' ); ?>
            </option>
            <option value="yes" <?php selected( $useframe, 'yes' ); ?>>
                <?php esc_html_e( 'Yes', 'also-in-this-collection' ); ?>
            </option>
            <option value="no" <?php selected( $useframe, 'no' ); ?>>
                <?php esc_html_e( 'No', 'also-in-this-collection' ); ?>
            </option>
        </select>
    </p>

    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'collection-frame-width' ) ); ?>">
            <?php esc_html_e( 'Set window size', 'also-in-this-collection' ); ?>
        </label>
        <input
            type="number"
            id="<?php echo esc_attr( $this->get_field_id( 'collection-frame-width' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'collection-frame-width' ) ); ?>"
            value="<?php echo esc_attr( $framewidth ); ?>"
            placeholder="<?php esc_attr_e( 'Leave blank for default setting', 'also-in-this-collection' ); ?>"
            min="1"
            class="widefat"
        />
    </p>

    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'collection-sort-order' ) ); ?>">
            <?php esc_html_e( 'Collection listing order', 'also-in-this-collection' ); ?>
        </label>
        <select
            id="<?php echo esc_attr( $this->get_field_id( 'collection-sort-order' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'collection-sort-order' ) ); ?>"
            class="widefat"
        >
            <option value="">
                <?php esc_html_e( 'Default', 'also-in-this-collection' ); ?>
            </option>
            <option value="asc" <?php selected( $sortorder, 'asc' ); ?>>
                <?php esc_html_e( 'Oldest to newest', 'also-in-this-collection' ); ?>
            </option>
            <option value="desc" <?php selected( $sortorder, 'desc' ); ?>>
                <?php esc_html_e( 'Newest to oldest', 'also-in-this-collection' ); ?>
            </option>
        </select>
    </p>

    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'collection-hide-listing' ) ); ?>">
            <?php esc_html_e( 'Display collection listing?', 'also-in-this-collection' ); ?>
        </label>
        <select
            id="<?php echo esc_attr( $this->get_field_id( 'collection-hide-listing' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'collection-hide-listing' ) ); ?>"
            class="widefat"
        >
            <option value="default" <?php selected( $hidecollectionlisting, 'default' ); ?>>
                <?php esc_html_e( 'Default', 'also-in-this-collection' ); ?>
            </option>
            <option value="no" <?php selected( $hidecollectionlisting, 'no' ); ?>>
                <?php esc_html_e( 'Yes', 'also-in-this-collection' ); ?>
            </option>
            <option value="yes" <?php selected( $hidecollectionlisting, 'yes' ); ?>>
                <?php esc_html_e( 'No', 'also-in-this-collection' ); ?>
            </option>
        </select>
    </p>

    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'collection-always-link' ) ); ?>">
            <?php esc_html_e( 'Always show collection link?', 'also-in-this-collection' ); ?>
        </label>
        <select
            id="<?php echo esc_attr( $this->get_field_id( 'collection-always-link' ) ); ?>"
            name="<?php echo esc_attr( $this->get_field_name( 'collection-always-link' ) ); ?>"
            class="widefat"
        >
            <option value="default" <?php selected( $alwayslinkcollection, 'default' ); ?>>
                <?php esc_html_e( 'Default', 'also-in-this-collection' ); ?>
            </option>
            <option value="yes" <?php selected( $alwayslinkcollection, 'yes' ); ?>>
                <?php esc_html_e( 'Yes', 'also-in-this-collection' ); ?>
            </option>
            <option value="no" <?php selected( $alwayslinkcollection, 'no' ); ?>>
                <?php esc_html_e( 'No', 'also-in-this-collection' ); ?>
            </option>
        </select>
    </p>

</div>
