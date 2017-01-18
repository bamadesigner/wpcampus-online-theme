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

		?>
		<div id="wpc-online-coc">
			<h2>Code of Conduct</h2>
			<p>WPCampus seeks to provide a friendly, safe environment in which all participants can engage in productive dialogue, sharing, and learning with each other in an atmosphere of mutual respect. In order to promote such an environment, we require all participants to adhere to our <a href="https://wpcampus.org/code-of-conduct/">code of conduct</a>, which applies to all community interaction and events.</p>
		</div>
	</div>
</div>
<?php

get_footer();
