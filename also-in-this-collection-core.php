<?php

namespace elicawebservices\wordpress\also_in_this_collection;

const COLLECTION_SLUG = 'also-in-this-collection';
const COLLECTION_TAXONOMY = 'collection';

function config( $key = null ) {
    $defaults = [
        'title-wrap' => 'h2',
        'title-template' => 'also-in',
        'insert-in-content' => 'append',
        'archive-sort-order' => 'asc',
        'window-collection-listing' => false,
        'hide-collection-listing' => false,
        'always-link-collection' => false,
    ];

    $config = array_merge( $defaults, get_option( COLLECTION_SLUG, [] ) );

    return $key !== null ? $config[$key] : $config;
}

function displayCollection( $args = [] ) {
    $fargs = wp_parse_args( $args, [
        'collection-slug' => null,
        'collectionSlug' => null, // legacy param
        'use-frame' => true,
        'frame-width' => null,
        'sort-order' => null,
        'order' => null, // legacy param
        'title-wrap' => null,
        'title-template' => null,
        'hide-collection-listing' => 'default',
        'always-link-collection' => 'default',
    ] );

    $fargs = filter_var_array( [
        'collectionslug' => $fargs['collection-slug'] ?: $fargs['collectionSlug'],
        'useframe' => $fargs['use-frame'],
        'framewidth' => $fargs['frame-width'],
        'sortorder' => $fargs['sort-order'] ?: $fargs['order'],
        'titlewrap' => $fargs['title-wrap'],
        'titletemplate' => $fargs['title-template'],
        'hidecollectionlisting' => $fargs['hide-collection-listing'],
        'alwayslinkcollection' => $fargs['always-link-collection'],
    ], [
        'collectionslug' => [
    'filter' => FILTER_DEFAULT
],
        'useframe' => [
            'filter' => FILTER_VALIDATE_BOOLEAN,
        ],
        'framewidth' => [
            'filter' => FILTER_VALIDATE_INT,
            'options' => [ 'min_range' => 1, 'default' => config( 'window-collection-listing' ) ],
        ],
        'sortorder' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [ 'regexp' => '/asc|desc/i', 'default' => config( 'archive-sort-order' ) ],
        ],
        'titlewrap' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [ 'regexp' => '/h1|h2|h3|span/i', 'default' => config( 'title-wrap' ) ],
        ],
        'titletemplate' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [ 'regexp' => '/also-in|ordinal|none/i', 'default' => config( 'title-template' ) ],
        ],
        'hidecollectionlisting' => [
            'filter' => FILTER_VALIDATE_BOOLEAN,
            'flags' => FILTER_NULL_ON_FAILURE,
            'options' => [ 'default' => config( 'hide-collection-listing' ) ],
        ],
        'alwayslinkcollection' => [
            'filter' => FILTER_VALIDATE_BOOLEAN,
            'flags' => FILTER_NULL_ON_FAILURE,
            'options' => [ 'default' => config( 'always-link-collection' ) ],
        ]
    ] );

    $collectionslug = $fargs['collectionslug'];
    $useframe = $fargs['useframe'];
    $framewidth = $fargs['framewidth'];
    $sortorder = $fargs['sortorder'];
    $titlewrap = $fargs['titlewrap'];
    $titletemplate = $fargs['titletemplate'];
    $hidecollectionlisting = $fargs['hidecollectionlisting'];
    $alwayslinkcollection = $fargs['alwayslinkcollection'];

    $post = get_post();
    $currentpostid = $post ? $post->ID : null;

    if( $collectionslug ) {
        $collection = get_term_by( 'slug', $collectionslug, COLLECTION_TAXONOMY );
    }
    else {
        $post and $postcollection = get_the_terms( $post->ID, COLLECTION_TAXONOMY ) and $collection = reset( $postcollection );
    }

    if( !$collection ) {
        return;
    }

    $query = [
        'tax_query' => [
            [
                'taxonomy' => COLLECTION_TAXONOMY,
                'field' => 'id',
                'terms' => (int) $collection->term_id
            ]
        ],
        'order' => $sortorder ?: null,
        'nopaging' => true,
    ];

    $collectionposts = get_posts( $query );
    $postsincollection = count( $collectionposts );

    $currentpostrank = findCurrentPostRank( $collectionposts, $currentpostid, $sortorder );
    $frame = [0, $postsincollection - 1];

    $framing = $post && $useframe && $framewidth;
    if( $framing ) {
        $frame = computeFrame( $collectionposts, $framewidth, $currentpostid );
        $collectionposts = array_slice( $collectionposts, $frame[0], $frame[1] - $frame[0] );
    }

    $logicalframe = [$frame[0] + 1, $frame[1] + 1];
    if( $sortorder === 'desc' ) {
        $logicalframe[0] = $postsincollection + 1 - $logicalframe[0];
        $logicalframe[1] = $postsincollection + 1 - $logicalframe[1];
    }

    switch( $titletemplate ) {
        case 'also-in':
            $title = sprintf( __( 'Also in %s', 'also-in-this-collection' ), $collection->name );
            break;

        case 'ordinal':
            $title = sprintf( __( 'This is part %d of %d in %s', 'also-in-this-collection' ), $currentpostrank + 1, $postsincollection, $collection->name );
            break;

        case 'none':
        default:
            $title = '';
    }

    $description = $collection->description;

    $themeTemplate = get_template_part(
        COLLECTION_SLUG . '/collectionlisting',
        $collectionslug,
        [
            'collection' => $collection,
            'collectionposts' => $collectionposts,
            'sortorder' => $sortorder,
            'logicalframe' => $logicalframe,
            'framing' => $framing,
            'titlewrap' => $titlewrap,
            'title' => $title,
            'description' => $description,
            'alwayslinkcollection' => $alwayslinkcollection,
            'hidecollectionlisting' => $hidecollectionlisting,
            'currentpostrank' => $currentpostrank,
        ]
    );
    if( false === $themeTemplate ) {
        include apply_filters( 'alsointhiscollection_template', 'views/collectionlisting.php' );
    } 
}

