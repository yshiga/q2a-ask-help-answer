<?php
if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
	header('Location: ../../');
	exit;
}

require_once QA_INCLUDE_DIR.'qa-app-options.php';
require_once QA_PLUGIN_DIR.'q2a-ask-help-answer/ha-db-client.php';

class ha_mail_body_builder
{
	public static $body;
	public static function create()
	{
		self::$body = '';
		self::create_header_section();
		self::create_24_ununsers_section();
		self::create_one_unser_setction();

		return self::$body;
	}

	public static function create_header_section()
	{
		// $begin = qa_opt('qa_ask_help_answer_mail_begin');
		self::$body .= qa_opt('qa_ask_help_answer_mail_begin')."\n\n";
	}

	public static function create_24_ununsers_section()
	{
		$questions = ha_db_client::get_24_unanswer_questions(3);
		$title = qa_lang('qa_ask_help_answer_lang/unanswers_mail_title');

		self::create_section($questions, $title);
	}

	public static function create_one_unser_setction()
	{
		$questions = ha_db_client::get_one_answer_questions(3);
		$title = qa_lang('qa_ask_help_answer_lang/oneanswer_mail_title');

		self::create_section($questions, $title);
	}

	public static function create_section($questions = array(), $title = '')
	{
		if (empty($questions)) return;

		$baseurl = qa_opt('site_url');
		self::$body .= $title."\n";

		foreach ($questions as $question) {
			self::$body .= "・".$question['title']."\n";
			self::$body .= $baseurl.$question['postid']."\n\n";
		}
	}
}

/*
 * DEBUG
 */
// var_dump( ha_mail_body_builder::create() );
