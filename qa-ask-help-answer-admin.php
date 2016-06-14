<?php

class qa_ask_help_answer_admin
{
	public function init_queries($tableslc)
	{
		return;
	}
	public function option_default($option)
	{
		switch ($option) {
			case 'qa_ask_help_answer_to_address':
				return 'exsample@mail.com, answers@mail.com';
			case 'qa_ask_help_answer_mail_subject':
				return '[38qa.net]Questions Mail';
			case 'qa_ask_help_answer_mail_begin':
				return 'There are no answers in this question yet.';
			case 'qa_ask_help_answer_widget_title':
				return 'Answer Wanted';
			default:
				return;
		}
	}

	public function allow_template($template)
	{
		return $template != 'admin';
	}

	public function admin_form(&$qa_content)
	{
		// process the admin form if admin hit Save-Changes-button
		$ok = null;
		if (qa_clicked('qa_ask_help_answer_save')) {
			qa_opt('qa_ask_help_answer_to_address', qa_post_text('qa_ask_help_answer_to_address'));
			qa_opt('qa_ask_help_answer_mail_subject', qa_post_text('qa_ask_help_answer_mail_subject'));
			qa_opt('qa_ask_help_answer_mail_begin', qa_post_text('qa_ask_help_answer_mail_begin'));
			qa_opt('qa_ask_help_answer_widget_title', qa_post_text('qa_ask_help_answer_widget_title'));
			$ok = qa_lang('admin/options_saved');
		}

		// form fields to display frontend for admin
		$fields = array();

		$fields[] = array(
			'label' => qa_lang('qa_ask_help_answer_lang/mail_to'),
			'tags' => 'NAME="qa_ask_help_answer_to_address"',
			'value' => qa_opt('qa_ask_help_answer_to_address'),
			'type' => 'text',
		);

		$fields[] = array(
			'label' => qa_lang('qa_ask_help_answer_lang/mail_subject'),
			'tags' => 'NAME="qa_ask_help_answer_mail_subject"',
			'value' => qa_opt('qa_ask_help_answer_mail_subject'),
			'type' => 'text',
		);

		$fields[] = array(
			'label' => qa_lang('qa_ask_help_answer_lang/mail_beginning'),
			'tags' => 'NAME="qa_ask_help_answer_mail_begin"',
			'value' => qa_opt('qa_ask_help_answer_mail_begin'),
			'type' => 'textarea',
			'rows' => 5
		);

		$fields[] = array(
			'label' => qa_lang('qa_ask_help_answer_lang/widget_title'),
			'tags' => 'NAME="qa_ask_help_answer_widget_title"',
			'value' => qa_opt('qa_ask_help_answer_widget_title'),
			'type' => 'text',
		);

		return array(
			'ok' => ($ok && !isset($error)) ? $ok : null,
			'fields' => $fields,
			'buttons' => array(
				array(
					'label' => qa_lang_html('main/save_button'),
					'tags' => 'name="qa_ask_help_answer_save"',
				),
			),
		);
	}
}
