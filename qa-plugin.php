<?php

/*
		Plugin Name: Ask Help Answer
		Plugin URI:
		Plugin Update Check URI:
		Plugin Description: If it has passed for 24 hours, the question which has no answers is sent by mail.
		Plugin Version: 0.1
		Plugin Date: 2016-06-07
		Plugin Author: 38qa.net
		Plugin Author URI:
		Plugin License: GPLv2
		Plugin Minimum Question2Answer Version: 1.7
*/


	if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
			header('Location: ../../');
			exit;
	}

	// language file
	qa_register_plugin_phrases('qa-ask-help-answer-lang-*.php', 'qa_ask_help_answer_lang');
	// admin
	qa_register_plugin_module('module', 'qa-ask-help-answer-admin.php', 'qa_ask_help_answer_admin', 'Ask Help Answer Admin');

/*
	Omit PHP closing tag to help avoid accidental output
*/
