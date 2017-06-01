<?php

get_header();

?>
<div id="wpc-online-content">
	<div class="inside">
		<div class="panel gray" style="text-align:center;margin:20px 0 40px 0;padding-bottom:10px;"><h2>The "WordPress in Education" Survey</h2><p>After an overwhelming response to our 2016 survey, WPCampus is back this year to dig a little deeper on key topics that schools and campuses care about most when it comes to WordPress and website development. We’d love to include your feedback in our results this year. The larger the data set, the more we all benefit. <strong>The survey will close on June 23rd, 2017.</strong></p><a class="button panel blue block" style="margin-bottom:0;font-weight:bold;font-size:110%;background:#770000;display:block;" href="https://2017.wpcampus.org/announcements/wordpress-in-education-survey/">Take the "WordPress in Education" survey</a></div>
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
