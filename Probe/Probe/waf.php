<?php
function waf($url)
{
	/*
	��ȫ��
	http://172.16.10.210/
	http://172.16.10.210/?id=1%20union%20select%201,2,3,4

	����
	http://www.npxpf.com/
	http://www.aemedia.org/
	http://www.aemedia.org/?id=1%20union%20select%201,2,3,4

	��Ѷ��
	http://www.zhuojianchina.com/
	http://www.zhuojianchina.com/?id=1%20union%20select%201,2,3,4

	�ٶ���
	https://su.baidu.com/
	https://su.baidu.com/?id=1%20union%20select%201,2,3,4

	������
	https://yq.aliyun.com/
	https://www.itjuzi.com/
	https://yq.aliyun.com/?id=1%20union%20select%201,2,3,4

	������
	https://www.yunaq.com/
	https://www.yunaq.com/?id=1%20union%20select%201,2,3,4

	360������ʿ
	http://zhuji.360.cn/
	http://zhuji.360.cn/?id=1%20union%20select%201,2,3,4
	*/

	//��Ѷ��
	//405 Not Allowed ���ķ��ʿ��ܻ����վ���Σ�գ��ѱ���Ѷ�ư�ȫ���ء�

	//��ȫ��
	//��վ����ǽ ���ύ�����ݰ���Σ�յĹ�������

	//����
	//��վ����ǽ �ύ�������в��Ϸ��Ĳ���,�ѱ���վ����Ա��������

	//�ٶ���
	//������ʾ | �ٶ��Ƽ���

	//==========================================================================================

	//������ʼ��
	$wafContent = array(
		safedog => "http://404.safedog.cn/images/safedogsite/broswer_logo.jpg", //��ȫ��
		yunsuo => ".yunsuologo{margin:0 auto; display:block; margin-top:20px;}",	//����
		tencent => "http://waf.tencent-cloud.com:8080/css/main.css", //��Ѷ��
		aliyun => "https://errors.aliyun.com/images/TB1TpamHpXXXXaJXXXXeB7nYVXX-104-162.png",	//������
		baidu => "/cdn-cgi/styles/baidu.errors.css",	//�ٶ���
		zhuji => "http://zhuji.360.cn/guard/firewall/stopattack.html",		//360
		yunaq => "https://www.yunaq.com/misinformation_upload/?from="		//������
	);

	//	$payload = "?id=1%20union%20select%201,2,3,4";
	//	$payload = "/test.asp;.jpg";
	//	$pyaload = "/test.asp;.jpg?id=1%20and%201=1";
	//	$payload = "/test.asp;?id=1union%20select.jpg";
	//	$payload = "/test.asp;?id=1 and user() /*.jpg";
	//	$payload = "/test.asp%3b%3fid%3d1+and+user()+%2f*.jpg";


	$payload = "/?id=1%20union%20select%201,2,3,4";
	$result = "NULL";

	//==========================================================================================
	$url = $_GET['url'];


	$httpRule  = "/.*?\/\/.*?\//i";
	preg_match($httpRule,$url,$http);
	$http = $http[0];

	$url= $http.$payload; 


	$context = stream_context_create();
	stream_context_set_option($context, 'http', 'ignore_errors', true);
	$html = file_get_contents($url, false, $context); 


	foreach($wafContent as $k => $v)
	{
		if(strstr($html,$v))
		{
			$result = $k;
		}
	}

	return $result;
}
?>
