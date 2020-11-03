<?php

add_action('plugins_loaded', function(){

	if ( ! class_exists('WebMapp_Acf') )
		return;


// DEFINIZIONE DEL DATAMODEL x ROUTE ------------------------------------------------------------------------------------------------

$field_group1 =	array(
	'key' => 'wm_route_quote',
	'title' => 'Date e preventivo',
	'fields' => array(
		array(
			'key' => 'wm_route_quote_tab_model',
			'label' => 'Modello',
			'type' => 'tab',
			'placement' => 'top',
			'endpoint' => 0,
		),
		array(
			'key' => 'wm_route_not_salable',
			'label' => 'Route non vendibile',
			'name' => 'not_salable',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => 'Non vendibile',
			'default_value' => 1,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
			'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
		),
		// array(
		// 	'key' => 'wm_route_in_promotion',
		// 	'label' => 'Route in promozione',
		// 	'name' => 'promotion',
		// 	'type' => 'true_false',
		// 	'instructions' => '',
		// 	'required' => 0,
		// 	'conditional_logic' => 0,
		// 	'wrapper' => array(
		// 		'width' => '',
		// 		'class' => '',
		// 		'id' => '',
		// 	),
		// 	'message' => 'Applica promozione',
		// 	'default_value' => 0,
		// 	'ui' => 0,
		// 	'ui_on_text' => '',
		// 	'ui_off_text' => '',
		// ),
		array(
			'key' => 'wm_route_quote_product',
			'label' => 'Modello product',
			'name' => 'product',
			'type' => 'relationship',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array(
				0 => 'product',
			),
			'taxonomy' => '',
			'filters' => array(
				0 => 'search',
			),
			'elements' => '',
			'min' => 0,
			'max' => 10,
			'return_format' => 'id',
			'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
		),
		array(
			'key' => 'wm_route_quote_tab_model_season',
			'label' => 'Modello (stagioni)',
			'type' => 'tab',
			'placement' => 'top',
			'endpoint' => 0,
		),
		array(
			'key' => 'wm_route_quote_season_repeater',
			'label' => 'Periodi di prezzo (stagionalità)',
			'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
			'name' => 'model_season',
			'type' => 'repeater',
			'layout' => 'row',
			'sub_fields' => array(
				array(
					'key' => 'wm_route_quote_model_season_name',
					'wpml_cf_preferences' => WEBMAPP_TRANSLATE_CUSTOM_FIELD,
					'label' => 'Stagionalità',
					'name' => 'season_name',
					'type' => 'text',
					'instructions' => 'Inserire ad esempio: Alta Stagione, Bassa Stagione',
				),
				array(
					'key' => 'wm_route_quote_model_season_disactive',
					'label' => 'Stagione disattiva',
					'name' => 'season_disactive',
					'type' => 'true_false',
					'instructions' => 'Clicca per disattivare questa stagione',
					'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
				),
				array(
					'key' => 'wm_route_quote_model_season_dates_periods_repeater',
					'label' => 'Periodi di partenza',
					'name' => 'periods',
					'type' => 'repeater',
					'layout' => 'table',
					'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
					'sub_fields' => array(
						array(
							'key' => 'wm_route_quote_model_season_dates_periods_start',
							'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
							'label' => 'Inizio',
							'name' => 'start',
							'type' => 'date_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'display_format' => 'd/m/Y',
							'return_format' => 'd/m/Y',
							'first_day' => 1,
						),
						array(
							'key' => 'wm_route_quote_model_season_dates_periods_stop',
							'label' => 'Fine periodo',
							'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
							'name' => 'stop',
							'type' => 'date_picker',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'display_format' => 'd/m/Y',
							'return_format' => 'd/m/Y',
							'first_day' => 1,
						),
					),
				),

				array(
					'key' => 'wm_route_quote_model_season_product',
					'label' => 'Modello product',
					'name' => 'product',
					'type' => 'relationship',
					'instructions' => 'Inserisci i modelli di prodotto creati per questa Stagionalità',
					'post_type' => array(
						0 => 'product',
					),
					'min' => 0,
					'max' => 10,
					'return_format' => 'id',
					'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
				),
			),
		),
		array(
			'key' => 'wm_route_quote_dates',
			'label' => 'Partenza (periodi di date)',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
		),
		array(
			'key' => 'wm_route_quote_dates_periods_repeater',
			'label' => 'Periodi di partenza',
			'name' => 'departures_periods',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'table',
			'button_label' => '',
			'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
			'sub_fields' => array(
				array(
					'key' => 'wm_route_quote_dates_period_name',
					'label' => 'Nome del periodo',
					'name' => 'period_name',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'wpml_cf_preferences' => WEBMAPP_TRANSLATE_CUSTOM_FIELD,
				),
				array(
					'key' => 'wm_route_quote_dates_period_start',
					'label' => 'Inizio Periodo',
					'name' => 'start',
					'type' => 'date_picker',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'display_format' => 'd/m/Y',
					'return_format' => 'd/m/Y',
					'first_day' => 1,
					'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
				),
				array(
					'key' => 'wm_route_quote_dates_period_stop',
					'label' => 'Fine periodo',
					'name' => 'stop',
					'type' => 'date_picker',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'display_format' => 'd/m/Y',
					'return_format' => 'd/m/Y',
					'first_day' => 1,
					'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
				),
				array(
					'key' => 'wm_route_quote_dates_period_week_days',
					'label' => 'Giorni della settimana',
					'name' => 'week_days',
					'type' => 'checkbox',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'mon' => 'mon',
						'tue' => 'tue',
						'wed' => 'wed',
						'thu' => 'thu',
						'fri' => 'fri',
						'sat' => 'sat',
						'sun' => 'sun',
					),
					'allow_custom' => 0,
					'default_value' => array(),
					'layout' => 'horizontal',
					'toggle' => 0,
					'return_format' => 'value',
					'save_custom' => 0,
					'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
				),
			),
		),
		array(
			'key' => 'wm_route_quote_dates_specific_tab',
			'label' => 'Partenza (date specifiche)',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
		),
		array(
			'key' => 'wm_route_quote_dates_specific_repeater',
			'label' => 'Date specifiche di partenza',
			'name' => 'departure_dates',
			'type' => 'repeater',
			'instructions' => 'Inserisci una o più date per la partenza',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => 'field_5d02059174143',
			'min' => 0,
			'max' => 0,
			'layout' => 'table',
			'button_label' => 'Aggiuni data',
			'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
			'sub_fields' => array(
				array(
					'key' => 'wm_route_quote_dates_specific',
					'label' => 'Data',
					'name' => 'date',
					'type' => 'date_picker',
					'instructions' => 'Inserisci una data',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'display_format' => 'd/m/Y',
					'return_format' => 'd/m/Y',
					'first_day' => 1,
					'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'route',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
);

//ROUTE sezione Flusso pubblicazione
$group_field_flusso = array(
		'key' => 'wm_route_flusso_pubblicazione',
		'title' => 'Flusso pubblicazione',
		'fields' => array(
			array(
				'key' => 'wm_route_priorita_golive',
				'label' => 'Priorità Golive',
				'name' => 'priorita_golive',
				'type' => 'number',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
				'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
			),
			array(
				'key' => 'wm_route_stato_pubblicazione',
				'label' => 'stato pubblicazione',
				'name' => 'stato_pubblicazione',
				'type' => 'select',
				'instructions' => '',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'choices' => array(
					'new' => 'New',
					'seo' => 'SEO',
					'pending' => 'Pending',
					'done' => 'Done',
					'done21' => 'Done 21',
				),
				'default_value' => array(
					0 => 'new',
				),
				'allow_null' => 0,
				'multiple' => 0,
				'ui' => 0,
				'return_format' => 'value',
				'ajax' => 0,
				'placeholder' => '',
				'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
			),
			array(
				'key' => 'wm_route_url_fornitore',
				'label' => 'URL fornitore',
				'name' => 'url_fornitore',
				'type' => 'url',
				'instructions' => 'Inserire l\'indirizzo web corrispondente al pacchetto sul sito del fornitore',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
			),
			array(
				'key' => 'wm_route_tour_operator',
				'label' => 'Tour Operator',
				'name' => 'tour_operator',
				'type' => 'relationship',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'post_type' => array(
					0 => 'tour_operator',
				),
				'taxonomy' => '',
				'filters' => array(
					0 => 'search',
				),
				'elements' => '',
				'min' => 1,
				'max' => 1,
				'return_format' => 'id',
				'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
			),
			array(
				'key' => 'wm_route_description_pdf',
				'label' => 'Description PDF',
				'name' => 'description_pdf',
				'type' => 'file',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'id',
				'library' => 'all',
				'min_size' => '',
				'max_size' => '',
				'mime_types' => '',
				'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
			),
			array(
				'key' => 'wm_route_pending_notes',
				'label' => 'Pending Notes',
				'name' => 'pending_notes',
				'type' => 'textarea',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'new_lines' => '',
				'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
			),
			array(
				'key' => 'wm_route_assegnato_a',
				'label' => 'Assegnato a',
				'name' => 'assegnato_a',
				'type' => 'user',
				'instructions' => 'Inserisci l\'utente al quale è assegnata la lavorazione',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'role' => '',
				'allow_null' => 1,
				'multiple' => 0,
				'return_format' => 'id',
				'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
			),
			array(
				'key' => 'wm_route_route_con_track',
				'label' => 'Route con track',
				'name' => 'route_con_track',
				'type' => 'checkbox',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'choices' => array(
					'si' => 'si',
					'no' => 'no',
				),
				'allow_custom' => 0,
				'default_value' => array(
				),
				'layout' => 'vertical',
				'toggle' => 0,
				'return_format' => 'value',
				'save_custom' => 0,
				'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'route',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'acf_after_title',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
	);


// ROUTE Definizione di Included and Not Included
$field_group_included = array(
	'key' => 'wm_route_included_not_included',
	'title' => 'Incluso e Non Incluso',
	'fields' => array(
		array(
			'key' => 'wm_route_ini_activated',
			'label' => 'Activate Included not Included',
			'name' => 'ini_activated',
			'type' => 'true_false',
			'instructions' => 'Set to True to configure all the Included and Not Included options.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 0,
			'wpml_cf_preferences' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
			'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
		),
		array(
			'key' => 'wm_route_tab_included',
			'label' => 'Opzioni',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'wm_route_ini_activated',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'wpml_cf_preferences' => 0,
			'placement' => 'top',
			'endpoint' => 0,
		),
		array(
			'key' => 'wm_route_ini_insurance',
			'label' => 'Assicurazione EuropAssistance medico bagaglio 24/24',
			'name' => 'ini_insurance',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 1,
			'ui' => 0,
			'wpml_cf_preferences' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
			'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
		),
		array(
			'key' => 'wm_route_ini_bandb',
			'label' => 'Pernottamento e prima colazione',
			'name' => 'ini_bandb',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 1,
			'ui' => 0,
			'wpml_cf_preferences' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
			'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
		),
		array(
			'key' => 'wm_route_ini_gps',
			'label' => 'Tracce GPS',
			'name' => 'ini_gps',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 1,
			'ui' => 0,
			'wpml_cf_preferences' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
			'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
		),
		array(
			'key' => 'wm_route_ini_app',
			'label' => 'APP',
			'name' => 'ini_app',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 0,
			'wpml_cf_preferences' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
			'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
		),
		array(
			'key' => 'wm_route_ini_luggage',
			'label' => 'Trasporto bagagli da hotel a hotel durante il tour',
			'name' => 'ini_luggage',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 1,
			'ui' => 0,
			'wpml_cf_preferences' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
			'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
		),
		array(
			'key' => 'wm_route_ini_support',
			'label' => 'Assistenza Telefonica 7/7',
			'name' => 'ini_support',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 1,
			'ui' => 0,
			'wpml_cf_preferences' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
			'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
		),
		array(
			'key' => 'wm_route_ini_transfer',
			'label' => 'Transfer qualora non specificati ne "La quota include"',
			'name' => 'ini_transfer',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 0,
			'wpml_cf_preferences' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
			'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
		),
		array(
			'key' => 'wm_route_ini_taxes',
			'label' => 'Tasse di soggiorno',
			'name' => 'ini_taxes',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 0,
			'wpml_cf_preferences' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
			'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
		),
		array(
			'key' => 'wm_route_ini_tip',
			'label' => 'Mance',
			'name' => 'ini_tip',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 0,
			'wpml_cf_preferences' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
			'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
		),
		array(
			'key' => 'wm_route_ini_trip',
			'label' => 'Viaggio a/r dall\'Italia',
			'name' => 'ini_trip',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 0,
			'wpml_cf_preferences' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
			'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
		),
		array(
			'key' => 'wm_route_ini_meal',
			'label' => 'Pasti e bevande non specificati ne "La quota include"',
			'name' => 'ini_meal',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 0,
			'wpml_cf_preferences' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
			'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
		),
		array(
			'key' => 'wm_route_ini_bike',
			'label' => 'Noleggio bicicletta',
			'name' => 'ini_bike',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 0,
			'wpml_cf_preferences' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
			'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
		),
		array(
			'key' => 'wm_route_ini_extra',
			'label' => 'Extra in genere',
			'name' => 'ini_extra',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 0,
			'wpml_cf_preferences' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
			'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
		),
		array(
			'key' => 'wm_route_ini_ticket',
			'label' => 'Ingressi, traghetti e quanto non espressamente indicato ne "La quota include"',
			'name' => 'ini_ticket',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 0,
			'wpml_cf_preferences' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
			'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
		),
		array(
			'key' => 'wm_route_ini_briefing',
			'label' => 'Briefing di benvenuto',
			'name' => 'ini_briefing',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 1,
			'ui' => 0,
			'wpml_cf_preferences' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
			'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
		),
		array(
			'key' => 'wm_route_ini_route_description',
			'label' => 'Descrizione dettagliata del percorso con mappe',
			'name' => 'ini_route_description',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 1,
			'ui' => 0,
			'wpml_cf_preferences' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
			'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
		),
		array(
			'key' => 'wm_route_ini_included_aditional_repeater',
			'label' => 'Campo libero Incluso',
			'name' => 'ini_included_aditional_repeater',
			'type' => 'repeater',
			'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'table',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'wm_route_ini_included_aditional',
					'label' => 'Campo libero',
					'name' => 'ini_included_aditional',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'wpml_cf_preferences' => 0,
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
				),
			),
		),
		array(
			'key' => 'wm_route_ini_not_included_aditional_repeater',
			'label' => 'Campo libero Non Incluso',
			'name' => 'ini_not_included_aditional_repeater',
			'type' => 'repeater',
			'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'table',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'wm_route_ini_not_included_aditional',
					'label' => 'Campo libero',
					'name' => 'ini_not_included_aditional',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'wpml_cf_preferences' => 0,
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'route',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
);
	

// DEFINIZIONE DEL DATAMODEL x BARCHE ------------------------------------------------------------------------------------------------
$field_group2 =	array(
	'key' => 'wm_barche',
	'title' => 'Barche info',
	'fields' => array(
		array(
			'key' => 'wm_barche_riassunto',
			'label' => 'Riassunto',
			'name' => 'riassunto',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'wm_barche_gallery',
			'label' => 'Gallery',
			'name' => 'gallery',
			'type' => 'gallery',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'min' => '',
			'max' => '',
			'insert' => 'append',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
			'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'barche',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
);


// DEFINIZIONE DEL DATAMODEL x la data di partenza nel Backend degli Ordini ---------------------------------------------------------------------------------------------------


$field_group3 =	array(
	'key' => 'group_5d63fd404135a',
	'title' => 'Order departure date',
	'fields' => array(
		array(
			'key' => 'field_5d63fd58692ca',
			'label' => 'Order departure date',
			'name' => 'order_departure_date',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => 'order-departure-date',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'shop_order',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'seamless',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
);


	
	new WebMapp_Acf('route',$field_group1);
	new WebMapp_Acf('route',$group_field_flusso);
	new WebMapp_Acf('route',$field_group_included);
	new WebMapp_Acf('barche',$field_group2);
	new WebMapp_Acf('shop_order',$field_group3);


} );