<<?php foreach ( $values as $index => $value ) : ?>
    <input 
        type="checkbox" 
        id="<?php echo esc_attr( "{$id}_{$index}" ); ?>" 
        name="<?php echo esc_attr( $name ); ?>" 
        value="<?php echo esc_attr( $value ); ?>" 
        <?php echo isset( $checked[ $index ] ) ? esc_attr( $checked[ $index ] ) : ''; ?> 
    />
    <?php if ( isset( $labels[ $index ] ) ) : ?>
        <label for="<?php echo esc_attr( "{$id}_{$index}" ); ?>"><?php echo esc_html( $labels[ $index ] ); ?></label>
    <?php endif; ?>
<?php endforeach; ?>