function pre_get_posts( $query ) {
    $sortorder = config( 'archive-sort-order' );

    if( isset( $query->query[COLLECTION_TAXONOMY] ) && $sortorder )
        $query->set( 'order', $sortorder );

    return $query;
}

function the_content( $content ) {
    if( !is_singular( 'post' ) || !config( 'insert-in-content' ) ) {
        return $content;
    }
    
    ob_start();
    displayCollection();
    $alsointhiscollection = ob_get_contents(); 
    ob_end_clean();
    
    $before = $after = '';
    switch( config( 'insert-in-content' ) ) {
        case 'prepend' :
            $before = $alsointhiscollection;
            break;

        case 'append' :
            $after = $alsointhiscollection;
            break;

        default :
    }

    return $before . $content . $after;
}

function computeFrame( $collectionposts, $framewidth, $currentpostid ) {
    $pivot = 0;

    if( !$currentpostid ) {
        return [0, count( $collectionposts ) - 1];
    }

    foreach( $collectionposts as $index => $collectionpost ) {
        $pivot = $index;
        if( $collectionpost->ID === $currentpostid ) {
            break;
        }
    }

    $frame_left = max( 0, $pivot - floor( ( $framewidth - 1 ) / 2 ) );
    $frame_right = min( count( $collectionposts ) - 1, $pivot + ceil( ( $framewidth - 1 ) / 2 ) );

    $ldiff = $frame_left - ( $pivot - floor( ( $framewidth - 1 ) / 2 ) );
    $rdiff = ( $pivot + ceil( ( $framewidth - 1 ) / 2 ) ) - $frame_right;

    if( $ldiff && !$rdiff ) {
        $frame_right = min( count( $collectionposts ) - 1, $frame_right + $ldiff );
    }
    elseif( $rdiff && !$ldiff ) {
        $frame_left = max( 0, $frame_left - $rdiff );
    }

    return [$frame_left, 1 + $frame_right];
}

function findCurrentPostRank( $collectionposts, $currentpostid, $order ) {
    $currentpostrank = null;

    if( !$currentpostid ) {
        return $currentpostrank;
    }

    foreach( $collectionposts as $index => $collectionpost ) {
        if( $collectionpost->ID === $currentpostid ) {
            $currentpostrank = $index;
            break;
        }
    }

    switch( $order ) {
        case 'desc':
        case 'DESC':
            return count( $collectionposts ) - 1 - $currentpostrank;
            break;

        case 'asc':
        case 'ASC':
        default:
            return $currentpostrank;
    }
}

add_action( 'pre_get_posts', __NAMESPACE__ . '\pre_get_posts' );
add_action( 'the_content', __NAMESPACE__ . '\the_content', 1 );
