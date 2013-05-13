<?php

class Photo{
    
   var $type;//图片类型   
   var $width;//实际宽度 
   var $height;//实际高度   
   var $resize_width;//改变后的宽度    
   var $resize_height;//改变后的高度  
   var $cut;//是否裁图  
   var $srcimg;//源图象 
   var $dstimg;//目标图象地址   
   var $im;//临时创建的图象 
   
   
    /*
	* 参数:源图，长，高，输出图片
	*
	*/
	function resizeimage($img, $wid, $hei,$c,$dstpath) {  
		   $this->srcimg = $img;  
		   $this->resize_width = $wid;  
		   $this->resize_height = $hei;  
		   $this->cut = $c;
		   
		   $this->type = strtolower(substr(strrchr($this->srcimg,"."),1));//图片的类型  
		   $this->initi_img();//初始化图象  
		   $this -> dst_img($dstpath);//目标图象地址  
			
		   $this->width = imagesx($this->im);  
		   $this->height = imagesy($this->im);        
		   $this->newimg();//生成图象   
		   ImageDestroy ($this->im);  
	   }
	function newimg() {  
		  $resize_ratio = ($this->resize_width)/($this->resize_height);//改变后的图象的比例     
		  $ratio = ($this->width)/($this->height);//实际图象的比例    
	if(($this->cut)=="1") {  
				//裁图 高度优先   
				if($ratio>=$resize_ratio){  
				  $newimg = imagecreatetruecolor($this->resize_width,$this->resize_height);  
				   imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width,$this->resize_height, (($this->height)*$resize_ratio), $this->height);  
					ImageJpeg ($newimg,$this->dstimg);  
				}  
				 
			   //裁图 宽度优先   
			   if($ratio<$resize_ratio) {  
					$newimg = imagecreatetruecolor($this->resize_width,$this->resize_height);  
					imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, $this->resize_height, $this->width, (($this->width)/$resize_ratio));  
				   ImageJpeg ($newimg,$this->dstimg);  
				}  
		   } else {  
				//不裁图   
				if($ratio>=$resize_ratio) {  
					$newimg = imagecreatetruecolor($this->resize_width,($this->resize_width)/$ratio);  
					imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, ($this->resize_width)/$ratio, $this->width, $this->height);  
				   ImageJpeg ($newimg,$this->dstimg);  
			   }  
			   if($ratio<$resize_ratio) {  
				   $newimg = imagecreatetruecolor(($this->resize_height)*$ratio,$this->resize_height);  
					imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, ($this->resize_height)*$ratio, $this->resize_height, $this->width, $this->height);  
					ImageJpeg ($newimg,$this->dstimg);  
				}  
		  }  
	}
	
    //初始化图象   
    function initi_img() {  
       if($this->type=="jpg") {  
           $this->im = imagecreatefromjpeg($this->srcimg);  
        }  
         
      if($this->type=="gif") {  
           $this->im = imagecreatefromgif($this->srcimg);  
       }  
         
       if($this->type=="png") {  
           $this->im = imagecreatefrompng($this->srcimg);  
        }  
         
       if($this->type=="bmp") {  
           $this->im = $this->imagecreatefrombmp($this->srcimg);  
        }  
    }

     //图象目标地址   
    function dst_img($dstpath) {  
       $full_length  = strlen($this->srcimg);  
       $type_length  = strlen($this->type);  
       $name_length  = $full_length-$type_length;  
       $name = substr($this->srcimg,0,$name_length-1);  
       $this->dstimg = $dstpath;  
    }
	
	
    function ConvertBMP2GD($src, $dest = false) {  
        if(!($src_f = fopen($src, "rb"))) {  
            return false;  
       }  
        if(!($dest_f = fopen($dest, "wb"))) {  
            return false;  
        }  
        $header = unpack("vtype/Vsize/v2reserved/Voffset", fread($src_f,14));  
        $info = unpack("Vsize/Vwidth/Vheight/vplanes/vbits/Vcompression/Vimagesize/Vxres/Vyres/Vncolor/Vimportant", fread($src_f, 40));  
        
        extract($info);  
        extract($header);  
         
       if($type != 0x4D42) { // signature "BM"   
            return false;  
        }  
        
        $palette_size = $offset - 54;  
        $ncolor = $palette_size / 4;  
        $gd_header = "";  
        // true-color vs. palette   
        $gd_header .= ($palette_size == 0) ? "\xFF\xFE" : "\xFF\xFF";  
        $gd_header .= pack("n2", $width, $height);  
        $gd_header .= ($palette_size == 0) ? "\x01" : "\x00";  
        if($palette_size) {  
            $gd_header .= pack("n", $ncolor);  
        }  
        // no transparency   
        $gd_header .= "\xFF\xFF\xFF\xFF";  
  
fwrite($dest_f, $gd_header);  
  
if($palette_size) {  
           $palette = fread($src_f, $palette_size);  
           $gd_palette = "";  
           $j = 0; 
            while($j < $palette_size) {  
                $b = $palette{$j++};  
                $g = $palette{$j++};  
                $r = $palette{$j++};  
                $a = $palette{$j++};  
                $gd_palette .= "$r$g$b$a";  
            }  
            $gd_palette .= str_repeat("\x00\x00\x00\x00", 256 - $ncolor);  
           fwrite($dest_f, $gd_palette);  
        }  
  
$scan_line_size = (($bits * $width) + 7) >> 3;  
$scan_line_align = ($scan_line_size & 0x03) ? 4 - ($scan_line_size & 0x03) : 0;  
  
for($i = 0, $l = $height - 1; $i < $height; $i++, $l--) {
          fseek($src_f, $offset + (($scan_line_size + $scan_line_align) * $l));  
            $scan_line = fread($src_f, $scan_line_size);  
           if($bits == 24) {  
               $gd_scan_line = "";  
                $j = 0;  
                while($j < $scan_line_size) {  
                    $b = $scan_line{$j++};  
                   $g = $scan_line{$j++};  
                    $r = $scan_line{$j++};  
                   $gd_scan_line .= "\x00$r$g$b";  
                }  
            }  
           else if($bits == 8) {  
               $gd_scan_line = $scan_line;  
            }  
            else if($bits == 4) {  
                $gd_scan_line = "";  
               $j = 0;  
                while($j < $scan_line_size) {  
                    $byte = ord($scan_line{$j++});  
                    $p1 = chr($byte >> 4);  
                   $p2 = chr($byte & 0x0F);  
                   $gd_scan_line .= "$p1$p2";  
                }  
               $gd_scan_line = substr($gd_scan_line, 0, $width);  
            }  
           else if($bits == 1) {  
                $gd_scan_line = "";  
               $j = 0;  
               while($j < $scan_line_size) {  
                    $byte = ord($scan_line{$j++});  
                   $p1 = chr((int) (($byte & 0x80) != 0));  
                    $p2 = chr((int) (($byte & 0x40) != 0));  
                    $p3 = chr((int) (($byte & 0x20) != 0));  
                    $p4 = chr((int) (($byte & 0x10) != 0));  
                    $p5 = chr((int) (($byte & 0x08) != 0));  
                   $p6 = chr((int) (($byte & 0x04) != 0));  
                   $p7 = chr((int) (($byte & 0x02) != 0));  
                  $p8 = chr((int) (($byte & 0x01) != 0));  
                  $gd_scan_line .= "$p1$p2$p3$p4$p5$p6$p7$p8";  
               }  
                $gd_scan_line = substr($gd_scan_line, 0, $width);  
          }  
            fwrite($dest_f, $gd_scan_line);  
       }  
        fclose($src_f);  
       fclose($dest_f);  
       return true;  
   }	
    
	function imagecreatefrombmp($filename) {  
			$tmp_name = tempnam("/tmp", "GD");  
			if($this->ConvertBMP2GD($filename, $tmp_name)) {  
				$img = imagecreatefromgd($tmp_name);  
				unlink($tmp_name);  
			   return $img;  
			}  
			return false;  
	}


