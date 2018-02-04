<?php
$url = "http://xxxxx.com"; //目标网站
$log = "/Application/Runtime/Logs/Home/"; //其中Application可能会变，比如App，需要自己测试
$stime = "17"; //开始时间，2017年写17
$etime = "18"; //结束时间，2018年写18

$url = $url . $log;
for ($i = $stime; $i <= $etime; $i++) {
	//1月到12月
	for ($j = 1; $j <= 12; $j++) {
		//1号到31号
		for ($d = 1; $d <= 31; $d++) {
			//tp3 Log格式：18_01_30.log
			$log = str_pad($i, 2, "0", STR_PAD_LEFT) . "_" . str_pad($j, 2, "0", STR_PAD_LEFT) . "_" . str_pad($d, 2, "0", STR_PAD_LEFT) . ".log";
			if (check_remote_file_exists($url . $log)) {
				file_put_contents($log, file_get_contents($url . $log));
				echo "Found out:$log\n";
			} else {
				echo "$log isn't exists\n";
			}
		}
	}
}

function check_remote_file_exists($url) {
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_NOBODY, true);
	$result = curl_exec($curl);
	if ($result !== false) {
		$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		if ($statusCode == 200) {
			$found = true;
		} else {
			$found = false;
		}
	}
	curl_close($curl);
	return $found;
}
