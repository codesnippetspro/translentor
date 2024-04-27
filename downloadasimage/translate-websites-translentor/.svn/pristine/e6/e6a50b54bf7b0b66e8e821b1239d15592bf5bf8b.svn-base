<?php

/**
 * Extramentor Widgets Product Data Tabs.
 *
 * @package translentor_currency
 */
 


if ( ! defined( 'ABSPATH' ) ) 
{
	exit;   // Exit if accessed directly.
}
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Base;
use Elementor\Group_Control_Border;
use Elementor\Plugin;
use Elementor\Repeater;
class extramentor_wc_currency extends \Elementor\Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
      wp_register_style( 'currency-css', plugin_dir_url( __FILE__ ) .  'assets/css/currency-css.min.css');
        
      wp_register_script( 'currency-js', plugin_dir_url( __FILE__ ) . 'assets/js/currency-js.min.js' );
	 
    }

    public function get_name() 
    {
        return 'woomentor-curremcy';
    }
    
    public function get_title() 
    {
        return __( 'Price: Currency', translentor_slug );
    }

    public function get_icon() 
    {
        return 'eicon-product-price';
    }

    public function get_categories() 
    {
        return [ 'translentor-category' ];
    }
  
    public function get_style_depends() 
    {
        return [ 'currency-css' ];
    }
    
    public function get_script_depends() 
    {
		return [ 
		    'currency-js' 
		];
	}
    protected function currency_setting()
    {
        $this->start_controls_section(
			'currency_section',
			[
				'label' => esc_html__( 'Currency Settings', translentor_slug ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        $repeater = new Repeater();
    
        $repeater->add_control(
            'choose_currency',
            array(
                'label' => __( 'Choose Code', translentor_slug ),
                'type' => Controls_Manager::SELECT2,
                'options' => $this->get_code(),
                'default' => 'USD',
                'label_block' => true,
            )
        );
        $repeater->add_control(
            'choose_symbol',
            array(
                'label' => __( 'Choose Symbol', translentor_slug ),
                'type' => Controls_Manager::SELECT2,
                'options' => $this->get_symbol(),
                'default'     => '&#36;',
                'label_block' => true,
            )
        );
        $repeater->add_control(
			'choose_position',
			[
				'label' => esc_html__( 'Symbol Postion', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $this->get_position(),
                'default'     => 'left',
                'label_block' => true,
			]
		);
        $repeater->add_control(
			'decimals',
			[
				'label' => esc_html__( 'Decimals', translentor_slug ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 8,
				'step' => 1,
				'default' => 0,
			]
		);
        $repeater->add_control(
			'separators',
            [
				'label' => esc_html__( 'Separators', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $this->get_separators(),
                'default'     => 0,
                'label_block' => true,
			]
		);
        $repeater->add_control(
			'currency_icon',
			[
				'label' => esc_html__( 'Choose Image', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
        $repeater->add_control(
			'currency_description',
			[
				'label' => esc_html__( 'Description', translentor_slug ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Default Description', translentor_slug ),
				'placeholder' => esc_html__( 'Type your description here', translentor_slug ),
			]
		);
        $this->add_control(
            'currency_settings',
            array(
                'type'        => Controls_Manager::REPEATER,
                'fields'      =>  $repeater->get_controls() ,
				'item_actions' => [
					'add'       => false,
					'duplicate' => false,
					'remove'    => false,
					'sort'      => true,
				],
                'default'     => [
                    [
                        'choose_currency'  => __( 'USD', translentor_slug ),
                        'choose_symbol'  => __( '&#36;', translentor_slug ),
                        'choose_position'=> __( 'left', translentor_slug ),
                        'currency_icon'=>[
                            'url' => \Elementor\Utils::get_placeholder_image_src(),
                        ],
                        'decimals'=>0,
                        'separators'=>0,
                        
                    ],
                   [
                        'choose_currency'  => __( 'EUR', translentor_slug ),
                        'choose_symbol'  => __( '&euro;', translentor_slug ),
                        'choose_position'=> __( 'left', translentor_slug ),
                        'currency_icon'=>[
                            'url' => \Elementor\Utils::get_placeholder_image_src(),
                        ],
                        'decimals'=>0,
                        'separators'=>0,
                    
                   ],
                  
                ],
                'title_field' => '{{{ choose_currency }}}',
            )
        );
        
		$this->end_controls_section();
    }
    protected function currency_nav()
	{
		$this->start_controls_section(
			'currency_nav_options',
			array(
				'label' => __( 'Currency Nav Options', translentor_slug ),
			)
		);
		$this->add_responsive_control(
			'nav_columns',
			array(
				'label' => __( 'Nav Columns', translentor_slug ),
				'type' => Controls_Manager::SLIDER,
				
				'range' => array(
					'px' => array(
						'min' => 1,
						'max' => 10,
						'step' => 1,
					),
					'%' => array(
						'min' => 1,
						'max' => 8,
						'step' => 1,
					),
					'em' => array(
						'min' => 1,
						'max' => 6,
						'step' => 1,
					),
				),
				'devices' => array( 'desktop', 'tablet', 'mobile' ),
				'desktop_default' => array(
					'size' => 1,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 1,
					'unit' => '%',
				),
				'mobile_default' => array(
					'size' => 1,
					'unit' => 'em',
				),
				'selectors' => array(
					'{{WRAPPER}} .ct-currency__dropdown, {{WRAPPER}} .currency_footer' => 'grid-template-columns: repeat({{SIZE}}, 1fr);',
				),
			)
		);
		$this->add_control(
			'nav_style_location_currency',
			[
				'label' => __( 'Alignment', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'left' => __( 'Right', translentor_slug ),
					'right' => __( 'Left', translentor_slug ),
					'none' => __( 'Center', translentor_slug ),
				],
			]
		);
		$this->end_controls_section();
	}
	protected function currency_toast()
	{
		$this->start_controls_section(
			'currency_toast',
			array(
				'label' => __( 'Currency Notification', translentor_slug ),
			)
		);
			$this->add_control(
			'toast_title_currency',
			[
				'label' => esc_html__( 'Title', translentor_slug ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Website title here', translentor_slug ),
			]
		);
			$this->add_control(
			'toast_position_currency',
			[
				'label' => esc_html__( 'Position', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'bottom-left',
				'options' => [
					'bottom-left'  => esc_html__( 'Bottom Left', translentor_slug ),
					'bottom-right' => esc_html__( 'Bottom Right', translentor_slug ),
					'bottom-center' => esc_html__( 'Bottom Center', translentor_slug ),
					'top-left' => esc_html__( 'Top Left', translentor_slug ),
					'top-right' => esc_html__( 'Top Right', translentor_slug ),
					'top-center' => esc_html__( 'Top Center', translentor_slug ),
					'mid-center' => esc_html__( 'Mid Center', translentor_slug ),
				],
			]
		);
		$this->add_control(
			'toast_transition_currency',
			[
				'label' => esc_html__( 'showHideTransition', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => [
					'fade'  => esc_html__( 'Fade', translentor_slug ),
					'slide' => esc_html__( 'Slide', translentor_slug ),
					'plain' => esc_html__( 'Plain', translentor_slug ),
				],
			]
		);
		$this->add_control(
			'toast-hide_currency',
			[
				'label' => esc_html__( 'HideAfter', translentor_slug ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1000,
				'max' => 10000,
				'step' => 1000,
				'default' => 5000,
			]
		);
		$this->add_control(
			'toast_text_color_currency',
			[
				'label' => esc_html__( 'Text Color', translentor_slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
			]
		);
		$this->add_control(
			'toast_bg_color_currency',
			[
				'label' => esc_html__( 'Background Color', translentor_slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Heading Typography', translentor_slug ),
				'name' => 'heading_typography',
				'selector' => '{{WRAPPER}} .jq-toast-single h2',
				
				
			]
		);
		$this->end_controls_section();
	}
	protected function currency_search()
	{
		$this->start_controls_section(
			'currency_search',
			array(
				'label' => __( 'Currency Search', translentor_slug ),
			)
		);
			$this->add_control(
			'is_search',
			[
				'label' => esc_html__( 'Search BOX', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', translentor_slug ),
				'label_off' => esc_html__( 'Hide', translentor_slug ),
				'return_value' => 'yes',
				'default' => 'no',
				
			]
		);
		$this->add_control(
			'is_search_footer',
			[
				'label' => esc_html__( 'Search BOX', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', translentor_slug ),
				'label_off' => esc_html__( 'Hide', translentor_slug ),
				'return_value' => 'yes',
				'default' => 'no',
				 
			]
		);
		$this->add_control(
			'placeholder',
			[
				'label' => esc_html__( 'Placeholder', translentor_slug ),
				'type' => Controls_Manager::TEXT,
				'separator' => 'before',
				'default' => esc_html__( 'Search', translentor_slug ) . '...',
				'condition' => [
					'is_footer!' => 'yes',
				],
			]
		);
		$this->add_control(
			'placeholder_footer',
			[
				'label' => esc_html__( 'Placeholder', translentor_slug ),
				'type' => Controls_Manager::TEXT,
				'separator' => 'before',
				'default' => esc_html__( 'Search', translentor_slug ) . '...',
				 
			]
		);
			$this->add_responsive_control(
			'currency_type_size',
			array(
				'label' => __( 'SIze', translentor_slug ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => array('%' ),
				'range' => array(
					
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
					
				),
				'devices' => array( 'desktop', 'tablet', 'mobile' ),
				'desktop_default' => array(
					'size' => 60,
					'unit' => '%',
				),
				'tablet_default' => array(
					'size' => 40,
					'unit' => '%',
				),
				'mobile_default' => array(
					'size' => 20,
					'unit' => '%',
				),
				'selectors' => array(
					'{{WRAPPER}} .currency_search' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'=>array(
					'is_footer!' => 'yes',
				),
				
			)
		);
		$this->add_responsive_control(
			'currency_type_size_footer',
			array(
				'label' => __( 'SIze', translentor_slug ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => array('%' ),
				'range' => array(
					
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
					
				),
				'devices' => array( 'desktop', 'tablet', 'mobile' ),
				'desktop_default' => array(
					'size' => 60,
					'unit' => '%',
				),
				'tablet_default' => array(
					'size' => 40,
					'unit' => '%',
				),
				'mobile_default' => array(
					'size' => 20,
					'unit' => '%',
				),
				'selectors' => array(
					'{{WRAPPER}} .search_footer' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'=>array(
					'is_footer' => 'yes',
				),
				
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'input_typography',
				'selector' => '{{WRAPPER}} input[type="search"].currency_search',
				'global' => [
					//'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'condition' => [
					'is_footer!' => 'yes',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'input_typography_footer',
				'selector' => '{{WRAPPER}} input[type="search"].search_footer',
				'global' => [
					//'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				 
			]
		);
		$this->start_controls_tabs( 'tabs_input_colors' );

		$this->start_controls_tab(
			'tab_input_normal',
			[
				'label' => esc_html__( 'Normal', translentor_slug ),
			]
		);

		$this->add_control(
			'input_text_color',
			[
				'label' => esc_html__( 'Text Color', translentor_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					
					'{{WRAPPER}} input[type="search"].currency_search' => 'color: {{VALUE}}; fill: {{VALUE}}',
				],
				'condition' => [
					'is_footer!' => 'yes',
				],
			]
		);
$this->add_control(
			'input_text_color_footer',
			[
				'label' => esc_html__( 'Text Color', translentor_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					
					'{{WRAPPER}} input[type="search"].search_footer' => 'color: {{VALUE}}; fill: {{VALUE}}',
				],
				 
			]
		);
		$this->add_control(
			'input_background_color',
			[
				'label' => esc_html__( 'Background Color', translentor_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					
					'{{WRAPPER}} input[type="search"].currency_search' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'is_footer!' => 'yes',
				],
				
			]
		);
$this->add_control(
			'input_background_color_footer',
			[
				'label' => esc_html__( 'Background Color', translentor_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					
					'{{WRAPPER}} input[type="search"].search_footer' => 'background-color: {{VALUE}}',
				],
				 
				
			]
		);
		$this->add_control(
			'input_border_color',
			[
				'label' => esc_html__( 'Border Color', translentor_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} input[type="search"].currency_search' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'is_footer!' => 'yes',
				],
			]
		);
$this->add_control(
			'input_border_color_footer',
			[
				'label' => esc_html__( 'Border Color', translentor_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} input[type="search"].search_footer' => 'border-color: {{VALUE}}',
				],
				 
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'input_box_shadow',
				'selector' => '{{WRAPPER}} .currency_search',
				'fields_options' => [
					'box_shadow_type' => [
						'separator' => 'default',
					],
				],
				'condition' => [
					'is_footer!' => 'yes',
				],
				
			]
		);
$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'input_box_shadow_footer',
				'selector' => '{{WRAPPER}} .search_footer',
				'fields_options' => [
					'box_shadow_type' => [
						'separator' => 'default',
					],
				],
				 
				
			]
		);
		

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_input_focus',
			[
				'label' => esc_html__( 'Focus', translentor_slug ),
			]
		);

		$this->add_control(
			'input_text_color_focus',
			[
				'label' => esc_html__( 'Text Color', translentor_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					
					'{{WRAPPER}} input[type="search"].currency_search:focus' => 'color: {{VALUE}}; fill: {{VALUE}}',
				],
				'condition' => [
					'is_footer!' => 'yes',
				],
			]
		);
$this->add_control(
			'input_text_color_focus_footer',
			[
				'label' => esc_html__( 'Text Color', translentor_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					
					'{{WRAPPER}} input[type="search"].search_footer:focus' => 'color: {{VALUE}}; fill: {{VALUE}}',
				],
				 
			]
		);
		$this->add_control(
			'input_background_color_focus',
			[
				'label' => esc_html__( 'Background Color', translentor_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					
					'{{WRAPPER}} input[type="search"].currency_search:focus' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'is_footer!' => 'yes',
				],
			]
		);
$this->add_control(
			'input_background_color_focus_footer',
			[
				'label' => esc_html__( 'Background Color', translentor_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					
					'{{WRAPPER}} input[type="search"].search_footer:focus' => 'background-color: {{VALUE}}',
				],
				 
			]
		);
		$this->add_control(
			'input_border_color_focus',
			[
				'label' => esc_html__( 'Border Color', translentor_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} input[type="search"].currency_search:focus' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'is_footer!' => 'yes',
				],
			]
		);
$this->add_control(
			'input_border_color_focus_footer',
			[
				'label' => esc_html__( 'Border Color', translentor_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} input[type="search"].search_footer:focus' => 'border-color: {{VALUE}}',
				],
				 
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'input_box_shadow_focus',
				'selector' => '{{WRAPPER}} .currency_search:focus',
				'fields_options' => [
					'box_shadow_type' => [
						'separator' => 'default',
					],
				],
				'condition' => [
					'is_footer!' => 'yes',
				],
				
			]
		);
$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'input_box_shadow_focus_footer',
				'selector' => '{{WRAPPER}} .search_footer:focus',
				'fields_options' => [
					'box_shadow_type' => [
						'separator' => 'default',
					],
				],
				 
				
			]
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border Radius', translentor_slug ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .currency_search' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'is_footer!' => 'yes',
				],
			]
		);
		$this->add_control(
			'border_radius_footer',
			[
				'label' => esc_html__( 'Border Radius', translentor_slug ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .search_footer' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
				 
			]
		);
	$this->add_responsive_control(
			'padding',
			[
				'label' => esc_html__( 'Padding', translentor_slug ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default' => [
					'size' => 3,
					'unit' => 'px',
				],
				'selectors' => [
					
					'{{WRAPPER}} input[type="search"].currency_search' => 'padding: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'is_footer!' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'padding_searchfooter',
			[
				'label' => esc_html__( 'Padding', translentor_slug ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default' => [
					'size' => 3,
					'unit' => 'px',
				],
				'selectors' => [
					
					'{{WRAPPER}} input[type="search"].search_footer' => 'padding: {{SIZE}}{{UNIT}}',
				],
				 
			]
		);
		$this->add_responsive_control(
			'margin',
			[
				'label' => esc_html__( 'Margin', translentor_slug ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default' => [
					'size' => 3,
					'unit' => 'px',
				],
				'selectors' => [
					
					'{{WRAPPER}} input[type="search"].currency_search' => 'margin: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'is_footer!' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'margin_searchfooter',
			[
				'label' => esc_html__( 'Margin', translentor_slug ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default' => [
					'size' => 3,
					'unit' => 'px',
				],
				'selectors' => [
					
					'{{WRAPPER}} input[type="search"].search_footer' => 'margin: {{SIZE}}{{UNIT}}',
				],
				 
			]
		);
		$this->end_controls_section();
	}
    protected function currency_icon_or_text()
    {

        $this->start_controls_section(
			'currency_options_outer',
			array(
				'label' => __( 'Currency Options Outer', translentor_slug ),
			)
		);
		// $this->add_control(
		// 	'is_footer',
		// 	[
		// 		'label' => esc_html__( 'Footer', translentor_slug ),
		// 		'type' => \Elementor\Controls_Manager::SWITCHER,
		// 		'label_on' => esc_html__( 'Show', translentor_slug ),
		// 		'label_off' => esc_html__( 'Hide', translentor_slug ),
		// 		'return_value' => 'yes',
		// 		'default' => 'no',
		// 	]
		// );
		$this->add_control(
			'outer_currency_style',
			array(
				'label' => __( 'Choose Style', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'both',
				'options' => array(
					'icon'  => __( 'Icon', translentor_slug ),
					'text' => __( 'Text', translentor_slug ),
					'both' => __( 'Icon + Text', translentor_slug ),
				),
			)
		);
		
		$this->add_control(
			'icon_position_currency',
			array(
				'label' => __( 'Icon Position', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'left',
				'options' => array(
					'left'  => __( 'Left', translentor_slug ),
					'right' => __( 'Right', translentor_slug ),
				),
				'condition' => array(
                    'outer_currency_style' => 'both'
                ),
			)
		);
		
		$this->add_control(
			'currency_icon_heading',
			array(
				'label' => __( 'Currency Icon', translentor_slug ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
                    'outer_currency_style' => 'both'
                ),
			)
		);
		
		$this->add_control(
			'currency__icon',
			array(
				'label' => __( 'Icon', translentor_slug ),
				'type' => Controls_Manager::ICONS,
				'default' => array(
					'value' => 'fas fa-dollar-sign',
					'library' => 'solid',
				),
				'condition' => array(
                    'outer_currency_style!' => 'text'
                ),
			)
		);
		
		$this->add_responsive_control(
			'currency_icon_size',
			array(
				'label' => __( 'Icon SIze', translentor_slug ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
					'em' => array(
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					),
				),
				'devices' => array( 'desktop', 'tablet', 'mobile' ),
				'desktop_default' => array(
					'size' => 16,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 16,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 16,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .ct-currency i,{{WRAPPER}} .drop_currency img,{{WRAPPER}} .drop_footer img' => 'font-size: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
                    'outer_currency_style!' => 'text'
                ),
			)
		);
		
		$this->add_control(
			'currency_icon_color',
			[
				'label' => __( 'Icon Colour', translentor_slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
					'default' => '#F81414',
				
				'selectors' => [
					'{{WRAPPER}} .ct-currency i' => 'color: {{VALUE}};',
					],
				
			]
		);
			$this->add_control(
			'currency_text_color',
			[
				'label' => __( 'Text Colour', translentor_slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
					'default' => '#F81414',
				
				'selectors' => [
					'{{WRAPPER}} .ct-currency span' => 'color: {{VALUE}};',
					],
				
			]
		);
		
		$this->add_control(
			'currency_icon_color_hover',
			[
				'label' => __( 'Icon Colour Hover', translentor_slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
					'default' => '#F81414',
				
				'selectors' => [
					'{{WRAPPER}} .ct-currency i:hover' => 'color: {{VALUE}};',
					],
				
			]
		);
			$this->add_control(
			'currency_text_color_hover',
			[
				'label' => __( 'Text Colour Hover', translentor_slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
					'default' => '#F81414',
				
				'selectors' => [
					'{{WRAPPER}} .ct-currency span:hover' => 'color: {{VALUE}};',
					],
				
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Css_Filter::get_type(),
			[
				'name' => 'custom_css_filters',
				'selector' => '{{WRAPPER}} .drop_currency img,{{WRAPPER}} .drop_footer img,{{WRAPPER}} .drop_currency i,{{WRAPPER}} .drop_footer i',
			]
		);
		$this->add_responsive_control(
			'currency_icon_padding',
			array(
				'label'      => __( 'Icon Padding', translentor_slug ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ct-currency i,{{WRAPPER}} .drop_currency img,{{WRAPPER}} .drop_footer img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition' => array(
                    'outer_currency_style!' => 'text'
                ),
			)
		);
		

		$this->add_control(
			'currency_text_heading',
			array(
				'label' => __( 'Currency Text', translentor_slug ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
                    'outer_currency_style' => 'both'
                ),
			)
		);
		
		$this->add_control(
			'currency_text',
			array(
				'label' => __( 'Text', translentor_slug ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Currency', translentor_slug ),
				'placeholder' => __( 'Type your currency text here', translentor_slug ),
				'condition' => array(
                    'outer_currency_style!' => 'icon'
                ),
			)
		);
		
		
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name' => 'currency_text_typography',
				'label' => __( 'Text Typography', translentor_slug ),
				
				'selector' => '{{WRAPPER}} .ct-currency span',
				'condition' => array(
                    'outer_currency_style!' => 'icon'
                ),
			)
		);
	
		
		$this->end_controls_section();
    }
    
    protected function flags_icon_or_text()
    {
        $this->start_controls_section(
			'currency_options',
			array(
				'label' => __( 'Currency Options', translentor_slug ),
			)
		);
		
		$this->add_control(
			'currency_style',
			array(
				'label' => __( 'Choose Style', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'both',
				'options' => array(
					'icon'  => __( 'Icon', translentor_slug ),
					'text' => __( 'Text', translentor_slug ),
					'both' => __( 'Icon + Text', translentor_slug ),
				),
			)
		);
		
		$this->add_control(
			'currency_icon_heading_flag',
			array(
				'label' => __( 'Currency Icon', translentor_slug ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
                    'currency_style' => 'both'
                ),
			)
		);
		
		$this->add_control(
			'currency_icon_position_currency',
			array(
				'label' => __( 'Icon Position', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'left',
				'options' => array(
					'left'  => __( 'Left', translentor_slug ),
					'right' => __( 'Right', translentor_slug ),
				),
				'condition' => array(
                    'currency_style' => 'both'
                ),
			)
		);
		
		$this->add_control(
			'currency_icon_layout',
			array(
				'label' => __( 'Icon Layout', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => array(
					'horizontal'  => __( 'Horizontal', translentor_slug ),
					'vertical' => __( 'Vertical', translentor_slug ),
				),
				'condition' => array(
                    'currency_style' => 'icon'
                ),
			)
		);
		
	
		
		$this->end_controls_section();
    }
    

    
    protected function register_general_controls()
    {
        $this->start_controls_section(
			'section_lt_general',
			array(
				'label' => __( 'General', translentor_slug ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name' => 'background',
				'label' => __( 'Background', translentor_slug ),
				'types' => [ 'classic', 'gradient', translentor_slug ],
				'selector'  => '{{WRAPPER}} .ct-currency',
			)
		);
		
		
		
		$this->add_responsive_control(
			'section_lt_list_padding',
			array(
				'label'      => __( 'Country Padding', translentor_slug ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				
				'selectors'  => array(
					'{{WRAPPER}} .ct-currency__dropdown li,{{WRAPPER}} .currency_footer li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		
		$this->add_responsive_control(
			'section_lt_dropdown_position',
			array(
				'label'      => __( 'Dropdown Positioning', translentor_slug ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default' => array(
					'size' => 71,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .ct-currency__dropdown, {{WRAPPER}} .currency_footer' => 'top: {{TOP}}{{UNIT}};left: {{LEFT}}{{UNIT}};',
				
				),
			)
		);
$this->add_responsive_control(
			'section_text_margin',
			array(
				'label'      => __( 'Text Margin', translentor_slug ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				
				'selectors'  => array(
					'{{WRAPPER}} .ct-currency span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_section();
    }
    protected function register_processbar_style_control()
	{
		$this->start_controls_section(
			'section_processbar_style',
			array(
				'label' => __( 'Process Bar', translentor_slug ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'bar_background',
			array(
				'label' => __( 'Background Colour', translentor_slug ),
				'type' => Controls_Manager::COLOR,
				
				'default' => '#ededed',
				'selectors' => array(
					
					'{{WRAPPER}} .progress-container_currency, {{WRAPPER}} .progress-container_currency_footer' => 'background-color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'bar_color',
			array(
				'label' => __( 'Colour', translentor_slug ),
				'type' => Controls_Manager::COLOR,
				
				'default' => '#ededed',
				'selectors' => array(
					
					'{{WRAPPER}} .progress-bar-currency,{{WRAPPER}} .progress-bar_footer' => 'background-color: {{VALUE}}',
				),
			)
		);
		$this->end_controls_section();
	}
    protected function register_country_style_control()
    {
        $this->start_controls_section(
			'section_country_style',
			array(
				'label' => __( 'Countries', translentor_slug ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		
		$this->add_control(
			'country_background',
			array(
				'label' => __( 'Background Colour', translentor_slug ),
				'type' => Controls_Manager::COLOR,
				
				'default' => '#ededed',
				'selectors' => array(
					
					'{{WRAPPER}} .ct-currency__dropdown li, {{WRAPPER}} .currency_footer li' => 'background: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'country_background_hover',
			array(
				'label' => __( 'Background Hover Colour', translentor_slug ),
				'type' => Controls_Manager::COLOR,
				
				'default' => '#ededed',
				'selectors' => array(
					'{{WRAPPER}} .ct-currency__dropdown li:hover ,{{WRAPPER}} .currency_footer li:hover' => 'background: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'country_text_heading',
			array(
				'label' => __( 'Country Text', translentor_slug ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		
		$this->start_controls_tabs(
			'style_tabs'
		);

		$this->start_controls_tab(
			'style_normal_tab',
			array(
				'label' => __( 'Normal', 'plugin-name' ),
			)
		);
		
		$this->add_control(
			'country_normal_color',
			array(
				'label' => __( 'Colour', translentor_slug ),
				'type' => Controls_Manager::COLOR,
				
				'selectors' => array(
					'{{WRAPPER}} .ct-currency__dropdown a,{{WRAPPER}} .currency_footer a' => 'color: {{VALUE}}',
				),
			)
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name' => 'hyperlink_normal_typography',
				'label' => __( 'Typography', translentor_slug ),
				
				'selector' => '{{WRAPPER}} .ct-currency__dropdown a,{{WRAPPER}} .currency_footer a',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'style_hover_tab',
			array(
				'label' => __( 'Hover', translentor_slug ),
			)
		);
		
		$this->add_control(
			'country_hover_color',
			array(
				'label' => __( 'Colour', translentor_slug ),
				'type' => Controls_Manager::COLOR,
				
				'selectors' => array(
					'{{WRAPPER}} .ct-currency__dropdown a:hover, {{WRAPPER}} .currency_footer a:hover' => 'color: {{VALUE}}',
				),
			)
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name' => 'hyperlink_hover_typography',
				'label' => __( 'Typography', translentor_slug ),
				
				'selector' => '{{WRAPPER}} .ct-currency__dropdown a:hover,{{WRAPPER}} .currency_footer a:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
    }
    
    protected function register_flags_style_control()
    {
        $this->start_controls_section(
			'section_flags_style',
			array(
				'label' => __( 'Flags', translentor_slug ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		
		$this->add_responsive_control(
			'flags_size',
			array(
				'label' => __( 'Flag SIze', translentor_slug ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
					'em' => array(
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					),
				),
				'devices' => array( 'desktop', 'tablet', 'mobile' ),
				'desktop_default' => array(
					'size' => 16,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 16,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 16,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lang-img' => 'width: {{SIZE}}{{UNIT}} !important;',
				),
			)
		);
		
		$this->add_responsive_control(
			'flags_padding',
			array(
				'label'      => __( 'Padding', translentor_slug ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .lang-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		
		$this->add_responsive_control(
			'flags_margins',
			array(
				'label'      => __( 'Margin', translentor_slug ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default' => array(
					'unit' => 'px',
					'top' => 10,
					'bottom' => 10,
					'left' => 10,
					'right' => 10,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lang-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
    }
    protected function register_dropdown_outer_style_control()
	{
		 $this->start_controls_section(
			'section_dropdown_outer_style',
			array(
				'label' => __( 'Nav Outer Selectors', translentor_slug ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'dropdown_outer_padding',
			[
				'label'      => __( 'Padding', translentor_slug ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default' => array(
					'unit' => 'px',
					'top' => 0,
					'bottom' => 0,
					'left' => 0,
					'right' => 0,
				),
				'selectors'  => [
					'{{WRAPPER}} .ct-currency' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);
		
		$this->add_responsive_control(
			'dropdown_outer_margin',
			[
				'label'      => __( 'Margins', translentor_slug ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => [
					'{{WRAPPER}} .ct-currency' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__( 'Border',translentor_slug),
				'selector' => '{{WRAPPER}} .currency-nav-align',
			]
		);
		$this->add_responsive_control(
			'dropdown_outer_border_radius',
			[
				'label'      => __( 'Border Redius', translentor_slug ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => [
					'{{WRAPPER}} .currency-nav-align' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
	}
    protected function register_dropdown_style_control()
    {
        $this->start_controls_section(
			'section_dropdown_style',
			array(
				'label' => __( 'Currency Selectors', translentor_slug ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		
		$this->add_responsive_control(
			'dropdown_list_padding',
			[
				'label'      => __( 'Padding', translentor_slug ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default' => array(
					'unit' => 'px',
					'top' => 10,
					'bottom' => 10,
					'left' => 10,
					'right' => 10,
				),
				'selectors'  => [
					'{{WRAPPER}} .ct-currency__dropdown li, {{WRAPPER}}.currency_footer li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'dropdown_list_margin',
			array(
				'label'      => __( 'Margins', translentor_slug ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ct-currency__dropdown li,{{WRAPPER}} .currency_footer li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'dropdown_dropdown_before_position',
			array(
				'label'      => __( 'Before Icon Position', translentor_slug ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ct-currency__dropdown::before,{{WRAPPER}} .currency_footer::before' => 'top: {{BOTTOM}}{{UNIT}};right: {{LEFT}}{{UNIT}};bottom: {{TOp}}{{UNIT}};left: {{RIGHT}}{{UNIT}};',
				),
			)
		);
			$this->add_control(
			'dropdown_dropdown_before_color',
			array(
				'label' => __( 'Before Icon Colour', translentor_slug ),
				'type' => Controls_Manager::COLOR,
				
				'default' => '#ededed',
				'selectors' => array(
					'{{WRAPPER}} .ct-currency__dropdown::before, {{WRAPPER}} .currency_footer::before' => 'border-bottom-color: {{VALUE}}',
				),
			)
		);
		$this->end_controls_section();
    }
    protected function register_controls() 
    {
       
        $this->currency_setting();
        $this->currency_icon_or_text();
        
        $this->flags_icon_or_text();
        
        $this->register_general_controls();
        
        $this->register_country_style_control();
        
        $this->register_flags_style_control();
        
        $this->register_dropdown_style_control();
		$this->register_processbar_style_control();
		$this->currency_nav();
		$this->currency_toast();
		$this->currency_search();
		$this->register_dropdown_outer_style_control();
    }
    protected function get_separators()
    {
        return[
            0 => '10,000.00', //default
            1 => '10.000,00',
            2 => '10 000.00',
            3 => '10 000,00',
            4 => '10000.00',
            5 => '10000,00',
        ];
    }
    protected function get_position()
{
return [
    'left'=> __( 'Left', translentor_slug ),
    'left_space'=> __( 'Left Space', translentor_slug ),
    'right'=> __( 'Right', translentor_slug ),
    'right_space'=> __( 'Right Space', translentor_slug )
];    
}
    protected function get_symbol()
    {
        return[
            '&#36;'=>__( '&#36;', translentor_slug ),
            '&euro;'=>__( '&euro;', translentor_slug ),
            '&pound;'=>__( '&pound;', translentor_slug ),
            '&#1075;&#1088;&#1085;.'=>__( '&#1075;&#1088;&#1085;.', translentor_slug ),
            '&#1088;&#1091;&#1073;.'=>__( '&#1088;&#1091;&#1073;.', translentor_slug ),
            '&#x62f;.&#x625;'=>__( '&#x62f;.&#x625;', translentor_slug ),
            '&#x60b;'=>__( '&#x60b;', translentor_slug ),
            'L'=>__( 'L', translentor_slug ),
            'AMD'=>__( 'AMD', translentor_slug ),
            '&fnof;'=>__( '&fnof;', translentor_slug ),
            'Kz'=>__( 'Kz', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            'Afl.'=>__( 'Afl.', translentor_slug ),
            'AZN'=>__( 'AZN', translentor_slug ),
            'KM'=>__( 'KM', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            '&#2547;&nbsp;'=>__( '&#2547;&nbsp;', translentor_slug ),
            '&#1083;&#1074;.'=>__( '&#1083;&#1074;.', translentor_slug ),
            '.&#x62f;.&#x628;'=>__( '.&#x62f;.&#x628;', translentor_slug ),
            'Fr'=>__( 'Fr', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            'Bs.'=>__( 'Bs.', translentor_slug ),
            'Rs'=>__( 'Rs', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            '&#3647;'=>__( '&#3647;', translentor_slug ),
            'Nu.'=>__( 'Nu.', translentor_slug ),
            'P'=>__( 'P', translentor_slug ),
            'Br'=>__( 'Br', translentor_slug ),
            'Br'=>__( 'Br', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            'Fr'=>__( 'Fr', translentor_slug ),
            '&#67;&#72;&#70;'=>__( '&#67;&#72;&#70;', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            '&yen;'=>__( '&yen;', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            '&#x20a1;'=>__( '&#x20a1;', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            '&#75;&#269;'=>__( '&#75;&#269;', translentor_slug ),
            'Fr'=>__( 'Fr', translentor_slug ),
            'DKK'=>__( 'DKK', translentor_slug ),
            'RD&#36;'=>__( 'RD&#36;', translentor_slug ),
            '&#x62f;.&#x62c;'=>__( '&#x62f;.&#x62c;', translentor_slug ),
            'EGP'=>__( 'EGP', translentor_slug ),
            'Nfk'=>__( 'Nfk', translentor_slug ),
            'Br'=>__( 'Br', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            '&pound;'=>__( '&pound;', translentor_slug ),
            '&#x10da;'=>__( '&#x10da;', translentor_slug ),
            '&pound;'=>__( '&pound;', translentor_slug ),
            '&#x20b5;'=>__( '&#x20b5;', translentor_slug ),
            '&pound;'=>__( '&pound;', translentor_slug ),
            'D'=>__( 'D', translentor_slug ),
            'Fr'=>__( 'Fr', translentor_slug ),
            'Q'=>__( 'Q', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            'L'=>__( 'L', translentor_slug ),
            'Kn'=>__( 'Kn', translentor_slug ),
            'G'=>__( 'G', translentor_slug ),
            '&#70;&#116;'=>__( '&#70;&#116;', translentor_slug ),
            'Rp'=>__( 'Rp', translentor_slug ),
            '&#8362;'=>__( '&#8362;', translentor_slug ),
            '&pound;'=>__( '&pound;', translentor_slug ),
            '&#8377;'=>__( '&#8377;', translentor_slug ),
            '&#x639;.&#x62f;'=>__( '&#x639;.&#x62f;', translentor_slug ),
            '&#xfdfc;'=>__( '&#xfdfc;', translentor_slug ),
            '&#x062A;&#x0648;&#x0645;&#x0627;&#x0646;'=>__( '&#x062A;&#x0648;&#x0645;&#x0627;&#x0646;', translentor_slug ),
            'kr.'=>__( 'kr.', translentor_slug ),
            '&pound;'=>__( '&pound;', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            '&#x62f;.&#x627;'=>__( '&#x62f;.&#x627;', translentor_slug ),
            '&yen;'=>__( '&yen;', translentor_slug ),
            'KSh'=>__( 'KSh', translentor_slug ),
            '&#x441;&#x43e;&#x43c;'=>__( '&#x441;&#x43e;&#x43c;', translentor_slug ),
            '&#x17db;'=>__( '&#x17db;', translentor_slug ),
            'Fr'=>__( 'Fr', translentor_slug ),
            '&#x20a9;'=>__( '&#x20a9;', translentor_slug ),
            '&#8361;'=>__( '&#8361;', translentor_slug ),
            '&#x62f;.&#x643;'=>__( '&#x62f;.&#x643;', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            'KZT'=>__( 'KZT', translentor_slug ),
            '&#8365;'=>__( '&#8365;', translentor_slug ),
            '&#x644;.&#x644;'=>__( '&#x644;.&#x644;', translentor_slug ),
            '&#xdbb;&#xdd4;'=>__( '&#xdbb;&#xdd4;', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            'L'=>__( 'L', translentor_slug ),
            '&#x644;.&#x62f;'=>__( '&#x644;.&#x62f;', translentor_slug ),
            '&#x62f;.&#x645;.'=>__( '&#x62f;.&#x645;.', translentor_slug ),
            'MDL'=>__( 'MDL', translentor_slug ),
            'Ar'=>__( 'Ar', translentor_slug ),
            '&#x434;&#x435;&#x43d;'=>__( '&#x434;&#x435;&#x43d;', translentor_slug ),
            'Ks'=>__( 'Ks', translentor_slug ),
            '&#x20ae;'=>__( '&#x20ae;', translentor_slug ),
            'P'=>__( 'P', translentor_slug ),
            'UM'=>__( 'UM', translentor_slug ),
            '&#x20a8;'=>__( '&#x20a8;', translentor_slug ),
            '.&#x783;'=>__( '.&#x783;', translentor_slug ),
            'MK'=>__( 'MK', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            '&#82;&#77;'=>__( '&#82;&#77;', translentor_slug ),
            'MT'=>__( 'MT', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            '&#8358;'=>__( '&#8358;', translentor_slug ),
            'C&#36;'=>__( 'C&#36;', translentor_slug ),
            '&#107;&#114;'=>__( '&#107;&#114;', translentor_slug ),
            '&#8360;'=>__( '&#8360;', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            '&#x631;.&#x639;.'=>__( '&#x631;.&#x639;.', translentor_slug ),
            'B/.'=>__( 'B/.', translentor_slug ),
            'S/.'=>__( 'S/.', translentor_slug ),
            'K'=>__( 'K', translentor_slug ),
            '&#8369;'=>__( '&#8369;', translentor_slug ),
            '&#8360;'=>__( '&#8360;', translentor_slug ),
            '&#122;&#322;'=>__( '&#122;&#322;', translentor_slug ),
            '&#x440;.'=>__( '&#x440;.', translentor_slug ),
            '&#8370;'=>__( '&#8370;', translentor_slug ),
            '&#x631;.&#x642;'=>__( '&#x631;.&#x642;', translentor_slug ),
            '&yen;'=>__( '&yen;', translentor_slug ),
            'lei'=>__( 'lei', translentor_slug ),
            '&#x434;&#x438;&#x43d;.'=>__( '&#x434;&#x438;&#x43d;.', translentor_slug ),
            'Fr'=>__( 'Fr', translentor_slug ),
            '&#x631;.&#x633;'=>__( '&#x631;.&#x633;', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            '&#x20a8;'=>__( '&#x20a8;', translentor_slug ),
            '&#x62c;.&#x633;.'=>__( '&#x62c;.&#x633;.', translentor_slug ),
            '&#107;&#114;'=>__( '&#107;&#114;', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            '&pound;'=>__( '&pound;', translentor_slug ),
            'Le'=>__( 'Le', translentor_slug ),
            'Sh'=>__( 'Sh', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            '&pound;'=>__( '&pound;', translentor_slug ),
            'Db'=>__( 'Db', translentor_slug ),
            '&#x644;.&#x633;'=>__( '&#x644;.&#x633;', translentor_slug ),
            'L'=>__( 'L', translentor_slug ),
            '&#3647;'=>__( '&#3647;', translentor_slug ),
            '&#x405;&#x41c;'=>__( '&#x405;&#x41c;', translentor_slug ),
            'm'=>__( 'm', translentor_slug ),
            '&#x62f;.&#x62a;'=>__( '&#x62f;.&#x62a;', translentor_slug ),
            'T&#36;'=>__( 'T&#36;', translentor_slug ),
            '&#8378;'=>__( '&#8378;', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            '&#78;&#84;&#36;'=>__( '&#78;&#84;&#36;', translentor_slug ),
            'Sh'=>__( 'Sh', translentor_slug ),
            'UGX'=>__( 'UGX', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            'UZS'=>__( 'UZS', translentor_slug ),
            'Bs F'=>__( 'Bs F', translentor_slug ),
            '&#8363;'=>__( '&#8363;', translentor_slug ),
            'Vt'=>__( 'Vt', translentor_slug ),
            'T'=>__( 'T', translentor_slug ),
            'CFA'=>__( 'CFA', translentor_slug ),
            '&#36;'=>__( '&#36;', translentor_slug ),
            'CFA'=>__( 'CFA', translentor_slug ),
            'Fr'=>__( 'Fr', translentor_slug ),
            '&#xfdfc;'=>__( '&#xfdfc;', translentor_slug ),
            '&#82;'=>__( '&#82;', translentor_slug ),
            'ZK'=>__( 'ZK', translentor_slug )
        ];
    }
    protected function get_code()
    {
        return [
         'AED'=> __( 'AED', translentor_slug ),
         'AFN'=> __( 'AFN', translentor_slug ),
         'ALL'=> __( 'ALL', translentor_slug ),
         'AMD'=> __( 'AMD', translentor_slug ),
         'ANG'=> __( 'ANG', translentor_slug ),
         'AOA'=> __( 'AOA', translentor_slug ),
         'ARS'=> __( 'ARS', translentor_slug ),
         'AUD'=> __( 'AUD', translentor_slug ),
         'AWG'=> __( 'AWG', translentor_slug ),
         'AZN'=> __( 'AZN', translentor_slug ),
         'BAM'=> __( 'BAM', translentor_slug ),
         'BBD'=> __( 'BBD', translentor_slug ),
         'BDT'=> __( 'BDT', translentor_slug ),
         'BGN'=> __( 'BGN', translentor_slug ),
         'BHD'=> __( 'BHD', translentor_slug ),
         'BIF'=> __( 'BIF', translentor_slug ),
         'BMD'=> __( 'BMD', translentor_slug ),
         'BND'=> __( 'BND', translentor_slug ),
         'BOB'=> __( 'BOB', translentor_slug ),
         'BRL'=> __( 'BRL', translentor_slug ),
         'BSD'=> __( 'BSD', translentor_slug ),
         'BTC'=> __( 'BTC', translentor_slug ),
         'BWP'=> __( 'BWP', translentor_slug ),
         'BYN'=> __( 'BYN', translentor_slug ),
         'BZD'=> __( 'BZD', translentor_slug ),
         'CAD'=> __( 'CAD', translentor_slug ),
         'CDF'=> __( 'CDF', translentor_slug ),
         'CHF'=> __( 'CHF', translentor_slug ),
         'CLP'=> __( 'CLP', translentor_slug ),
         'CNY'=> __( 'CNY', translentor_slug ),
         'COP'=> __( 'COP', translentor_slug ),
         'CRC'=> __( 'CRC', translentor_slug ),
         'CUC'=> __( 'CUC', translentor_slug ),
         'CUP'=> __( 'CUP', translentor_slug ),
         'CVE'=> __( 'CVE', translentor_slug ),
         'CZK'=> __( 'CZK', translentor_slug ),
         'DJF'=> __( 'DJF', translentor_slug ),
         'DKK'=> __( 'DKK', translentor_slug ),
         'DOP'=> __( 'DOP', translentor_slug ),
         'DZD'=> __( 'DZD', translentor_slug ),
         'EGP'=> __( 'EGP', translentor_slug ),
         'ETB'=> __( 'ETB', translentor_slug ),
         'EUR'=> __( 'EUR', translentor_slug ),
         'FJD'=> __( 'FJD', translentor_slug ),
         'GBP'=> __( 'GBP', translentor_slug ),
         'GEL'=> __( 'GEL', translentor_slug ),
         'GHS'=> __( 'GHS', translentor_slug ),
         'GMD'=> __( 'GMD', translentor_slug ),
         'GNF'=> __( 'GNF', translentor_slug ),
         'GTQ'=> __( 'GTQ', translentor_slug ),
         'GYD'=> __( 'GYD', translentor_slug ),
         'HKD'=> __( 'HKD', translentor_slug ),
         'HNL'=> __( 'HNL', translentor_slug ),
         'HRK'=> __( 'HRK', translentor_slug ),
         'HTG'=> __( 'HTG', translentor_slug ),
         'HUF'=> __( 'HUF', translentor_slug ),
         'IDR'=> __( 'IDR', translentor_slug ),
         'ILS'=> __( 'ILS', translentor_slug ),
         'INR'=> __( 'INR', translentor_slug ),
         'IQD'=> __( 'IQD', translentor_slug ),
         'IRR'=> __( 'IRR', translentor_slug ),
         'ISK'=> __( 'ISK', translentor_slug ),
         'JMD'=> __( 'JMD', translentor_slug ),
         'JOD'=> __( 'JOD', translentor_slug ),
         'JPY'=> __( 'JPY', translentor_slug ),
         'KES'=> __( 'KES', translentor_slug ),
         'KGS'=> __( 'KGS', translentor_slug ),
         'KHR'=> __( 'KHR', translentor_slug ),
         'KMF'=> __( 'KMF', translentor_slug ),
         'KRW'=> __( 'KRW', translentor_slug ),
         'KWD'=> __( 'KWD', translentor_slug ),
         'KYD'=> __( 'KYD', translentor_slug ),
         'KZT'=> __( 'KZT', translentor_slug ),
         'LAK'=> __( 'LAK', translentor_slug ),
         'LBP'=> __( 'LBP', translentor_slug ),
         'LKR'=> __( 'LKR', translentor_slug ),
         'LRD'=> __( 'LRD', translentor_slug ),
         'LSL'=> __( 'LSL', translentor_slug ),
         'LYD'=> __( 'LYD', translentor_slug ),
         'MAD'=> __( 'MAD', translentor_slug ),
         'MDL'=> __( 'MDL', translentor_slug ),
         'MGA'=> __( 'MGA', translentor_slug ),
         'MKD'=> __( 'MKD', translentor_slug ),
         'MMK'=> __( 'MMK', translentor_slug ),
         'MOP'=> __( 'MOP', translentor_slug ),
         'MRO'=> __( 'MRO', translentor_slug ),
         'MUR'=> __( 'MUR', translentor_slug ),
         'MVR'=> __( 'MVR', translentor_slug ),
         'MWK'=> __( 'MWK', translentor_slug ),
         'MXN'=> __( 'MXN', translentor_slug ),
         'MYR'=> __( 'MYR', translentor_slug ),
         'MZN'=> __( 'MZN', translentor_slug ),
         'NAD'=> __( 'NAD', translentor_slug ),
         'NGN'=> __( 'NGN', translentor_slug ),
         'NIO'=> __( 'NIO', translentor_slug ),
         'NOK'=> __( 'NOK', translentor_slug ),
         'NPR'=> __( 'NPR', translentor_slug ),
         'NZD'=> __( 'NZD', translentor_slug ),
         'OMR'=> __( 'OMR', translentor_slug ),
         'PAB'=> __( 'PAB', translentor_slug ),
         'PEN'=> __( 'PEN', translentor_slug ),
         'PGK'=> __( 'PGK', translentor_slug ),
         'PHP'=> __( 'PHP', translentor_slug ),
         'PKR'=> __( 'PKR', translentor_slug ),
         'PLN'=> __( 'PLN', translentor_slug ),
         'PYG'=> __( 'PYG', translentor_slug ),
         'QAR'=> __( 'QAR', translentor_slug ),
         'RON'=> __( 'RON', translentor_slug ),
         'RSD'=> __( 'RSD', translentor_slug ),
         'RUB'=> __( 'RUB', translentor_slug ),
         'RWF'=> __( 'RWF', translentor_slug ),
         'SAR'=> __( 'SAR', translentor_slug ),
         'SBD'=> __( 'SBD', translentor_slug ),
         'SCR'=> __( 'SCR', translentor_slug ),
         'SDG'=> __( 'SDG', translentor_slug ),
         'SEK'=> __( 'SEK', translentor_slug ),
         'SGD'=> __( 'SGD', translentor_slug ),
         'SLL'=> __( 'SLL', translentor_slug ),
         'SOS'=> __( 'SOS', translentor_slug ),
         'SRD'=> __( 'SRD', translentor_slug ),
         'SSP'=> __( 'SSP', translentor_slug ),
         'STD'=> __( 'STD', translentor_slug ),
         'SZL'=> __( 'SZL', translentor_slug ),
         'THB'=> __( 'THB', translentor_slug ),
         'TJS'=> __( 'TJS', translentor_slug ),
         'TMT'=> __( 'TMT', translentor_slug ),
         'TND'=> __( 'TND', translentor_slug ),
         'TOP'=> __( 'TOP', translentor_slug ),
         'TRY'=> __( 'TRY', translentor_slug ),
         'TTD'=> __( 'TTD', translentor_slug ),
         'TWD'=> __( 'TWD', translentor_slug ),
         'TZS'=> __( 'TZS', translentor_slug ),
         'UAH'=> __( 'UAH', translentor_slug ),
         'UGX'=> __( 'UGX', translentor_slug ),
         'USD'=> __( 'USD', translentor_slug ),
         'UYU'=> __( 'UYU', translentor_slug ),
         'UZS'=> __( 'UZS', translentor_slug ),
         'VEF'=> __( 'VEF', translentor_slug ),
         'VND'=> __( 'VND', translentor_slug ),
         'XAF'=> __( 'XAF', translentor_slug ),
         'XCD'=> __( 'XCD', translentor_slug ),
         'XOF'=> __( 'XOF', translentor_slug ),
         'XPF'=> __( 'XPF', translentor_slug ),
         'YER'=> __( 'YER', translentor_slug ),
         'ZAR'=> __( 'ZAR', translentor_slug ),
         'ZMW'=> __( 'ZMW', translentor_slug )
        ];

    }
    protected function render()
    {
        $settings = $this->get_settings_for_display();
		$this->add_render_attribute(
			'toast_title_currency',
			[
				'id' => 'toast_title_currency',
				'style' => 'display:none',
			
			]
		);
		$this->add_render_attribute(
			'toast_position_currency',
			[
				'id' => 'toast_position_currency',
				'style' => 'display:none',
			
			]
		);
		$this->add_render_attribute(
			'toast_transition_currency',
			[
				'id' => 'toast_transition_currency',
				'style' => 'display:none',
			
			]
		);
		$this->add_render_attribute(
			'toast_hide_currency',
			[
				'id' => 'toast-hide_currency',
				'style' => 'display:none',
			
			]
		);
		$this->add_render_attribute(
			'toast_text_color_currency',
			[
				'id' => 'toast_text_color_currency',
				'style' => 'display:none',
			
			]
		);
		$this->add_render_attribute(
			'toast_bg_color_currency',
			[
				'id' => 'toast_bg_color_currency',
				'style' => 'display:none',
			
			]
		);
		$this->add_render_attribute(
			'currency_style',
			[
				'id' => 'currency_style',
				'style' => 'display:none',
			
			]
		);
		$this->add_render_attribute(
			'icon_position_currency',
			[
				'id' => 'icon_position_currency',
				'style' => 'display:none',
			
			]
		);
		$this->add_render_attribute( 
			'progress-container_currency',
[
	'class' => [ 'progress-container_currency','fixed-top_currency'],
] );
$this->add_render_attribute( 
	'cttopbarlistcurrency',
[
'class' => [ 'list-unstyled_currency', 'list-inline_currency', 'ct-topbar_currency__list'],
] );
$this->add_render_attribute( 'progress-bar-currency',[
	'class'=>'progress-bar-currency',
	'percent'=>'100',
	]);
	$this->add_render_attribute(
		'currency_search',
		[
			'id' => 'currency_search',
			'class' => 'currency_search',
			'type'=>'search',
			'placeholder'=> esc_html($settings['placeholder']),
		
		]
	);
	$this->add_render_attribute( 'ct-topbar_currency', 'class','ct-topbar_currency');
	$this->add_render_attribute( 'container_currency', 'class','container_currency');
	$this->add_render_attribute( 'ct-currency', 'class','ct-currency');
    $this->add_render_attribute( 'drop_currency', 'class','drop_currency');
	$this->add_render_attribute( 'stilesnavaligncurrency', 'class','currency-nav-align');
        $result=array();
        $response = wp_remote_get( 'https://api.exchangerate-api.com/v4/latest/USD' );
		$exchangeRates=json_decode($response['body'], true);
        $selected = array();
		?>
<div <?php echo $this->get_render_attribute_string( 'toast_title_currency' ); ?>><?php echo esc_html($settings['toast_title_currency']);?></div>
<div <?php echo $this->get_render_attribute_string( 'toast_position_currency' ); ?>><?php echo esc_html($settings['toast_position_currency']);?></div>
<div <?php echo $this->get_render_attribute_string( 'toast_transition_currency' ); ?>><?php echo esc_html($settings['toast_transition_currency']);?></div>
<div <?php echo $this->get_render_attribute_string( 'toast_hide_currency' ); ?>><?php echo esc_html($settings['toast-hide_currency']);?></div>
<div <?php echo $this->get_render_attribute_string( 'toast_text_color_currency' ); ?>><?php echo esc_html($settings['toast_text_color_currency']);?></div>
<div <?php echo $this->get_render_attribute_string( 'toast_bg_color_currency' ); ?>><?php echo esc_html($settings['toast_bg_color_currency']);?></div>
<div <?php echo $this->get_render_attribute_string( 'currency_style' ); ?>><?php echo esc_html($settings['currency_style']);?></div>
<div <?php echo $this->get_render_attribute_string( 'icon_position_currency' ); ?>><?php echo esc_html($settings['icon_position_currency']);?></div>
<?php

?>

<div <?php echo $this->get_render_attribute_string( 'progress-container_currency' ); ?>>
  <span <?php echo $this->get_render_attribute_string( 'progress-bar-currency' ); ?>></span>
</div>
        <div <?php echo $this->get_render_attribute_string( 'ct-topbar_currency' ); ?>>
            <div <?php echo $this->get_render_attribute_string( 'container_currency' ); ?>>
                <ul <?php echo $this->get_render_attribute_string( 'cttopbarlistcurrency' ); ?>>
                    <?php
					$position='';
					if( $settings['icon_position_currency'] === 'right' )
                    {
if($settings['nav_style_location_currency']==='right')
			{
				$location="left: 0;";
							$position='position: absolute';
			}else if($settings['nav_style_location_currency']==='left')
			{
				$location="right: 0;";
							$position='position: relative';
							//$top='25px;left:30%;';
			}else{
							$location="right: 0px;
    left: 0px;
    text-align: center;";
						}
			
                        ?>
                        <li <?php echo $this->get_render_attribute_string( 'ct-currency' ); ?> style="<?php echo $location?>"><span <?php echo $this->get_render_attribute_string( 'drop_currency' ); ?>><span><?php echo esc_html($settings[ 'currency_text' ]); ?></span>
							<?php \Elementor\Icons_Manager::render_icon( $settings['currency__icon'], [ 'aria-hidden' => 'true' ] ); ?>
							</span>
                        <?php
                    }
                    else
                    {
						if($settings['nav_style_location_currency']==='right')
			{
				$location="left: 0;";
							$position='position: absolute';
			}else if($settings['nav_style_location_currency']==='left')
			{
				$location="right: 0;";
							$position='position: relative';
							//$top='25px;left:30%;';
			}else{
							$location="right: 0px;
    left: 0px;
    text-align: center;";
						}
						$this->add_render_attribute(
							'horizontal',
							[
								'id' => 'mydata_currency',
								'class' => ['list-unstyled_currency', 'ct-currency__dropdown', 'horizontal'],
								'style'=>['display: grid;','float: '.esc_html($settings['nav_style_location_currency']).' !important;',esc_html($position).';'],
								
							
							]
						);
						$this->add_render_attribute(
							'vertical',
							[
								'id' => 'mydata_currency',
								'class' => ['list-unstyled_currency', 'ct-currency__dropdown', 'horizontal'],
								'style'=>['display: grid;','float: '.esc_html($settings['nav_style_location_currency']).' !important;',esc_html($position).';'],
								
							
							]
						);
                        ?>
					<li <?php echo $this->get_render_attribute_string( 'ct-currency' ); ?> style="<?php echo $location?>"><span <?php echo $this->get_render_attribute_string( 'drop_currency' ); ?>><?php \Elementor\Icons_Manager::render_icon( $settings['currency__icon'], [ 'aria-hidden' => 'true' ] ); ?><span> <?php echo esc_html($settings[ 'currency_text' ]); ?> </span></span>
						<?php if($settings['is_search']==='yes'){ ?>
						<input  <?php echo $this->get_render_attribute_string( 'currency_search' ); ?>>
                        <?php
						}
                    }
                        if( $settings['currency_icon_layout'] === 'horizontal' )
                        {
                            ?>
                            <ul <?php echo $this->get_render_attribute_string( 'horizontal' ); ?>  >
                            <?php
                        }
                        else
                        {
                            ?>
                            <ul <?php echo $this->get_render_attribute_string( 'vertical' ); ?>  >
                            <?php
                        }
                        $count=count( $settings[ 'currency_settings' ] );
                        if ( count( $settings[ 'currency_settings' ] ) ) 
                        {
							$i=0;
                        	foreach ( $settings[ 'currency_settings' ] as $items ) 
                        	{
								$repeater_setting__country = $this->get_repeater_setting_key( 'choose_currency', 'currency_settings', $count );
                                    $this->add_inline_editing_attributes( $repeater_setting__country );
								$result[$items['choose_currency']] = array(
									'name' => $items['choose_currency'],
									'rate' => floatval($exchangeRates['rates'][$items['choose_currency']]),
									'symbol' => $items['choose_symbol'],
									'position' => $items['choose_position'],
									'is_etalon' => 0,
									'hide_cents' => 0,
									'hide_on_front' => 0,
									'rate_plus' =>'',
									'decimals' => $items['decimals'],
									'separators' => $items['separators'],
									'description' => $items['currency_description'],
									'flag' => '',
								);
								$this->add_render_attribute(
									'currencylink'.$i,
									[
										'class' => 'translentor_currency_currency_link',
										'href'=> '#',
										'data-currency'=> $items['choose_currency'],
									]
								);  
								$this->add_render_attribute(
									'currencyimg'.$i,
									[
										'class' => 'lang-img',
										'src'=> $items['currency_icon']['url'],
										'alt'=> $items['choose_currency'],
									]
								); 
								echo '<li '.$this->get_render_attribute_string('stilesnavaligncurrency').'>';
                                           
                                        if( $settings['currency_style'] === 'both' )
                                        {
                                            if( $settings['currency_icon_position_currency'] === 'right' )
                                            { 
                                                ?>
                                                <a <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__country ) ); 
												echo $this->get_render_attribute_string('currencylink'.$i);
												?>><?php echo esc_html($items['choose_currency']); ?> 
												<img <?php echo $this->get_render_attribute_string('currencyimg'.$i)?>></a>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <a <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__country ) ); 
												echo $this->get_render_attribute_string('currencylink'.$i);?>>
												<img <?php echo $this->get_render_attribute_string('currencyimg'.$i)?>><?php echo esc_html($items['choose_currency']); ?> </a>
                                                <?php
                                            }
                                        }
                                        elseif( $settings['currency_style'] === 'icon' )
                                        {
                                            ?>
                                            <a <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__country ) ); 
											echo $this->get_render_attribute_string('currencylink'.$i);?>>
											<img <?php echo $this->get_render_attribute_string('currencyimg'.$i)?>></a>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                                <a <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__country ) ); 
												echo $this->get_render_attribute_string('currencylink'.$i);
												?>><?php echo esc_html($items['choose_currency']);?><img <?php echo $this->get_render_attribute_string('currencyimg'.$i)?>></a>
                                            <?php
                                        }
                                        ?>
                                    </li>
															
                                    <?php
									  $i++; 
                        	
                        	}
							update_option('translentor_currency', $result);
                        }
                        ?>
                        
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
<script>
jQuery('.drop_currency').on('click',function(){
        if(jQuery(this).attr('data-click-state') == 1) {
            jQuery(this).attr('data-click-state', 0);
            jQuery(".ct-currency__dropdown").css("overflow", "hidden");
			jQuery(".currency_search").css("display", "none");
          }
        else {
          jQuery(this).attr('data-click-state', 1);
          jQuery(".ct-currency__dropdown").css("overflow", "visible");
		  jQuery(".currency_search").css("display", "block");
        }
      });
</script>
    
        <?php
		echo '<h6 style="color: transparent;background:  transparent;">hide</h6>';
		
    }
	protected function content_template() {
		?>
<?php
	
	}
       


    }




Plugin::instance()->widgets_manager->register_widget_type( new extramentor_wc_currency() );