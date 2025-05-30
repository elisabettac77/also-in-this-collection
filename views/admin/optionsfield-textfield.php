<input 
    type="text" 
    id="<?php echo esc_attr( $id ); ?>" 
    name="<?php echo esc_attr( $name ); ?>" 
    value="<?php echo esc_attr( $value ); ?>" 
/>

<?php if ( isset( $label ) ) : ?>
    <label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></label>
<?php endif; ?>
