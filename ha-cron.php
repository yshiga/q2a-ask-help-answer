<?php
if (!defined('QA_VERSION')) {
	require_once dirname(empty($_SERVER['SCRIPT_FILENAME']) ? __FILE__ : $_SERVER['SCRIPT_FILENAME']).'/../../qa-include/qa-base.php';
}
ini_set('max_execution_time', 120);

error_log('-----------------------------------');
error_log('ask_help_answer cron start');
require_once QA_PLUGIN_DIR.'q2a-ask-help-answer/ha-db-client.php';
require_once QA_PLUGIN_DIR.'q2a-ask-help-answer/ha-mail-body-builder.php';
require_once QA_PLUGIN_DIR.'q2a-ask-help-answer/ha-send-mail.php';
error_log('ask_help_answer cron finished');
error_log('-----------------------------------');

/*
	Omit PHP closing tag to help avoid accidental output
*/
