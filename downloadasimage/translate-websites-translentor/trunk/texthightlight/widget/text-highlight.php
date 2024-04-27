<?php
/**
 * translentor Icon.
 *
 * @package translentor
 */

// Elementor Classes.
use Elementor\Icons_Manager;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Utils;
use Elementor\Plugin;

if(!defined('ABSPATH')) exit;

if ( ! session_id() && ! headers_sent() ) 
{
	session_start();
}
class text_highlight extends Widget_Base{
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);

    }
    
    public function get_name()
    {
        return 'text-highlight';
    }
    
    public function get_title()
    {
        return 'Text Highlight';
    }
    
    public function get_icon()
    {
        return 'eicon-heading';
    }
    
    public function get_categories()
    {
        return [ 'translentor-category' ];
    }
    
    protected function register_controls() 
    {
		$this->start_controls_section(
			'section_highlighted_text',
			[
				'label' => esc_html__( 'Text', translentor_slug ),
			]
		);
		$this->add_control(
			'text',
			[
				'label' => esc_html__( 'Text', translentor_slug ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => esc_html__( 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.', translentor_slug ),
				'placeholder' => esc_html__( 'Type your text here', translentor_slug ),
			]
		);
		$this->add_control(
			'highlight_position',
			[
				'label' => esc_html__( 'Highlight Text Position', translentor_slug ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '1-3,8-10', translentor_slug ),
				'placeholder' => esc_html__( 'Type your title here', translentor_slug ),
				'description'   => esc_html__( 'If you would like to wrap from third to fifth and from seventh to ninth words, you would enter "1-3,8-10" or if you want to highlight whole text enter -1', translentor_slug ),
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_style_highlighted_text',
			[
				'label' => esc_html__( 'Style', translentor_slug ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'text_align',
			array(
				'label' => esc_html__( 'Alignment', translentor_slug ),
				'type' => Controls_Manager::CHOOSE,
				'options' => $this->get_select_type_options( 'alignment_icons' ),
				'responsive' => true,
				'default' => 'left',
			
			),
		);
		$this->add_control(
			'text_tag',
			array(
				'label' => esc_html__( 'Text Tag', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $this->get_select_type_options( 'title_tag', false ),
				'default' => 'p',
				
			)
		);
		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', translentor_slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .highlight-content' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Text Typography', translentor_slug ),
				'name' => 'text_typography',
				'selector' => '{{WRAPPER}} .highlight-content',
			]
		);
		$this->add_control(
			'highlight_text_color',
			[
				'label' => esc_html__( 'Highlight Text Color', translentor_slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .highlight' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'highlight_background_style',
			array(
				'label' => esc_html__( 'Highlight Text Background Style', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options'       => array(
					'color'    => esc_html__( 'Color', translentor_slug ),
					'gradient' => esc_html__( 'Gradient', translentor_slug ),
				),
				'default' => 'color',
				
			)
		);
		$this->add_control(
			'highlight_background_color',
			[
				'label' => esc_html__( 'Highlight Text Background Color', translentor_slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#CAD729',
				'condition' => ['highlight_background_style' => 'color'],
			]
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'highlight_item_color',
			[
				'label' => esc_html__( 'Color', translentor_slug ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#00ff00',
			]
		);

		$repeater->add_control(
			'highlight_color_percentage',
			[
				'label' => esc_html__( 'Color Percentage', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					
					],
					
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
			
			],
			]

		);
		$this->add_control(
			'gradient_item',
			[
				'label' => esc_html__( 'Gradient Colors', translentor_slug ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'highlight_item_color' => '#FF5733',
						'highlight_color_percentage' => array(
							'size' => 50,
							'unit' => '%',
						),
					],
					[
						'highlight_item_color' => '#21034F',
						'highlight_color_percentage' => array(
							'size' => 50,
							'unit' => '%',
						),
					],
				],
			
				'condition' => ['highlight_background_style' => 'gradient'],
			]
		);
		$this->add_control(
			'gradient_degree',
			[
				'label' => esc_html__( 'Gradient Degree', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -180,
						'max' => 180,
						
					],
					
				],
				'default' => [
					'unit' => 'px',
					'size' => 180,
				],
			'condition' => ['highlight_background_style' => 'gradient'],
			]

		);
		$this->add_control(
			'top_offset',
			[
				'label' => esc_html__( 'Top Offset', translentor_slug ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 0,
			]
		);
		$this->add_control(
			'bottom_offset',
			[
				'label' => esc_html__( 'Bottom Offset', translentor_slug ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 0,
			]
		);
		$this->add_control(
		'highlight_padding',
			[
				'label' => esc_html__( 'Padding', translentor_slug ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					
					],
					
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'responsive' => true,
			],
			]
		);
		 $this->end_controls_section();
    }
	function get_select_type_options( $type){
		$options = array();
		switch ( $type ) {
			case 'title_tag':
				$options['h1'] = 'H1';
				$options['h2'] = 'H2';
				$options['h3'] = 'H3';
				$options['h4'] = 'H4';
				$options['h5'] = 'H5';
				$options['h6'] = 'H6';
				$options['p']  = 'P';
				break;
			case 'alignment_icons':
				$options['left']   = array(
					'title' => esc_html__( 'Left', translentor_slug ),
					'icon'  => 'eicon-text-align-left',
				);
				$options['center'] = array(
					'title' => esc_html__( 'Center', translentor_slug ),
					'icon'  => 'eicon-text-align-center',
				);
				$options['right']  = array(
					'title' => esc_html__( 'Right', translentor_slug ),
					'icon'  => 'eicon-text-align-right',
				);
				break;

		}
		return $options;
	}
    protected function render() {
		$settings = $this->get_settings_for_display();
		
		echo "<". esc_attr( $settings['text_tag'] )." class='highlight-content' style='text-align:".$settings['text_align']."'>";
	
		echo  $this->get_modified_texthighlight( $settings ) ;
	   echo "</". esc_attr( $settings['text_tag'] ).">";
	}
	private function get_modified_texthighlight( $atts ) {
		$text = $atts['text'];

		if ( ! empty( $text ) && ! empty( $atts['highlight_position'] ) ) {

			$highlight_styles   = $this->get_highlight_styles_text( $atts );
			$highlight_position = $atts['highlight_position'];
			$text_prefix        = '<span class="highlight" ' . $this->swarm_get_inline_style_text( $highlight_styles ) . '>';
			$text_suffix        = '</span>';

			if ( '-1' === $highlight_position ) {
				$text = $text_prefix . $text . $text_suffix;
			} else {
				$split_text = explode( ' ', $text );
				$highlights = explode( ',', str_replace( ' ', '', $atts['highlight_position'] ) );

				$highlight_positions = array();
				foreach ( $highlights as $highlight ) {
					$highlight_positions[] = explode( '-', $highlight );
				}

				foreach ( $highlight_positions as $highlight_position ) {
					$positions = array_filter(
						array(
							'start' => isset( $highlight_position[0] ) ? $highlight_position[0] : '',
							'end'   => isset( $highlight_position[1] ) ? $highlight_position[1] : '',
						)
					);
					asort( $positions );

					if ( ! empty( $positions ) ) {

						foreach ( $positions as $key => $value ) {
							$text_prefix_html = 'start' === $key ? $text_prefix : '';
							$text_suffix_html = 'end' === $key ? $text_suffix : '';

							if ( isset( $split_text[ intval( $value ) - 1 ] ) && ! empty( $split_text[ intval( $value ) - 1 ] ) ) {
								$split_text[ $value - 1 ] = $text_prefix_html . $split_text[ $value - 1 ] . $text_suffix_html;
							}
						}

						$text = implode( ' ', $split_text );
					}
				}
			}
		}

		return $text;
	}
	private function get_highlight_styles_text( $atts ) {
		$styles = array();

		if ( ! isset( $atts['highlight_background_style'] ) || 'color' === $atts['highlight_background_style'] ) {
			if ( ! empty( $atts['highlight_background_color'] ) ) {
				$styles[] = 'background-image: linear-gradient(to bottom, transparent ' . ( 0 + (int) $atts['top_offset'] ) . '%, ' . $atts['highlight_background_color'] . ' ' . ( 0 + (int) $atts['top_offset'] ) . '%, ' . $atts['highlight_background_color'] . ' ' . ( 100 - (int) $atts['bottom_offset'] ) . '%, transparent ' . ( 100 - (int) $atts['bottom_offset'] ) . '%);padding:'.$atts['highlight_padding']['size'].'px';
			}
		} elseif ( 'gradient' === $atts['highlight_background_style'] ) {
			
			$gradient_colors =  $atts['gradient_item'];

			if ( count( $gradient_colors ) ) {
				$style = 'background: linear-gradient(' . $atts['gradient_degree']['size'] . 'deg';

				foreach ( $gradient_colors as $color ) {
					$style .= ',' . $color['highlight_item_color'] . ' ' . $color['highlight_color_percentage']['size'] . '%';
				}

				$style .= ');';
                $style .='padding:'.$atts['highlight_padding']['size'].'px';
				$styles[] = $style;
			}
		}

		return $styles;
	}
	function swarm_get_inline_style_text( $value ) {
		return $this->swarm_get_inline_attr( $value, 'style', ';' );
	}
	function swarm_get_inline_attr( $value, $attr, $glue = '', $allow_zero_values = false ) {
		if ( $allow_zero_values ) {
			if ( '' !== $value ) {

				if ( is_array( $value ) && count( $value ) ) {
					$properties = implode( $glue, $value );
				} else {
					$properties = $value;
				}

				return $attr . '="' . esc_attr( $properties ) . '"';
			}
		} else {
			if ( ! empty( $value ) ) {

				if ( is_array( $value ) && count( $value ) ) {
					$properties = implode( $glue, $value );
				} elseif ( '' !== $value ) {
					$properties = $value;
				} else {
					return '';
				}

				return $attr . '="' . esc_attr( $properties ) . '"';
			}
		}

		return '';
	}

}
Plugin::instance()->widgets_manager->register_widget_type( new text_highlight() );
?>