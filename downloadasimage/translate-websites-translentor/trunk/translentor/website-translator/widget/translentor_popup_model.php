<?php

/**
 * SMW Language Translator.
 *
 * @package SMW
 */


// Elementor Classes.
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

class translentor_pop_model extends \Elementor\Widget_Base
{
	protected $elementor_setting;
	protected $position;
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);
		wp_register_style( 'translentor-website-translator-css', translentor_URL .  'translentor/assets/css/translentor-css.min.css');
        wp_register_style( 'translentor-website-translator-toast-css', translentor_URL .  'translentor/assets/css/jquery.toast.min.css');
	
		wp_register_script( 'translentor-website-translator-js', translentor_URL .  'translentor/assets/js/translentor-js.min.js');
        wp_register_script( 'translentor-website-translator-toast-js', translentor_URL .  'translentor/assets/js/jquery.toast.min.js');
		wp_register_style( 'translentor_popup_model-css', translentor_URL . 'translentor/assets/css/translentor-translentor-model.min.css',
		array(),
		translentor_VERSION );
		
    }
    
    public function get_name()
    {
        return 'translentor_popup_model';
    }
    
    public function get_title()
    {
        return 'Translentor Popup';
    }
    
    public function get_icon()
    {
        return 'eicon-user-preferences';
    }
    
    public function get_categories()
    {
        return [ 'translentor-category' ];
        //return [ 'general' ];
    }
    
	public function get_style_depends() 
    {
        return [ 'translentor-website-translator-css','translentor-website-translator-toast-css','translentor_popup_model-css'];
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
        $this->translator_icon_or_text();
        
        $this->flags_icon_or_text();
        
        $this->language_section();
        
        $this->register_general_controls();
        
        $this->register_country_style_control();
        
        $this->register_flags_style_control();
        
        $this->register_dropdown_style_control();
		$this->register_processbar_style_control();
		$this->tranlator_nav();
		$this->translator_toast();
		$this->ip_detection();
		$this->register_dropdown_outer_style_control();
    }
    protected function tranlator_nav()
	{
		$this->start_controls_section(
			'translator_nav_options',
			array(
				'label' => __( 'Translator Nav Options', translentor_slug ),
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
					'{{WRAPPER}} .ct-language__model, {{WRAPPER}} .language_footer,{{WRAPPER}} .menu' => 'grid-template-columns: repeat({{SIZE}}, 1fr);',
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
	protected function translator_toast()
	{
		$this->start_controls_section(
			'translator_toast',
			array(
				'label' => __( 'Translator Notification', translentor_slug ),
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

    protected function translator_icon_or_text()
    {

        $this->start_controls_section(
			'translator_options',
			array(
				'label' => __( 'Translator Options', translentor_slug ),
			)
		);
		$this->add_control(
			'translator_style',
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
                    'translator_style' => 'both'
                ),
			)
		);
		
		$this->add_control(
			'translator_icon_heading',
			array(
				'label' => __( 'Translator Icon', translentor_slug ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
                    'translator_style' => 'both'
                ),
			)
		);
		
		$this->add_control(
			'translator_icon',
			array(
				'label' => __( 'Icon', translentor_slug ),
				'type' => Controls_Manager::ICONS,
				'default' => array(
					'value' => 'fas fa-globe',
					'library' => 'solid',
				),
				'condition' => array(
                    'translator_style!' => 'text'
                ),
			)
		);
		
		$this->add_responsive_control(
			'translator_icon_size',
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
                    'translator_style!' => 'text'
                ),
			)
		);
		
		$this->add_control(
			'translator_icon_color',
			[
				'label' => __( 'Icon Colour', translentor_slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
					'default' => '#F81414',
				
				'selectors' => [
					'{{WRAPPER}} .ct-language i' => 'color: {{VALUE}};',
					],
				
			]
		);
			$this->add_control(
			'translator_text_color',
			[
				'label' => __( 'Text Colour', translentor_slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
					'default' => '#F81414',
				
				'selectors' => [
					'{{WRAPPER}} .ct-language span' => 'color: {{VALUE}};',
					],
				
			]
		);
		
		$this->add_control(
			'translator_icon_color_hover',
			[
				'label' => __( 'Icon Colour Hover', translentor_slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
					'default' => '#F81414',
				
				'selectors' => [
					'{{WRAPPER}} .ct-language i:hover' => 'color: {{VALUE}};',
					],
				
			]
		);
			$this->add_control(
			'translator_text_color_hover',
			[
				'label' => __( 'Text Colour Hover', translentor_slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				
					'default' => '#F81414',
				
				'selectors' => [
					'{{WRAPPER}} .ct-language span:hover' => 'color: {{VALUE}};',
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
			'translator_icon_padding',
			array(
				'label'      => __( 'Icon Padding', translentor_slug ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ct-language i,{{WRAPPER}} .drop img,{{WRAPPER}} .drop_footer img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition' => array(
                    'translator_style!' => 'text'
                ),
			)
		);
		

		$this->add_control(
			'translator_text_heading',
			array(
				'label' => __( 'Translator Text', translentor_slug ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
                    'translator_style' => 'both'
                ),
			)
		);
		
		$this->add_control(
			'translator_text',
			array(
				'label' => __( 'Text', translentor_slug ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Translate', translentor_slug ),
				'placeholder' => __( 'Type your translator text here', translentor_slug ),
				'condition' => array(
                    'translator_style!' => 'icon'
                ),
			)
		);
		
		
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name' => 'translator_text_typography',
				'label' => __( 'Text Typography', translentor_slug ),
				
				'selector' => '{{WRAPPER}} .ct-language span',
				'condition' => array(
                    'translator_style!' => 'icon'
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
				'default' => 'both',
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
                    'language_style' => 'both',
					'language_style' => 'both_short'
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
				'condition' => array(
                    'language_style' => 'both',
					'language_style' => 'both_short'
                ),
			)
		);
		
		$this->add_control(
			'language_icon_layout',
			array(
				'label' => __( 'Icon Layout', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => array(
					'horizontal'  => __( 'Horizontal', translentor_slug ),
					'vertical' => __( 'Vertical', translentor_slug ),
				),
				
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
					'{{WRAPPER}} .ct-language__model li,{{WRAPPER}} .language_footer li,{{WRAPPER}} .menu li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .ct-language__model, {{WRAPPER}} .language_footer,{{WRAPPER}} .menu ' => 'top: {{TOP}}{{UNIT}};left: {{LEFT}}{{UNIT}};',
				
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
				
				'default' => '#ededed',
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
				
				'default' => '#ededed',
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
				
				'default' => '#ededed',
				'selectors' => array(
					
					'{{WRAPPER}} .ct-language__model li, {{WRAPPER}} .language_footer li,{{WRAPPER}} .menu li' => 'background: {{VALUE}}',
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
					'{{WRAPPER}} .ct-language__model li:hover ,{{WRAPPER}} .language_footer li:hover,{{WRAPPER}} .menu li:hover' => 'background: {{VALUE}}',
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
					'{{WRAPPER}} .menu li' => 'width: {{SIZE}}{{UNIT}};',
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
				
				'selectors' => array(
					'{{WRAPPER}} .ct-language__model a,{{WRAPPER}} .language_footer a,{{WRAPPER}} .menu a' => 'color: {{VALUE}}',
				),
			)
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name' => 'hyperlink_normal_typography',
				'label' => __( 'Typography', translentor_slug ),
				
				'selector' => '{{WRAPPER}} .ct-language__model a,{{WRAPPER}} .language_footer a,{{WRAPPER}} .menu a',
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
					'{{WRAPPER}} .ct-language__model a:hover, {{WRAPPER}} .language_footer a:hover,{{WRAPPER}} .menu a:hover' => 'color: {{VALUE}}',
				),
			)
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name' => 'hyperlink_hover_typography',
				'label' => __( 'Typography', translentor_slug ),
				
				'selector' => '{{WRAPPER}} .ct-language__model a:hover,{{WRAPPER}} .language_footer a:hover,{{WRAPPER}} .menu a:hover',
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
					'{{WRAPPER}} .lang-img' => 'width: {{SIZE}}{{UNIT}};',
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
				'selectors'  => [
					'{{WRAPPER}} .ct-language' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
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
    protected function register_dropdown_style_control()
    {
        $this->start_controls_section(
			'section_dropdown_style',
			array(
				'label' => __( 'Language Selectors', translentor_slug ),
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
					'{{WRAPPER}} .ct-language__model li, {{WRAPPER}}.language_footer li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .ct-language__model li,{{WRAPPER}} .language_footer li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .ct-language__model::before,{{WRAPPER}} .language_footer::before' => 'top: {{BOTTOM}}{{UNIT}};right: {{LEFT}}{{UNIT}};bottom: {{TOp}}{{UNIT}};left: {{RIGHT}}{{UNIT}};',
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
					'{{WRAPPER}} .ct-language__model::before, {{WRAPPER}} .language_footer::before' => 'border-bottom-color: {{VALUE}}',
				),
			)
		);
		$this->end_controls_section();
    }
	protected function ip_detection()
	{
		$this->start_controls_section(
			'translator_ip_detection',
			array(
				'label' => __( 'Translator IP Detection', translentor_slug ),
			)
		);
		$this->add_control(
			'ip_detection_enabled',
			[
				'label' => esc_html__( 'IP Detection', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', translentor_slug ),
				'label_off' => esc_html__( 'Hide', translentor_slug ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
		$this->add_control(
			'detection_method',
			array(
				'label' => __( 'Detection Method', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'browser-ip',
				'options' => array(
			'browser-ip'    => __( 'First by browser language, then IP address', translentor_slug),
			'ip-browser'    => __( 'First by IP address, then by browser language', translentor_slug),
			'browser'       => __( 'Only by browser language', translentor_slug),
			'ip'            => __( 'Only by IP address', translentor_slug),
				),
				'condition' => array(
                    'ip_detection_enabled' => 'yes'
                ),
			)
		);
		$this->add_control(
			'popup_option',
			array(
				'label' => __( 'Popup Option', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'popup',
				'options' => array(
					'popup'    => esc_html__( 'A popup appears asking the user if they want to be redirected', translentor_slug),
					'no_popup'    => esc_html__( 'Redirect directly (*not recommended)', translentor_slug),
				),
				'condition' => array(
                    'ip_detection_enabled' => 'yes'
                ),
			)
		);
		$this->add_control(
			'popup_type',
			array(
				'label' => __( 'Popup Type', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'normal_popup',
				'options' => array(
					'normal_popup' => esc_html__('Pop-up window over the content', translentor_slug),
                    
				),
				'condition' => array(
					'ip_detection_enabled' => 'yes'
                ),
			)
		);
		$this->add_control(
			'popup_textarea',
			array(
				'label' => esc_html__( 'Description', translentor_slug ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => esc_html__( 'We\'ve detected you might be speaking a different language. Do you want to change to:', translentor_slug ),
				'placeholder' => esc_html__( 'Type your description here', translentor_slug ),
				'condition' => array(
					'ip_detection_enabled' => 'yes'
                ),
			)
			);
			$this->add_control(
				'popup_textarea_button',
				array(
					'label' => esc_html__( 'Button Title', translentor_slug ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Change Language', translentor_slug ),
					'placeholder' => esc_html__( 'Type your title here', translentor_slug ),
					'condition' => array(
						'ip_detection_enabled' => 'yes'
					),
				)
			);
			$this->add_control(
				'popup_textarea_close_button',
				array(
					'label' => esc_html__( 'Close', translentor_slug ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Close and do not switch language', translentor_slug ),
					'placeholder' => esc_html__( 'Type your title here', translentor_slug ),
					'condition' => array(
						'ip_detection_enabled' => 'yes'
					),
				)
			);
		$this->end_controls_section();
	} 
    protected function render() 
    {
		$settings = $this->get_settings_for_display();
			$node_id  = $this->get_id();
			
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
			$this->add_render_attribute( 'drop', 'class','drop');
			$this->add_render_attribute( 'ebcf_modal-content', 'class','ebcf_modal-content');
			$this->add_render_attribute( 'ebcf_close', 'class','ebcf_close');
			$this->add_render_attribute( 'countryselector', ['class'=>['country-selector', 'list-unstyled','ct-language__model', 'vertical'],'style'=>'display: grid;',]);
             $this->add_render_attribute( 'stilesnavalign', 'class','stiles-nav-align');
			 $this->add_render_attribute(
				'mySizeChart',
				[
					'id' => 'mySizeChart',
					'href' => '#',
				]
			);	
			$this->add_render_attribute(
				'ebcf_modal',
				[
					'class' => 'ebcf_modal',
					'id' => 'mySizeChartModal',
				]
			);	
		?>
		
    
        <a <?php echo $this->get_render_attribute_string( 'mySizeChart' ); ?>><span
		<?php echo $this->get_render_attribute_string( 'drop' ); ?>><span><?php echo esc_html($settings[ 'translator_text' ]); ?></span>
                    <?php \Elementor\Icons_Manager::render_icon( $settings['translator_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                </span></a>


<div <?php echo $this->get_render_attribute_string( 'ebcf_modal' ); ?>>

  <div <?php echo $this->get_render_attribute_string( 'ebcf_modal-content' ); ?>>
    <span <?php echo $this->get_render_attribute_string( 'ebcf_close' ); ?>>&times;</span>
	<ul <?php echo $this->get_render_attribute_string('countryselector');?>>
             <?php
$code = $settings["choose_default_language"];										
$code = array_search( $code , $languagecodes);
$name = array_search( $code , $languagename);
$elementor_setting['translentor-default-language']=$code;
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
				  'href'=>'#googtrans(en|'.esc_html($code).')',
				  'data-lang'=>esc_html($code),
			  ]
		  );  
		  $this->add_render_attribute(
			  'googleimg'.$i,
			  [
				  'class' => 'lang-img',
				  'src'=> plugin_dir_url( __DIR__ ) . 'flags/'.wp_kses_post( $item['choose_language'] ).'.svg',
				  'alt'=>esc_html($name),
			  ]
		  ); 

			echo '<li '.$this->get_render_attribute_string('stilesnavalign').'>';
				   
				if( $settings['language_style'] === 'both' )
				{
					if( $settings['language_icon_position'] === 'right' )
					{ 
						?>
<a <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__country ) ); 
echo $this->get_render_attribute_string('googlelink'.$i); 
?>><?php echo esc_html($name); ?> <img <?php echo $this->get_render_attribute_string('googleimg'.$i) ?>></a>
<?php
					}
					else
					{
						?>
<a <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__country ) );echo $this->get_render_attribute_string('googlelink'.$i) ?>
><img <?php echo $this->get_render_attribute_string('googleimg'.$i) ?>><?php echo esc_html($name); ?> </a>
<?php
					}
				}
				elseif( $settings['language_style'] === 'both_short' )
				{
					if( $settings['language_icon_position'] === 'right' )
					{ 
						?>
<a <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__country ) ); echo $this->get_render_attribute_string('googlelink'.$i)?>
><?php echo strtoupper($code); ?> <img <?php echo $this->get_render_attribute_string('googleimg'.$i) ?>></a>
<?php
					}
					else
					{
						?>
<a <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__country ) );echo $this->get_render_attribute_string('googlelink'.$i) ?>
><img <?php echo $this->get_render_attribute_string('googleimg'.$i) ?>><?php echo strtoupper($code);?> </a>
<?php
					}
				}
				elseif( $settings['language_style'] === 'icon' )
				{
					?>
<a <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__country ) );echo $this->get_render_attribute_string('googlelink'.$i) ?>
><img <?php echo $this->get_render_attribute_string('googleimg'.$i) ?>></a>
<?php
				}
				elseif( $settings['language_style'] === 'short' )
				{
					?>
<a <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__country ) ); echo $this->get_render_attribute_string('googlelink'.$i) ?>
><?php echo strtoupper($code); ?></a>
<?php
				}
				else
				{
					?>
<a <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__country ) ); echo $this->get_render_attribute_string('googlelink'.$i) ?>
><?php echo esc_html($name); ?></a>
<?php
				}
				?>
</li>

<?php
		   }
		   $elementor_setting['translentor_lang'][$key]=$code;
		   $elementor_setting['translentor_publish-lang'][$key]=$code;
		   if ( empty ( $elementor_setting['translentor-lang-slugs'][$code] ) ){
			   $elementor_setting['translentor-lang-slugs'][$code] = $code;
		   }else{
			   $elementor_setting['translentor-lang-slugs'][$code] = sanitize_title( strtolower( $elementor_setting['translentor-lang-slugs'][$code] )) ;
		   }
		   $elementor_setting['translentor-lang-parameter'][ $code ] = 'informal';
	   
   $i++;
	   
}

}

			  ?>
			</ul>
  </div>

</div>

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

   <script>
	// Get the modal
var ebModal = document.getElementById('mySizeChartModal');

// Get the button that opens the modal
var ebBtn = document.getElementById("mySizeChart");

// Get the <span> element that closes the modal
var ebSpan = document.getElementsByClassName("ebcf_close")[0];

// When the user clicks the button, open the modal 
ebBtn.onclick = function() {
    ebModal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
ebSpan.onclick = function() {
    ebModal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == ebModal) {
        ebModal.style.display = "none";
    }
}
   </script>

        <!-- Body of the sheet -->
		

		<?php		

    }
	protected function content_template() {
		?>
<?php
	
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new translentor_pop_model() );