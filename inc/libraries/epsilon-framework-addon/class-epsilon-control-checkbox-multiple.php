<?php

if ( class_exists( 'WP_Customize_Control' ) ) {
	/**
	 * Multiple checkbox customize control class.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @credit : http://justintadlock.com/archives/2015/05/26/multiple-checkbox-customizer-control
	 */
	class Epsilon_Control_Checkbox_Multiple extends WP_Customize_Control {

		/**
		 * The type of customize control being rendered.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    string
		 */
		public $type = 'epsilon-checkbox-multiple';

		/**
		 * Enqueue scripts/styles.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function enqueue() {
			wp_enqueue_script( 'newspaper-x-customize-controls', trailingslashit( get_template_directory_uri() ) . 'inc/libraries/epsilon-framework-addon/assets/js/epsilon-control-checkbox-multiple.js', array( 'epsilon-object' ) );
		}

		/**
		 * Displays the control content.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function render_content() {

			if ( empty( $this->choices ) ) {
				return;
			} ?>

			<?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $this->description ) ) : ?>
                <span
                        class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>

			<?php $multi_values = ! is_array( $this->value() ) ? explode( ',', $this->value() ) : $this->value(); ?>

            <ul>
				<?php foreach ( $this->choices as $value => $label ) : ?>

                    <li>
                        <label>
                            <input type="checkbox"
                                   class="newspaper-x-control-multiple"
                                   value="<?php echo esc_attr( $value ); ?>" <?php checked( in_array( $value, $multi_values ) ); ?> />
							<?php echo esc_html( $label ); ?>
                        </label>
                    </li>

				<?php endforeach; ?>
            </ul>

            <input type="hidden" <?php $this->link(); ?>
                   value="<?php echo esc_attr( implode( ',', $multi_values ) ); ?>"/>
		<?php }
	}
}