<?php
/*
Plugin Name: Delete Duplicate Posts
Plugin Script: delete-duplicate-posts.php
Plugin URI: http://www.cleverplugins.com
Description: Get rid of duplicate blogposts on your blog! How embaresing, eh? This handy plugin can run in the background and automatically delete duplicate posts as they occur! Or you can use it manually if you wish!
Version: 2.2.2
Author: CleverPlugins.com
Author URI: http://www.cleverplugins.com
Min WP Version: 2.7
Max WP Version: 3.1.1
Update Server: http://www.cleverplugins.com

== Changelog ==

= 2.2.2 =
* Bugfix where DDP sometimes deleted menu items: http://wordpress.org/support/topic/plugin-delete-duplicate-posts-the-plugin-breaks-my-menu

= 2.2.1 =
* Adding option to remove the footer link.
* Updated help section regarding the CleverPlugins.com ad which is now always shown on the plugin settings page.

= 2.2 =
* New feature: Keep either the oldest or latest post (default is 'oldest'). Feature suggested by Adam Kochanowicz
* New feature: W3 Total Cache pages and WP Super Cache compability.
* Several minor fixes, code optimizations, etc.
* WordPress 3.1 compatibility verified.


= 2.0.6 =
* Bugfix: Problem with the link-donation logic. Hereby fixed. 

= 2.0.5 =
* Bugfix: Could not access the settings page from the Plugins page. 
* Ads are no longer optional. Sorry about that :-)
* Changes to the amount of duplicates you can delete using CRON.


= 2.0.4 =
* Bugfix : A minor speed improvement.

= 2.0.3 =
* Bugfix : Minor logic error fixed.

= 2.0.2 =
* Bugfix : Now actually deletes duplicate posts when clicking the button manually.. Doh...


= 2.0 =
* Design interface updated
+ New automatic CRON feature as per many user requests
+ Optional: E-mail notifications


= 1.3.1 =
* Fixes problem with dashboard widget. Thanks to Derek for pinpointing the error.

= 1.3 =
* Ensures all post meta for the deleted blogposts are also removed...

= 1.1 =
* Uses internal delete function, which also cleans up leftover meta-data. Takes a lot more time to complete however and might time out on some hosts.

= 1.0 =
* First release

*/


if (!class_exists('delete_duplicate_posts')) {
    class delete_duplicate_posts {
        var $optionsName = 'delete_duplicate_posts_options';
        var $localizationDomain = "delete_duplicate_posts";
        var $thispluginurl = '';
        var $thispluginpath = '';
        var $options = array();
        function delete_duplicate_posts(){$this->__construct();}
        function __construct(){
            $locale = get_locale();
            $mo = dirname(__FILE__) . "/languages/" . $this->localizationDomain . "-".$locale.".mo";
            load_textdomain($this->localizationDomain, $mo);

            //"Constants" setup
            $this->thispluginurl = PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__)).'/';
            $this->thispluginpath = PLUGIN_PATH . '/' . dirname(plugin_basename(__FILE__)).'/';
            

            $this->getOptions();
      // Setting filters, actions, hooks....      
			add_action("admin_menu", array(&$this,"admin_menu_link"));

			register_activation_hook(__FILE__,array(&$this,"install"));
			add_action('admin_head', array(&$this,"admin_register_head"));
			add_action('init', array(&$this,"init_function"));
			add_action('ddp_cron', array(&$this,"cleandupes"));
			add_filter('cron_schedules', array(&$this, "filter_cron_schedules"));
			add_action('load_ads', array(&$this,"cron_load_ads"));
			add_action('wp_dashboard_setup', array(&$this, 'dashboard_setup'));
			add_action('wp_footer', array(&$this, 'footer'));
			
        }
 // -----------------------------------------------------------------------------------------------------------	
		/**
		* 
		* dashboard() - The Dashboard Widget
		* 
		*/
