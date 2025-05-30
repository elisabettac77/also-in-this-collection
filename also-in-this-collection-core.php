<?php

namespace elicawebservices\wordpress\also_in_this_collection;

const COLLECTION_SLUG = 'also-in-this-collection';
const COLLECTION_TAXONOMY = 'collection';

/**
 * Get configuration options, optionally by key.
 */
function config($key = null) {
    $defaults = [
        'title-wrap' => 'h2',
        'title-template' => 'also-in',
        'insert-in-content' => 'append',
        'archive-sort-order' => 'asc',
        'window-collection-listing' => false,
        'hide-collection-listing' => false,
        'always-link-collection' => false,
    ];

    $config = array_merge($defaults, get_option(COLLECTION_SLUG, []));

    return $key !== null ? $config[$key] : $config;
}

/**
 * Display the collection listing based on arguments.
 */
function displayCollection($args = []) {
    $fargs = wp_parse_args($args, [
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
    ]);

    // Normalize and validate arguments
    $fargs = filter_var_array([
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
            'options' => ['min_range' => 1, 'default' => config('window-collection-listing')],
        ],
        'sortorder' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => ['regexp' => '/asc|desc/i', 'default' => config('archive-sort-order')],
        ],
        'titlewrap' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => ['regexp' => '/h1|h2|h3|span/i', 'default' => config('title-wrap')],
        ],
        'titletemplate' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => ['regexp' => '/also-in|ordinal|none/i', 'default' => config('title-template')],
        ],
        'hidecollectionlisting' => [
            'filter' => FILTER_VALIDATE_BOOLEAN,
            'flags' => FILTER_NULL_ON_FAILURE,
            'options' => ['default' => config('hide-collection-listing')],
        ],
        'alwayslinkcollection' => [
            'filter' => FILTER_VALIDATE_BOOLEAN,
            'flags' => FILTER_NULL_ON_FAILURE,
            'options' => ['default' => config('always-link-collection')],
        ]
    ]);

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

    // Get collection term
    if ($collectionslug) {
        $collection = get_term_by('slug', $collectionslug, COLLECTION_TAXONOMY);
    } else {
        $post && $postcollection = get_the_terms($post->ID, COLLECTION_TAXONOMY) && $collection = reset($postcollection);
    }

    if (!$collection) {
        return;
    }

    // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- Controlled collection query for collection posts
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
    
// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_get_posts -- Controlled, expected small result set
    $collectionposts = get_posts($query);
    $postsincollection = count($collectionposts);

    $currentpostrank = findCurrentPostRank($collectionposts, $currentpostid, $sortorder);
    $frame = [0, $postsincollection - 1];

    $framing = $post && $useframe && $framewidth;
    if ($framing) {
        $frame = computeFrame($collectionposts, $framewidth, $currentpostid);
        $collectionposts = array_slice($collectionposts, $frame[0], $frame[1] - $frame[0]);
    }

    $logicalframe = [$frame[0] + 1, $frame[1] + 1];
    if ($sortorder === 'desc') {
        $logicalframe[0] = $postsincollection + 1 - $logicalframe[0];
        $logicalframe[1] = $postsincollection + 1 - $logicalframe[1];
    }

    // Use ordered placeholders for i18n strings
    switch ($titletemplate) {
        case 'also-in':
            $title = sprintf(
                /* translators: %s: collection name */
                __('Also in %1$s', 'also-in-this-collection'),
                $collection->name
            );
            break;

        case 'ordinal':
            $title = sprintf(
                /* translators: 1: current post rank, 2: total posts, 3: collection name */
                __('This is part %1$d of %2$d in %3$s', 'also-in-this-collection'),
                $currentpostrank + 1,
                $postsincollection,
                $collection->name
            );
            break;

        case 'none':
        default:
            $title = '';
    }

    $description = $collection->description;

    // Render template
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
    if (false === $themeTemplate) {
        include apply_filters('alsointhiscollection_template', 'views/collectionlisting.php');
    }
}

/**
 * Set the order for collection taxonomy archives.
 */
function pre_get_posts($query) {
    $sortorder = config('archive-sort-order');

    if (isset($query->query[COLLECTION_TAXONOMY]) && $sortorder) {
        $query->set('order', $sortorder);
    }

    return $query;
}

/**
 * Insert collection listing into post content.
 */
function the_content($content) {
    if (!is_singular('post') || !config('insert-in-content')) {
        return $content;
    }

    ob_start();
    displayCollection();
    $alsointhiscollection = ob_get_contents();
    ob_end_clean();

    $before = $after = '';
    switch (config('insert-in-content')) {
        case 'prepend':
            $before = $alsointhiscollection;
            break;

        case 'append':
            $after = $alsointhiscollection;
            break;

        default:
            // Do nothing
    }

    return $before . $content . $after;
}

/**
 * Compute the frame (window) of posts around the current post.
 */
function computeFrame($collectionposts, $framewidth, $currentpostid) {
    $pivot = 0;

    if (!$currentpostid) {
        return [0, count($collectionposts) - 1];
    }

    foreach ($collectionposts as $index => $collectionpost) {
        $pivot = $index;
        if ($collectionpost->ID === $currentpostid) {
            break;
        }
    }

    $frame_left = max(0, $pivot - floor(($framewidth - 1) / 2));
    $frame_right = min(count($collectionposts) - 1, $pivot + ceil(($framewidth - 1) / 2));

    $ldiff = $frame_left - ($pivot - floor(($framewidth - 1) / 2));
    $rdiff = ($pivot + ceil(($framewidth - 1) / 2)) - $frame_right;

    // Adjust frame if needed
    if ($ldiff && !$rdiff) {
        $frame_right = min(count($collectionposts) - 1, $frame_right + $ldiff);
    } elseif ($rdiff && !$ldiff) {
        $frame_left = max(0, $frame_left - $rdiff);
    }

    return [$frame_left, 1 + $frame_right];
}

/**
 * Find the rank of the current post within the collection.
 */
function findCurrentPostRank($collectionposts, $currentpostid, $order) {
    $currentpostrank = null;

    if (!$currentpostid) {
        return $currentpostrank;
    }

    foreach ($collectionposts as $index => $collectionpost) {
        if ($collectionpost->ID === $currentpostid) {
            $currentpostrank = $index;
            break;
        }
    }

    if (strtolower($order) === 'desc') {
    return count($collectionposts) - 1 - $currentpostrank;
} else {
    return $currentpostrank;
}
}

// Register hooks
add_action('pre_get_posts', __NAMESPACE__ . '\pre_get_posts');
add_action('the_content', __NAMESPACE__ . '\the_content', 1);
