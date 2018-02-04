<?php
$url = "http://xxxxx.com"; //目标网站
$log = "/runtime/log/"; //一般在根目录下，注意大小写。
$stime = "2017"; //开始时间，2017年写2017
$etime = "2018"; //结束时间，2018年写2018

$url = $url . $log;
for ($i = $stime; $i <= $etime; $i++) {
	//1月到12月
	for ($j = 1; $j <= 12; $j++) {
		//1号到31号
		for ($d = 1; $d <= 31; $d++) {
			//tp5 Log格式：201801/30.log
			$log = $i . str_pad($j, 2, "0", STR_PAD_LEFT) . "/" . str_pad($d, 2, "0", STR_PAD_LEFT) . ".log";
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
	$found = false;
	if ($result !== false) {
		$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		if ($statusCode == 200) {
			$found = true;
		}
	}
	curl_close($curl);
	return $found;
}
