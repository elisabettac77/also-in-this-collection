<aside id="<?php echo "collection-{$collection->slug}" ?>" class="also-in-this-collection">
<?php if( $title ) : ?>
<div class="collection-title">
	<<?php echo $titlewrap ?>><?php echo $title ?></<?php echo $titlewrap ?>>
</div>
<?php endif ?>
<?php if( $description ) : ?>
	<div class="collection-description"><?php echo $description ?></div>
<?php endif ?>

<?php if( !$hidecollectionlisting ) : ?>
	<ol start="<?php echo $logicalframe[0] ?>" <?php echo $sortorder === 'desc' ? 'reversed' : '' ?>>
	<?php foreach( $collectionposts as $index => $collectionpost ) : ?>
		<?php if( !is_single() || $collectionpost->ID !== $post->ID ) : ?>
			<li class="collection-post">
				<a href="<?php echo get_permalink( $collectionpost->ID ) ?>"
				><?php echo get_the_title( $collectionpost->ID ) ?></a>
			</li>
		<?php else : ?>
			<li class="collection-post current">
				<strong><?php echo get_the_title( $collectionpost->ID ) ?></strong>
			</li>
		<?php endif ?>
	<?php endforeach ?>
	</ol>
<?php endif ?>

<?php if( $hidecollectionlisting || $framing || $alwayslinkcollection ) : ?>
<div class="collection-link">
	<a href="<?php echo get_term_link( $collection ) ?>"><?php _e( 'View the entire collection', 'also-in-this-collection' ) ?></a>
</div>
<?php endif ?>
</aside>
