<form role="search" method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php __( 'Search for:', 'newspaper-x' ) ?></span>
		<input class="search-field" placeholder="Search ..." value="" name="s" type="search">
	</label>
	<button class="search-submit" value="Search" type="submit"><span class="fa fa-search"></span></button>
</form>