<?php
/**
 * On/off toggle control for the Customizer.
 *
 * Replaces Epsilon_Control_Toggle. This is a presentation class only: it renders
 * a checkbox bound with $this->link(), so the value is stored and sanitised
 * entirely by the WP_Customize_Setting it is attached to. Swapping the control
 * therefore changes no saved data.
 *
 * @package newspaper-x
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Newspaper_X_Control_Toggle' ) ) {

	/**
	 * Renders a boolean setting as an on/off switch.
	 */
	class Newspaper_X_Control_Toggle extends WP_Customize_Control {

		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'newspaper-x-toggle';

		/**
		 * Display the control content.
		 *
		 * Markup and class names match the control this replaced, so the
		 * Customizer looks and behaves exactly as before.
		 *
		 * @return void
		 */
		public function render_content() {
			?>
			<div class="checkbox_switch">
				<span class="customize-control-title onoffswitch_label">
					<?php echo esc_html( $this->label ); ?>
					<?php if ( ! empty( $this->description ) ) : ?>
						<i class="dashicons dashicons-editor-help" style="vertical-align: text-bottom; position: relative;">
							<span class="mte-tooltip"><?php echo wp_kses_post( $this->description ); ?></span>
						</i>
					<?php endif; ?>
				</span>
				<div class="onoffswitch">
					<input type="checkbox" id="<?php echo esc_attr( $this->id ); ?>"
						name="<?php echo esc_attr( $this->id ); ?>" class="onoffswitch-checkbox"
						value="<?php echo esc_attr( $this->value() ); ?>"
						<?php $this->link(); ?>
						<?php checked( $this->value() ); ?>>
					<label class="onoffswitch-label" for="<?php echo esc_attr( $this->id ); ?>"></label>
				</div>
			</div>
			<?php
		}
	}
}
