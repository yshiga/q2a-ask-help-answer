<?php

class qa_ask_help_answer_widget
{
	function allow_template($template)
	{
		return true;
	}

	function allow_region($region)
	{
		return true;
	}

	function output_widget($region, $place, $themeobject, $template, $request, $qa_content)
	{

		if (@$qa_content['q_view']['raw']['type']!='Q') { // question might not be visible, etc...
			return;
		}

		$questionid=$qa_content['q_view']['raw']['postid'];
		$userid=qa_get_logged_in_userid();
		$cookieid=qa_cookie_get();

		$title='回答を求む';
		// $questions= getSeasonalQuestions();
		$questions=array();
		$this->output_questions_widget($region, $place, $themeobject, $title, $userid, $cookieid, $questions);
	}

	function output_questions_widget($region, $place, $themeobject, $title, $userid, $cookieid, $questions)
	{
		$titlehtml='<h2>'.$title.'</h2>';
		$themeobject->output($titlehtml);
		$q_list=array(
			'form' => array(
				'tags' => 'method="post" action="'.qa_self_html().'"',

				'hidden' => array(
					'code' => qa_get_form_security_code('vote'),
				),
			),
			'qs' => array(),
		);
		$defaults=qa_post_html_defaults('Q');
		$usershtml=qa_userids_handles_html($questions);

		foreach ($questions as $question) {
			$q_list['qs'][]=qa_post_html_fields($question, $userid, $cookieid, $usershtml, null, qa_post_html_options($question, $defaults));
		}

		$themeobject->q_list_and_form($q_list);
	}
}
