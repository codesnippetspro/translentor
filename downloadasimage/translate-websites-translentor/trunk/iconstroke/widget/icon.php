<?php
/**
 * translentor Icon.
 *
 * @package translentor
 */
namespace Swarm;
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
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Utils;
use Elementor\Plugin;

if(!defined('ABSPATH')) exit;

if ( ! session_id() && ! headers_sent() ) 
{
	session_start();
}
class icon_stroke extends Widget_Base{
	
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);
		
        wp_register_style( 'icon-css', translentor_URL .  'iconstroke/css/icon.min.css');
        
    }
    
    public function get_name()
    {
        return 'stroke-icon';
    }
    
    public function get_title()
    {
        return 'Icon';
    }
    
    public function get_icon()
    {
        return 'eicon-favorite';
    }
    
    public function get_categories()
    {
        return [ 'translentor-category' ];
    }
    
    public function get_style_depends() 
    {
        return [ 'icon-css' ];
    }
    protected function register_controls() 
    {
			$this->start_controls_section(
				'section_icon',
				[
					'label' => esc_html__( 'Icon', translentor_slug ),
				]
			);
	
			$this->add_control(
				'selected_icon',
				[
					'label' => esc_html__( 'Icon', translentor_slug),
					'type' => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default' => [
						'value' => 'fas fa-star',
						'library' => 'fa-solid',
					],
				]
			);
	
			$this->add_control(
				'view',
				[
					'label' => esc_html__( 'View', translentor_slug ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'default' => esc_html__( 'Default', translentor_slug ),
						'stacked' => esc_html__( 'Stacked', translentor_slug ),
						'framed' => esc_html__( 'Framed', translentor_slug ),
					],
					'default' => 'default',
					'prefix_class' => 'translentor-view-',
				]
			);
	
			$this->add_control(
				'shape',
				[
					'label' => esc_html__( 'Shape', translentor_slug ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'circle' => esc_html__( 'Circle', translentor_slug ),
						'square' => esc_html__( 'Square', translentor_slug ),
					],
					'default' => 'circle',
					'condition' => [
						'view!' => 'default',
					],
					'prefix_class' => 'translentor-shape-',
				]
			);
	
			$this->add_control(
				'link',
				[
					'label' => esc_html__( 'Link', translentor_slug ),
					'type' => Controls_Manager::URL,
					'dynamic' => [
						'active' => true,
					],
					'placeholder' => esc_html__( 'https://your-link.com', translentor_slug ),
				]
			);
	
			$this->add_responsive_control(
				'align',
				[
					'label' => esc_html__( 'Alignment', translentor_slug ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', translentor_slug ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', translentor_slug ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', translentor_slug ),
							'icon' => 'eicon-text-align-right',
						],
					],
					'default' => 'center',
					'selectors' => [
						'{{WRAPPER}} .translentor-icon_wrapper' => 'text-align: {{VALUE}};',
					],
				]
			);
	
			$this->end_controls_section();
	
			$this->start_controls_section(
				'section_style_icon',
				[
					'label' => esc_html__( 'Icon', translentor_slug ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);
	
			$this->start_controls_tabs( 'icon_colors' );
	
			$this->start_controls_tab(
				'icon_colors_normal',
				[
					'label' => esc_html__( 'Normal', translentor_slug ),
				]
			);
	
			$this->add_control(
				'primary_color',
				[
					'label' => esc_html__( 'Primary Color', translentor_slug ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}}.translentor-view-stacked .translentor-icon' => 'background-color: {{VALUE}};',
						'{{WRAPPER}}.translentor-view-framed .translentor-icon, {{WRAPPER}}.translentor-view-default .translentor-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
						'{{WRAPPER}}.translentor-view-framed .translentor-icon, {{WRAPPER}}.translentor-view-default .translentor-icon svg' => 'fill: {{VALUE}};',
					],
					'global' => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
				]
			);
	
			$this->add_control(
				'secondary_color',
				[
					'label' => esc_html__( 'Secondary Color', translentor_slug ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'condition' => [
						'view!' => 'default',
					],
					'selectors' => [
						'{{WRAPPER}}.translentor-view-framed .translentor-icon' => 'background-color: {{VALUE}};',
						'{{WRAPPER}}.translentor-view-stacked .translentor-icon' => 'color: {{VALUE}};',
						'{{WRAPPER}}.translentor-view-stacked .translentor-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
	       $this->add_control(
			   'stroke_color',
			   [
				'label' => esc_html__( 'Stroke Color', translentor_slug ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				
				'selectors' => [
					'{{WRAPPER}} .translentor-icon' => '-webkit-text-stroke-color: {{VALUE}};',
				],
			]
		   );
		   $this->add_responsive_control(
			'stroke_width',
			[
				'label' => esc_html__( 'Stroke Width', translentor_slug ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .translentor-icon' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
			$this->end_controls_tab();
	
			$this->start_controls_tab(
				'icon_colors_hover',
				[
					'label' => esc_html__( 'Hover', translentor_slug ),
				]
			);
	
			$this->add_control(
				'hover_primary_color',
				[
					'label' => esc_html__( 'Primary Color', translentor_slug ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}}.translentor-view-stacked .translentor-icon:hover' => 'background-color: {{VALUE}};',
						'{{WRAPPER}}.translentor-view-framed .translentor-icon:hover, {{WRAPPER}}.translentor-view-default .translentor-icon:hover' => 'color: {{VALUE}}; border-color: {{VALUE}};',
						'{{WRAPPER}}.translentor-view-framed .translentor-icon:hover, {{WRAPPER}}.translentor-view-default .translentor-icon:hover svg' => 'fill: {{VALUE}};',
					],
				]
			);
	
			$this->add_control(
				'hover_secondary_color',
				[
					'label' => esc_html__( 'Secondary Color', translentor_slug ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'condition' => [
						'view!' => 'default',
					],
					'selectors' => [
						'{{WRAPPER}}.translentor-view-framed .translentor-icon:hover' => 'background-color: {{VALUE}};',
						'{{WRAPPER}}.translentor-view-stacked .translentor-icon:hover' => 'color: {{VALUE}};',
						'{{WRAPPER}}.translentor-view-stacked .translentor-icon:hover svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'stroke_color_hover',
				[
				 'label' => esc_html__( 'Stroke Color', translentor_slug ),
				 'type' => Controls_Manager::COLOR,
				 'default' => '',
				 
				 'selectors' => [
					 '{{WRAPPER}} .translentor-icon:hover' => '-webkit-text-stroke-color: {{VALUE}};',
				 ],
			 ]
			);
			$this->add_responsive_control(
			 'stroke_width_hover',
			 [
				 'label' => esc_html__( 'Stroke Width', translentor_slug ),
				 'type' => Controls_Manager::SLIDER,
				 'range' => [
					 'px' => [
						 'min' => 0,
						 'max' => 100,
					 ],
				 ],
				 'selectors' => [
					 '{{WRAPPER}} .translentor-icon:hover' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
				 ],
				 'separator' => 'before',
			 ]
		 );
			$this->add_control(
				'hover_animation',
				[
					'label' => esc_html__( 'Hover Animation', translentor_slug ),
					'type' => Controls_Manager::HOVER_ANIMATION,
				]
			);
	
			$this->end_controls_tab();
	
			$this->end_controls_tabs();
	
			$this->add_responsive_control(
				'size',
				[
					'label' => esc_html__( 'Size', translentor_slug ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 6,
							'max' => 300,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .translentor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					],
					'separator' => 'before',
				]
			);
	
			$this->add_control(
				'icon_padding',
				[
					'label' => esc_html__( 'Padding', translentor_slug ),
					'type' => Controls_Manager::SLIDER,
					'selectors' => [
						'{{WRAPPER}} .translentor-icon' => 'padding: {{SIZE}}{{UNIT}};',
					],
					'range' => [
						'em' => [
							'min' => 0,
							'max' => 5,
						],
					],
					'condition' => [
						'view!' => 'default',
					],
				]
			);
	
			$this->add_responsive_control(
				'rotate',
				[
					'label' => esc_html__( 'Rotate', translentor_slug ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'deg' ],
					'default' => [
						'size' => 0,
						'unit' => 'deg',
					],
					'tablet_default' => [
						'unit' => 'deg',
					],
					'mobile_default' => [
						'unit' => 'deg',
					],
					'selectors' => [
						'{{WRAPPER}} .translentor-icon i, {{WRAPPER}} .translentor-icon svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
					],
				]
			);
	
			$this->add_control(
				'border_width',
				[
					'label' => esc_html__( 'Border Width', translentor_slug ),
					'type' => Controls_Manager::DIMENSIONS,
					'selectors' => [
						'{{WRAPPER}} .translentor-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'view' => 'framed',
					],
				]
			);
	
			$this->add_control(
				'border_radius',
				[
					'label' => esc_html__( 'Border Radius', translentor_slug ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors' => [
						'{{WRAPPER}} .translentor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'view!' => 'default',
					],
				]
			);
	
			$this->end_controls_section();
		
    }
    protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'translentor-icon_wrapper' );

		$this->add_render_attribute( 'icon_wrapper', 'class', 'translentor-icon' );

		if ( ! empty( $settings['hover_animation'] ) ) {
			$this->add_render_attribute( 'icon_wrapper', 'class', 'translentor-animation-' . $settings['hover_animation'] );
		}

		$icon_tag = 'div';

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_link_attributes( 'icon_wrapper', $settings['link'] );

			$icon_tag = 'a';
		}

		if ( empty( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['icon'] = 'fa fa-star';
		}

		if ( ! empty( $settings['icon'] ) ) {
			$this->add_render_attribute( 'icon', 'class', $settings['icon'] );
			$this->add_render_attribute( 'icon', 'aria-hidden', 'true' );
		}

		$migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
		$is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<<?php Utils::print_unescaped_internal_string( $icon_tag . ' ' . $this->get_render_attribute_string( 'icon_wrapper' ) ); ?>>
			<?php if ( $is_new || $migrated ) :
				Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
			else : ?>
				<i <?php $this->print_render_attribute_string( 'icon' ); ?>></i>
			<?php endif; ?>
			</<?php Utils::print_unescaped_internal_string( $icon_tag ); ?>>
		</div>
		<?php
	}
	protected function content_template() {
		?>
		<# var link = settings.link.url ? 'href="' + settings.link.url + '"' : '',
				iconHTML = elementor.helpers.renderIcon( view, settings.selected_icon, { 'aria-hidden': true }, 'i' , 'object' ),
				migrated = elementor.helpers.isIconMigrated( settings, 'selected_icon' ),
				iconTag = link ? 'a' : 'div';
		#>
		<div class="translentor-icon_wrapper">
			<{{{ iconTag }}} class="translentor-icon translentor-animation-{{ settings.hover_animation }}" {{{ link }}}>
				<# if ( iconHTML && iconHTML.rendered && ( ! settings.icon || migrated ) ) { #>
					{{{ iconHTML.value }}}
				<# } else { #>
					<i class="{{ settings.icon }}" aria-hidden="true"></i>
				<# } #>
			</{{{ iconTag }}}>
		</div>
		<?php
	}
}
Plugin::instance()->widgets_manager->register_widget_type( new icon_stroke() );
?>