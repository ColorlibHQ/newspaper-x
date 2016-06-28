<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
	<label>
		<span class="screen-reader-text"><?php __( 'Search for:', 'bugle' ) ?></span>
		<input class="search-field" placeholder="Search ..." value="" name="s" type="search">
	</label>
	<button class="search-submit" value="Search" type="submit"><span class="fa fa-search"></span></button>
</form>