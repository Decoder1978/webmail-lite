<?php

/*
 * Copyright 2004-2017, AfterLogic Corp.
 * Licensed under AGPLv3 license or AfterLogic license
 * if commercial version of the product was purchased.
 * See the LICENSE file for a full license statement.
 */

	define('WM_MODE_LOGGING', 'logging');
	define('WM_MODE_DAV', 'dav');
	define('WM_SWITCHER_MODE_NEW_DOMAIN', 'newdomain');
	define('WM_SWITCHER_MODE_EDIT_DOMAIN_GENERAL', 'editgeneral');
	define('WM_SWITCHER_MODE_EDIT_DOMAIN_WEBMAIL', 'editwebmail');
	define('WM_SWITCHER_MODE_EDIT_DOMAIN_ADDRESS_BOOK', 'editaddressbook');
	define('WM_SWITCHER_MODE_EDIT_DOMAIN_FILES', 'editfiles');
	define('WM_SWITCHER_MODE_EDIT_DOMAIN_HELPDESK', 'edithelpdesk');

	define('WM_SWITCHER_MODE_EDIT_USERS_GENERAL', 'editgeneral');

	/* langs */

	define('WM_MODE_DAV_NAME', CApi::I18N('ADMIN_PANEL/SUBTABNAME_MOBILE_SYNC'));
	define('WM_MODE_LOGGING_NAME', CApi::I18N('ADMIN_PANEL/SUBTABNAME_LOGGING'));
	define('WM_SWITCHER_MODE_NEW_DOMAIN_NAME', CApi::I18N('ADMIN_PANEL/TOOLBAR_BUTTON_NEW_DOMAIN'));
	define('WM_SWITCHER_MODE_EDIT_DOMAIN_GENERAL_NAME', CApi::I18N('ADMIN_PANEL/EDIT_DOMAIN_GENERAL_NAME'));
	define('WM_SWITCHER_MODE_EDIT_DOMAIN_WEBMAIL_NAME', CApi::I18N('ADMIN_PANEL/EDIT_DOMAIN_WEBMAIL_NAME'));
	define('WM_SWITCHER_MODE_EDIT_DOMAIN_ADDRESS_BOOK_NAME', CApi::I18N('ADMIN_PANEL/EDIT_DOMAIN_ADDRESS_BOOK_NAME'));
	define('WM_SWITCHER_MODE_EDIT_DOMAIN_FILES_NAME', CApi::I18N('ADMIN_PANEL/EDIT_DOMAIN_FILES_NAME'));
	define('WM_SWITCHER_MODE_EDIT_DOMAIN_HELPDESK_NAME', CApi::I18N('ADMIN_PANEL/EDIT_DOMAIN_HELPDESK_NAME'));

	define('WM_SWITCHER_MODE_EDIT_USERS_GENERAL_NAME', CApi::I18N('ADMIN_PANEL/EDIT_USERS_GENERAL_NAME'));

	define('WM_INFO_LOGCLEARSUCCESSFUL', CApi::I18N('ADMIN_PANEL/MSG_LOGCLEAR_OK'));
