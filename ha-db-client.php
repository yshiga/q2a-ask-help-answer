<?php
if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
	header('Location: ../../');
	exit;
}
require_once QA_INCLUDE_DIR.'qa-db-selects.php';
require_once QA_INCLUDE_DIR.'qa-app-options.php';

class ha_db_client
{
	/*
	 * 回答が殆ど無い質問を取得する
	 * count: 取得件数
	 */
	public static function get_almost_no_answer_questions($count = 6)
	{
		$sday1 = date("Y-m-d H:i:s", strtotime('-1 day'));
		$sday2 = date("Y-m-d H:i:s", strtotime('-2 day'));
		$eday2 = date("Y-m-d H:i:s", strtotime('-7 day'));

		$userid = 1;
		$selectspec=qa_db_posts_basic_selectspec($userid);
		$selectspec['source'] .=" WHERE type='Q'";
		$selectspec['source'] .=" AND (( ^posts.acount = 0";
		$selectspec['source'] .=" AND ^posts.created <= $ )";
		$selectspec['source'] .=" OR ( ^posts.acount = 1";
		$selectspec['source'] .=" AND ^posts.created <= $";
		$selectspec['source'] .=" AND ^posts.created >= $ ))";
		$selectspec['source'] .=" ORDER BY RAND() LIMIT #";

		array_push($selectspec['arguments'],$sday1);
		array_push($selectspec['arguments'],$sday2);
		array_push($selectspec['arguments'],$eday2);
		array_push($selectspec['arguments'],$count);

		return qa_db_single_select($selectspec);
	}
	/*
	 * 投稿後24時間経過しても回答が0件の質問を取得する
	 * count: 取得件数
	 */
	public static function get_24_unanswer_questions($count)
	{
		$sd = date("Y-m-d H:i:s", strtotime('-1 day'));
		$ed = null;

		$questions = self::get_questions(0, $count, 0, $sd, $ed);
		return $questions;
	}
	/*
	 * 投稿後48時間後～1週間の間に回答が1件しかない質問を取得する
	 * count: 取得件数
	 */
	public static function get_one_answer_questions($count)
	{
		$sd = date("Y-m-d H:i:s", strtotime('-2 day'));
		$ed = date("Y-m-d H:i:s", strtotime('-7 day'));

		$questions = self::get_questions(0, $count, 1, $sd, $ed);
		return $questions;
	}
	/*
	 * 条件にあう質問を取得する
	 * start: 取得開始位置 Offset
	 * count: 取得件数 Limit
	 * acount: 回答数
	 * startday: 投稿日(created)がこの日付より前 Y-m-d H:i:s
	 * endday: 投稿日(created)がこの日付より後 Y-m-d H:i:s
	 */
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
