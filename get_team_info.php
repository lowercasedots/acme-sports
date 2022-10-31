<?php
function get_nfl_team_info( $atts ) {
    $atts = shortcode_atts(
		array(
            'theme' => '',
		),
		$atts
	);
    
    //ensure an API key has been entered before we do anything else
    $options = get_option('nfl_options');
    if ( empty( $options['apikey'] ) ) {
        return '<div class="nfl-teams error"><small>(This error message is only viewable by admins.)</small><br>No API key was found - please verify it has been entered in the plugin settings.</div>';
    }

    $json_url = 'https://delivery.chalk247.com/team_list/NFL.JSON?api_key=' . $options['apikey'];
    $json_get = wp_remote_get($json_url);
    $response = wp_remote_retrieve_response_code( $json_get );


    //check for a valid response from the server and/or a valid API key
    if ( $response != 200 ) {
        if ( current_user_can('manage_options') ) {
            if ( $response == 401 ) {
                return '<div class="nfl-teams error"><small>(This error message is only viewable by admins.)</small><br>An unauthorized error occured while connecting to the server. (Is the API key entered correctly?).</div>';
            }
            return '<div class="nfl-teams error"><small>(This error message is only viewable by admins.)</small><br>An unexpected error occured while attempting to connect to the server. The server did not return an OK Response (HTTP Status Code 200).</div>';
        }
        return;
    }

    $json_data = $json_get['body'];

    //verify the json was downloaded
    if ( empty($json_data) ) {
        if ( current_user_can('manage_options') ) {
            return '<div class="nfl-teams error"><small>(This error message is only viewable by admins.)</small><br>We were able to contact the server, but an error occured downloading/processing the content.</div>';
        }
        return;
    }

    $data = json_decode($json_data, true);
    $teams = $data['results']['data']['team'];
    
    //check if a theme attribute has been used, otherwise use the default chosen in the options page. (And if a default hasn't been set, use "light")
    if ( empty( $atts['theme'] ) ) {
        if ( empty( $options['theme'] ) ) {
            $theme = "light";
        } else {
            $theme = $options['theme'];
        }
    } else {
        $theme = $atts['theme'];
    }
    
    //use output buffering for the HTML
    $output = '';
    ob_start(); ?>
    <div class="nfl-teams">
        <table class="nfl-table <?php echo $theme; ?>">
            <thead>
                <tr>
                    <th>Name<span class="arrow asc"></span></th>
                    <th>Conference<span class="arrow asc"></span></th>
                    <th>Division<span class="arrow asc"></span></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($teams as $team) : ?>
                <tr class="team">
                    <td class="cell name"><?php echo $team['display_name']; ?> <?php echo $team['nickname']; ?></td>
                    <td class="cell conference"><?php echo $team['conference']; ?></td>
                    <td class="cell division"><?php echo $team['division']; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php $output = ob_get_clean();
    return $output;
}