/*
* 参数：文件名，长度，高度
*/
static function img($filename,$_en_width,$_en_height,$x01=0,$y01=0,$x02=0,$y02=0,$string01='',$string02=''){

	if(file_exists($filename)){
	  $type=getimagesize($filename); 
	  list($width_orig, $height_orig) = getimagesize($filename);//获取原图大小
	  //按比例定长
	  if($width_orig>1000){
		$width=$width_orig * 0.15;
	  }elseif($width_orig>800){
		$width=$width_orig * 0.2;
	  }elseif($width_orig>600){
		$width=$width_orig * 0.3;
	  }elseif($width_orig>400){
		$width=$width_orig * 0.4;
	  }elseif($width_orig>200){
		$width=$width_orig * 0.55;
	  }else{
		$width=$width_orig;
	  }
	  //按比例定高
	  if($height_orig>1000){
		$height=$height_orig * 0.1;
	  }elseif($height_orig>800){
		$height=$height_orig * 0.15;
	  }elseif($height_orig>600){
		$height=$height_orig * 0.25;
	  }elseif($height_orig>400){
		$height=$height_orig * 0.35;
	  }elseif($height_orig>200){
		$height=$height_orig * 0.5;
	  }else{
		$height=$width_orig;
	  }
  //判断文件是jpeg还是png
  if($type[mime]=='image/jpeg' || $type[mime]=='image/pjpeg'){
      header('Content-Type:image/jpeg');
	  $nwephoto=imagecreatetruecolor($_en_width,$_en_height);
	  $srcphoto=imagecreatefromjpeg($filename);
	  imagecopyresampled($nwephoto,$srcphoto,0,0,0,0,$width,$height,$width_orig,$height_orig);
	  
	//  $textcolor = imagecolorallocate($nwephoto, 255, 255, 0);
	//  imagestring($nwephoto, 5, $x01, $y01, $string01, $textcolor);
	//  imagestring($nwephoto, 5, $x02, $y02,$string02, $textcolor);
	  
	  imagejpeg($nwephoto);
  }elseif($type[mime]=='image/png' || $type[mime]=='image/x-png'){
      header('Content-Type:image/png');
	  $nwephoto=imagecreatetruecolor($_en_width,$_en_height);
	  $srcphoto=imagecreatefrompng($filename);
	  imagecopyresampled($nwephoto,$srcphoto,0,0,0,0,$width,$height,$width_orig,$height_orig);
	  
	  imagepng($nwephoto);
  }
  //销毁图片资源
  imagedestroy($nwephoto);
  imagedestroy($srcphoto);
  }else{
    header('Content-Type:text/html;charset=utf-8');
    echo '不存在此文件';
  }
 }
}


$photo= new photo;
?>