<?php

	
	// backwards compatible
	add_action( 'admin_init', 'youtube_add_custom_box', 1 );
	
	/* Do something with the data entered */
	add_action( 'save_post', 'youtube_save_postdata' );
	
	/* Adds a box to the main column on the Post and Page edit screens */
	function youtube_add_custom_box() {
	    add_meta_box( 
	        'youtube_sectionid',
	        __( 'Opciones', 'ASM.Web' ),
	        'youtube_inner_custom_box',
	        'post' 
	    );
	   }
	
	/* Prints the box content */
	function youtube_inner_custom_box() {
	global $post;
	  // Use nonce for verification
	  wp_nonce_field( plugin_basename( __FILE__ ), 'youtube_noncename' );
	
	
	 
	 // The actual fields for data entry
	 
	 echo '<p>Adjuntar vídeo de YouTube</p>';
	 
	 echo '<input type="text" name="youtube" value="'.get_post_meta($post->ID, 'youtube',true).'" style="width:99%;" />';
	  
	}
	
	/* When the post is saved, saves our custom data */
	function youtube_save_postdata( $post_id ) {
	  // verify if this is an auto save routine. 
	  // If it is our form has not been submitted, so we dont want to do anything
	  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
	      return;
	
	  // verify this came from the our screen and with proper authorization,
	  // because save_post can be triggered at other times
	
	  if ( !wp_verify_nonce( $_POST['youtube_noncename'], plugin_basename( __FILE__ ) ) )
	      return;
	
	  
	  // Check permissions
	
	    if ( !current_user_can( 'edit_post', $post_id ) )
	        return;
	
	
	  // OK, we're authenticated: we need to find and save the data
	  $youtube = $_POST['youtube'];


	if($youtube){
	  $ytvIDlen = 11;
      $ytURL = $youtube;

      $idStarts = strpos($ytURL, "?v=");
                
     
                if($idStarts === FALSE)
                        $idStarts = strpos($ytURL, "&v=");
                if($idStarts === FALSE)
                        $idStarts = strpos($ytURL, "be/");
                
                if($idStarts === FALSE){
                
               
                
                } else {
                
                
                $idStarts +=3;
                
               
                $ytvID = substr($ytURL, $idStarts, $ytvIDlen);

	  	$youtube = "http://youtu.be/".$ytvID;
	}
	}
	  // Do something with $mydata 
	  // probably using add_post_meta(), update_post_meta(), or 
	  // a custom table (see Further Reading section below)
	  
	  
	  global $post;
	 
	
	 update_post_meta($post->ID,'youtube',$youtube);
	 
	  
	
	  
	 
	  
	}
	
	

?>