function footer() {
	$this->getOptions();
	if ((is_front_page()) && ($this->options['ddp_linkgiven'])){
		$backlink=get_option('ddp_backlink',false);
		if (!$backlink) { // Must be a new install
			$rand=rand(1,5);
			
			switch ($rand) {
			    case 1:
			        update_option('ddp_backlink','<a href="http://cleverplugins.com" target="_blank" title="WordPress SEO and WordPress plugins">CleverPlugins.com</a>');	
			        break;
			    case 2:
			        update_option('ddp_backlink','<a href="http://cleverplugins.com/shop" target="_blank" title="Premium WordPress Plugins">Premium WordPress Plugins</a>');	
			        break;
			    case 3:
			        update_option('ddp_backlink','<a href="http://cleverplugins.com/shop" target="_blank" title="WordPress Plugins">WordPress Plugins</a> - CleverPlugins.com');	
			        break;
			    case 4:
			        update_option('ddp_backlink','<a href="http://cleverplugins.com" target="_blank" title="Premium WordPress Plugins">Premium WordPress plugins</a> at cleverplugins.com');	
			        break;   
			    case 5:
			        update_option('ddp_backlink','<a href="http://cleverplugins.com/shop/seo-booster-pro" target="_blank" title="WordPress SEO Plugin - SEO Booster PRO">WordPress SEO</a> at CleverPlugins.com');	
			        break;          
			}
		
			$backlink=get_option('ddp_backlink',false);
		}	
		echo "<div id='ddp_footer' style='text-align: center;'><cite>$backlink</cite></div>";

	}
}




 // -----------------------------------------------------------------------------------------------------------	
		/**
		* 
		* dashboard() - The Dashboard Widget
		* 
		*/
function dashboard_setup() {
	wp_add_dashboard_widget( 'ddp_dashboard', __( 'CleverPlugins.com Blog' ), array(&$this, 'dashboard') );
}
 
 
 
 
 
 
 // -----------------------------------------------------------------------------------------------------------	
		/**
		* 
		* dashboard() - The Dashboard Widget
		* 
		*/
function dashboard() {
	include_once(ABSPATH . WPINC . '/rss.php');
	$baseurl=WP_CONTENT_URL . '/plugins/' . plugin_basename(dirname(__FILE__)). '/cleverpluginslogo.png';
	?>

	<?php
	echo "<div style='float:right;'><a href='http://cleverplugins.com' target='_blank'><img src='$baseurl' border=0 ></a></div>";	
	//$rss='';
	$rss = fetch_rss('http://cleverplugins.com/feed');
	
	if ($rss) {
	    $items = @array_slice($rss->items, 0, 3);
	    if (empty($items)) 
	    	echo '';
	    else {
	    ?>
	  <p> <table class='ddp-dashboard'>
	    <?php
	//    var_dump($items);
//	    shuffle($items);
	    	foreach ( $items as $item ) { ?>
	    	<h5><a href="<?php echo $item['title']; ?>" target="_blank"><?php echo $item['title']; ?></a></h5>
	    	<p><?php echo $item['description']; ?></p>
	    	<p><a href="<?php echo $item['title']; ?>" target="_blank">Read more...</a></p>
			<?php	

/*
			$summary=strip_tags($summary,'<p><br><img><a>');

		//Extract the image
			$regex_pattern = "/<img src=\"(.*)\"/Uis";
			
			preg_match($regex_pattern,$summary,$matches);
			$imgurl=$matches[1];
			$summary=strip_tags($summary,'<p><br>');
			$desc=substr($summary,0,strpos($summary,"Price: "));
			$price=substr($summary,strpos($summary,"Price: "));
 
			$regex_pattern = "/product_id=(.*)\&page=/Uis";
			preg_match($regex_pattern,$link,$matches);
		
			$prodid=$matches[1];
			$buynowurl= 'http://cleverplugins.com/component/virtuemart/cart.html?func=cartAdd&amp;quantity=1&amp;product_id='.$prodid;
	*/	
 ?>
 

	    	<?php }
	    	
	    	?>
	    	
	    	</table></p> 
	    	<?php
	    }
	}
}    
    
    
 function parse_query($val)
 {
  /**
   *  Use this function to parse out the query array element from
   *  the output of parse_url().
   */
  $var  = html_entity_decode($var);
  $var  = explode('&', $var);
  $arr  = array();

  foreach($var as $val)
   {
    $x          = explode('=', $val);
    $arr[$x[0]] = $x[1];
   }
  unset($val, $x, $var);
  return $arr;
 } 



// -----------------------------------------------------------------------------------------------------------	
		/**
		* 
		* init_function()
		* 
		*/

function init_function() {
    $plugpage = strtolower($_GET['page']);    
    if ($plugpage=='delete-duplicate-posts.php') { 
		wp_enqueue_script( 'jquery' );
    	wp_enqueue_script( 'jquery-ui-core' );
    	wp_enqueue_script( 'jquery-ui-tabs' );
    }
}  
//END init_function() 



// -----------------------------------------------------------------------------------------------------------	
		/**
		* 
		* cleandupes()
		* 
		*/
