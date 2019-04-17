<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/*
* Error Handle calss
*/
class MXMPH_Display_Error
{

	/**
	* Error notice
	*/
	public $mxmph_error_notice = '';

	public function __construct( $mxmph_error_notice )
	{

		$this->mxmph_error_notice = $mxmph_error_notice;

	}

	public function mxmph_show_error()
	{
		add_action( 'admin_notices', function() { ?>

			<div class="notice notice-error is-dismissible">

			    <p><?php echo $this->mxmph_error_notice; ?></p>
			    
			</div>
		    
		<?php } );
	}

}