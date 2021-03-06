<?php
/**
 * Overview displays standard Overview page
 *
 * @package modules
 * @copyright (C) 2002-2005 The Digital Development Foundation
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @link http://www.xaraya.com
 *
 * @subpackage Sitetools Module
 * @link http://xaraya.com/index.php/release/887.html
 * @author Jo Dalle Nogare <jojodee@xaraya.com>
 */
/**
 * Overview displays standard Overview page
 *
 * Used to call the template that provides display of the overview
 *
 * @author jojodee
 * @returns array xarTpl::module with $data containing template data
 * @return array containing the menulinks for the overview item on the main manu
 * @since 2 Nov 2005
 */
function sitetools_admin_overview()
{
    /* Security Check */
    if (!xarSecurity::check('AdminSiteTools')) {
        return;
    }

    $data=[];

    /* if there is a separate overview function return data to it
     * else just call the main function that usually displays the overview
     */

    return xarTpl::module('sitetools', 'admin', 'main', $data, 'main');
}