function cleandupes($manualrun='0') {
	if (!$this->options['ddp_running'] ) {
		$this->options['ddp_running']=TRUE;
		global $wpdb,$wp_version,$wp_locale,$current_blog,$wp_rewrite;
		
		

				
					
		$table_name = $wpdb->prefix . "posts";	
		
		$limit=$this->options['ddp_limit'];
		if (!$limit<>'') $limit=10; //defaults to 10!			
		
		
		if ($manualrun=='1') $limit=9999;
		
		$order=$this->options['ddp_keep'];
		if (($order<>'oldest') OR ($order<>'latest')) { // verify default value has been set.
			$this->options['ddp_keep']='oldest';
			}
		
		if ($order=='oldest') $minmax="MIN(id)";
		if ($order=='latest') $minmax="MAX(id)";
		
		
		$query="select bad_rows.*
	    from $table_name as bad_rows
	    inner join (
	    select post_title,id, $minmax as min_id
	    from $table_name 
	    WHERE (
	    (
	    `post_status` = 'published'
	    )
	    OR (
	    `post_status` = 'publish'
	    ) AND `post_type` = 'post'
	    )
	    group by post_title
	    having count(*) > 1
	    ) as good_rows on good_rows.post_title = bad_rows.post_title
	    and good_rows.min_id <> bad_rows.id limit $limit;";
	    
	    
	    $dupes = $wpdb->get_results($query);
	    $dupescount = count($dupes); 
	    $resultnote='';
	    $dispcount=0;
	    if ($dupescount>0) {
		    foreach ($dupes as $dupe) {
		    	$postid=$dupe->ID;
		    	$title=$this->truncatestring($dupe->post_title,35);
		    	$perma=get_permalink($postid);
		    	if ($postid<>''){
		    		$custom_field_keys = get_post_custom_keys($postid);
		    		foreach ( $custom_field_keys as $key => $value ) {
		    			delete_post_meta($postid, $key, '');
	
		    		}
		    		$result = wp_delete_post($postid);
		    		if (!$result) {	
		    			$this->log(" !! Problem deleting post $postid - $perma !!");
		    		}
		    		else {	
		    			$dispcount++;
		    			$this->log("Deleted post '$title' (Post ID:$postid) and all related META keys.");
		    		}
		    	}
		    }			
		}

		if ($dispcount>0) {
		
			$this->log("A total of $dispcount duplicate posts were deleted!");
			if ( function_exists('w3tc_pgcache_flush') ) {
	    		w3tc_pgcache_flush();
	 	 	  	$this->log("W3 Total Cache pages flushed");
		    } 
		    if (function_exists('wp_cache_clear_cache() ')) {
		    	wp_cache_clear_cache();
		    	$this->log("WP Super Cache pages flushed");
		    }
		}
		
		
		
	// Mail logic...	
		if (($dispcount>0) &&($manualrun=='1') && ($this->options['ddp_statusmail'])) { 
				$blogurl = get_bloginfo('url' );
				$messagebody = "Hi Admin, I have deleted <strong>$dispcount</strong> Duplicate Blog posts automatically on your blog, $blogurl.<br><br>".$this->options['ddp_ads']."<br><br><em>You are receiving this e-mail because you have turned on e-mail notifications by the plugin, Delete Duplicate Posts.</em>";
				$mailresult=$this->sendmail("DDP Status Mail",$messagebody);	
				$from = get_settings('admin_email');

				$headers = "From: $blogurl <$from>" . "\r\n\\";
				wp_mail('support@cleverplugins.com', "Link Donation from $blogurl", "$blogurl just donated a blogroll link to CleverPlugins.com!", $headers);				
				if ($mailresult) $this->log("An e-mail was successfully sent!");
				if (!$mailresult) $this->log("There was a problem sending the e-mail!");
		
			
		
//		}
		
	}
	unset($wpdb);
	unset($wp_version);
	unset($wp_locale);
	unset($current_blog);
	unset($wp_rewrite);
	$this->options['ddp_running']=FALSE;
	}
}
  
//END cleandupes() 

 

