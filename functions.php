<?php

if ( ! isset( $content_width ) )
	$content_width = 648;

include get_template_directory() . '/hacklab_post2home/hacklab_post2home.php';
include get_template_directory() . '/widgets/contribua/contribua.php';
include get_template_directory() . '/widgets/banner/banner.php';
require_once get_template_directory() . '/lib/admin.class.php';
require_once get_template_directory() . '/lib/query.class.php';
require_once get_template_directory() . '/lib/contents.class.php';

class Ethymos{
	
	function mobilize_setup() {
	/**
	* Add default posts and comments RSS feed links to head
	*
	*/	
		add_theme_support( 'automatic-feed-links' );
	}
	
	public function delibera_style(){
		wp_enqueue_style('delibera_style', WP_CONTENT_URL . '/plugins/delibera/themes/delibera_style.css');
	}
	
	public $tamanho_resumo, $admin, $contents, $query;
	/**
	* Registra actions do wordpress
	*
	*/
	public function __construct(){
		
		$this->admin = new Ethymos_Admin();
		$this->query = new Ethymos_Query();
		$this->content = new Ethymos_Contents();
		
		//Define tamanho do resumo gerado pela função the_excerpt();
		$this->tamanho_resumo = 40;
		
		//Recursos que o tema suporta
		add_theme_support('post-thumbnails');
		add_theme_support('custom-backgrounds'); 
		//add_theme_support('custom-header');
		
		add_action('wp_enqueue_scripts', array($this, 'css'));
		add_action('wp_enqueue_scripts', array($this, 'javascript'));
		add_action('after_setup_theme', array($this, 'cria_categoria_destaques'));
		add_action('wp_head', array($this, 'custom_css'));
		
		add_filter('excerpt_length', array($this, 'tamanho_resumo'), 1);
		
		
		/**
	    * Widgets
		*/		
		register_sidebar(array(
				'name' => 'sidebar',
				'id' => 'sidebar',
				'before_widget' => '<div id="%1$s" class="widget %2$s sidebar-box" >',
				'after_widget' => '</div>',
				'before_title' => '<h2>',
				'after_title' => '</h2>',
		));
		
		register_sidebar(array(
				'name' => 'sidebar-footer',
				'id' => 'sidebar-footer',
				'before_widget' => '<div id="%1$s" class="widget %2$s sidebar-footer span4">',
				'after_widget' =>'</div>',
				'before_title' => '</h2>',
				'after_title' => '</h2>',
		));
		
		/**
		* Tamanhos de imagens
		*/
		add_image_size('destaques-home', 274, 122, true);
		add_image_size('banner-home', 270, 182, true);
		add_image_size('foto-equipe', 104, 138, true);
		
		/**
		* Shortcodes
		*/
		add_shortcode('subtitulo', array($this, 'shortcode_subtitulo'));
		add_shortcode('lista-equipe', array($this, 'shortcode_equipe'));
		/**
		* Menus
		*/
		register_nav_menus(array(
			'rodape' => 'Menu do rodapé'
		));
		
		/**
		* Comment reply
		*/
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	* Função responsavel por controlar as folhas de estilo do site
	*/
	public function css(){
		$path = get_template_directory_uri() . '/css';
		wp_register_style('bootstrap-responsive', $path . '/bootstrap-responsive.min.css');
		wp_register_style('bootstrap', $path . '/bootstrap.min.css');		
		wp_register_style('geral', get_stylesheet_directory_uri() . '/style.css', array('bootstrap'));
		wp_register_style('flexslider', $path . '/flexslider.css');		
		
		wp_enqueue_style('bootstrap',5);
		wp_enqueue_style('bootstrap-responsive');
		wp_enqueue_style('geral');		
		wp_enqueue_style('flexslider');		
		
	}
	
	/**
	* Controla os arquivos javascript do site
	*
	*/
	public function javascript(){
		$path = get_template_directory_uri().'/js';

		wp_enqueue_script('jquery');
		wp_enqueue_script('modernizr', $path.'/modernizr.js');
		wp_enqueue_script('responsive', $path.'/jquery.flexslider-min.js');
		wp_enqueue_script('flexslider', $path.'/responsive.js');
		wp_enqueue_script('mobilizejs', $path.'/mobilize.js');
		wp_enqueue_script('jquery-tools');
	}
	
	/**
	* Função para criar a categoria dos destaques automaticamente qunado o tema for ativado
	*
	*/
	public function cria_categoria_destaques(){
		if(!term_exists('Destaques', 'category')){
			$this->categoria_destaques = wp_insert_term('Destaques', 'category', array('description' => _x('Destaques da capa do site', 'descricao-categoria', '_mobilize')));
		}
	}
		
	/**
	* Define o tamanho dos resumos do site gerados pela tag the_excert(). Deve ser utilizado no filter excerpt_length
	* não alterar o valor aqui, sete o valor para a variável tamanho_resumo
	*/
	public function tamanho_resumo($length){
		return $this->tamanho_resumo;
	}
	
	/**
	* 
	*
	*/
	public function shortcode_subtitulo($atts, $content){
		return '<div class="subtitulo borda-cor-1">' . $content . '</div>';
	}
	
	/**
	* 
	*
	*/
	public function shortcode_equipe(){
		ob_start();
		require get_template_directory() . '/content-equipe.php';
		$r = ob_get_contents();
		ob_end_clean();
		return $r;
	}
	
	/**
	* 
	*
	*/
	public function custom_css(){
		include get_template_directory() . '/custom-css.php';
	}
}

$ethymos = new Ethymos();

function pagination_function()
{
	// Get total number of pages
	global $wp_query;
	$total = $wp_query->max_num_pages;
	// Only paginate if we have more than five page
	if ( $total > 1 )  {
		// Get the current page
		if ( !$current_page = get_query_var('paged') )
			$current_page = 1;

			$big = 999999999;
			// Structure of "format" depends on whether we’re using pretty permalinks
			$permalink_structure = get_option('permalink_structure');
			$format = empty( $permalink_structure ) ? '&page=%#%' : 'page/%#%/';
			echo paginate_links(array(
					'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
					'format' => $format,
					'current' => $current_page,
					'total' => $total,
					'mid_size' => 2,
					'type' => 'list'
			));
	}
}

/**
 * Add Facebook scripts for the theme
 *
 * @todo Create an option page (or maybe in Customizer) to insert App ID
 */
function mobilize_fb_comments_box() {

	$fb_appid = get_theme_mod( 'mobilize_facebook_appid' );
	?>

	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&appId=<?php echo $fb_appid; ?>&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	
	<script>
		var siteLeadUrl = "<?php echo get_template_directory_uri() . "/js/site-lead.js" ?>";
		Modernizr.load({
	        test: Modernizr.mq("only screen and (min-width:64.063em)"),
	        yep: siteLeadUrl
		});
	</script>

	<?php
}
add_action( 'wp_footer', 'mobilize_fb_comments_box' );

/**
 * Add Facebook OpenGraph meta properties
 */
function mobilize_fb_opengraph() {
	$fb_appid = get_theme_mod( 'mobilize_facebook_appid' );

	if ( ! empty ( $fb_appid ) ) {
		echo '<meta property="fb:app_id" content="' . $fb_appid . '"/>';
	}	
}
add_action( 'wp_head', 'mobilize_fb_opengraph' );

