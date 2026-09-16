<?php

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

// delete the user meta we added via our plugin!
delete_metadata( 'user', 0, '_admin_bar_state', '', true );