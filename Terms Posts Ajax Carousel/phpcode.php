<?php

function my_ajax_test_code_here(){
	$html = '';
	
	$terms = get_terms([
		'taxonomy' => 'career-cat',
		'hide_empty' => true,
	]);

	//Fetching Terms Name as Tabs
	$html .= '<div class="catsHolder">';
	foreach ($terms as $term){
		$html .= '<p><a name="the_tab" href="'.$term->slug.'">'. $term->name .'</a></p>';
	}
	$html .= '</div>';


	   $count = 0;
	   //Fetching Posts Name Under Terms
	   foreach ($terms as $term){
		$args = array(
		   'post_type' => 'careers',
		   'posts_per_page'   => -1,
		   'post_status'     => 'publish',
		   'tax_query' => array(
			  array(
				 'taxonomy' => 'career-cat',
				 'field' => 'slug',
				 'terms' => $term
			  )
		   ),
		);
		$custom_query = new WP_Query($args);
  
		if ( $custom_query-> have_posts() && $count < 1) {
		$html .= '<div class="sliderContainer"><div class="owl-carousel slider-1">';
		   while($custom_query-> have_posts()){
			  $custom_query->the_post();
			  $html .= '<div class="item"><a href="'. get_the_permalink() .'">'. get_the_title() .'</a></div>';
		   }
		   wp_reset_query();
		   $html .= '</div></div>';
		}

		$count++;
	 }
	
	return $html;
}
add_shortcode('my-ajax-test', 'my_ajax_test_code_here');




function advancedAjaxTest(){

	$selectedTab = $_POST['the_tab'];

	$args = array(
		'post_type' => 'careers',
		'posts_per_page'   => -1,
		'post_status'     => 'publish',
		'tax_query' => array(
			array(
				'taxonomy' => 'career-cat',
				'field' => 'slug',
				'terms' => $selectedTab
			)
		),
	);

	$tabResults = get_posts($args);
	$list = array();

	foreach($tabResults as $tabresult){
		setup_postdata($tabresult);
		$list[] = array(
			'object' => $tabresult,
			'id' => $tabresult->ID,
			'name' => $tabresult->post_title,
			'link' => get_permalink($tabresult->ID),
			'location' => get_field('location', $tabresult->ID)
		); 
	}



	
	header("Content-type: application/json");
	echo json_encode($list);
	die;

}
add_action('wp_ajax_nopriv_advancedAjaxTest', 'advancedAjaxTest');
add_action('wp_ajax_advancedAjaxTest', 'advancedAjaxTest');
