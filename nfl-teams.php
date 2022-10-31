<?php

/**
 * Plugin Name: NFL Teams
 * Description: Display a list of current NFL Teams. Enables the use of [nfl_teams] shortcode.
 * Author: Shawn Smith
 */

require_once('nfl-options.php');
require_once('get_team_info.php');

wp_enqueue_style('nfl_teams_stylesheet', plugins_url('css/nfl-teams.css', __FILE__) );
wp_enqueue_script( 'nfl_teams_js', plugins_url('js/nfl-teams.js', __FILE__) );
add_shortcode('nfl_teams', 'get_nfl_team_info');