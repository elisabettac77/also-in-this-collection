<?php

namespace elicawebservices\wordpress\also_in_this_collection;

function CollectionShortcode( $args ) {
    ob_start();
    displayCollection( $args );
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

add_shortcode( 'alsointhiscollection', __NAMESPACE__ . '\CollectionShortcode' );
