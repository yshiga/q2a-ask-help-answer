<?php
if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
	header('Location: ../../');
	exit;
}
require_once QA_INCLUDE_DIR.'qa-db-selects.php';
require_once QA_INCLUDE_DIR.'qa-app-options.php';

class ha_db_client {
	public static function getQuestions() {
		$sql = "
		SELECT *
		FROM  qa_posts
		WHERE  type =  'Q'

		AND  acount =0
		ORDER BY  qa_posts.created DESC
		LIMIT 0 , 30;";

		$result = qa_db_query_sub($sql);
		return qa_db_read_all_assoc($result);
	}
}

/*
 * DEBUG
 */
$questions = ha_db_client::getQuestions;
var_dump( $questions );
