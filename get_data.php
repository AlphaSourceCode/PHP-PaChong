<?php
 $url = 'https://www.runoob.com/';//目标网站网址
 get_data($url);
 function get_data($url)
 {
 $mysqli = new mysqli("localhost","root","","pachong");//数据库配置
 $mysqli->set_charset("utf8");
 $curl = curl_init();
 $sql = "SELECT id FROM datas WHERE link='$url'" ;
 if ($result = $mysqli->query($sql))
 {
	 $count = $result->num_rows;
	 if($count == 0)
	 {
		 curl_setopt ( $curl , CURLOPT_URL ,  $url ) ; //设置url
		 curl_setopt ( $curl, CURLOPT_HEADER, 1 );//获取Header
		 curl_setopt ( $curl , CURLOPT_RETURNTRANSFER ,  1 ) ;//数据保存为字符串
		 curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //设置https
		 curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);//302重定向
		 $data  =  curl_exec ( $curl ) ;//执行请求
		 $state = curl_getinfo($curl,CURLINFO_HTTP_CODE);
		 header("Content-type:text/html;charset=UTF-8");
		 if($state = "200")
		 {	  
			  $preg ='/<title>([\S\s]*?)<\/title>/is';
			  preg_match_all($preg,$data,$array2);
			  $title =  $array2[1][0];
			  $date = date("Y-m-d H:i",time());
			  $sql = "INSERT INTO datas (title,link,date) VALUES ('$title','$url','$date')"; //数据插入到数据库
			   if($mysqli->query($sql))
			   {   
				 $preg='/<a .*?href="(.*?)".*?>/is';
				 preg_match_all($preg,$data,$array2); 
				 for($i=0;$i<count($array2[1]);$i++)
				 {
					$url = ltrim($array2[1][$i]);
					if(strpos($url, '/') == 0)
					{
						$url = preg_replace('/\//','',$url,1); //去掉符号"/"
					}
					if(strpos($url, '/') == 0)
					{
						$url = preg_replace('/\//','',$url,1);//再一次去掉符号"/"
					}
					if (strpos($url, 'runoob') !== false) {
						$url = $url;
					}
					else
					{
						$url = "www.runoob.com/".$url; //链接补上www.runoob.com/
					}
					if (strpos($url, 'http') !== false) {
						$url = $url;
					}
					else
					{
						$url = "https://".$url; //链接补上https://
					}
					get_data($url); //递归调用函数，循环获取URL
				 }
			   }
		 }
	 }
    }
    curl_close($curl);
 }
?>