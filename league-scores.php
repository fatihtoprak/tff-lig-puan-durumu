<?php

	///////// connectedBring()
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	protected function connectedBring($link) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $link);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_REFERER,"http://www.yandex.com.tr");
		$Curl = curl_exec($ch);
		curl_close($ch);
		return $Curl;
	}
	
	///////// cleanBring()
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	protected function cleanBring($data, $loops) {
		$linkdata = connectedBring($data);
		for($loop=1; $loop <= $loops; $loop++){
			if($loop < 10){$loop = "0".$loop;}
			preg_match('@<a id="ctl00_MPane_m_198_1890_ctnr_m_198_1890_grvACetvel_ctl' .$loop. '_lnkTakim" href="(.*?)">(.*?)</a>@si', $linkdata, $team);
			preg_match('@<span id="ctl00_MPane_m_198_1890_ctnr_m_198_1890_grvACetvel_ctl' .$loop. '_lblOyun">(.*?)</span>@si', $linkdata, $played);
			preg_match('@<span id="ctl00_MPane_m_198_1890_ctnr_m_198_1890_grvACetvel_ctl' .$loop. '_Label4">(.*?)</span>@si', $linkdata, $wins);
			preg_match('@<span id="ctl00_MPane_m_198_1890_ctnr_m_198_1890_grvACetvel_ctl' .$loop. '_lblKazanma">(.*?)</span>@si', $linkdata, $draws);
			preg_match('@<span id="ctl00_MPane_m_198_1890_ctnr_m_198_1890_grvACetvel_ctl' .$loop. '_lblPuan">(.*?)</span>@si', $linkdata, $loses);
			preg_match('@<span id="ctl00_MPane_m_198_1890_ctnr_m_198_1890_grvACetvel_ctl' .$loop. '_Label1">(.*?)</span>@si', $linkdata, $scored);
			preg_match('@<span id="ctl00_MPane_m_198_1890_ctnr_m_198_1890_grvACetvel_ctl' .$loop. '_Label2">(.*?)</span>@si', $linkdata, $against);
			preg_match('@<span id="ctl00_MPane_m_198_1890_ctnr_m_198_1890_grvACetvel_ctl' .$loop. '_Label5">(.*?)</span>@si', $linkdata, $average);
			preg_match('@<span id="ctl00_MPane_m_198_1890_ctnr_m_198_1890_grvACetvel_ctl' .$loop. '_Label3">(.*?)</span>@si', $linkdata, $points);
			$scores[] = array(
				'sort' => $loop,
				'team' => substr(stristr($team[2],"."),1),		// T - Takım
				'played' => $played[1],									// O - Oynanan
				'wins' => $wins[1],											// G - Galibiyet
				'draws' => $draws[1],										// B - Beraberlik
				'loses' => $loses[1],										// M - Mağlubiyet
				'scored' => $scored[1],									// A - Attığı
				'against' => $against[1],									// Y - Yediği
				'average' => $average[1],								// AV - Averaj
				'points' => $points[1]										// P - Puan
			);
		}
		return $scores;
	}
	
	///////// results
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$results = cleanBring("http://www.tff.org/Default.aspx?pageID=198", 18);
	
	///////// print_r
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	print_r($results);

?>