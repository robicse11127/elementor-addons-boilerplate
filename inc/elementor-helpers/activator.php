<?php
function prefix_elements_activator() {
	require_once PREFIX_PLUGIN_PATH . '/elements/blank.php';
}
add_action('elementor/widgets/widgets_registered','prefix_elements_activator');