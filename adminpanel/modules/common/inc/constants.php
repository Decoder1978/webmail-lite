<?php

/*
 * Copyright (C) 2002-2013 AfterLogic Corp. (www.afterlogic.com)
 * Distributed under the terms of the license described in COPYING
 *
 */

	define('CM_MODE_DB', 'db');
	define('CM_MODE_SECURITY', 'security');
	define('CM_SWITCHER_MODE_NEW_DOMAIN', 'newdomain');
	define('CM_SWITCHER_MODE_EDIT_DOMAIN_GENERAL', 'editgeneral');

	define('CM_SWITCHER_MODE_NEW_USER', 'newuser');
	define('CM_SWITCHER_MODE_EDIT_USER_GENERAL', 'editgeneral');

	/* langs */

	define('CM_MODE_DB_NAME', CApi::I18N('ADMIN_PANEL/SUBTABNAME_DATABASE'));
	define('CM_MODE_SECURITY_NAME', CApi::I18N('ADMIN_PANEL/SUBTABNAME_SECURITY'));
	define('CM_SWITCHER_MODE_NEW_DOMAIN_NAME', CApi::I18N('ADMIN_PANEL/TOOLBAR_BUTTON_NEW_DOMAIN'));
	define('CM_SWITCHER_MODE_EDIT_DOMAIN_GENERAL_NAME', CApi::I18N('ADMIN_PANEL/EDIT_DOMAIN_GENERAL_NAME'));

	define('CM_SWITCHER_MODE_NEW_USER_NAME', CApi::I18N('ADMIN_PANEL/TOOLBAR_BUTTON_NEW_USER'));
	define('CM_SWITCHER_MODE_EDIT_USER_GENERAL_NAME', CApi::I18N('ADMIN_PANEL/EDIT_USERS_GENERAL_NAME'));

	define('CM_LANG_NODOMAINS', CApi::I18N('ADMIN_PANEL/INFO_NODOMAINS'));
	define('CM_LANG_NODOMAINS_RESULTEMPTY', CApi::I18N('ADMIN_PANEL/INFO_DOMAINS_NOT_FOUND'));
	define('CM_LANG_NOUSERSINDOMAIN', CApi::I18N('ADMIN_PANEL/INFO_NOUSERS'));
	define('CM_LANG_USERS_RESULTEMPTY', CApi::I18N('ADMIN_PANEL/INFO_USERS_NOT_FOUND'));
	define('CM_LANG_TOTAL_USERS', CApi::I18N('ADMIN_PANEL/INFO_USERS_TOTAL'));

	define('CM_LANG_ACCOUNT_EXIST', CApi::I18N('ADMIN_PANEL/MSG_USER_EXIST'));
	define('CM_LANG_DOMAIN_EXIST', CApi::I18N('ADMIN_PANEL/MSG_DOMAIN_EXIST'));
	define('CM_LANG_DELETE_SUCCESSFUL', CApi::I18N('ADMIN_PANEL/MSG_DELETE_SUCCESSFUL'));
	define('CM_LANG_DELETE_UNSUCCESSFUL', CApi::I18N('ADMIN_PANEL/MSG_DELETE_UNSUCCESSFUL'));

	define('CM_PASSWORDS_NOT_MATCH', CApi::I18N('ADMIN_PANEL/MSG_PASSWORD_MISMATCH'));