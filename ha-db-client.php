<?php
if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
	header('Location: ../../');
	exit;
}
require_once QA_INCLUDE_DIR.'qa-db-selects.php';
require_once QA_INCLUDE_DIR.'qa-app-options.php';

class ha_db_client
{
	public static function get_24_unanswer_questions($count)
	{
		$sd = date("Y-m-d H:i:s", strtotime('-1 day'));
		$ed = null;

		$questions = self::get_questions(0, $count, 0, $sd, $ed);
		return $questions;
	}
	public static function get_one_answer_questions($count)
	{
		$sd = date("Y-m-d H:i:s", strtotime('-2 day'));
		$ed = date("Y-m-d H:i:s", strtotime('-7 day'));

		$questions = self::get_questions(0, $count, 1, $sd, $ed);
		return $questions;
	}
	static function get_questions($start=0, $count=3, $acount=0, $startday=null, $endday=null)
	{
		$sql = "SELECT postid, title FROM ^posts WHERE  type = 'Q' AND closedbyid IS NULL";

		switch ($acount) {
			case 1:
				$sql .= ' AND acount=1';
				break;
			default:
				$sql .= ' AND acount=0';
				break;
		}
		if ( !empty($startday) ) {
			$sql .= qa_db_apply_sub(" AND created <= $", array($startday) );
		}

		if ( !empty($endday) ) {
			$sql .= qa_db_apply_sub(" AND created >= $", array($endday) );
		}
		$sql .= " ORDER BY created DESC";
		$sql .= qa_db_apply_sub(" LIMIT # , #", array((int)$start, (int)$count) );

		// error_log($sql);
		return qa_db_read_all_assoc(qa_db_query_sub($sql));
	}
}

/*
 * DEBUG
 */

// $questions24 = ha_db_client::get_24_unanswer_questions(3);
// var_dump( $questions24 );
// $questions1 = ha_db_client::get_one_answer_questions(3);
// var_dump( $questions1 );
