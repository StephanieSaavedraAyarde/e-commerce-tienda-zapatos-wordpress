<?php
/**
 * Theme information krystal
 *
 * @package krystal
 */


if ( ! class_exists( 'Krystal_About_Page' ) ) {
	/**
	 * Singleton class used for generating the about page of the theme.
	 */
	class Krystal_About_Page {
		/**
		 * Define the version of the class.
		 *
		 * @var string $version The Krystal_About_Page class version.
		 */
		private $version = '1.0.0';
		/**
		 * Used for loading the texts and setup the actions inside the page.
		 *
		 * @var array $config The configuration array for the theme used.
		 */
		private $config;
		/**
		 * Get the theme name using wp_get_theme.
		 *
		 * @var string $theme_name The theme name.
		 */
		private $theme_name;
		/**
		 * Get the theme slug ( theme folder name ).
		 *
		 * @var string $theme_slug The theme slug.
		 */
		private $theme_slug;
		/**
		 * The current theme object.
		 *
		 * @var WP_Theme $theme The current theme.
		 */
		private $theme;
		/**
		 * Holds the theme version.
		 *
		 * @var string $theme_version The theme version.
		 */
		private $theme_version;		
		/**
		 * Define the html notification content displayed upon activation.
		 *
		 * @var string $notification The html notification content.
		 */
		private $notification;
		/**
		 * The single instance of Krystal_About_Page
		 *
		 * @var Krystal_About_Page $instance The Krystal_About_Page instance.
		 */
		private static $instance;
		/**
		 * The Main Krystal_About_Page instance.
		 *
		 * We make sure that only one instance of Krystal_About_Page exists in the memory at one time.
		 *
		 * @param array $config The configuration array.
		 */
		public static function krystal_init( $config ) {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Krystal_About_Page ) ) {
				self::$instance = new Krystal_About_Page;				
				self::$instance->config = $config;
				self::$instance->krystal_setup_config();
				self::$instance->krystal_setup_actions();				
			}
		}

		/**
		 * Setup the class props based on the config array.
		 */
		public function krystal_setup_config() {
			$theme = wp_get_theme();
			if ( is_child_theme() ) {
				$this->theme_name = $theme->parent()->get( 'Name' );
				$this->theme      = $theme->parent();
			} else {
				$this->theme_name = $theme->get( 'Name' );
				$this->theme      = $theme->parent();
			}
			$this->theme_version = $theme->get( 'Version' );
			$this->theme_slug    = $theme->get_template();			
			$this->notification  = isset( $this->config['notification'] ) ? $this->config['notification'] : ( '<p>' . sprintf( 'Welcome! Thank you for choosing %1$s ! To take full advantage of this theme, please make sure you visit our %2$swelcome page%3$s.', $this->theme_name, '<a href="' . esc_url( admin_url( 'themes.php?page=' . $this->theme_slug . '-theme-info' ) ) . '">', '</a>' ) . '</p><p><a href="' . esc_url( admin_url( 'themes.php?page=' . $this->theme_slug . '-theme-info' ) ) . '" class="button" style="text-decoration: none;">' . sprintf( 'Get started with %s', $this->theme_name ) . '</a></p>' );		
		}

		/**
		 * Setup the actions used for this page.
		 */
		public function krystal_setup_actions() {
			
			/* activation notice */
			add_action( 'load-themes.php', array( $this, 'krystal_activation_admin_notice' ) );						
		}		
		

		/**
		 * Adds an admin notice upon successful activation.
		 */
		public function krystal_activation_admin_notice() {
			global $pagenow;
			if ( is_admin() && ( 'themes.php' == $pagenow ) && isset( $_GET['activated'] ) ) {
				add_action( 'admin_notices', array( $this, 'krystal_about_page_welcome_admin_notice' ), 99 );
			}
		}

		/**
		 * Display an admin notice linking to the about page
		 */
		public function krystal_about_page_welcome_admin_notice() {
			if ( ! empty( $this->notification ) ) {
				echo '<div class="updated notice is-dismissible">';
				echo wp_kses_post( $this->notification );
				echo '</div>';
			}
		}		

	}
}


/**
 *  Adding a About Krystal page 
 */
add_action('admin_menu', 'krystal_add_menu');

function krystal_add_menu() {
     add_theme_page(esc_html__('About Krystal Theme','krystal'), esc_html__('About Krystal Theme','krystal'),'manage_options', esc_html__('krystal-theme-info','krystal'), esc_html__('krystal_theme_info','krystal'));
}

/**
 *  Callback
 */
