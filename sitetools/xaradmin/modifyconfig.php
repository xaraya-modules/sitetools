<?php
/*
 * File: $Id$
 *
 * Standard function to modify the configuration 
 *
 * @package Xaraya eXtensible Management System
 * @copyright (C) 2003 by the Xaraya Development Team.
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @link http://www.xaraya.com
 *
 * @subpackage SiteTools module
 * @author jojodee <http://xaraya.athomeandabout.com >
*/

/**
 * This is a standard function to modify the configuration parameters of the
 * module
 */
function sitetools_admin_modifyconfig()
{ 
    // Initialise the $data variable that will hold the data to be used in
    // the blocklayout template, and get the common menu configuration
    $data = xarModAPIFunc('sitetools', 'admin', 'menu');
    // Security check - important to do this as early as possible
    if (!xarSecurityCheck('AdminSiteTools')) return;
    // Generate a one-time authorisation code for this operation
    $data['authid'] = xarSecGenAuthKey(); 
    // Specify some labels and values for display
    $data['adopath']     = xarModGetVar('sitetools','adocachepath');
    $data['rsspath']     = xarModGetVar('sitetools','rsscachepath');
    $data['templpath']   = xarModGetVar('sitetools','templcachepath');
    $data['backuppath']  = xarModGetVar('sitetools','backuppath');
    $data['usetimestamp']= xarModGetVar('sitetools','timestamp');
    $data['lineterm']    = xarModGetVar('sitetools','lineterm');
    $data['colnumber']    = xarModGetVar('sitetools','colnumber');
    $data['defaultbktype'] = xarModGetVar('sitetools','defaultbktype');
    $data['defaultbktype'] = xarModGetVar('sitetools','defaultbktype');
    $data['usedbprefix']    = xarModGetVar('sitetools','usedbprefix');

    $data['defadopath']   = xarCoreGetVarDirPath()."/cache/adodb";
    $data['defrsspath']   = xarCoreGetVarDirPath()."/cache/rss";
    $data['deftemplpath'] = xarCoreGetVarDirPath()."/cache/templates";

    // scheduler functions available in sitetools at the moment
    $schedulerapi = array('optimize','backup');
    //Define for each job type
    $data['schedule']['optimize']=xarML('Run Optimize Job');
    $data['schedule']['backup']=xarML('Run Backup Job');

    if (xarModIsAvailable('scheduler')) {
        $data['intervals'] = xarModAPIFunc('scheduler','user','intervals');
        $data['interval'] = array();
        foreach ($schedulerapi as $func) {
            // see if we have a scheduler job running to execute this function
            $job = xarModAPIFunc('scheduler','user','get',
                                 array('module' => 'sitetools',
                                       'type' => 'scheduler',
                                       'func' => $func));
            if (empty($job) || empty($job['interval'])) {
                $data['interval'][$func] = '';
            } else {
                $data['interval'][$func] = $job['interval'];

            }
        }
    } else {
        $data['intervals'] = array();
        $data['interval'] = array();
    }

    $hooks = xarModCallHooks('module', 'modifyconfig', 'sitetools',
        array('module' => 'sitetools'));
    if (empty($hooks)) {
        $data['hooks'] = '';
    } elseif (is_array($hooks)) {
        $data['hooks'] = join('', $hooks);
    } else {
        $data['hooks'] = $hooks;
    } 

   // Return the template variables defined in this function
 return $data;
}
?>
