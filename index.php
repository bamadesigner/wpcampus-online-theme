<?php

get_header();

?>
<div id="wpc-online-content">
	<div class="inside">
		<?php

		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();

				the_content();

			endwhile;
		endif;

		wpc_online_print_coc();

		?>
	</div>
</div>
<?php

get_footer();
