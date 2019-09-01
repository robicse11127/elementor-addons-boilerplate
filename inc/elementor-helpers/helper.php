<?php 
namespace Elementor;

function prefix_elementor_init(){
    Plugin::instance()->elements_manager->add_category(
        'prefix-for-elementor',
        [
            'title'     => 'Prefix Elements',
            'icon'      => 'font'
        ],
        1
    );
}
add_action('elementor/init', 'Elementor\prefix_elementor_init');