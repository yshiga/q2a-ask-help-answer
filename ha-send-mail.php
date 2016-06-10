<?php
if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
	header('Location: ../../');
	exit;
}

require_once QA_INCLUDE_DIR.'qa-app-options.php';
require_once QA_INCLUDE_DIR.'qa-app-emails.php';
require_once QA_PLUGIN_DIR.'q2a-ask-help-answer/ha-mail-body-builder.php';

class ha_send_mail
{
	private $params;

	public function __construct()
	{
		$this->params = array();
		$this->params['fromemail'] = qa_opt('from_email');
		$this->params['fromname'] = qa_opt('site_title');
		$this->params['subject'] = qa_opt('qa_ask_help_answer_mail_subject');
		$this->params['body'] = ha_mail_body_builder::create();
		$this->params['toname'] = '';
		$this->params['html'] = false;
	}

	public function send()
	{
		$addresses = explode(',', qa_opt('qa_ask_help_answer_to_address'));
		foreach($addresses as $toemail) {
			$this->params['toemail'] = trim($toemail);
			qa_send_email($this->params);
			error_log('send to: ' . $this->params['toemail']);
		}
	}
}

/*
 * Send Mail
 */
$ha_mail = new ha_send_mail();
$ha_mail->send();
