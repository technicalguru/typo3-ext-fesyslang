<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2005 Ralph Schuster (rs.eschborn@gmx.de)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * Plugin 'FE Language Library' for the 'fesyslang' extension.
 *
 * @author	Ralph Schuster <rs.eschborn@gmx.de>
 */


require_once(PATH_tslib.'class.tslib_pibase.php');

class tx_fesyslang_pi1 extends tslib_pibase {
	var $prefixId = 'tx_fesyslang_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_fesyslang_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey = 'fesyslang';	// The extension key.
	var $pi_checkCHash = TRUE;
	
	/**
	 * [Put your description here]
	 */
	function main($content,$conf)	{
		// fe_users.tx_fesyslang_lang_uid 
		// Parameter L (can be configured)
		$paramName = $conf['langParam'];
		if (!$paramName) $paramName = 'L';

		// Check if there is a FE user logged in
		if ($GLOBALS['TSFE']->loginUser) {
			$userSetting = $GLOBALS['TSFE']->fe_user->user['tx_fesyslang_lang_uid'];
			$currSetting = $GLOBALS['TSFE']->config['config']['sys_language_uid'];

			$ltype = t3lib_div::_GP('logintype');
			if ($ltype == 'login') {
				// User just logged in
				// Check language setting and redirect if necessary
				if (($userSetting >= 0) && ($userSetting != $currSetting)) {
					$url = $this->pi_getPageLink($GLOBALS['TSFE']->id, '', array());
					$url = preg_replace('/\&'.$paramName.'=\d+/', '', $url);
					$url = preg_replace('/\?'.$paramName.'=\d+/', '?', $url);
					$ext = $paramName.'='.$userSetting;
					if (strpos($url, '?') > 0) {
						$url .= '&'.$ext;
					} else $url .= '?'.$ext;
					header('Location: '.$url.'&logintype=redirected');
					exit;
				}
			} else if ($ltype != 'logout') {
				// Check if user switched language and store value
				if ($userSetting != $currSetting) {
					$fields = array(
						'tx_fesyslang_lang_uid' => $currSetting,
					);
					$GLOBALS['TYPO3_DB']->exec_UPDATEquery('fe_users', 
					             'uid='.$GLOBALS['TSFE']->fe_user->user['uid'], $fields);
				}
			}
		}	
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/fesyslang/pi1/class.tx_fesyslang_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/fesyslang/pi1/class.tx_fesyslang_pi1.php']);
}

?>
