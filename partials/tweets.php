<?php

$tweets = array(
	'https://twitter.com/bamadesigner/status/794331594974588929',
	'https://twitter.com/wpcampusorg/status/792063807610912768',
	'https://twitter.com/jesselavery/status/792048331149209600',
	'https://twitter.com/smcl/status/792416706643783680',
	'https://twitter.com/wptavern/status/786659976248827904',
	'https://twitter.com/lacydev/status/792093486757601280',
	'https://twitter.com/bamadesigner/status/789151758899568640',
	'https://twitter.com/bamadesigner/status/790676358506524672',
	'https://twitter.com/wpcampusorg/status/791729174520041472',
	'https://twitter.com/sleary/status/792044292747374592',
	'https://twitter.com/sleary/status/788381181209407488',
	'https://twitter.com/donnatalarico/status/792031436807081984',
	'https://twitter.com/bamadesigner/status/792027984915865600',
	'https://twitter.com/palletjackracer/status/790894249814454272',
	'https://twitter.com/wpcampusorg/status/789511921343033348',
	'https://twitter.com/wpcampusorg/status/793916280357011456',
	'https://twitter.com/UBCSauderLS/status/789552680397963264',
	'https://twitter.com/wpcampusorg/status/790945782803202049',
);

// Make sure we don't have duplicates.
$tweets = array_unique( $tweets );

?>
<div class="wpc-online-tweets">
	<?php

	foreach ( $tweets as $tweet ) :

		?>
		<div class="wpc-tweet">
			<?php echo wp_oembed_get( $tweet ); ?>
		</div>
		<?php

	endforeach;

	?>
</div>
