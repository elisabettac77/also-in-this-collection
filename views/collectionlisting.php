<aside id="<?php echo esc_attr( "collection-{$collection->slug}" ); ?>" class="also-in-this-collection">

<?php if ( $title ) : ?>
    <div class="collection-title">
        <<?php echo esc_html( $titlewrap ); ?>>
            <?php echo esc_html( $title ); ?>
        </<?php echo esc_html( $titlewrap ); ?>>
    </div>
<?php endif; ?>

<?php if ( $description ) : ?>
    <div class="collection-description"><?php echo wp_kses_post( $description ); ?></div>
<?php endif; ?>

<?php if ( ! $hidecollectionlisting ) : ?>
    <ol start="<?php echo esc_attr( $logicalframe[0] ); ?>" <?php echo ( $sortorder === 'desc' ) ? 'reversed' : ''; ?>>
        <?php foreach ( $collectionposts as $index => $collectionpost ) : ?>
            <?php if ( ! is_single() || $collectionpost->ID !== $post->ID ) : ?>
                <li class="collection-post">
                    <a href="<?php echo esc_url( get_permalink( $collectionpost->ID ) ); ?>">
                        <?php echo esc_html( get_the_title( $collectionpost->ID ) ); ?>
                    </a>
                </li>
            <?php else : ?>
                <li class="collection-post current">
                    <strong><?php echo esc_html( get_the_title( $collectionpost->ID ) ); ?></strong>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ol>
<?php endif; ?>

<?php if ( $hidecollectionlisting || $framing || $alwayslinkcollection ) : ?>
    <div class="collection-link">
        <a href="<?php echo esc_url( get_term_link( $collection ) ); ?>">
            <?php echo esc_html__( 'View the entire collection', 'also-in-this-collection' ); ?>
        </a>
    </div>
<?php endif; ?>

</aside>
