<select id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>">
    <?php foreach ( $values as $index => $value ) : ?>
        <option value="<?php echo esc_attr( $value ); ?>" <?php echo isset( $selected[ $index ] ) ? esc_attr( $selected[ $index ] ) : ''; ?>>
            <?php echo isset( $labels[ $index ] ) ? esc_html( $labels[ $index ] ) : ''; ?>
        </option>
    <?php endforeach; ?>
</select>
