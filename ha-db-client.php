<?php
if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
	header('Location: ../../');
	exit;
}
require_once QA_INCLUDE_DIR.'qa-db-selects.php';
require_once QA_INCLUDE_DIR.'qa-app-options.php';

class ha_db_client
{
	public function get_24_unanswer_questions($count)
	{
		$sd = date("Y-m-d H:i:s", strtotime('-1 day'));
		$ed = null;
		$questions = $this->get_questions(0, $count, 0, $sd, $ed);

		return $questions;
	}
	public function get_one_answer_questions($count)
	{
		$sd = date("Y-m-d H:i:s", strtotime('-2 day'));
		$ed = date("Y-m-d H:i:s", strtotime('-7 day'));
		$questions = $this->get_questions(0, $count, 1, $sd, $ed);

		return $questions;
	}
	private function get_questions($start=0, $count=3, $acount=0, $startday=null, $endday=null)
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

		// return $sql;
		error_log($sql);
		return qa_db_read_all_assoc(qa_db_query_sub($sql));
	}
}

/*
 * DEBUG
 */
$db_client = new ha_db_client();
$questions24 = $db_client->get_24_unanswer_questions(3);
if ( is_array( $questions24 ) ) {
	print_r( $questions24 );
} else {
	var_dump( $questions24 );
}
echo "\n\n";
$questions1 = $db_client->get_one_answer_questions(3);
if ( is_array( $questions1 ) ) {
	print_r( $questions1 );
} else {
	var_dump( $questions1 );
}
