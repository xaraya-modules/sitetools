<?php
/*
 * File: $Id:
 *
 * Get all items in the sitetools table
 *
 * @package Xaraya eXtensible Management System
 * @copyright (C) 2003 by the Xaraya Development Team.
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @link http://www.xaraya.com
 *
 * @subpackage SiteTools module
 * @author jojodee <jojodee@xaraya.com>
*/

/*
 * @returns integer
 * @return number of items held by this module
 * @raise DATABASE_ERROR
*/
function sitetools_adminapi_getall($args)
{ 
   extract($args);
   
    if (!isset($startnum)) {
        $startnum = 1;
    } 
    if (!isset($numitems)) {
        $numitems = -1;
    }
    
        $invalid = array();
    if (!isset($startnum) || !is_numeric($startnum)) {
        $invalid[] = 'startnum';
    } 
    if (!isset($numitems) || !is_numeric($numitems)) {
        $invalid[] = 'numitems';
    } 
    if (count($invalid) > 0) {
        $msg = xarML('Invalid #(1) for #(2) function #(3)() in module #(4)',
            join(', ', $invalid), 'user', 'getall', 'Example');
        xarExceptionSet(XAR_SYSTEM_EXCEPTION, 'BAD_PARAM',
            new SystemException($msg));
        return;
    } 
    if (!xarSecurityCheck('AdminSiteTools')) return;
    $items = array();

    // Get database setup
    list($dbconn) = xarDBGetConn();
    $xartable = xarDBGetTables(); 

    $sitetoolstable = $xartable['sitetools'];

    $query = "SELECT xar_stid, xar_stgained
            FROM $sitetoolstable";
    $result = $dbconn->SelectLimit($query, $numitems, $startnum-1); 
    // Check for an error with the database code, adodb has already raised
    // the exception so we just return
    if (!$result) return;
     for (; !$result->EOF; $result->MoveNext()) {
        list($stid, $stgain) = $result->fields;
        if (xarSecurityCheck('AdminSiteTools')) {
            $items[] = array('stid' => $stid,
                             'stgain' => $stgain);
        }
    }
    // All successful database queries produce a result set, and that result
    // set should be closed when it has been finished with
    $result->Close();
    // Return the number of items
    return $items;
}
?>
