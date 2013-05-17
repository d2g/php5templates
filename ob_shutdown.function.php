<?php
/* 
 * @package     Pure PHP5 Templates (Templating Libary)
 * @author      Dan Goldsmith
 * @copyright   Dan Goldsmith 2012
 * @link        http://d2g.org.uk/
 * @version     {SUBVERSION_BUILD_NUMBER}
 * 
 * @licence     MPL 2.0
 * 
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. 
 *
 *
 * Send all buffers to the browser which should mean that errors become visable in templates.
 */
function ob_shutdown()
{
    $output = "";
    
    while(ob_get_level() > 0)
    {
        $output .= ob_get_contents();
        ob_end_flush();
    }
    
    if(is_array(error_get_last()) || error_get_last() !== null)
    {
        echo $output;
    }
}

?>