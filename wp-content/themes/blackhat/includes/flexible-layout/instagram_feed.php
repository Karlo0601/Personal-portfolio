<?php
	/*
	* Instagram feed
	*/

class blackhat_Flexible_Layout_Render_instagram_feed {
	
	function __construct($field) {
		$this->field 		= $field;
		$this->field_name 	= 'instagram_feed';
	}

	function render() {
		global $block_position;
		$block_position ++;
		$context['block_position'] 	= $block_position;		
		$block = $this->field;
		
        $output = '';
        
        $context['instagram_top_title'] 	= $block['instagram_top_title'];
		$context['instagram_title'] 	= $block['instagram_title'];
		
        $instagram_api_url = $block['instagram_api_url'];
        $instagram_hashtag = $block['instagram_feed_hashtag'];

        if(!empty($instagram_api_url)){
            $json = @file_get_contents($instagram_api_url);
            $obj = json_decode($json);
            $instagramFeed = $obj->data;
        }
        
        if($instagram_api_url && $instagramFeed):
            foreach($instagramFeed as $feed):
                $feedURL = explode('/', $feed->images->standard_resolution->url);
                unset($feedURL[6]);
                $feedURL = implode('/', $feedURL);
                //if(in_array($instagram_hashtag, $feed->tags)){
                    $instagram_image['image_permalink'] =  $feed->link;
                    $instagram_image['image_url'] =  $feed->images->standard_resolution->url;
                    $instagram_image['width'] =  $feed->images->standard_resolution->width;
                    $instagram_image['height'] =  $feed->images->standard_resolution->height;
                    $context['images'][] = $instagram_image;
                //}
               
            endforeach;
        endif;
		
		$output .= Timber::compile( 'instagram-feed.twig', $context );
		return $output;

	}
}