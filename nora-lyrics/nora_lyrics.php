<?php
/**
 * @package Nora_Lyrics
 * @version 0.9
 */
/*
Plugin Name: Nora Lyrics
Plugin URI: http://tomnora.com/plugins/
Description: This plugin highlights various of my favorite music lyrics. Forked from Matt's Hello Dolly plugin, it will display one random line from the $lyrics on the upper right corner in the dashboard.
Author: Tom Nora, Matt Mullenweg
Version: 0.9
Author URI: http://tomnora.com, http://ma.tt
*/

function nora_lyrics_get_lyric() {
	/** These are the lyrics to several songs, including...  */
	$lyrics = "I got a sixty-nine Chevy with a 396
    Fuelie heads and a Hurst on the floor
    She's waiting tonight down in the parking lot
    Outside the Seven-Eleven store
    Me and my partner Sonny built her straight out of scratch
    And he rides with me from town to town
    We only run for the money, got no strings attached
    We shut 'em up and then we shut 'em down
    
    Tonight, tonight the strip's just right
    I want to blow 'em off in my first heat
    Summer's here and the time is right
    For racin' in the street
    
    We take all the action we can meet
    And we cover all the northeast state
    When the strip shuts down we run 'em in the street
    From the fire roads to the interstate
    Some guys they just give up living
    And start dying little by little, piece by piece
    Some guys come home from work and wash up
    And go racin' in the street
    
    Tonight, tonight the strip's just right
    I want to blow 'em all out of their seats
    Calling out around the world, we're going racin' in the street
    
    I met her on the strip three years ago
    In a Camaro with this dude from L.A.
    I blew that Camaro off my back
    And drove that little girl away
    But now there's wrinkles around my baby's eyes
    And she cries herself to sleep at night
    When I come home the house is dark
    She sighs, baby did you make it all right
    She sits on the porch of her daddy's house
    But all her pretty dreams are torn
    She stares off alone into the night
    With the eyes of one who hates for just being born
    For all the shut down strangers and hot rod angels
    Rumbling through this promised land
    Tonight my baby and me, we're gonna ride to the sea
    And wash these sins off our hands
    
    Tonight, tonight the highway's bright
    Out of our way, mister, you best keep
    'Cause summer's here and the time is right
    For racin' in the street";

	// Here we split it into lines.
	$lyrics = explode( "\n", $lyrics );

	// And then randomly choose a line.
	return wptexturize( $lyrics[ mt_rand( 0, count( $lyrics ) - 1 ) ] );
}

// This just echoes the chosen line, we'll position it later.
function nora_lyrics() {
	$chosen = nora_lyrics_get_lyric();
	$lang   = '';
	if ( 'en_' !== substr( get_user_locale(), 0, 3 ) ) {
		$lang = ' lang="en"';
	}

	printf(
		'<p id="dolly"><span class="screen-reader-text">%s </span><span dir="ltr"%s>%s</span></p>',
		__( 'Quote from Hello Dolly song, by Jerry Herman:', 'hello-dolly' ),
		$lang,
		$chosen
	);
}

// Now we set that function up to execute when the admin_notices action is called.
add_action( 'admin_notices', 'nora_lyrics' );

// We need some CSS to position the paragraph.
function dolly_css() {
	echo "
	<style type='text/css'>
	#dolly {
		float: right;
		padding: 5px 10px;
		margin: 0;
		font-size: 12px;
		line-height: 1.6666;
	}
	.rtl #dolly {
		float: left;
	}
	.block-editor-page #dolly {
		display: none;
	}
	@media screen and (max-width: 782px) {
		#dolly,
		.rtl #dolly {
			float: none;
			padding-left: 0;
			padding-right: 0;
		}
	}
	</style>
	";
}

add_action( 'admin_head', 'dolly_css' );
