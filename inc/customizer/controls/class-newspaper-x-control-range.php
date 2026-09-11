<?php
/**
 * Range control for the Customizer.
 *
 * Replaces Epsilon_Control_Slider, which rendered a disabled text field plus a
 * jQuery UI slider wired up by an inline <script> in every instance. This uses
 * the browser's own range input and shows the current value beside it, so no
 * jQuery UI and no inline script are needed.
 *
 * Bounds are read from $choices - min, max and step - which is how the control
 * it replaces was configured, so existing call sites need no changes.
 *
 * @package newspaper-x
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Newspaper_X_Control_Range' ) ) {

	/**
	 * Range slider with a live value readout.
	 */
	class Newspaper_X_Control_Range extends WP_Customize_Control {

		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'newspaper-x-range';

		/**
		 * Display the control content.
		 *
		 * @return void
		 */
		public function render_content() {
			$input_id  = '_customize-input-' . $this->id;
			$output_id = $input_id . '-value';

			$bounds = wp_parse_args(
				is_array( $this->choices ) ? $this->choices : array(),
				array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				)
			);

			$describedby = ! empty( $this->description ) ? '_customize-description-' . $this->id : '';
			?>
			<label for="<?php echo esc_attr( $input_id ); ?>">
				<?php if ( ! empty( $this->label ) ) : ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif; ?>
			</label>

			<?php if ( $describedby ) : ?>
				<span id="<?php echo esc_attr( $describedby ); ?>" class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>

			<span class="newspaper-x-range">
				<input
					type="range"
					id="<?php echo esc_attr( $input_id ); ?>"
					<?php if ( $describedby ) : ?>aria-describedby="<?php echo esc_attr( $describedby ); ?>"<?php endif; ?>
					min="<?php echo esc_attr( $bounds['min'] ); ?>"
					max="<?php echo esc_attr( $bounds['max'] ); ?>"
					step="<?php echo esc_attr( $bounds['step'] ); ?>"
					value="<?php echo esc_attr( $this->value() ); ?>"
					oninput="document.getElementById('<?php echo esc_js( $output_id ); ?>').value = this.value"
					<?php $this->link(); ?>
				/>
				<output
					id="<?php echo esc_attr( $output_id ); ?>"
					for="<?php echo esc_attr( $input_id ); ?>"
					class="newspaper-x-range__value"><?php echo esc_html( $this->value() ); ?></output>
			</span>
			<?php
		}
	}
}