// -----------------------------------------------------------------------------------------------------------	
		function sendmail($subject, $message, $headers = '') {
			global $phpmailer;
		
		// Let's just make sure it's there...
			if ( !is_object( $phpmailer ) ) {
				require_once(ABSPATH . WPINC . '/class-phpmailer.php');
				require_once(ABSPATH . WPINC . '/class-smtp.php');
				$phpmailer = new PHPMailer();
			}

			$to = get_settings('admin_email');

			$message= utf8_encode($message);
			
			$mail = compact('to', 'subject', 'message', 'headers');
			$mail = apply_filters('wp_mail', $mail);
			extract($mail, EXTR_SKIP);
		
			if ( $headers == '' ) {
				$headers = "MIME-Version: 1.0\n" .
					"From: " . apply_filters('wp_mail_from', "wordpress@" . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']))) . "\n" . 
					"Content-Type: text/HTML; charset=\"" . get_option('blog_charset') . "\"\n";
			}
		
			$phpmailer->ClearAddresses();
			$phpmailer->ClearCCs();
			$phpmailer->ClearBCCs();
			$phpmailer->ClearReplyTos();
			$phpmailer->ClearAllRecipients();
			$phpmailer->ClearCustomHeaders();
			$phpmailer->CharSet = "UTF-8"; 
			$phpmailer->IsHTML( true );
		
			$phpmailer->AddAddress("$to", "");
		
			$phpmailer->FromName = "DeleteDuplicatePosts";
			$phpmailer->Subject = $subject;
			$phpmailer->Body    = $message;
			
			$phpmailer->IsMail(); // set mailer to use php mail()
		
			do_action_ref_array('phpmailer_init', array(&$phpmailer));
		
			$mailheaders = (array) explode( "\n", $headers );
			foreach ( $mailheaders as $line ) {
				$header = explode( ":", $line );
				switch ( trim( $header[0] ) ) {
					case "From":
						$from = trim( str_replace( '"', '', $header[1] ) );
						if ( strpos( $from, '<' ) ) {
							$phpmailer->FromName = str_replace( '"', '', substr( $header[1], 0, strpos( $header[1], '<' ) - 1 ) );
							$from = trim( substr( $from, strpos( $from, '<' ) + 1 ) );
							$from = str_replace( '>', '', $from );
						} else {
							$phpmailer->FromName = $from;
						}
						$phpmailer->From = trim( $from );
						break;
					default:
						if ( $line != '' && $header[0] != 'MIME-Version' && $header[0] != 'Content-Type' )
							$phpmailer->AddCustomHeader( $line );
						break;
				}
			}
			$result = @$phpmailer->Send();
	
		return $result;
		}
// END SENDMAIL()     
  
// -----------------------------------------------------------------------------------------------------------	
		/**
		* 
		* admin_register_head
		* 
		*/
     
function admin_register_head() {
    $plugpage = strtolower($_GET['page']);    
    if ($plugpage=='delete-duplicate-posts.php') {
    	wp_admin_css();
		wp_enqueue_script( 'common' );
		wp_enqueue_script( 'jquery-color' );
		wp_print_scripts('editor');
		if (function_exists('add_thickbox')) add_thickbox();
		wp_print_scripts('media-upload');
		if (function_exists('wp_tiny_mce')) wp_tiny_mce();
		wp_admin_css();
		wp_enqueue_script('utils');
		do_action("admin_print_styles-post-php");
		do_action('admin_print_styles');
    	$siteurl = get_option('siteurl');
    	$url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/delete-duplicate-posts.css';
    	echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
    }
}
//END admin_register_head() 

  

        
// -----------------------------------------------------------------------------------------------------------	
		/**
		* 
		* LOG FUNCTION
		* 
		*/
		function log($text) {
			global $wpdb;
			$table_name_log = $wpdb->prefix . "delete-duplicate-posts_log";	
			$text= 	gmdate("(d/m-Y H:i:s)", time()) ." - ". mysql_real_escape_string($text);
			$query = "INSERT INTO `$table_name_log` (note) 
							  VALUES (
							  '$text'
							  )";
			$success = mysql_query($query);
			unset($query);
			unset($success);
		}
//END LOG()        







// -----------------------------------------------------------------------------------------------------------	
		/**
		* 
		* INSTALL ROUTINES
		* 
		*/
		function install () {
			global $wpdb;
			if ( file_exists(ABSPATH . 'wp-admin/includes/upgrade.php') ) {
			    require_once(ABSPATH . '/wp-admin/includes/upgrade.php');
			} else { // Wordpress <= 2.2
			    require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
			}
			$table_name_log = $wpdb->prefix . "delete-duplicate-posts_log";		
			dbDelta("CREATE TABLE `$table_name_log` (
				  `id` int(11) NOT NULL auto_increment,
				  `note` varchar(255) NOT NULL default '',
				  UNIQUE KEY `id` (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=latin1;");
			$this->log("Log database created.");
			
			$this->options['ddp_showads']=true;
			$this->options['ddp_statusmail']=true;
			$this->options['ddp_linkgiven']=true;
			$this->saveAdminOptions();
			$this->cron_load_ads();
			wp_clear_scheduled_hook('ddp_cron');
			
		}	
// END INSTALL()	        
        
 
 
// -----------------------------------------------------------------------------------------------------------	
	/**
	 * Downloads the latest message from myWordPress.com
	 */  

function cron_load_ads(){
    if ($this->options['ddp_showads']) {
    
    	$this->getOptions();
    	$file = wp_remote_fopen('http://cleverplugins.com/cleverads.php');
    	if (is_wp_error($file)) {
    		$errors= $file->get_error_message();
    		$this->log("cron_load_ads() Error:$errors");
    		return;
    	}		
    	$this->options['ddp_ads']=strip_tags($file,'<a><br><p><img>');	
    	$this->saveAdminOptions();
    	unset($file);
    	wp_schedule_event(time()+24*60*60, 'daily', 'cron_load_ads');
    }
}	
// END CRON_LOAD_ADS()  

        
// -----------------------------------------------------------------------------------------------------------	
        /**
        * Retrieves the plugin options from the database.
        * @return array
        */
        function getOptions() {
            //Don't forget to set up the default options
            if (!$theOptions = get_option($this->optionsName)) {
                $theOptions = array('default'=>'options');
                update_option($this->optionsName, $theOptions);
            }
            $this->options = $theOptions;
            
        }
        
// -----------------------------------------------------------------------------------------------------------	
        /**
        * Saves the admin options to the database.
        */
        function saveAdminOptions(){
            return update_option($this->optionsName, $this->options);
        }
        


// -----------------------------------------------------------------------------------------------------------	
        /**
        * Truncates a string...
        */
		function truncatestring($string, $del) {
		  $len = strlen($string);
		  if ($len > $del) {
		    $new = substr($string,0,$del)."...";
		    return $new;
		  }
		  else return $string;
		}
// END truncatestring()


// -----------------------------------------------------------------------------------------------------------	
        /**
        * @desc Adds the options subpanel
        */
        function admin_menu_link() {
            add_management_page('Delete Duplicate Posts', 'Delete Duplicate Posts', 8, basename(__FILE__), array(&$this,'admin_options_page'));
            add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array(&$this, 'filter_plugin_actions'), 10, 2 );
        }



// -----------------------------------------------------------------------------------------------------------	
        /**
        * Adds the Settings link to the plugin activate/deactivate page
        */
        function filter_plugin_actions($links, $file) {
           $settings_link = '<a href="tools.php?page=' . basename(__FILE__) . '">' . __('Settings') . '</a>';
           array_unshift( $links, $settings_link ); // before other links

           return $links;
        }



//### Adds every half hour to the list of WP cron schedules.
function filter_cron_schedules( $param ) {


	return array( '30min' => array( 
								'interval' => 1800, 
								'display'  => __( 'Every 30 minutes' ) 
							) 
									
					);
							
							
						
													
}



// -----------------------------------------------------------------------------------------------------------	
        /**
        * Function returns number of minutes to human understandable format
          Reference: http://techjunk.websewak.com/function-to-convert-minutes-to-hours-minutes-format-in-php/	
        */
function to_hour_string($MM)
{
		$MM=floor($MM/60); //Lars tweak
        $Hour=floor($MM/60);
        $Min=($MM%60);
        If($Hour>0)
        {
                $str = $Hour." hour";
                if ($Hour > 1)
                        $str .= "s";
                if ($Min > 0)
                        $str .= " ".$Min." minute";
                if ($Min > 1)
                        $str .= "s";
        }
        else if ($Min > 0)
        {
                $str = " ".$Min." minute";
                if ($Min > 1)
                        $str .= "s";
        }
        else
        {
                $str = "-";
        }
        return $str;
} 




// -----------------------------------------------------------------------------------------------------------	
        /**
        * Administration options page
        */
function admin_options_page() { 

	
// DELETE NOW
	if ( (wp_verify_nonce($_POST['_wpnonce'], 'ddp-clean-now')) && ($_POST['deleteduplicateposts_delete'] ) ){
		$this->cleandupes(1); // use the value 1 to indicate it is being run manually.
	}
	
// RUN NOW!!
	if($_POST['ddp_runnow']){
		if (! wp_verify_nonce($_POST['_wpnonce'], 'ddp-update-options') ) die('Whoops! Some error occured, try again, please!'); 

		if ( function_exists('current_user_can') && current_user_can('edit_plugins')) {
			$search4dupes=true; // remember that we are searching for dupes! .. is used later on in this function as to not disturb the layout
		}
	}



// SAVING OPTIONS
	if($_POST['delete_duplicate_posts_save']){
		if (! wp_verify_nonce($_POST['_wpnonce'], 'ddp-update-options') ) 
			die('Whoops! There was a problem with the data you posted. Please go back and try again.'); 
		$this->options['ddp_enabled'] = ($_POST['ddp_enabled']=='on')?true:false;
		$this->options['ddp_showads'] = ($_POST['ddp_showads']=='on')?true:false;
		$this->options['ddp_statusmail'] = ($_POST['ddp_statusmail']=='on')?true:false;
		$this->options['ddp_keep'] = mysql_real_escape_string($_POST['ddp_keep']);
   		$this->options['ddp_limit'] = mysql_real_escape_string($_POST['ddp_limit']);
		
		$this->options['ddp_linkgiven'] = ($_POST['ddp_linkgiven']=='on')?true:false;


		
   		
   		if ($this->options['ddp_enabled'] ){
			wp_clear_scheduled_hook('ddp_cron');
			wp_schedule_event(time()+$this->options['ddp_postinterval'], '30min', 'ddp_cron');
		} else {
			wp_clear_scheduled_hook('ddp_cron');
		}
		
		$this->saveAdminOptions();
		
		echo '<div class="updated"><p>Your changes were sucessfully saved!</p></div>';
	}
			
// CLEARING THE LOG
	if($_POST['ddp_clearlog']){
		if (! wp_verify_nonce($_POST['_wpnonce'], 'ddp_clearlog_nonce') ) die('Whoops! Some error occured, try again, please!'); 
		global $wpdb;
		$table_name_log = $wpdb->prefix . "delete-duplicate-posts_log";	
		$wpdb->query ("TRUNCATE `$table_name_log`;");
		echo '<div class="updated"><p>The log was cleared</p></div>';
		unset($wpdb);
	}			

// *************************************


	global $wpdb;
	

// Check for if update is necessary... And then runs the install function if needed.
	$table_name = $wpdb->prefix . "delete-duplicate-posts_log";    
	if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
		$this->install();
	}
	
	
	$table_name = $wpdb->prefix . "posts";	

	$pluginfo=get_plugin_data(__FILE__);
	$version=$pluginfo['Version'];	
	$name=$pluginfo['Name'];
	$siteurl = get_option('siteurl');
	$imgurl = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/cleverpluginslogo.png';
		?>                

	<div class="wrap">    
		<div id="tabs">
			<div style="float:right;"><a href="http://cleverplugins.com" target="_blank"><img src="<?php echo $imgurl; ?>"></a>
			</div>
		<h2>Delete Duplicate Posts<span id="cpgreen"> v <?php echo $version; ?></span></h2>
		<br class="clear" />


	
		<br class="clear" />
<?php
	$this->options['ddp_showads']=true; // Now defaults to true...
//	$this->cron_load_ads();
//	if (($this->options['ddp_ads']<>'') && ($this->options['ddp_showads']) ) {
	?>
	<center>	<small><i>CleverPlugins.com Ads:</i></small><br>
	<div class="ui-state-highlight ui-corner-all" style="margin-bottom:10px;padding:0.7em;max-width:500px;"> 
			
			<?php echo $this->options['ddp_ads']; ?></p>
		</div> </center>
<?php
//	}
	?>

	<br class="clear" />
		<ul>
			<li><a href="#dashboard"><?php _e('Dashboard', $this->localizationDomain); ?></a></li>
			<li><a href="#configuration"><?php _e('Configuration', $this->localizationDomain); ?></a></li>
			<li><a href="#log"><?php _e('Log', $this->localizationDomain); ?></a></li>
			<li><a href="#help"><?php _e('Help', $this->localizationDomain); ?></a></li>
		</ul>
			
		<script type="text/javascript">
		jQuery(function(){
	
		    // Tabs
		    jQuery('#tabs').tabs();
		    
		    //hover states on the static widgets
		    jQuery('#dialog_link, ul#icons li').hover(
		    	function() { $(this).addClass('ui-state-hover'); }, 
		    	function() { $(this).removeClass('ui-state-hover'); }
		    );
		    
		});
		</script>


		
<div id="dashboard">

	<h3><?php _e('Dashboard', $this->localizationDomain); ?></h3>
<?php
		if ($this->options['ddp_enabled'] ) {
			$nextscheduled = wp_next_scheduled('ddp_cron');
			if (!$nextscheduled<>'') { // plugin active, but the cron needs to be activated also..
				echo "not set, setting cron...";
				wp_clear_scheduled_hook('ddp_cron');
				wp_schedule_event(time()+$this->options['ddp_postinterval'], '30min', 'ddp_cron');
				$nextscheduled = wp_next_scheduled('ddp_cron');
				
			}
			
			$nexttime=date('l jS \of F Y H:i ',$nextscheduled);

		}	else {
			wp_clear_scheduled_hook('ddp_cron');
		}

// Status check

		$query="select bad_rows.*
	    from $table_name as bad_rows
	    inner join (
	    select post_title,id, $minmax as min_id
	    from $table_name 
	    WHERE (
	    (
	    `post_status` = 'published'
	    )
	    OR (
	    `post_status` = 'publish'
	    ) AND `post_type` = 'post'
	    )
	    group by post_title
	    having count(*) > 1
	    ) as good_rows on good_rows.post_title = bad_rows.post_title
	    and good_rows.min_id <> bad_rows.id limit $limit;";
	    
			$dupes = $wpdb->get_results($query);
			
			$dupescount = count($dupes); 	


if ($dupescount) {

?>
			<div class="ui-state-error ui-corner-all" style="padding: 0pt 0.7em;margin-left:6em;margin-right:6em;"> 
					<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: 0.3em;"></span> 
					<strong>Warning</strong>: I have discovered a total of <strong><?php echo $dupescount; ?></strong> duplicate blogposts!</p>
				<h3>Top 10</h3>
<?php
		
		// lets show them some of them	
		$query="select bad_rows.*
	    from $table_name as bad_rows
	    inner join (
	    select post_title,id, $minmax as min_id
	    from $table_name 
	    WHERE (
	    (
	    `post_status` = 'published'
	    )
	    OR (
	    `post_status` = 'publish'
	    ) AND `post_type` = 'post'
	    )
	    group by post_title
	    having count(*) > 1
	    ) as good_rows on good_rows.post_title = bad_rows.post_title
	    and good_rows.min_id <> bad_rows.id limit 10;";
	    
			
			$dupes = $wpdb->get_results($query);
			
			$plugurl=WP_CONTENT_URL . '/plugins/' .plugin_basename(__FILE__) ;	
			echo '<table class="widefat post" cellspacing="0">';
			
			echo '<thead><tr><th>Post title</th></thead>';
			echo '<tbody>';
			foreach ($dupes as $dupe) {
				$postid=$dupe->ID;
			
				$title=$this->truncatestring($dupe->post_title,120);
				echo "<tr><td><a href='".get_permalink($postid)."' target='_blank'>".$title."</a></td></tr>";
			}
			echo '</tbody>';
			echo "</table>";
			?>
	<form method="post" id="ddp_runcleannow">
	<?php wp_nonce_field('ddp-clean-now'); ?>
	<p align="center"><input type="submit" name="deleteduplicateposts_delete" class="button-primary" value="Delete All Duplicates" /></p>
</form>
			<?php
			echo "</div>";

	} else { // no dupes found!
	
		?>
	<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0pt 0.7em;"> 
		<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: 0.3em;"></span>
		I have just checked, and you have no detected duplicate posts right now.</p>
		<p>
		<?php
		
		$nextscheduled = wp_next_scheduled('ddp_cron');
		
		if ($nextscheduled) echo "You have enabled CRON, so I am running on automatic. Relax, I'll take care of everything...";
	if ($nextscheduled) echo _e("<p>Next automatic check: <strong>$nexttime</strong><small><em>(Server Time Now:".date('l jS \of F Y H:i ',time()).")</em></small></p>", $this->localizationDomain);
	
		if (!$nextscheduled) echo "You know what, <em>I can take care of every duplicate for you automatically</em>, <br>just go to the 'Configuration' tab and turn on CRON.";
		?>
		 </p>
		

	</div>

		
		
		<?php
	}

		?>

</div>			


			
			
<div id="configuration">
		
						
	<h3><?php _e('Configuration', $this->localizationDomain); ?></h3>  
	

	<form method="post" id="delete_duplicate_posts_options">
	<?php wp_nonce_field('ddp-update-options'); ?>
	<table width="100%" cellspacing="2" cellpadding="5" class="form-table">
				
	<th colspan=2><h4><?php _e('Automatic (CRON) Settings', $this->localizationDomain); ?></h4></th>         
	<tr valign="top"> 
	<th><label for="ddp_enabled"><?php _e('Enable CRON?:', $this->localizationDomain); ?></label></th><td><input type="checkbox" id="ddp_enabled" name="ddp_enabled" <?=($this->options['ddp_enabled']==true)?'checked="checked"':''?>>
                            <p><em><?php _e('Clean duplicates automatically', $this->localizationDomain); ?></em></p>
                            </td>
                        </tr>
  
  
  
  
 	<th><label for="ddp_keep"><?php _e('Which posts to keep?:', $this->localizationDomain); ?></label></th><td>
 	
 	<select name="ddp_keep" id="ddp_keep">
 		<option value="oldest" <?=($this->options['ddp_keep']=='oldest')?'selected="selected"':''?>>Keep oldest post</option>
	 	<option value="latest" <?=($this->options['ddp_keep']=='latest')?'selected="selected"':''?>>Keep latest post</option>
 	</select>
 	
 	
                            <p><em><?php _e('Keep the oldest or the latest version of duplicates? Default is keeping the oldest, and deleting any subsequent duplicate posts', $this->localizationDomain); ?></em></p>
                            </td>
                        </tr> 
	<th><label for="ddp_statusmail"><?php _e('Send status mail?:', $this->localizationDomain); ?></label></th><td><input type="checkbox" id="ddp_statusmail" name="ddp_statusmail" <?=($this->options['ddp_statusmail']==true)?'checked="checked"':''?>>
                            <p><em><?php _e('Sends a status email if duplicates have been found.', $this->localizationDomain); ?></em></p>
                            </td>
                        </tr>                     

                        <tr valign="top"> 
                            <th><label for="ddp_limit"><?php _e('Limit to maximum :', $this->localizationDomain); ?></label></th><td><select name="ddp_limit">
                            		<?php
									for($x = 1; $x <= 8; $x++) {
										$val=($x*25);
										echo "<OPTION VALUE='$val' ";
										if ($this->options['ddp_limit']==$val) echo "selected"; 
										
										echo ">$val</OPTION>";
									}
									?> 
									</select> <?php _e(' duplicates.', $this->localizationDomain); ?>
									<p><em><?php _e('Limiting is a good idea, if your site is on a busy server.', $this->localizationDomain); ?></em></p>
									
                            </td>
                        </tr>                                                 
 
	<th><label for="ddp_linkgiven"><?php _e('Donate backlink?:', $this->localizationDomain); ?></label></th><td><input type="checkbox" id="ddp_linkgiven" name="ddp_linkgiven" <?=($this->options['ddp_linkgiven']==true)?'checked="checked"':''?>>
                            <p><em><?php _e('Donate a backlink in the footer of the frontpage of your site.', $this->localizationDomain); ?></em></p>
                            </td>
                        </tr> 
                

                            <th colspan=2><input type="submit" class="button-primary" name="delete_duplicate_posts_save" value="<?php _e('Save Settings', $this->localizationDomain); ?>" /></th>
                        </tr>
                        
                    </table>
		
			</form>
			</div>
	
			
<div id="log">
			
			              	<h3><?php _e('The Log', $this->localizationDomain); ?></h3>
			              	
		              	
			              	
                <textarea rows="32" class="large-text" name="ddp_log" id="ddp_log" style="font-size: 10px;line-height:1em"><?php
					$table_name_log = $wpdb->prefix . "delete-duplicate-posts_log";	
					$query = "SELECT * FROM `".$table_name_log."` order by `id` ASC";
					$loghits = $wpdb->get_results($query, ARRAY_A);
					if ($loghits){
						foreach ($loghits as $hits) {
							echo $hits['note']."\n";
						}
					}		
					unset($loghits);
					unset($query);
					unset($table_name_log);	
				?></textarea>                   
                 <p>
                 <form method="post" id="ddp_clearlog">
                	<?php wp_nonce_field('ddp_clearlog_nonce'); ?>
             
                	<input type="submit" name="ddp_clearlog" value="Reset log" />
				</form>
				</p> 
			
			</div>
			
<div id="help">
	<h3><?php _e('Help', $this->localizationDomain); ?></h3>



	
	
	<h4>What does this plugin do?</h4>		
	<p>It can help you clean duplicate posts from your blog. The plugin checks for blogposts on your blog with the EXACT same title. It will automatically keep the first version, and only delete all the OTHERS.</p>
	<p>It can run automatically via WordPress's own internal CRON-system, or you can run it automatically.
	</p>	
	<p>It also has a nice feature that can send you an e-mail when Delete Duplicate Posts finds and deletes something (if you have turned on the CRON feature).</p>

	<h4>Help! Something was deleted that was not supposed to be deleted!</h4>	
		<p>I am sorry for that, but <strong>there is nothing I can do to help you!</strong></p>
		<p>If you run this plugin, manually or automatically, it is at your OWN risk!</p>
		
		<p><i>I have done my best to avoid deleting something that should not be deleted, but if it happens, there is nothing I can do to help you.</i></p>
		
		
		<h4>Hey, what is that ad above?</h4>	
		<p>I develop free plugins like this, because I want to give back to the WordPress community, but I also develop Premium WordPress plugins which I sell online at <a href="http://cleverplugins.com">CleverPlugins.com</a></p>

		
</div>			
		</div>



		
               <?php
        }
     
        
  } //End Class
} 

if (class_exists('delete_duplicate_posts')) {
    $delete_duplicate_posts_var = new delete_duplicate_posts();
}
?>