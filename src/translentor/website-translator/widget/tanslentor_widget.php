<?php

/**
 * SMW Language Translentor.
 *
 * @package SMW
 */

use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;

if(!defined('ABSPATH')) exit;

 if ( ! session_id() && ! headers_sent() ) 
{
 	session_start();
 }

class translentor_elementor_widget extends \Elementor\Widget_Base
{
	
	protected $position;
	
	/**
	 * Static flag to track if Google Translate script has been loaded
	 * Prevents duplicate script loading when multiple widgets are on the same page
	 */
	private static $script_loaded = false;
	
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);
    }
    
    public function get_name()
    {
        return 'translentor-website-translentor';
    }
    
    public function get_title()
    {
        return 'Translentor';
    }
    
    public function get_icon()
    {
        return 'eicon-user-preferences';
    }
    
    public function get_categories()
    {
        return [ 'translentor-category' ];
    }
    
    public function get_style_depends() 
    {
        return [ 
          'translentor-website-translator-css', 
          'translentor-website-translator-toast-css' 
        ];
    }
    
    public function get_script_depends() 
    {
        return [ 
			    'translentor-website-translator-js',
			    'translentor-website-translator-toast-js'
        ];
    }
    
    protected function get_languages()
    {
        return [
            'Afrikaans' => __( 'Afrikaans', translentor_slug ),
            'Albanian' => __( 'Albanian', translentor_slug ),
            'Arabic' => __( 'Arabic', translentor_slug ),
            'Azerbaijani' => __( 'Azerbaijani', translentor_slug ),
            'Bangla' => __( 'Bangla', translentor_slug ),
            'Basque' => __( 'Basque', translentor_slug ),
            'Belarusian' => __( 'Belarusian', translentor_slug ),
            'Bulgarian' => __( 'Bulgarian', translentor_slug ),
            'Catalan' => __( 'Catalan', translentor_slug ),
            'Chinese Simplified' => __( 'Chinese Simplified', translentor_slug ),
            'Chinese Traditional' => __( 'Chinese Traditional', translentor_slug ),
            'Croatian' => __( 'Croatian', translentor_slug ),
            'Czech' => __( 'Czech', translentor_slug ),
            'Danish' => __( 'Danish', translentor_slug ),
            'Dutch' => __( 'Dutch', translentor_slug ),
            'English' => __( 'English', translentor_slug ),
            'Esperanto' => __( 'Esperanto', translentor_slug ),
            'Estonian' => __( 'Estonian', translentor_slug ),
            'Filipino' => __( 'Filipino', translentor_slug ),
            'Finnish' => __( 'Finnish', translentor_slug ),
            'French' => __( 'French', translentor_slug ),
            'Galician' => __( 'Galician', translentor_slug ),
            'Georgian' => __( 'Georgian', translentor_slug ),
            'German' => __( 'German', translentor_slug ),
            'Greek' => __( 'Greek', translentor_slug ),
            'Gujarati' => __( 'Gujarati', translentor_slug ),
            'Haitian Creole' => __( 'Haitian Creole', translentor_slug ),
            'Hebrew' => __( 'Hebrew', translentor_slug ),
            'Hindi' => __( 'Hindi', translentor_slug ),
            'Hungarian' => __( 'Hungarian', translentor_slug ),
            'Icelandic' => __( 'Icelandic', translentor_slug ),
            'Indonesian' => __( 'Indonesian', translentor_slug ),
            'Irish' => __( 'Irish', translentor_slug ),
            'Italian' => __( 'Italian', translentor_slug ),
            'Japanese' => __( 'Japanese', translentor_slug ),
            'Kannada' => __( 'Kannada', translentor_slug ),
            'Korean' => __( 'Korean', translentor_slug ),
            'Latin' => __( 'Latin', translentor_slug ),
            'Latvian' => __( 'Latvian', translentor_slug ),
            'Lithuanian' => __( 'Lithuanian', translentor_slug ),
            'Macedonian' => __( 'Macedonian', translentor_slug ),
            'Malay' => __( 'Malay', translentor_slug ),
            'Maltese' => __( 'Maltese', translentor_slug ),
            'Norwegian' => __( 'Norwegian', translentor_slug ),
            'Persian' => __( 'Persian', translentor_slug ),
            'Polish' => __( 'Polish', translentor_slug ),
            'Portugese' => __( 'Portugese', translentor_slug ),
            'Romanian' => __( 'Romanian', translentor_slug ),
            'Russian' => __( 'Russian', translentor_slug ),
            'Serbian' => __( 'Serbian', translentor_slug ),
            'Slovak' => __( 'Slovak', translentor_slug ),
            'Slovenian' => __( 'Slovenian', translentor_slug ),
            'Spanish' => __( 'Spanish', translentor_slug ),
            'Swahili' => __( 'Swahili', translentor_slug ),
            'Swedish' => __( 'Swedish', translentor_slug ),
            'Tamil' => __( 'Tamil', translentor_slug ),
            'Telugu' => __( 'Telugu', translentor_slug ),
            'Thai' => __( 'Thai', translentor_slug ),
            'Turkish' => __( 'Turkish', translentor_slug ),
            'Ukranian' => __( 'Ukranian', translentor_slug ),
            'Urdu' => __( 'Urdu', translentor_slug ),
            'Vietnamese' => __( 'Vietnamese', translentor_slug ),
            'Welsh' => __( 'Welsh', translentor_slug ),
            'Yiddish' => __( 'Yiddish', translentor_slug )
        ];
    }
    
    protected function register_controls() 
    {
        $this->translentor_icon_or_text();
        
        $this->flags_icon_or_text();
        
        $this->language_section();
        
        $this->register_general_controls();
        
        $this->register_country_style_control();
        
        $this->register_flags_style_control();
        
        $this->register_dropdown_style_control();
		$this->register_processbar_style_control();
		$this->tranlator_nav();
		$this->translentor_toast();
	
		$this->register_dropdown_outer_style_control();
    }
	protected function tranlator_nav()
	{
		$this->start_controls_section(
			'translentor_nav_options',
			array(
				'label' => __( 'Translentor Nav Options', translentor_slug ),
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
				'default' => [
                    'unit' => 'px',
                    'size' => 2,
                ],
				'selectors' => array(
					'{{WRAPPER}} .ct-language__dropdown, {{WRAPPER}} .language_footer' => 'grid-template-columns: repeat({{SIZE}}, 1fr);',
				),
			)
		);
		$this->add_control(
			'nav_style_location',
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
	protected function translentor_toast()
	{
		$this->start_controls_section(
			'translentor_toast',
			array(
				'label' => __( 'Translentor Notification', translentor_slug ),
			)
		);
			$this->add_control(
			'toast_title',
			[
				'label' => esc_html__( 'Title', translentor_slug ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Website title here', translentor_slug ),
			]
		);
			$this->add_control(
			'toast_position',
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
			'toast_transition',
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
			'toast-hide',
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
			'toast_text_color',
			[
				'label' => esc_html__( 'Text Color', translentor_slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
			]
		);
		$this->add_control(
			'toast_bg_color',
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

	
    protected function translentor_icon_or_text()
    {

        $this->start_controls_section(
			'translentor_options',
			array(
				'label' => __( 'Translentor Options', translentor_slug ),
			)
		);
		$this->add_control(
			'is_footer',
			[
				'label' => esc_html__( 'Footer', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', translentor_slug ),
				'label_off' => esc_html__( 'Hide', translentor_slug ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
		$this->add_control(
			'translentor_style',
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
			'icon_position',
			array(
				'label' => __( 'Icon Position', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'left',
				'options' => array(
					'left'  => __( 'Left', translentor_slug ),
					'right' => __( 'Right', translentor_slug ),
				),
				'condition' => array(
                    'translentor_style' => 'both'
                ),
			)
		);
		$this->add_responsive_control(
			'flags_size',
			array(
				'label' => __( 'Icon Spacing', translentor_slug ),
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
					'size' => 0,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 0,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 0,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} span.drop,{{WRAPPER}} span.drop_footer' => 'gap: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
                    'translentor_style' => 'both'
                ),
			),
			
		);
		$this->add_control(
			'translentor_icon_heading',
			array(
				'label' => __( 'Translentor Icon', translentor_slug ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
                    'translentor_style' => 'both'
                ),
			)
		);
		
		$this->add_control(
			'translentor_icon',
			array(
				'label' => __( 'Icon', translentor_slug ),
				'type' => Controls_Manager::ICONS,
				'default' => array(
					'value' => 'fas fa-globe',
					'library' => 'solid',
				),
				'condition' => array(
                    'translentor_style!' => 'text'
                ),
			)
		);
		
		$this->add_responsive_control(
			'translentor_icon_size',
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
					'{{WRAPPER}} .ct-language i,{{WRAPPER}} .drop img,{{WRAPPER}} .drop_footer img' => 'font-size: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
                    'translentor_style!' => 'text'
                ),
			)
		);
		
		$this->add_control(
			'translentor_icon_color',
			[
				'label' => __( 'Icon Colour', translentor_slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
					'default' => '#FFFFFF',
				
				'selectors' => [
					'{{WRAPPER}} .ct-language i' => 'color: {{VALUE}};',
					],
				
			]
		);
			$this->add_control(
			'translentor_text_color',
			[
				'label' => __( 'Text Colour', translentor_slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
					'default' => '#FFFFFF',
				
				'selectors' => [
					'{{WRAPPER}} .text-label' => 'color: {{VALUE}};',
					],
				
			]
		);
		
		$this->add_control(
			'translentor_icon_color_hover',
			[
				'label' => __( 'Icon Colour Hover', translentor_slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
					'default' => '#1F69DE',
				
				'selectors' => [
					'{{WRAPPER}} .ct-language i:hover' => 'color: {{VALUE}};',
					],
				
			]
		);
			$this->add_control(
			'translentor_text_color_hover',
			[
				'label' => __( 'Text Colour Hover', translentor_slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
					'default' => '#1F69DE',
				
				'selectors' => [
					'{{WRAPPER}} .text-label:hover' => 'color: {{VALUE}};',
					],
				
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Css_Filter::get_type(),
			[
				'name' => 'custom_css_filters',
				'selector' => '{{WRAPPER}} .drop img,{{WRAPPER}} .drop_footer img,{{WRAPPER}} .drop i,{{WRAPPER}} .drop_footer i',
			]
		);
		$this->add_responsive_control(
			'translentor_icon_padding',
			array(
				'label'      => __( 'Icon Padding', translentor_slug ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default' => [
					'unit' => 'px',
					'top' => '0',
					'right' => '4',
					'bottom' => '0',
					'left' => '0',
					'isLinked' => true, // Whether the values are linked (e.g., for padding/margin)
				],
				'selectors'  => array(
					'{{WRAPPER}} .ct-language i,{{WRAPPER}} .drop img,{{WRAPPER}} .drop_footer img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition' => array(
                    'translentor_style!' => 'text'
                ),
			)
		);
		

		$this->add_control(
			'translentor_text_heading',
			array(
				'label' => __( 'Translentor Text', translentor_slug ),
				'type' => Controls_Manager::HEADING,
				'default' => 'Translate',
				'separator' => 'before',
				'condition' => array(
                    'translentor_style' => 'both'
                ),
			)
		);
		
		$this->add_control(
			'translentor_text',
			array(
				'label' => __( 'Text', translentor_slug ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Translate', translentor_slug ),
				'placeholder' => __( 'Type your translentor text here', translentor_slug ),
				'condition' => array(
                    'translentor_style!' => 'icon'
                ),
			)
		);
		
		
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name' => 'translentor_text_typography',
				'label' => __( 'Text Typography', translentor_slug ),
				
				'selector' => '{{WRAPPER}} .text-label',
				'default' => [
                    'typography' => 'custom',
                    'font_family' => 'Arial',
                    'font_size' => [
                        'unit' => 'px',
                        'size' => 16,
                    ],
                    'font_weight' => '400',
                    'line_height' => [
                        'unit' => 'em',
                        'size' => 1.5,
                    ],
                    'letter_spacing' => [
                        'unit' => 'px',
                        'size' => 0,
                    ],
                    'text_transform' => 'none',
                    'text_decoration' => 'none',
                ],
				'condition' => array(
                    'translentor_style!' => 'icon'
                ),
			)
		);
	
		
		$this->end_controls_section();
    }
    
	protected function flags_icon_or_text()
    {
        $this->start_controls_section(
			'labguage_options',
			array(
				'label' => __( 'Language Options', translentor_slug ),
			)
		);
		
		$this->add_control(
			'language_style',
			array(
				'label' => __( 'Choose Style', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => array(
					'icon'  => __( 'Icon', translentor_slug ),
					'text' => __( 'Text', translentor_slug ),
					'short' => __( 'ShortText', translentor_slug ),
					'both' => __( 'Icon + Text', translentor_slug ),
					'both_short' => __( 'Icon + ShortText', translentor_slug ),
				),
			)
		);
		
		$this->add_control(
			'language_icon_heading',
			array(
				'label' => __( 'Language Icon', translentor_slug ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
                   'language_style' => [ 'both', 'both_short' ],
                ),
			)
		);
		
		$this->add_control(
			'language_icon_position',
			array(
				'label' => __( 'Icon Position', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'left',
				'options' => array(
					'left'  => __( 'Left', translentor_slug ),
					'right' => __( 'Right', translentor_slug ),
				),
				'condition' => [
                   'language_style' => [ 'both', 'both_short' ],
				],
			)
		);
		
		$this->add_control(
    			'choose_default_language',
    			array(
    			    'label' => __( 'Choose Default Language', translentor_slug ),
    				'type' => Controls_Manager::SELECT2,
    				'options' => $this->get_languages(),
    				'default' => 'English',
    				'label_block' => true,
    			)
    		);
	
		
		$this->end_controls_section();
    }
    
	protected function language_section()
    {
        $this->start_controls_section(
			'section_countries',
			array(
				'label' => __( 'Countries', translentor_slug ),
			)
		);
		
		    $repeater = new Repeater();
    
    		$repeater->add_control(
    			'choose_language',
    			array(
    			    'label' => __( 'Choose Language', translentor_slug ),
    				'type' => Controls_Manager::SELECT2,
    				'options' => $this->get_languages(),
    				'default' => 'English',
    				'label_block' => true,
    			)
    		);
    		
    		$this->add_control(
    			'language_settings',
    			array(
    				'type'        => Controls_Manager::REPEATER,
    				'fields'      =>  $repeater->get_controls() ,
					'item_actions' => [
						'add'       => false,
						'duplicate' => false,
						'remove'    => false,
						'sort'      => true,
					],
    				'default'     => array(
    					array(
    						'choose_language'  => __( 'English', translentor_slug ),
    					),
    					array(
    						'choose_language'  => __( 'Spanish', translentor_slug ),
    					),
						
    					
						
    				
    				),
    				'title_field' => '{{{ choose_language }}}',
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
				'selector'  => '{{WRAPPER}} .ct-language',
			)
		);
		
	
		
		$this->add_responsive_control(
			'section_lt_list_padding',
			array(
				'label'      => __( 'Country Padding', translentor_slug ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				
				'selectors'  => array(
					'{{WRAPPER}} .ct-language__dropdown li,{{WRAPPER}} .language_footer li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .ct-language__dropdown, {{WRAPPER}} .language_footer' => 'top: {{TOP}}{{UNIT}};left: {{LEFT}}{{UNIT}};',
				
				),
			)
		);
          $this->add_responsive_control(
			'section_text_margin',
			array(
				'label'      => __( 'Text Margin', translentor_slug ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default' => [
                    'unit' => 'px',
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '4',
                    'isLinked' => true, // Whether the values are linked (e.g., for padding/margin)
                ],
				'selectors'  => array(
					'{{WRAPPER}} .ct-language span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				
				'default' => '#EDEDED00',
				'selectors' => array(
					
					'{{WRAPPER}} .progress-container, {{WRAPPER}} .progress-container_footer' => 'background-color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'bar_color',
			array(
				'label' => __( 'Colour', translentor_slug ),
				'type' => Controls_Manager::COLOR,
				
				'default' => '#1F5AB7',
				'selectors' => array(
					
					'{{WRAPPER}} .progress-bar,{{WRAPPER}} .progress-bar_footer' => 'background-color: {{VALUE}}',
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
				
				'default' => '#191B2D',
				'selectors' => array(
					
					'{{WRAPPER}} .ct-language__dropdown li, {{WRAPPER}} .language_footer li' => 'background: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'country_background_hover',
			array(
				'label' => __( 'Background Hover Colour', translentor_slug ),
				'type' => Controls_Manager::COLOR,
				
				'default' => '#1F69DE',
				'selectors' => array(
					'{{WRAPPER}} .ct-language__dropdown li:hover ,{{WRAPPER}} .language_footer li:hover' => 'background: {{VALUE}}',
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
		$this->add_control(
			'country_text_width',
			[
				'label' => esc_html__( 'Width', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .ct-language__dropdown li a,{{WRAPPER}} .language_footer li a' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
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
				'default' => '#FFFFFF',
				'selectors' => array(
					'{{WRAPPER}} .ct-language__dropdown .stiles-nav-align .lang-text,{{WRAPPER}} .ct-language__dropdown .stiles-nav-align .lang-short-text, {{WRAPPER}} .language_footer  .stiles-nav-align .lang-text,{{WRAPPER}} .language_footer .stiles-nav-align .lang-short-text' => 'color: {{VALUE}}',
				),
			)
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name' => 'hyperlink_normal_typography',
				'label' => __( 'Typography', translentor_slug ),
				'default' => [
                    'font_family' => 'Ubuntu',
                    'font_weight' => '600',
                ],
				'selector' => '{{WRAPPER}} .ct-language__dropdown .stiles-nav-align .lang-text,{{WRAPPER}} .ct-language__dropdown .stiles-nav-align .lang-short-text, {{WRAPPER}} .language_footer  .stiles-nav-align .lang-text,{{WRAPPER}} .language_footer .stiles-nav-align .lang-short-text',
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
				'default' => '#FFFFFF',
				'selectors' => array(
					'{{WRAPPER}} .ct-language__dropdown .stiles-nav-align .lang-text:hover,{{WRAPPER}} .ct-language__dropdown .stiles-nav-align .lang-short-text:hover, {{WRAPPER}} .language_footer  .stiles-nav-align .lang-text:hover,{{WRAPPER}} .language_footer .stiles-nav-align .lang-short-text:hover' => 'color: {{VALUE}}',
				),
			)
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name' => 'hyperlink_hover_typography',
				'label' => __( 'Typography', translentor_slug ),
				'default' => [
                    'font_family' => 'Ubuntu',
                    'font_weight' => '600',
                ],
				'selector' => '{{WRAPPER}} .ct-language__dropdown .stiles-nav-align .lang-text:hover,{{WRAPPER}} .ct-language__dropdown .stiles-nav-align .lang-short-text:hover, {{WRAPPER}} .language_footer  .stiles-nav-align .lang-text:hover,{{WRAPPER}} .language_footer .stiles-nav-align .lang-short-text:hover',
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
			'country_flags_width',
			array(
				'label' => __( 'Flag Width', translentor_slug ),
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
					'size' => 24,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 20,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 16,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lang-img' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'country_flags_height',
			array(
				'label' => __( 'Flag Height', translentor_slug ),
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
					'size' => 24,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'size' => 20,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 16,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .lang-img' => 'height: {{SIZE}}{{UNIT}};',
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
					'top' => 16,
					'bottom' => 16,
					'left' => 24,
					'right' => 40,
				),
				'selectors'  => array(
					'{{WRAPPER}} .lang-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__( 'Border',translentor_slug),
				'selector' => '{{WRAPPER}} .stiles-nav-align',
			]
		);
		$this->add_responsive_control(
			'dropdown_outer_border_radius',
			[
				'label'      => __( 'Border Redius', translentor_slug ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => [
					'{{WRAPPER}} .stiles-nav-align' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
    }
    protected function register_dropdown_outer_style_control()
	{
		 $this->start_controls_section(
			'section_dropdown_outer_style',
			array(
				'label' => __( 'Label Styling', translentor_slug ),
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
					'{{WRAPPER}} .ct-language' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);
		
		$this->add_responsive_control(
			'dropdown_outer_margin',
			[
				'label'      => __( 'Margins', translentor_slug ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default' => array(
					'unit' => 'px',
					'top' => -4,
					'bottom' => 0,
					'left' => 0,
					'right' => 0,
				),
				'selectors'  => [
					'{{WRAPPER}} .ct-language' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'label' => __( 'DropDown Styling', translentor_slug ),
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
					'top' => 8,
					'bottom' => 8,
					'left' => 0,
					'right' => 4,
				),
				'selectors'  => [
					'{{WRAPPER}} .ct-language__dropdown li, {{WRAPPER}}.language_footer li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'dropdown_list_margin',
			array(
				'label'      => __( 'Margins', translentor_slug ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default' => array(
					'unit' => 'px',
					'top' => 0,
					'bottom' => 0,
					'left' => 0,
					'right' => -4,
				),
				'selectors'  => array(
					'{{WRAPPER}} .ct-language__dropdown li,{{WRAPPER}} .language_footer li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .ct-language__dropdown::before,{{WRAPPER}} .language_footer::before' => 'top: {{BOTTOM}}{{UNIT}};right: {{LEFT}}{{UNIT}};bottom: {{TOp}}{{UNIT}};left: {{RIGHT}}{{UNIT}};',
				),
			)
		);
			$this->add_control(
			'dropdown_dropdown_before_color',
			array(
				'label' => __( 'Before Icon Colour', translentor_slug ),
				'type' => Controls_Manager::COLOR,
				
				'default' => '#1F5AB7',
				'selectors' => array(
					'{{WRAPPER}} .ct-language__dropdown::before, {{WRAPPER}} .language_footer::before' => 'border-bottom-color: {{VALUE}}',
				),
			)
		);
		$this->end_controls_section();
    }
    
    protected function render() 
    {
		$settings = $this->get_settings_for_display();
			$node_id  = $this->get_id();
		$this->add_render_attribute(
			'toast_title',
			[
				'id' => 'toast_title',
				'style' => 'display:none',
			
			]
		);
		$this->add_render_attribute(
			'toast_position',
			[
				'id' => 'toast_position',
				'style' => 'display:none',
			
			]
		);
		$this->add_render_attribute(
			'toast_transition',
			[
				'id' => 'toast_transition',
				'style' => 'display:none',
			
			]
		);
		$this->add_render_attribute(
			'toast_hide',
			[
				'id' => 'toast-hide',
				'style' => 'display:none',
			
			]
		);
		$this->add_render_attribute(
			'toast_text_color',
			[
				'id' => 'toast_text_color',
				'style' => 'display:none',
			
			]
		);
		$this->add_render_attribute(
			'toast_bg_color',
			[
				'id' => 'toast_bg_color',
				'style' => 'display:none',
			
			]
		);
		$this->add_render_attribute(
			'language_style',
			[
				'id' => 'language_style',
				'style' => 'display:none',
			
			]
		);
		$this->add_render_attribute(
			'position',
			[
				'id' => 'position',
				'style' => 'display:none',
			
			]
		);
		$this->add_render_attribute(
			'style_icon',
			[
				'id' => 'style_icon',
				'style' => 'display:none',
			
			]
		);
		$this->add_render_attribute(
			'default_language',
			[
				'id' => 'default_language',
				'style' => 'display:none',
			
			]
		);
		$this->add_render_attribute(
			'default_language_image',
			[
				'id' => 'default_language_image',
				'style' => 'display:none',
			
			]
		);
	
		$this->add_render_attribute( 
			'progress-container_footer',
[
	'class' => [ 'progress-container_footer','fixed-top'],
] );
$this->add_render_attribute( 
	'progress-container',
[
'class' => [ 'progress-container','fixed-top'],
] );
$this->add_render_attribute( 
	'cttopbarlist',
[
'class' => [ 'list-unstyled', 'list-inline', 'ct-topbar__list'],
] );
$this->add_render_attribute( 'progress-bar_footer',[
'class'=>'progress-bar_footer',
'percent'=>'100',
]);
$this->add_render_attribute( 'progress-bar',[
	'class'=>'progress-bar',
	'percent'=>'100',
	]);
$this->add_render_attribute( 'ct-topbar', 'class','ct-topbar');
$this->add_render_attribute( 'container', 'class','container');
$this->add_render_attribute( 'ct-language', 'class','ct-language');
$this->add_render_attribute( 'drop_footer', 'class','drop_footer');
$this->add_render_attribute( 'drop', 'class','drop');
$this->add_render_attribute( 'horizontal_nav', 'class','horizontal_nav');
$this->add_render_attribute( 'menu', 'class','menu');
$this->add_render_attribute( 'stilesnavalign', 'class','stiles-nav-align');
$languagecodes = array (
	'af' => 'Afrikaans',
	'ga' => 'Irish',
	'sq' => 'Albanian',
	'it' => 'Italian',
	'ar' => 'Arabic',
	'ja' => 'Japanese',
	'az' => 'Azerbaijani',
	'kn' => 'Kannada',
	'eu' => 'Basque',
	'ko' => 'Korean',
	'bn' => 'Bangla',
	'la' => 'Latin',
	'be' => 'Belarusian',
	'lv' => 'Latvian',
	'bg' => 'Bulgarian',
	'lt' => 'Lithuanian',
	'ca' => 'Catalan',
	'mk' => 'Macedonian',
	'zh' => 'Chinese Simplified',
	'ms' => 'Malay',
	'zh-TW' => 'Chinese Traditional',
	'mt' => 'Maltese',
	'hr' => 'Croatian',
	'no' => 'Norwegian',
	'cs' => 'Czech',
	'fa' => 'Persian',
	'da' => 'Danish',
	'pl' => 'Polish',
	'nl' => 'Dutch',
	'pt' => 'Portugese',
	'en' => 'English',
	'ro' => 'Romanian',
	'eo' => 'Esperanto',
	'ru' => 'Russian',
	'et' => 'Estonian',
	'sr' => 'Serbian',
	'tl' => 'Filipino',
	'sk' => 'Slovak',
	'fi' => 'Finnish',
	'sl' => 'Slovenian',
	'fr' => 'French',
	'es' => 'Spanish',
	'gl' => 'Galician',
	'sw' => 'Swahili',
	'ka' => 'Georgian',
	'sv' => 'Swedish',
	'de' => 'German',
	'ta' => 'Tamil',
	'el' => 'Greek',
	'te' => 'Telugu',
	'gu' => 'Gujarati',
	'th' => 'Thai',
	'ht' => 'Haitian Creole',
	'tr' => 'Turkish',
	'iw' => 'Hebrew',
	'uk' => 'Ukranian',
	'hi' => 'Hindi',
	'ur' => 'Urdu',
	'hu' => 'Hungarian',
	'vi' => 'Vietnamese',
	'is' => 'Icelandic',
	'cy' => 'Welsh',
	'id' => 'Indonesian',
	'yi' => 'Yiddish'
);

$languagename = array (

	 'Afrikaans'=>     'Afrikaans',
	 'Irish'=>     'Irish',
	 'Albanian'=>     'Albanian',
	 'Italian'=>     'Italian',
	 'Arabic'=>     'Arabic',
	 'Japanese'=>      'Japanese',
	 'Azerbaijani'=>     'Azerbaijani',
	 'Kannada'=>'Kannada',
	 'Basque'=>      'Basque',
	 'Korean'=>       'Korean',
	 'Bangla'=>       'Bangla',
	 'Latin'=>      'Latin',
	 'Belarusian'=>      'Belarusian',
	 'Latvian'=>      'Latvian',
	 'Bulgarian'=>      'Bulgarian',
	 'Lithuanian'=>      'Lithuanian',
	 'Catalan'=>      'Catalan',
	 'Macedonian'=>      'Macedonian',
	  'Chinese Simplified'=>       'Chinese Simplified',
	  'Malay'=>       'Malay',
	   'Chinese Traditional'=>        'Chinese Traditional',
	  'Maltese'=>       'Maltese',
	  'Croatian'=>       'Croatian',
	  'Norwegian'=>       'Norwegian',
	  'Czech'=>       'Czech',
	  'Persian'=>       'Persian',
	  'Danish'=>       'Danish',
	  'Polish'=>       'Polish',
	  'Dutch'=>       'Dutch',
	  'Portugese'=>       'Portugese',
	  'English'=>       'English',
	  'Romanian'=>       'Romanian',
	  'Esperanto'=>       'Esperanto',
	  'Russian'=>       'Russian',
	  'Estonian'=>       'Estonian',
	  'Serbian'=>       'Serbian',
	  'Filipino'=>       'Filipino',
	  'Slovak'=>       'Slovak',
	  'Finnish'=>       'Finnish',
	  'Slovenian'=>       'Slovenian',
	  'French'=>       'French',
	  'Spanish'=>       'Spanish',
	  'Galician'=>       'Galician',
	  'Swahili'=>       'Swahili',
	 'Georgian'=>      'Georgian',
	   'Swedish'=>        'Swedish',
	   'German'=>        'German',
   'Tamil'=>    'Tamil',
		'Greek'=>         'Greek',
	 'Telugu'=>      'Telugu',
	  'Gujarati'=>       'Gujarati',
		  'Thai'=>           'Thai',
		   'Haitian Creole'=>            'Haitian Creole',
		   'Turkish'=>            'Turkish',
			 'Hebrew'=>              'Hebrew',
			'Ukranian'=>             'Ukranian',
		   'Hindi'=>            'Hindi',
			 'Urdu'=>              'Urdu',
			'Hungarian'=>             'Hungarian',
			'Vietnamese'=>             'Vietnamese',
			'Icelandic'=>             'Icelandic',
			'Welsh'=>             'Welsh',
		   'Indonesian'=>            'Indonesian',
		   'Yiddish'=>            'Yiddish'
);

$selected = array();
?>

<div <?php echo $this->get_render_attribute_string( 'toast_title' ); ?>><?php echo esc_html($settings['toast_title']);?></div>
<div <?php echo $this->get_render_attribute_string( 'toast_position' ); ?>><?php echo esc_html($settings['toast_position']);?></div>
<div <?php echo $this->get_render_attribute_string( 'toast_transition' ); ?>><?php echo esc_html($settings['toast_transition']);?></div>
<div <?php echo $this->get_render_attribute_string( 'toast_hide' ); ?>><?php echo esc_html($settings['toast-hide']);?></div>
<div <?php echo $this->get_render_attribute_string( 'toast_text_color' ); ?>><?php echo esc_html($settings['toast_text_color']);?></div>
<div <?php echo $this->get_render_attribute_string( 'toast_bg_color' ); ?>><?php echo esc_html($settings['toast_bg_color']);?></div>
<div <?php echo $this->get_render_attribute_string( 'language_style' ); ?>><?php echo esc_html($settings['language_style']);?></div>

<?php
			if($settings['is_footer']==='yes')
			{?>
<div <?php echo $this->get_render_attribute_string( 'position' ); ?>><?php echo esc_html($settings['icon_position']);?></div>
<div <?php echo $this->get_render_attribute_string( 'style_icon' ); ?>><?php echo esc_html($settings['translentor_style']); ?></div>
<?php
	  $code = $settings["choose_default_language"];
										
										$code = array_search( $code , $languagecodes);
			 $name = array_search( $code , $languagename);
			
	?>
<div <?php echo $this->get_render_attribute_string( 'default_language' ); ?>><?php echo '#googtrans(en|'.$code.')'?></div>
<div <?php echo $this->get_render_attribute_string( 'default_language_image' ); ?>>
    <?php echo plugin_dir_url( __DIR__ ) . 'flags/'.wp_kses_post( $settings["choose_default_language"] ). '.svg';?>
</div>
<div <?php echo $this->get_render_attribute_string( 'progress-container_footer' ); ?>>
    <span <?php echo $this->get_render_attribute_string( 'progress-bar_footer' ); ?>></span>
</div>
<div <?php echo $this->get_render_attribute_string( 'ct-topbar' ); ?>>
    <div <?php echo $this->get_render_attribute_string( 'container' ); ?>>
        <ul <?php echo $this->get_render_attribute_string( 'cttopbarlist' ); ?>>
            <?php if( $settings['icon_position'] === 'right' )
						{
	
	if($settings['nav_style_location']==='right')
				{
					$location="left: 0;";
								$position='position: absolute;';
					$class="t-footer-right-side";
				}else if($settings['nav_style_location']==='left')
				{
					$location="right: 0;";
								$position='position: relative';
								$class="t-footer-left-side";
								//$top='25px;left:30%;';
				}else{
								$location="right: 0px;
		left: 0px;
		text-align: center;";
		$position='position: relative';
		$class="t-footer-center-side";
							}
							$this->add_render_attribute(
								'mydata_footer',
								[
									'id' => 'mydata_footer',
									'class' => ['list-unstyled', 'language_footer', 'vertical'],
									'style'=>['display: grid;','float: '.esc_html($settings['nav_style_location']).' !important;',esc_html($position).';'],
									
								
								]
							);
						
							?>
            <li <?php echo $this->get_render_attribute_string( 'ct-language' ); ?> id="<?php echo $class?>" style="<?php echo $location?>"><span
			<?php echo $this->get_render_attribute_string( 'drop_footer' ); ?> >
			<?php if($settings[ 'translentor_text' ] !='') {?>
			<span class="text-label"><?php echo esc_html($settings[ 'translentor_text' ]); ?></span>
                    <?php } \Elementor\Icons_Manager::render_icon( $settings['translentor_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                </span>
                <?php
						}
						else
						{
							if($settings['nav_style_location']==='right')
				{
					$location="left: 0;";
								$position='position: absolute;';
					$class="t-footer-right-side";
				}else if($settings['nav_style_location']==='left')
				{
					$location="right: 0;";
								$position='position: relative';
								$class="t-footer-left-side";
								//$top='25px;left:30%;';
				}else{
								$location="right: 0px;
		left: 0px;
		text-align: center;";
		$position='position: relative';
		$class="t-footer-center-side";
							}
							$this->add_render_attribute(
								'mydata_footer',
								[
									'id' => 'mydata_footer',
									'class' => ['list-unstyled', 'language_footer', 'vertical'],
									'style'=>['display: grid;','float: '.esc_html($settings['nav_style_location']).' !important;',esc_html($position).';'],
									
								
								]
							);
							?>
            <li <?php echo $this->get_render_attribute_string( 'ct-language' ); ?> id="<?php echo $class ?>" style="<?php echo $location?>"><span
			<?php echo $this->get_render_attribute_string( 'drop_footer' ); ?>><?php \Elementor\Icons_Manager::render_icon( $settings['translentor_icon'], [ 'aria-hidden' => 'true' ] ); ?>
			<?php if($settings[ 'translentor_text' ] !='') {?>
			<span class="text-label">
                        <?php echo esc_html($settings[ 'translentor_text' ]);?> </span>
					<?php }?>
					</span>
                <?php 
						}
							
							
							
								?>
        <ul <?php echo $this->get_render_attribute_string( 'mydata_footer' ); ?>>
            <?php
								$count=count( $settings[ 'language_settings' ] );
								if ( count( $settings[ 'language_settings' ] ) ) 
								{
									$i=0;
									foreach ( $settings[ 'language_settings' ] as $key=>$item ) 
									{
										
										if( ! in_array( $item["choose_language"] , $selected ) )
										{
											//add our item to array so it cant be used again
											array_push($selected , $item["choose_language"] );
												
											$repeater_setting__country = $this->get_repeater_setting_key( 'choose_language', 'language_settings', $count );
											$this->add_inline_editing_attributes( $repeater_setting__country );
													
											$code = $item["choose_language"];
											$name = array_search( $code , $languagename);
											$code = array_search( $code , $languagecodes);
											$this->add_render_attribute(
												'footer_googlelink'.$i,
												[
													'class' => ['lang-es','lang-select_footer'],
													'href'=>'#googtrans(en|'.$code.')',
													'data-lang'=> $code,
												]
											);  
											$this->add_render_attribute(
												'footer_googleimg'.$i,
												[
													'class' => 'lang-img',
													'src'=> plugin_dir_url( __DIR__ ) . 'flags/'.wp_kses_post( $item['choose_language'] ).'.svg',
													'alt'=>esc_html($name),
													'width'=>'24',
													'height'=>'24'
												]
											); 
											
												   
												if( $settings['language_style'] === 'both' )
												{
													if( $settings['language_icon_position'] === 'right' )
													{ 
														echo '<li id="both-right"'.$this->get_render_attribute_string('stilesnavalign').'>';
														?>
                        <a <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__country ) ); 
						 echo $this->get_render_attribute_string('footer_googlelink'.$i);
						?>
                            ><span class="lang-text notranslate"><?php echo esc_html($name); ?></span> <img <?php echo $this->get_render_attribute_string('footer_googleimg'.$i)?>></a></li>
                        <?php
													}
													else
													{
														echo '<li id="both-left"'.$this->get_render_attribute_string('stilesnavalign').'>';
														?>
                        <a <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__country ) ); 
						echo $this->get_render_attribute_string('footer_googlelink'.$i);?>
                           ><img <?php echo $this->get_render_attribute_string('footer_googleimg'.$i)?>><span class="lang-text notranslate"><?php echo esc_html($name); ?></span> </a></li>
                        <?php
													}
												}
												elseif( $settings['language_style'] === 'both_short' )
												{
													if( $settings['language_icon_position'] === 'right' )
													{ 
														echo '<li id="both_short-right"'.$this->get_render_attribute_string('stilesnavalign').'>';
														?>
                        <a <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__country ) ); 
						echo $this->get_render_attribute_string('footer_googlelink'.$i);?>
                            ><span class="lang-short-text notranslate"><?php echo strtoupper($code); ?></span> <img <?php echo $this->get_render_attribute_string('footer_googleimg'.$i)?>></a></li>
                        <?php
													}
													else
													{
														echo '<li id="both_short-left"'.$this->get_render_attribute_string('stilesnavalign').'>';
														?>
                        <a <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__country ) ); 
						echo $this->get_render_attribute_string('footer_googlelink'.$i);
						?>
                            ><img <?php echo $this->get_render_attribute_string('footer_googleimg'.$i)?>><span class="lang-short-text notranslate"><?php echo strtoupper($code); ?></span>  </a></li>
                        <?php
													}
												}
												elseif( $settings['language_style'] === 'icon' )
												{
													echo '<li id="icon-only"'.$this->get_render_attribute_string('stilesnavalign').'>';
													?>
                        <a <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__country ) ); 
						echo $this->get_render_attribute_string('footer_googlelink'.$i);
						?>
                            ><img <?php echo $this->get_render_attribute_string('footer_googleimg'.$i)?>></a></li>
                        <?php
												}
												elseif( $settings['language_style'] === 'short' )
												{
													echo '<li id="short-only"'.$this->get_render_attribute_string('stilesnavalign').'>';
													?>
                        <a <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__country ) ); 
						echo $this->get_render_attribute_string('footer_googlelink'.$i);
						?>
                            ><span class="lang-short-text notranslate"><?php echo strtoupper($code); ?></span> <img style="display:none"
							<?php echo $this->get_render_attribute_string('footer_googleimg'.$i)?>></a></li>
                        <?php
												}
												else
												{
													echo '<li id="full-text"'.$this->get_render_attribute_string('stilesnavalign').'>';
													?>
                        <a <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__country ) );
						echo $this->get_render_attribute_string('footer_googlelink'.$i);
						?>
                            ><span class="lang-text notranslate"><?php echo esc_html($name); ?></span><img style="display:none"
							<?php echo $this->get_render_attribute_string('footer_googleimg'.$i)?>></a></li>
                        <?php
												}
												?>
            

            <?php
										   }
										  
									   
										   $i++;   
									   
							   }
							  
						
								}
								?>
        </ul>
        <?php
							

							
							?>


        </li>
        </ul>
    </div>
</div>
<?php
// Only load Google Translate script once per page (prevent duplicate loading when multiple widgets exist)
if (!self::$script_loaded) {
    self::$script_loaded = true;
?>
<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script>
function googleTranslateElementInit() {

    new google.translate.TranslateElement({
        layout: google.translate.TranslateElement.FloatPosition.TOP_LEFT
    }, "google_translate_element");
    var n = window.location.toString();
    if (n.indexOf("#") > 0) {
        var a = n.substring(0, n.indexOf("#"));
        window.history.replaceState({}, document.title, a);
    }
    console.log('Init');
}
</script>
<?php
}
?>
<script>
jQuery('.drop_footer').on('click', function() {
    if (jQuery(this).attr('data-click-state') == 1) {
        jQuery(this).attr('data-click-state', 0);
        jQuery(".language_footer").css("overflow", "hidden");

    } else {
        jQuery(this).attr('data-click-state', 1);
        jQuery(".language_footer").css("overflow", "visible");

    }
});
</script>

<?php
			echo '<h6 style="color: transparent;background:  transparent;display:none;">hide</h6>';
			}else{
			?>

<div <?php echo $this->get_render_attribute_string( 'position' ); ?>><?php echo esc_html($settings['icon_position']);?></div>
<div <?php echo $this->get_render_attribute_string( 'style_icon' ); ?>><?php echo esc_html($settings['translentor_style']); ?></div>
<?php
	  $code = $settings["choose_default_language"];
										
										$code = array_search( $code , $languagecodes);
				$name = array_search( $code , $languagename);

	?>
<div <?php echo $this->get_render_attribute_string( 'default_language' ); ?>><?php echo '#googtrans(en|'.$code.')'?></div>
<div <?php echo $this->get_render_attribute_string( 'default_language_image' ); ?>>
    <?php echo plugin_dir_url( __DIR__ ) . 'flags/'.wp_kses_post( $settings["choose_default_language"] ). '.svg';?>
</div>
<div <?php echo $this->get_render_attribute_string( 'progress-container' ); ?>>
    <span <?php echo $this->get_render_attribute_string( 'progress-bar' ); ?>></span>
</div>
<div <?php echo $this->get_render_attribute_string( 'ct-topbar' ); ?>>
    <div <?php echo $this->get_render_attribute_string( 'container' ); ?>>
        <ul <?php echo $this->get_render_attribute_string( 'cttopbarlist' ); ?>>
            <?php if( $settings['icon_position'] === 'right' )
						{
	
							if($settings['nav_style_location']==='right')
							{
								$location="left: 0;";
											$position='position: absolute;';
								$class="t-right-side";
							}else if($settings['nav_style_location']==='left')
							{
								$location="right: 0;";
											$position='position: relative';
											$class="t-left-side";
											//$top='25px;left:30%;';
							}else{
											$location="right: 0px;
					left: 0px;
					text-align: center;";
					$position='position: relative';
					$class="t-center-side";
										}
							$this->add_render_attribute(
								'mydata',
								[
									'id' => 'mydata',
									'class' => ['list-unstyled', 'ct-language__dropdown', 'vertical'],
									'style'=>['display: grid;','float: '.esc_html($settings['nav_style_location']).' !important;',esc_html($position).';'],
									
								
								]
							);
							?>
            <li <?php echo $this->get_render_attribute_string( 'ct-language' ); ?> id="<?php echo $class ?>" style="<?php echo $location?>"><span
			<?php echo $this->get_render_attribute_string( 'drop' ); ?>>
			<?php if($settings[ 'translentor_text' ] !='') {?>
			<span class="text-label"><?php echo esc_html($settings[ 'translentor_text' ]); ?></span>
                    <?php } \Elementor\Icons_Manager::render_icon( $settings['translentor_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                </span>
                <?php
						}
						else
						{
							if($settings['nav_style_location']==='right')
				{
					$location="left: 0;";
								$position='position: absolute;';
					$class="t-right-side";
				}else if($settings['nav_style_location']==='left')
				{
					$location="right: 0;";
								$position='position: relative';
								$class="t-left-side";
								//$top='25px;left:30%;';
				}else{
								$location="right: 0px;
		left: 0px;
		text-align: center;";
		$position='position: relative';
		$class="t-center-side";
							}
							$this->add_render_attribute(
								'mydata',
								[
									'id' => 'mydata',
									'class' => ['list-unstyled', 'ct-language__dropdown', 'vertical'],
									'style'=>['display: grid;','float: '.esc_html($settings['nav_style_location']).' !important;',esc_html($position).';'],
									
								
								]
							);
							?>
            <li <?php echo $this->get_render_attribute_string( 'ct-language' ); ?> id="<?php echo $class ?>" style="<?php echo $location?>"><span
			<?php echo $this->get_render_attribute_string( 'drop' ); ?>><?php \Elementor\Icons_Manager::render_icon( $settings['translentor_icon'], [ 'aria-hidden' => 'true' ] ); ?>
			<?php if($settings[ 'translentor_text' ] !='') {?>
			<span class="text-label">
                        <?php echo esc_html($settings[ 'translentor_text' ]); ?> </span><?php }?></span>
                <?php 
						}
							
							
								?>
        <ul <?php echo $this->get_render_attribute_string( 'mydata' ); ?>>
            <?php
						$count=count( $settings[ 'language_settings' ] );
						if ( count( $settings[ 'language_settings' ] ) ) 
								{
									$i=0;
									foreach ( $settings[ 'language_settings' ] as $key=>$item ) 
									{
										
										if( ! in_array( $item["choose_language"] , $selected ) )
										{
											//add our item to array so it cant be used again
											array_push($selected , $item["choose_language"] );
												
											$repeater_setting__country = $this->get_repeater_setting_key( 'choose_language', 'language_settings', $count );
											$this->add_inline_editing_attributes( $repeater_setting__country );
													
											$code = $item["choose_language"];
											$name = array_search( $code , $languagename);
											$code = array_search( $code , $languagecodes);
											$this->add_render_attribute(
												'googlelink'.$i,
												[
													'class' => ['lang-es','lang-select'],
													'href'=>'#googtrans(en|'.$code.')',
													'data-lang'=> $code,
												]
											);  
											$this->add_render_attribute(
												'googleimg'.$i,
												[
													'class' => 'lang-img',
													'src'=> plugin_dir_url( __DIR__ ) . 'flags/'.wp_kses_post( $item['choose_language'] ).'.svg',
													'alt'=>esc_html($name),
													'width'=>'24',
													'height'=>'24'
												]
											); 
										
												   
												if( $settings['language_style'] === 'both' )
												{
													if( $settings['language_icon_position'] === 'right' )
													{ 
														echo '<li id="both-right"'.$this->get_render_attribute_string('stilesnavalign').'>';
														?>
                        <a <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__country ) ); 
						 echo $this->get_render_attribute_string('googlelink'.$i);
						?>
                            ><span class="lang-text notranslate"><?php echo esc_html($name); ?></span> <img <?php echo $this->get_render_attribute_string('googleimg'.$i)?>></a></li>
                        <?php
													}
													else
													{
														echo '<li id="both-left"'.$this->get_render_attribute_string('stilesnavalign').'>';
														?>
                        <a <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__country ) ); 
						echo $this->get_render_attribute_string('googlelink'.$i);?>
                           ><img <?php echo $this->get_render_attribute_string('googleimg'.$i)?>><span class="lang-text notranslate"><?php echo esc_html($name); ?></span> </a></li>
                        <?php
													}
												}
												elseif( $settings['language_style'] === 'both_short' )
												{
													if( $settings['language_icon_position'] === 'right' )
													{ 
														echo '<li id="both_short-right"'.$this->get_render_attribute_string('stilesnavalign').'>';
														?>
                        <a <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__country ) ); 
						echo $this->get_render_attribute_string('googlelink'.$i);?>
                            ><span class="lang-short-text notranslate"><?php echo strtoupper($code); ?></span> <img <?php echo $this->get_render_attribute_string('googleimg'.$i)?>></a></li>
                        <?php
													}
													else
													{
														echo '<li id="both_short-left"'.$this->get_render_attribute_string('stilesnavalign').'>';
														?>
                        <a <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__country ) ); 
						echo $this->get_render_attribute_string('googlelink'.$i);
						?>
                            ><img <?php echo $this->get_render_attribute_string('googleimg'.$i)?>><span class="lang-short-text notranslate"><?php echo strtoupper($code); ?></span> </a></li>
                        <?php
													}
												}
												elseif( $settings['language_style'] === 'icon' )
												{
													echo '<li id="icon-only"'.$this->get_render_attribute_string('stilesnavalign').'>';
													?>
                        <a <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__country ) ); 
						echo $this->get_render_attribute_string('googlelink'.$i);
						?>
                            ><img <?php echo $this->get_render_attribute_string('googleimg'.$i)?>></a></li>
                        <?php
												}
												elseif( $settings['language_style'] === 'short' )
												{
													echo '<li id="short-only"'.$this->get_render_attribute_string('stilesnavalign').'>';
													?>
                        <a <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__country ) ); 
						echo $this->get_render_attribute_string('googlelink'.$i);
						?>
                            ><span class="lang-short-text notranslate"><?php echo strtoupper($code); ?></span><img style="display:none"
							<?php echo $this->get_render_attribute_string('googleimg'.$i)?>></a></li>
                        <?php
												}
												else
												{
													echo '<li id="full-text"'.$this->get_render_attribute_string('stilesnavalign').'>';
													?>
                        <a <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__country ) );
						echo $this->get_render_attribute_string('googlelink'.$i);
						?>
                            ><span class="lang-text notranslate"><?php echo esc_html($name); ?></span><img style="display:none"
							<?php echo $this->get_render_attribute_string('googleimg'.$i)?>></a></li>
                        <?php
												}
												?>

            <?php
										   }
										   
									   
										   $i++;   
									   
							   }
							  
							  
								}
						?>
        </ul>
        <?php
							
							
							?>


        </li>
        </ul>
    </div>
</div>
<?php
// Only load Google Translate script once per page (prevent duplicate loading when multiple widgets exist)
if (!self::$script_loaded) {
    self::$script_loaded = true;
?>
<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script>
function googleTranslateElementInit() {

    new google.translate.TranslateElement({
        layout: google.translate.TranslateElement.FloatPosition.TOP_LEFT
    }, "google_translate_element");
    var n = window.location.toString();
    if (n.indexOf("#") > 0) {
        var a = n.substring(0, n.indexOf("#"));
        window.history.replaceState({}, document.title, a);
    }
    console.log('Init');
}
</script>
<?php
}
?>
<script>
jQuery('.drop').on('click', function() {
    if (jQuery(this).attr('data-click-state') == 1) {
        jQuery(this).attr('data-click-state', 0);
        jQuery(".ct-language__dropdown").css("overflow", "hidden");

    } else {
        jQuery(this).attr('data-click-state', 1);
        jQuery(".ct-language__dropdown").css("overflow", "visible");

    }
});
</script>

<?php
			echo '<h6 style="color: transparent;background:  transparent; display:none;">hide</h6>';
			}
    }
	protected function content_template() {
		?>
<?php
	
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new translentor_elementor_widget() );