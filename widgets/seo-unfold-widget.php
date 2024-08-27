<?php

use Elementor\Core\Base\Document;
use ElementorPro\Modules\QueryControl\Module as QueryControlModule;
use ElementorPro\Plugin;

class Elementor_SEO_Unfold_Widget extends \Elementor\Widget_Base {
    
    public function get_name() {
        return 'seo-unfold';
    }

    public function get_title() {
        return __( 'SEO Unfold', 'seo-unfold' );
    }

    public function get_icon() {
        return 'eicon-code';
    }

    public function get_categories() {
        return [ 'basic' ];
    }

    public function get_keywords() {
		return [ 'seo', 'unfold' ];
	}

    protected function _register_controls() {
        $this->start_controls_section(
            'unfold_settings',
            [
                'label' => __( 'Paramètres', 'seo-unfold' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'content_min_height',
            [
                'label' => __( 'Hauteur minimum', 'seo-unfold' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
            ]
        );

        $this->add_control(
            'activate_gradient_mask',
            [
                'label' => __( 'Activer le masque dégradé', 'seo-unfold' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Oui', 'seo-unfold' ),
                'label_off' => __( 'Non', 'seo-unfold' ),
                'default' => 'no',
                'return_value' => 'yes',
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => __( 'Hauteur du dégradé', 'seo-unfold' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
                'condition' => [
                    'activate_gradient_mask' => 'yes',
                ],
                'selectors' => [
					'{{WRAPPER}} .seo-unfold-gradient-mask' => 'height: {{SIZE}}px;',
				],
            ]
        );

		$this->end_controls_section();

        $this->start_controls_section(
            'content_settings',
            [
                'label' => __( 'Contenu', 'seo-unfold' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'content_type',
            [
                'label' => __('Type de contenu', 'seo-unfold'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'editor',
                'options' => [
                    'editor' => __('Editeur', 'seo-unfold'),
                    'template' => __('Template', 'seo-unfold'),
                ],
            ]
        );

        $document_types = Plugin::elementor()->documents->get_document_types( [
			'show_in_library' => true,
		] );

        $this->add_control(
            'template',
			[
				'label' => esc_html__( 'Choisir un template', 'seo-unfold' ),
				'type' => QueryControlModule::QUERY_CONTROL_ID,
				'label_block' => true,
				'autocomplete' => [
					'object' => QueryControlModule::QUERY_OBJECT_LIBRARY_TEMPLATE,
					'query' => [
						'meta_query' => [
							[
								'key' => Document::TYPE_META_KEY,
								'value' => array_keys( $document_types ),
								'compare' => 'IN',
							],
						],
					],
				],
                'condition' => [
                    'content_type' => 'template',
                ],
			]
        );

        $this->add_control(
            'content',
            [
                'label' => __( 'Contenu', 'seo-unfold' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __( 'Ajouter du contenu', 'seo-unfold' ),
                'condition' => [
                    'content_type' => 'editor',
                ],
            ]
        );

        

		$this->end_controls_section();

        $this->start_controls_section(
            'buttons_settings',
            [
                'label' => __( 'Boutons', 'seo-unfold' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->start_controls_tabs( 'tabs_settings' );

		$this->start_controls_tab(
			'closed_tab_settings',
			[
				'label' => __( 'Fermé', 'seo-unfold' ),
            ]
		);

        $this->add_control(
            'closed_button_text',
            [
                'label' => __( 'Label', 'seo-unfold' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Fermé', 'seo-unfold' ),
            ]
        );

        $this->add_control(
            'closed_button_icon',
            [
				'label' => esc_html__( 'Icône', 'seo-unfold' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-chevron-down',
					'library' => 'fa-solid',
				],
                'fa4compatibility' => 'old_closed_button_icon',
                'skin' => 'inline',
                'label_block'      => false,
            ]
        );

        $this->end_controls_tab();

		$this->start_controls_tab(
			'opened_tab_settings',
			[
				'label' => esc_html__( 'Ouvert', 'seo-unfold' ),
            ]
		);

        $this->add_control(
            'opened_button_text',
            [
                'label' => __( 'Label', 'seo-unfold' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Ouvert', 'seo-unfold' ),
            ]
        );

        $this->add_control(
            'opened_button_icon',
            [
                'label' => esc_html__( 'Icône', 'seo-unfold' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-up',
                    'library' => 'fa-solid',
                ],
                'fa4compatibility' => 'old_opened_button_icon',
                'skin' => 'inline',
                'label_block'      => false,
            ]
        );

        $this->end_controls_tab();

	    $this->end_controls_tabs();

		$this->end_controls_section();

        $this->start_controls_section(
			'content_style_section',
			[
				'label' => esc_html__( 'Contenu', 'seo-unfold' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
			'heading_gradient_mask',
			[
				'label' => esc_html__( 'Masque dégradé', 'seo-unfold' ),
				'type' => \Elementor\Controls_Manager::HEADING,
                'condition' => [
                    'activate_gradient_mask!' => '',
                ],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background_gradient_mask',
				'types' => ['gradient'],
                'condition' => [
                    'activate_gradient_mask!' => '',
                ],
                'selector' => '{{WRAPPER}} .seo-unfold-gradient-mask',
			]
		);

        $this->add_control(
			'heading_content',
			[
				'label' => esc_html__( 'Contenu', 'seo-unfold' ),
				'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'activate_gradient_mask!' => '',
                ],
			]
		);

        $this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Couleur', 'seo-unfold' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .seo-unfold-content' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
            'content_padding',
            [
                'label'      => __( 'Padding', 'seo-unfold' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .seo-unfold-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ],
        );

        $this->add_control(
            'content_margin',
            [
                'label'      => __( 'Margin', 'seo-unfold' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .seo-unfold-content-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ],
        );

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .seo-unfold-content',
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
			'buttons_style_section',
			[
				'label' => esc_html__( 'Boutons', 'seo-unfold' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
			'button_alignment',
			[
				'label'   => __( 'Alignement', 'seo-unfold' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'flex-start' => [
						'title' => __( 'Début', 'seo-unfold' ),
						'icon'  => 'eicon-h-align-left',
                    ],
					'center' => [
						'title' => __( 'Centré', 'seo-unfold' ),
						'icon'  => 'eicon-h-align-center',
                    ],
					'flex-end' => [
						'title' => __( 'Fin', 'seo-unfold' ),
						'icon'  => 'eicon-h-align-right',
                    ],
					'stretch' => [
						'title' => __( 'Justifié', 'seo-unfold' ),
						'icon'  => 'eicon-h-align-stretch',
                    ],
                ],
				'selectors'  => [
					'{{WRAPPER}} .seo-unfold' => 'align-items: {{VALUE}};',
                ],
            ]
		);

        $this->add_responsive_control(
			'icon_button_position',
			[
				'label'   => __( 'Position de l\'icône', 'seo-unfold' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'default' => 'row',
				'options' => [
					'row-reverse' => [
						'title' => __( 'Gauche', 'seo-unfold' ),
						'icon'  => 'eicon-h-align-left',
                    ],
                    'row' => [
						'title' => __( 'Droite', 'seo-unfold' ),
						'icon'  => 'eicon-h-align-right',
                    ],
                ],
				'selectors'  => [
					'{{WRAPPER}} .seo-unfold-buttons' => 'flex-direction: {{VALUE}};',
                ],
            ]
		);


        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'buttons_text_typography',
				'selector' => '{{WRAPPER}} .seo-unfold-buttons',
			]
		);

        $this->add_control(
            'icon_text_space',
            [
                'label' => __( 'Espacement', 'seo-unfold' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .seo-unfold-buttons' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
            ]
        );

        $this->add_control(
        'buttons_padding',
			[
				'label'      => __( 'Padding', 'seo-unfold' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .seo-unfold-buttons' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ],
        );

        $this->add_control(
            'buttons_margin',
            [
                'label'      => __( 'Margin', 'seo-unfold' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .seo-unfold-buttons' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ],
        );

        $this->start_controls_tabs( 'tabs_buttons_style' );

		$this->start_controls_tab(
			'tab_buttons_normal',
			[
				'label' => __( 'Normal', 'seo-unfold' ),
            ]
		);

        $this->add_control(
            'icon_color',
            [
                'label' => __( 'Couleur', 'seo-unfold' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .seo-unfold-buttons' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
			'buttons_bg_color',
			[
				'label'     => __( 'Fond', 'seo-unfold' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .seo-unfold-buttons' => 'background-color: {{VALUE}}',
                ],
            ],
		);

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'        => 'buttons_border',
				'label'       => __( 'Bordure', 'seo-unfold' ),
				'placeholder' => '1px',
				'default'     => '1px',
                'selector' => '{{WRAPPER}} .seo-unfold-buttons',
            ],
		);

		$this->add_responsive_control(
			'button_border_radius',
			[
				'label'      => __( 'Border Radius', 'seo-unfold' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .seo-unfold-buttons' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ],
		);

        $this->end_controls_tab();

		$this->start_controls_tab(
			'tab_buttons_hover',
			[
				'label' => __( 'Hover', 'seo-unfold' ),
            ]
		);

        $this->add_control(
            'icon_color_hover',
            [
                'label' => __( 'Couleur', 'seo-unfold' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .seo-unfold-buttons:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
			'buttons_bg_color_hover',
			[
				'label'     => esc_html__( 'Fond', 'seo-unfold' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .seo-unfold-buttons:hover' => 'background-color: {{VALUE}}',
                ],
            ],
		);

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'        => 'buttons_hover_border',
				'label'       => __( 'Bordure', 'seo-unfold' ),
				'placeholder' => '1px',
				'default'     => '1px',
                'selector' => '{{WRAPPER}} .seo-unfold-buttons:hover',
            ],
		);

		$this->add_responsive_control(
			'button_hover_border_radius',
			[
				'label'      => __( 'Border Radius', 'seo-unfold' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .seo-unfold-buttons:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ],
		);

        $this->end_controls_tab();

        $this->end_controls_tabs();

		$this->end_controls_section();


    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if ( ! empty( $settings['closed_button_icon'] ) ) {
			$this->add_render_attribute( 'closed_button_icon', 'class', $settings['closed_button_icon'] );
			$this->add_render_attribute( 'closed_button_icon', 'aria-hidden', 'true' );
		}

        if ( ! empty( $settings['opened_button_icon'] ) ) {
			$this->add_render_attribute( 'opened_button_icon', 'class', $settings['closed_button_icon'] );
			$this->add_render_attribute( 'opened_button_icon', 'aria-hidden', 'true' );
		}


        ?>

        <div class="seo-unfold">
            <div class="seo-unfold-content-wrapper" data-height="<?php echo $settings['content_min_height']['size'] ?>">
                <div class="seo-unfold-content">
                    <?php if ($settings['content_type'] === 'editor') {
                        echo $settings['content']; // Contenu de l'éditeur classique
                    } elseif ($settings['content_type'] === 'template') {
                        echo Plugin::elementor()->frontend->get_builder_content( $settings['template'],true );
                    } ?>
                </div>
                <?php if ($settings['activate_gradient_mask'] == 'yes') { ?>
                    <div class="seo-unfold-gradient-mask"></div>
                <?php } ?>
            </div>
            <div class="seo-unfold-buttons seo-unfold-closed-button">
                <span class="seo-unfold-buttons-text seo-unfold-closed-button-text"><?php echo $settings['closed_button_text']; ?></span>
                <span class="seo-unfold-buttons-icon seo-unfold-closed-button-icon">
				    <?php \Elementor\Icons_Manager::render_icon( $settings['closed_button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                </span>
            </div>
            <div class="seo-unfold-buttons seo-unfold-opened-button">
                <span class="seo-unfold-buttons-text seo-unfold-opened-button-text"><?php echo $settings['opened_button_text']; ?></span>
                <span class="seo-unfold-buttons-icon seo-unfold-opened-button-icon">
                <?php \Elementor\Icons_Manager::render_icon( $settings['opened_button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                </span>
            </div>
        </div>

        <?php
    }
}