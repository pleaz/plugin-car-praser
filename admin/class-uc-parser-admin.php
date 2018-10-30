<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://iha6.com
 * @since      1.0.0
 *
 * @package    Uc_Parser
 * @subpackage Uc_Parser/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Uc_Parser
 * @subpackage Uc_Parser/admin
 * @author     pleaz <oprstfaq@gmail.com>
 */
class Uc_Parser_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles($hook) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Uc_Parser_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Uc_Parser_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ( 'toplevel_page_uc-parser' != $hook ) {
			return;
		}

			//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/uc-parser-admin.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . '_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . '_awesome', 'https://use.fontawesome.com/releases/v5.3.1/css/all.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . '_select', 'https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.2/dist/css/bootstrap-select.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Uc_Parser_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Uc_Parser_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ( 'toplevel_page_uc-parser' != $hook ) {
			return;
		}

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/uc-parser-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'_bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array( ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'_popper', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js', array( ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'_select', 'https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.2/dist/js/bootstrap-select.min.js', array( ), $this->version, false );

	}

	/**
	 * Add an options page under the Settings submenu
	 *
	 * @since  1.0.0
	 */
	public function options_page() {

		add_menu_page(
			__( 'Used Cars Parser', 'uc-parser' ),
			__( 'UC Parser', 'uc-parser' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);

		add_role( 'stm_dealer', 'STM Dealer', array( 'read' => true, 'level_0' => true ) );

	}

	/**
	 * Render the options page for plugin
	 *
	 * @since  1.0.0
	 */
	public function display_options_page() {
		include_once 'partials/uc-parser-admin-display.php';
	}


	public function sending_callback() {

		if($_POST['check'] == 'dealers') {

			$error = <<<HTML
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong> Some error with crawling. Please try again.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
HTML;
			$notice = <<<HTML
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Notice!</strong> New Dealers not found.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
HTML;
			$success = <<<HTML
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> %s new Dealers found.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
HTML;

			$request = wp_remote_get( 'http://q.iha6.com:8751/crawl.json?spider_name=dealers&url=https://www.usedcarsni.com/search_results.php?search_type=15%26dcat[]=1%26pagepc0=1', ['timeout' => 7200] );

			if( is_wp_error( $request ) ) {
				echo json_encode(['status'=>$error, 'message'=>null]); wp_die(); // Bail early
			}

			$body = wp_remote_retrieve_body( $request );
			$data = json_decode( $body );

			if($data->status != 'ok') {
				echo json_encode(['status'=>$error, 'message'=>null]); wp_die();
			}

			if(!$data->stats->item_scraped_count) {
				echo json_encode(['status'=>$notice, 'message'=>null]); wp_die();
			} else {
				echo json_encode(['status'=>sprintf($success,$data->stats->item_scraped_count), 'message'=>$data->items]);
				wp_die();
			}
		} elseif ($_POST['check'] == 'save_dealers') {

			$success = <<<HTML
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> %s Dealers imported.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
HTML;

			if($_POST['dealer_list']) {
			    $i = 0;
				foreach ($_POST['dealer_list'] as $item):
					$userdata = array(
						'user_login'  =>  substr(str_replace(['directory','/'],'',strtolower($item['url'])), 0, 60), //.wp_rand( 1, 10000 ),
						'nickname'    =>  $item['name'],
						'display_name' => $item['name'],
						'role'  => 'stm_dealer',
						'user_pass'   =>  NULL
					);
					$new_userid = wp_insert_user( $userdata );
                    if(empty($new_userid->errors['existing_user_login'])){
						add_user_meta( $new_userid, 'stm_dealer_url', $item['url'], true );
                        $i++;
                    } else {
                        continue;
                    }
				endforeach;
				$all = $i; # $all = count($_POST['dealer_list']);
			} else {
				$all = 0;
			}

			echo json_encode(['status'=>sprintf($success,$all), 'message'=>null]); wp_die();

		} elseif ($_POST['check'] == 'get_dealers') {

			$users = get_users( ['role'  => 'stm_dealer', 'meta_key' => 'stm_dealer_url'] );
			$users_array = [];
			if($users){
				foreach ($users as $user):
					$users_array[$user->ID] = $user->display_name;
				endforeach;
				echo json_encode(['status'=>'ok', 'message'=>$users_array]); wp_die();
			}

		} elseif ($_POST['check'] == 'sync_cars') {

			$error = <<<HTML
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong> Some error with crawling. Please try again.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
HTML;

			$notice = <<<HTML
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Notice!</strong> 0 cars founded.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
HTML;

			$success = <<<HTML
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> %s cars found and imported.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
HTML;

			if($_POST['dealer']) {
				$urls = get_user_meta($_POST['dealer'], 'stm_dealer_url');
				$request = wp_remote_get( 'http://q.iha6.com:6787/crawl.json?spider_name=cars&url=https://www.usedcarsni.com'.$urls['0'], ['timeout' => 7200] );

				if( is_wp_error( $request ) ) {
					echo json_encode(['status'=>$error, 'message'=>null]); wp_die(); // Bail early
				}

				$body = wp_remote_retrieve_body( $request );
				$data = json_decode( $body );

				if($data->status != 'ok') {
					echo json_encode(['status'=>$error, 'message'=>null]); wp_die();
				}

				if(!$data->stats->item_scraped_count) {
					echo json_encode(['status'=>$notice, 'message'=>null]); wp_die();
				} else {

					$args = array(
						'post_type' => 'listings',
						'posts_per_page' => -1,
						'meta_query' => array(
							'relation' => 'AND',
							array(
								'key' => 'uc_parser',
								'compare' => '=',
								'value' => 1
							),
							array(
								'key' => 'stm_car_user',
								'compare' => '=',
								'value' => $_POST['dealer']
							)
						)
					);
					$posts = new WP_Query($args);
					if ($posts->have_posts()) {
						while ($posts->have_posts()) {
							$posts->the_post();
							$attachments = get_children(['post_type'=>'attachment', 'post_parent'=>$posts->post->ID]);
							if($attachments){
								foreach($attachments as $attachment) {
									wp_delete_attachment($attachment->ID, true);
								}
							}
							wp_delete_post($posts->post->ID, true);
						}
						wp_reset_postdata();
					}
					//wp_die();

					foreach ($data->items as $item){
						$post_data = array(
							'post_type' => 'listings',
							'post_title' => $item->title,
							'post_content' => $item->description ? $item->description : '',
							'post_status' => 'publish',
						);
						$post_id = wp_insert_post($post_data, true);

						if (!empty($item->condition)) {
							wp_add_object_terms($post_id, $item->condition, 'condition');
							update_post_meta($post_id, 'condition', sanitize_title($item->condition));
						}

						if (!empty($item->make)) {
							wp_add_object_terms($post_id, $item->make, 'make');
							update_post_meta($post_id, 'make', sanitize_title($item->make));
						}

						if (!empty($item->model)) {
							$model_id = wp_add_object_terms($post_id, $item->model, 'serie');
							if (!empty($item->make)) update_option('stm_parent_taxonomy_'.$model_id[0], sanitize_title($item->make));
							update_post_meta($post_id, 'serie', sanitize_title($item->model));
						}

						if (!empty($item->year)) {
							update_post_meta($post_id, 'ca-year', $item->year);
						}

						if (!empty($item->mileage)) {
							update_post_meta($post_id, 'mileage', $item->mileage);
						}

						if (!empty($item->variant)) { // null
							update_post_meta($post_id, 'variant', $item->variant);
						}

						if (!empty($item->body)) {
							wp_add_object_terms($post_id, $item->body, 'body');
							update_post_meta($post_id, 'body', sanitize_title($item->body));
						}

						if (!empty($item->exterior_color)) {
							wp_add_object_terms($post_id, $item->exterior_color, 'exterior-color');
							update_post_meta($post_id, 'exterior-color', sanitize_title($item->exterior_color));
						}

						if (!empty($item->door)) {
							wp_add_object_terms($post_id, $item->door, 'door');
							update_post_meta($post_id, 'door', sanitize_title($item->door));
						}

						if (!empty($item->transmission)) {
							wp_add_object_terms($post_id, $item->transmission, 'transmission');
							update_post_meta($post_id, 'transmission', sanitize_title($item->transmission));
						}

						if (!empty($item->engine_size)) {
							update_post_meta($post_id, 'engine', $item->engine_size);
						}

						if (!empty($item->fuel_type)) {
							wp_add_object_terms($post_id, $item->fuel_type, 'fuel');
							update_post_meta($post_id, 'fuel', sanitize_title($item->fuel_type));
						}

						if (!empty($item->co_emission)) {
							update_post_meta($post_id, 'co2-emission', $item->co_emission);
						}

						if (!empty($item->tax_cost)) {
							update_post_meta($post_id, 'tax-cost', $item->tax_cost);
						}

						if (!empty($item->price)) {
							update_post_meta($post_id, 'stm_genuine_price', $item->price);
							update_post_meta($post_id, 'price', $item->price);
						}

						if (!empty($item->features)) {
							wp_add_object_terms($post_id, $item->features, 'stm_additional_features');
							// wp_set_object_terms also can used (true four param)
							update_post_meta($post_id, 'additional_features', implode(',', $item->features));
						}

						if (!empty($_POST['dealer'])) { # User ID same for all == Dealer
							update_post_meta($post_id, 'stm_car_user', $_POST['dealer']);
						}

						update_post_meta($post_id, 'uc_parser', '1'); # my label for deleting

						/* images */
						if (!empty($item->images)) {
							//require_once(ABSPATH . 'wp-admin/includes/image.php');
							$upload_dir = wp_upload_dir();
							$attachments_ids = [];
							foreach ($item->images as $k => $image_url):
								$image_data = file_get_contents($image_url);
								$filename = basename($image_url);
								if(wp_mkdir_p($upload_dir['path'])) {
									$file = $upload_dir['path'] . '/' . $filename;
								} else {
									$file = $upload_dir['basedir'] . '/' . $filename;
								}
								file_put_contents($file, $image_data);
								$wp_filetype = wp_check_filetype($filename, null);
								$attachment = array(
									'guid' => $upload_dir['url'] . '/' . $filename,
									'post_mime_type' => $wp_filetype['type'],
									'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
									'post_content' => '',
									'post_status' => 'inherit'
								);
								$attach_id = wp_insert_attachment($attachment, $file, $post_id);
								$attach_data = wp_generate_attachment_metadata($attach_id, $file);
								wp_update_attachment_metadata($attach_id, $attach_data);
								$attachments_ids[$k] = $attach_id;
							endforeach;
							ksort($attachments_ids);
							if (!empty($attachments_ids)) {
								update_post_meta($post_id, '_thumbnail_id', reset($attachments_ids));
								array_shift($attachments_ids);
							}
							update_post_meta($post_id, 'gallery', $attachments_ids);
						}

					}

					echo json_encode(['status'=>sprintf($success,$data->stats->item_scraped_count), 'message'=>null]);
					wp_die();
				}

			}

		}

		wp_die();
	}

}
