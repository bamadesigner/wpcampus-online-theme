<?php

get_header();

?>
<div id="wpc-online-content">
	<div class="inside">
		<?php

		wpcampus_online_print_main_callout();

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
