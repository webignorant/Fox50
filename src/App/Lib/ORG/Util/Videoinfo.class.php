<?php
 class Videoinfo{
  var $ffmpeg='ffmpeg -i "%s" 2>&1';//ffmpeg路径
  var $resolution;//分辨率
  var $vformat;//视频格式
  var $vcodec;//编码格式
  var $size;//文件大小
  var $file_time;//文件播放时长
  
  
  function video_info($file) {
    ob_start();
    passthru(sprintf($this->ffmpeg, $file));
    $info = ob_get_contents();// 通过使用输出缓冲，获取到ffmpeg所有输出的内容。
    ob_end_clean();
    if (preg_match("/Video: (.*?), (.*?), (.*?)[,\s]/", $info, $match)) {
        $this->vformat = $match[1]; // 编码格式
        $this->vcodec = $match[2]; // 视频格式 
        $this->resolution = $match[3]; // 分辨率
        $a = explode('x', $match[3]);
        $ret['width'] = $a[0];
        $ret['height'] = $a[1];
    }
    $this->size = substr(filesize($file)/1024/1024,0,3);// 文件大小
	$this->file_time=date('i:s',$this->getTime($file)/1000); //获取时长 
}
   
  
  function BigEndian2Int($byte_word, $signed = false) { 
	$int_value = 0; 
	$byte_wordlen = strlen($byte_word); 
	for ($i = 0; $i < $byte_wordlen; $i++) { 
		$int_value += ord($byte_word{$i}) * pow(256, ($byte_wordlen - 1 - $i)); 
	} 
	if ($signed) { 
		$sign_mask_bit = 0x80 << (8 * ($byte_wordlen - 1)); 
		if ($int_value & $sign_mask_bit) { 
			$int_value = 0 - ($int_value & ($sign_mask_bit - 1)); 
		} 
	} 
   return $int_value; 
} 
  function getTime($name){ 
		if(!file_exists($name)){ 
		echo "文件不存在";
		exit;
	} 
		$flv_data_length=filesize($name); 
		$fp = @fopen($name, 'rb'); 
		$flv_header = fread($fp, 5); 
		fseek($fp, 5, SEEK_SET); 
		$frame_size_data_length =$this->BigEndian2Int(fread($fp, 4)); 
		$flv_header_frame_length = 9; 
	if ($frame_size_data_length > $flv_header_frame_length) { 
		fseek($fp, $frame_size_data_length - $flv_header_frame_length, SEEK_CUR); 
	} 
		$duration = 0; 
	while ((ftell($fp) + 1) < $flv_data_length) { 
		$this_tag_header = fread($fp, 16); 
		$data_length = $this->BigEndian2Int(substr($this_tag_header, 5, 3)); 
		$timestamp = $this->BigEndian2Int(substr($this_tag_header, 8, 3)); 
		$next_offset = ftell($fp) - 1 + $data_length; 
	if ($timestamp > $duration) { 
		$duration = $timestamp; 
	} 
		fseek($fp, $next_offset, SEEK_SET); 
	} 
	fclose($fp);
		return $duration; 
	}
}
?>