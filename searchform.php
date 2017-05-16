<?php $search_query = get_search_query(); ?>
<form role="search" method="get" id="searchform"
      action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label><span
			class="screen-reader-text"><?php echo esc_html__( 'Search for:', 'newspaper-x' ) ?></span>
		<input
			class="search-field <?php echo $search_query === '' ? '' : 'opened'; ?>"
			id="search-field"
			placeholder="<?php echo esc_html__( 'Type the search term', 'newspaper-x' ) ?>"
			value="<?php echo esc_attr( $search_query ); ?>" name="s"
			type="search">
	</label>
	<button id="search-submit" type="submit"
	        class="search-submit <?php echo $search_query === '' ? '' : 'close-button'; ?>"><span
			class="first-bar"></span><span
			class="second-bar"></span></button>
</form>