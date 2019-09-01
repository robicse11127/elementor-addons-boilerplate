<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_Prefix_Name extends Widget_Base {

	public function get_name() {
		return 'prefix-widget-id';
	}

	public function get_title() {
		return esc_html__( 'Widget Title', 'boilerplate-textdomain' );
	}

	public function get_script_depends() {
        return [
            'prefix-public'
        ];
    }

	public function get_icon() {
		return 'eicon-carousel';
	}

    public function get_categories() {
		return [ 'prefix-for-elementor' ];
	}

	protected function _register_controls() {
        /**
         * Content Settings
         */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'boilerplate-textdomain' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->end_controls_section();
        

		/**
		 * Style Tab
		 */
		$this->style_tab();

    }

	private function style_tab() {}

	protected function render() {
		$prefix = $this->get_settings_for_display();
		$this->add_render_attribute(
			'prefix_attrs',
			[
				'id' => 'prefix-widget-'.$this->get_id(),
			]
		);
    ?>
        <!-- Add Markup Starts -->
        <div <?php echo $this->get_render_attribute_string( 'prefix_attrs' ); ?>>

		</div>
        <!-- Add Markup Ends -->
	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Prefix_Name() );