function krystal_theme_info() {
?>
	<div class="krystal-info">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="title">
						<h2><?php esc_html_e( 'Thank you for using Krystal free WordPress theme', 'krystal' ); ?></h2>
						<div class="title-content">
							<p><?php esc_html_e( 'Krystal is a WordPress theme built for most popular drag and drop page builder Elementor. Krystal comes with 9+ unique demos and with 1 click demo import feature. Krystal is SEO friendly, mobile responsive, translation ready theme and is compatible with most of the popular plugins. We also provide support to the free version.', 'krystal' ); ?></p>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<div class="section-box">
						<div class="icon">
							<span class="dashicons dashicons-visibility"></span>
						</div>
						<div class="heading">
							<h3><a href="<?php echo esc_url(KRYSTAL_THEME_URL); ?>" target="_blank"><?php esc_html_e( 'VIEW DEMO', 'krystal' ); ?></a></h3>
						</div>						
					</div>
				</div>
				<div class="col-md-2">
					<div class="section-box">
						<div class="icon">
							<span class="dashicons dashicons-format-aside"></span>
						</div>
						<div class="heading">
							<h3><a href="<?php echo esc_url(KRYSTAL_THEME_DOC_URL); ?>" target="_blank"><?php esc_html_e( 'VIEW DOCUMENTATION', 'krystal' ); ?></a></h3>
						</div>						
					</div>
				</div>
				<div class="col-md-2">
					<div class="section-box">
						<div class="icon">
							<span class="dashicons dashicons-video-alt2"></span>
						</div>
						<div class="heading">
							<h3><a href="<?php echo esc_url(KRYSTAL_THEME_VIDEOS_URL); ?>" target="_blank"><?php esc_html_e( 'VIDEO TUTORIALS', 'krystal' ); ?></a></h3>
						</div>						
					</div>
				</div>
				<div class="col-md-2">
					<div class="section-box">
						<div class="icon">
							<span class="dashicons dashicons-sos"></span>
						</div>
						<div class="heading">
							<h3><a href="<?php echo esc_url(KRYSTAL_THEME_SUPPORT_URL); ?>" target="_blank"><?php esc_html_e( 'ASK FOR SUPPORT', 'krystal' ); ?></a></h3>
						</div>						
					</div>
				</div>
			
				<div class="col-md-2">
					<div class="section-box">
						<div class="icon">
							<span class="dashicons dashicons-star-filled"></span>
						</div>
						<div class="heading">
							<h3><a href="<?php echo esc_url(KRYSTAL_THEME_RATINGS_URL); ?>" target="_blank"><?php esc_html_e( 'RATE OUR THEME', 'krystal' ); ?></a></h3>
						</div>						
					</div>
				</div>
				<div class="col-md-2">
					<div class="section-box">
						<div class="icon">
							<span class="dashicons dashicons-admin-tools"></span>
						</div>
						<div class="heading">
							<h3><a href="<?php echo esc_url(KRYSTAL_THEME_CHANGELOGS_URL); ?>" target="_blank"><?php esc_html_e( 'VIEW CHANGELOGS', 'krystal' ); ?></a></h3>
						</div>						
					</div>
				</div>
			</div>	
			<div class="row">
				<div class="col-md-12">
					<div class="comp-box">
						<center><h2 class="table-heading"><?php esc_html_e( 'FREE VS PRO', 'krystal' ); ?></h2></center>
						<div class="comp-table">
							<table>
								<thead> 
									<tr> 
									 	<td class="thead-column1"><strong><h4><?php esc_html_e( 'Feature', 'krystal' ); ?></h4></strong></td>
										<td class="thead-column2"><strong><h4><?php esc_html_e( 'Krystal', 'krystal' ); ?></h4></strong></td>
										<td class="thead-column3"><strong><h4><?php esc_html_e( 'PRO Addon Plugin', 'krystal' ); ?></h4></strong></td>
									</tr> 
								</thead>
								<tbody>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Parallax Background Image', 'krystal' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Favicon, Logo, Title and Tagline Customization', 'krystal' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Customizer Theme Options', 'krystal' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Contact Form', 'krystal' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Sidebar Options (Full, Left and Right)', 'krystal' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Color Settings', 'krystal' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Footer Widget Columns', 'krystal' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Sticky Header Option', 'krystal' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( '1 Click Demo Import', 'krystal' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Breadcrumb Display', 'krystal' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Elementor Page Builder', 'krystal' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-yes"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Top Social Icons', 'krystal' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( '600+ Google Fonts', 'krystal' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Default Slider', 'krystal' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Typography', 'krystal' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Header Search', 'krystal' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'WooCommerce Ready', 'krystal' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Extra Customizer Settings', 'krystal' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Extra Premium Demos', 'krystal' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr>
									<tr> 
					 					<td class="tbody-column1"><?php esc_html_e( 'Priority Support', 'krystal' ); ?></td>
					 					<td class="tbody-column2"><span class="dashicons dashicons-no-alt"></span></td>
					 					<td class="tbody-column3"><span class="dashicons dashicons-yes"></span></td>
									</tr> 
									<tr class="last-row"> 
					 					<td class="tbody-column1"></td>
					 					<td class="tbody-column2"></td>
					 					<td class="tbody-column3"><a class="button button-primary button-large" href="<?php echo esc_url(KRYSTAL_THEME_PRO_URL); ?>" target="_blank"><?php esc_html_e( 'Upgrade to PRO', 'krystal' ); ?></a></td>
									</tr> 
				   				</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>		
		</div>		
	</div>
<?php
}
