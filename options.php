<?php
/**
 * Settings Class
 *
 * Implement all functionality on CF7 Skins Settings page.
 *
 * @package cf7skins
 * @author Neil Murray
 * @version 0.0.2
 * @since 0.1.0
 */
 
class GooglURL_Settings {

    // Holds the values to be used in the fields callbacks
    private $options;
   
	// Define class variables
	var $tabs, $title, $section, $fields, $slug, $textdomain;

    /**
     * Class constructor
	 * 
     * @uses http://codex.wordpress.org/Function_Reference/add_action
     * @uses http://codex.wordpress.org/Function_Reference/add_filter
	 * @filter cf7skins_setting_tabs
	 * @since 0.1.0
     */
    function __construct() {
		$this->slug = GOOGLULR_SLUG;
		$this->textdomain = GOOGLULR_TEXTDOMAIN;			
		$this->title = __( 'Googl Settings', $this->textdomain );
		
		$this->section = isset( $_GET['tab'] ) ? $_GET['tab'] : 'general';
		$this->options = get_option( $this->slug );
		//print_r( $this->options );
        add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

	
    /**
     * Add CF7 Skins Settings page as submenu under Contact Form 7 plugin menu item
	 *
	 * @uses add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function);
	 * @link http://codex.wordpress.org/Function_Reference/add_options_page
	 * @since 0.1.0
     */
    function add_menu_page() {
		$this->tabs = array( 
			'general'	=> __( 'General', $this->textdomain ),
			'advanced'	=> __( 'Advanced', $this->textdomain )			
		);	
		
        $page = add_options_page( $this->title, 'Googl', 'manage_options', $this->slug, array( $this, 'settings_fields' ) );
		
		add_action( 'admin_print_styles-' . $page, array( &$this, 'custom_styles' ) );
		add_action( 'admin_print_scripts-' . $page, array( &$this, 'custom_script' ) );
    }		
	
	
	/**
     * Add Settings jQuery
	 * 
	 * @since 0.1.0
     */
    function custom_styles() {
		// add custom admin styles here
    }
	
	
	/**
     * Add Settings jQuery
	 * 
	 * @since 0.1.0
     */
    function custom_script() {
		// add custom admin scripts here
    }	
	
	
    /**
     * Display CF7 Skins Settings page in Tabs
	 * 
	 * Output nonce, action, and option_page fields for a settings page settings_fields( $option_group )
	 * @see settings_fields ( string $option_group = null )
	 * Print out the settings fields for a particular settings section
	 * @see do_settings_fields ( string $page = null, section $section = null )
     * @since 0.1.0
     */
    function settings_fields() {
		?>
		<div class="wrap">
			<?php //echo '<pre style="font-size:10px;line-height:10px;">'. print_r( $this->options, true ) .'</pre>'; ?>
			<h2><?php echo $this->title; ?></h2><br />
			<h2 class="nav-tab-wrapper">
				<?php	
				foreach( $this->tabs as $tab => $name ) {
					$class = ( $tab == $this->section ) ? ' nav-tab-active' : '';
					echo "<a class='nav-tab$class' href='?page=". $this->slug ."&tab=$tab'>$name</a>";
				}
				?>
			</h2>     
            <form method="post" action="options.php">
            <?php		
				settings_fields( $this->slug );
				echo "<input name='{$this->slug}[section]' value='{$this->section}' type='hidden' />";	// handle section
				echo '<table class="form-table commentators-option">';
				do_settings_fields( $this->slug, $this->section );
				echo '</table>';
				do_action( "cf7skins_section_{$this->section}" ); 
				submit_button( __( 'Save Changes', $this->textdomain ) );
            ?>
            </form>
        </div>
        <?php
    }

	
    /**
	 * Register and add settings
	 * 
	 * @see register_setting( $option_group, $option_name, $sanitize_callback );
	 * @see add_settings_section( $id, $title, $callback, $page );
	 * @see add_settings_field( $id, $title, $callback, $page, $section, $args );
	 * @since 0.1.0
     */
    function page_init() {
		if( ! isset( $this->tabs ) )
			return;
			
        register_setting( $this->slug, $this->slug, array( $this, 'sanitize_callback' ) );		
		
		// Add section for each tab on Settings page
		foreach( $this->tabs as $tab => $name ) {
			add_settings_section( $tab, '',  '', $this->slug );
		}

		
		/* Add Initial Fields
		 * Licenses are added via apply_filters () in license.php 
		 * @filter cf7skins_setting_fields
		 * @since 0.2.0. 
		 */
		$fields = apply_filters( 'googlurl_settings_field', array(
			'api_key' => array( 
				'section' => 'general',
				'label' => __( 'Application Key', $this->textdomain ),
				'type' => 'text',
				'description' => sprintf( __( 'Google API browser key. More about <a href="%s">acquiring a browser API key</a>.', '$this->textdomain'),
					esc_url( 'https://developers.google.com/api-client-library/python/guide/aaa_apikeys#acquiring-api-keys' ) . '" target="blank' )
			),
			
			'custom' => array( 
				'section' => 'advanced',
				'label' => __( 'Custom Styles & Scripts', $this->textdomain ),
				'type' => 'textarea',
				'description' => __( 'Print your custom scripts or styles with the tag to push to the wp_head().', $this->textdomain ),
			),

		));	
		
		$this->fields = $fields; // @since 0.5.0 set class object
		
		// Set function setting_field () as callback for each field
		foreach( $fields as $key => $field ) {
			$field['label_for'] = $key;
			add_settings_field( $key, $field['label'], array( $this, 'setting_field' ), $this->slug, $field['section'], $field );		
		}
				
		// Create initialize settings if this is the first install
		if( ! get_option( $this->slug ) ) {
			global $wp_settings_fields;
			$sections = $wp_settings_fields[$this->slug];
			$array = array();
			foreach( $sections as $fields ) {
				foreach( $fields as $k => $field ) {
					$array[$k] = isset( $field['args']['default'] ) ? $field['args']['default'] : '';
				}
			}
			update_option( $this->slug, $array );
		}		
    }
	
	
    /**
     * Sanitize each setting field as needed
	 * 
     * @param array $input Contains all settings fields as array keys
     * @since 0.1.0
     */
    function sanitize_callback( $inputs ) {
		// return if inputs are empty
		if( ! isset( $inputs['section'] ) )
			return $inputs;
			
		global $wp_settings_fields;
		$section = $wp_settings_fields[$this->slug][$inputs['section']];
		$old_option = $this->options;
		
		foreach( $inputs as $k => $input ) {
			$type = $section[$k]['args']['type'];
			
			if( 'text' == $type ) {
				$this->options[$k] = sanitize_text_field( $input );
			} elseif( 'number' == $type ) {
				$this->options[$k] = absint( $input );
			} elseif( 'url' == $type ) {
				$this->options[$k] = esc_url( $input );
			} else {
				$this->options[$k] = $input;
			}
		}
		
		// Special case for checkbox, we need to loop through setting fields
		foreach( $section as $k => $field )
			if( 'checkbox' == $field['args']['type'] )
				if( ! isset( $inputs[$k] ) )
					$this->options[$k] = false;			
		
		/* $this->options is the new and $inputs is old
		 * 
		 * Sanitized Licenses are added via apply_filters () in license.php 
		 * 
		 * @filter cf7skins_setting_sanitize
		 * @since 0.2.0. 
		 */
        return apply_filters( 'cf7skins_setting_sanitize', $this->options, $old_option, $inputs );
    }

	
    /**
     * Print the option field in the section
	 * 
     * @params $args
     * @since 0.1.0
     */	
    public function setting_field( $args ) {
		// echo '<pre style="font-size:10px;line-height:10px;">'. print_r( $this->options, true ) .'</pre>';
		// echo '<pre style="font-size:10px;line-height:10px;">'. print_r( $args, true ) .'</pre>';
		extract( $args );
		$id = isset( $label_for ) ? $label_for : '';  // Use label_for arg as id if set
		$default = isset( $default ) ? $default : '';  // Use label_for arg as id if set
		switch ( $type ) {
			case 'textarea':
				printf( '<textarea id="%1$s" name="'.$this->slug.'[%1$s]" cols="50" rows="5" class="large-text">%2$s</textarea>',
					$id, isset( $this->options[$id] ) ? $this->options[$id] : '' );
				break;			
				
			case 'checkbox':
				// Check if multiple checkbox options
				if( isset( $options ) ) {				
					$diff = array_diff_key( $options, $this->options[$id] );
					$array = array_merge( $this->options[$id], $diff );	
					foreach( $array as $k => $v ) {
						$value = isset( $this->options[$id][$k] ) ? $this->options[$id][$k] : false;
						printf( '<label><input class="total-sortable" id="%1$s" name="'.$this->slug.'[%1$s][%2$s]" type="checkbox" value="1" %3$s />%4$s</label>',
							$id, $k, $value ? 'checked="checked"' : '', $options[$k] );													
					}
				} else {
					$value = isset( $this->options[$id] ) && $this->options[$id] ? true : false;
					printf( '<label><input id="%1$s" name="'.$this->slug.'[%1$s]" type="checkbox" value="1" %2$s />%3$s</label>',
						$id, $value ? 'checked="checked"' : '', $detail );				
				}
				break;				
				
			case 'select':
				echo "<select class='select' name='{$this->slug}[$id]'>";
				foreach ( $options as $key => $value )
					echo "<option value='$key'" . selected( $this->options[$id], $key, false ) . ">$value</option>";				
				echo "</select>";
				break;
				
			case 'text':
			case 'number':
			case 'url':
			default:
				printf( '<input id="%1$s" name="'.$this->slug.'[%1$s]" value="%2$s" class="regular-text" type="%3$s" />',
					$id, isset( $this->options[$id] ) ? $this->options[$id] : $default, $type );
				break;
		}
		
		if( isset( $description ) )
			echo '<p class="description">'. $description .'</p>';
    }
	
} new GooglURL_Settings();