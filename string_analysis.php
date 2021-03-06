<?php
	require_once 'lib/Igo.php';
	$igo = new Igo("./ipadic", "UTF-8");
	$text = file_get_contents('data.txt');
	$results = $igo->parse($text);

	// 名詞一覧を取得する
	$noun_list = array();
	$sort_key = array();
	foreach ($results as $result) {
		if (strpos($result->feature, '名詞') !== false) {
			$noun_list[$result->surface] = (isset($noun_list[$result->surface])) ? $noun_list[$result->surface] + 1 : 1;
		}
	}
	foreach ($noun_list as $count) {
		$sort_key[] = $count;
	}
	// 出現回数で降順ソート
	array_multisort($sort_key, SORT_DESC, $noun_list);
	foreach ($noun_list as $noun => $count) {
		echo str_pad($noun, 18, '　') . $count . "回\n";
	}
	