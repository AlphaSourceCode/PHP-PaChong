<?php

 ignore_user_abort (TRUE);  
 set_time_limit (0);
 $GLOBALS["host"] = 'runoob'; //主域名
 $GLOBALS["url"] = 'https://www.'. $GLOBALS["host"] . '.com/';//超链接
 $GLOBALS["id"] = 0; //请求ID
 $GLOBALS["mysqli"] = new mysqli("localhost","root","","pachong");//数据库配置
 $GLOBALS["mysqli"]->set_charset("utf8");
 $GLOBALS["curl"] = curl_init();
 header("Content-type:text/html;charset=UTF-8");
 $url = $GLOBALS["url"];
 $sql = "SELECT id FROM list WHERE link='$url'" ;
 $result = $GLOBALS["mysqli"]->query($sql);
 $count = $result->num_rows;
 if($count == 0)
 {
	$sql = "INSERT INTO list (link) VALUES ('$url')"; //数据插入到数据库
	$GLOBALS["mysqli"]->query($sql);
	$sql = "SELECT id FROM list WHERE link='$url'" ;
	$result = $GLOBALS["mysqli"]->query($sql);
	$row = $result->fetch_assoc();
	$GLOBALS["id"] = $row["id"];
 }
 else
 {
	$row = $result->fetch_assoc();
	$GLOBALS["id"] = $row["id"];
 }

 while(true)
 {
	 $url = $GLOBALS["url"];
	 curl_setopt ( $GLOBALS["curl"] , CURLOPT_URL ,  $url ) ; //设置url
	 curl_setopt ( $GLOBALS["curl"], CURLOPT_HEADER, 1 );//获取Header
	 curl_setopt ( $GLOBALS["curl"] , CURLOPT_RETURNTRANSFER ,  1 ) ;//数据保存为字符串
	 curl_setopt( $GLOBALS["curl"], CURLOPT_SSL_VERIFYPEER, false); //设置https
	 curl_setopt( $GLOBALS["curl"], CURLOPT_FOLLOWLOCATION, 1);//302重定向
	 $data  =  curl_exec ( $GLOBALS["curl"] ) ;//执行请求
	 $state = curl_getinfo($GLOBALS["curl"],CURLINFO_HTTP_CODE);
	 if($state = "200")
	 {
		$sql = "SELECT id,title FROM datas WHERE link='$url'" ;
		$result = $GLOBALS["mysqli"]->query($sql);
		$count = $result->num_rows;
		$row = $result->fetch_assoc();
		if($count == 0)
		{
		   $preg ='/<title>([\S\s]*?)<\/title>/is';
		   preg_match_all($preg,$data,$results);
		   if(count($results[1])==0)
		   {
			   $title = "无标题";
		   }
		   else
		   {
			   $title = $results[1][0];
		   }		
		   $date = date("Y-m-d H:i",time());
		   $sql = "INSERT INTO datas (title,link,date) VALUES ('$title','$url','$date')"; //数据插入到数据库
		   $GLOBALS["mysqli"]->query($sql);
		}
		$preg='/<a .*?href="(.*?)".*?>/is';
		preg_match_all($preg,$data,$results);
		$link_count = count($results[1]);
		if($link_count > 0)
		{
			for($i=0;$i<$link_count;$i++)
			{
				$urls = ltrim($results[1][$i]);
				if(strpos($urls, '/') == 0)
				{
					$urls = preg_replace('/\//','',$urls,1); //去掉符号"/"
				}
				if(strpos($urls, '/') == 0)
				{
					$urls = preg_replace('/\//','',$urls,1);//再一次去掉符号"/"
				}
				if (strpos($urls, $GLOBALS["host"]) !== false) {
					$urls = $urls;
				}
				else
				{
					$urls = "www.".$GLOBALS["host"].".com/".$urls; //链接补上域名
				}
				if (strpos($urls, 'http') !== false) {
					$urls = $urls;
				}
				else
				{
					$urls = "https://".$urls; //链接补上https://
				}
				$sql = "SELECT id FROM list WHERE link='$urls'" ;
				$result = $GLOBALS["mysqli"]->query($sql);
				$count = $result->num_rows;
				if($count == 0)
				{
					$sql = "INSERT INTO list (link) VALUES ('$urls')"; //数据插入到数据库
					$GLOBALS["mysqli"]->query($sql);
				}
			}				   
		}	   	   
	}
	$GLOBALS["id"] = $GLOBALS["id"] + 1;
	$id = $GLOBALS["id"];
	$sql = "SELECT link FROM list WHERE id='$id'" ;
	$result = $GLOBALS["mysqli"]->query($sql);
	$row = $result->fetch_assoc();
	$count = $result->num_rows;
	if($count > 0)
	{
	   $GLOBALS["url"] = $row['link'];
	}
 }
  curl_close($GLOBALS["curl"]);

?>
