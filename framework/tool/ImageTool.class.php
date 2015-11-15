<?php

class ImageTool{

    /**
     * 创建画布的函数名映射
     */
    private static $createFunc = array(
        'image/jpeg'=>'imagecreatefromjpeg',
        'image/png'=>'imagecreatefrompng',
        'image/gif'=>'imagecreatefromgif',
    );
    //用于输出图片的映射
    private static $outputFunc = array(
        'image/jpeg'=>'imagejpeg',
        'image/png'=>'imagepng',
        'image/gif'=>'imagegif',
    );
    /**
     * 
     * @param type $srcFile
     * @param string $path
     * @return string
     * 
     * abc.jpg
     * abc_100_100.jpg
     */
    public function thumb($srcFile, $path = '',$width='100',$height='100') {
//        $targetFile = $path . $targetFile;
        //缩略图名字应当带有尺寸
//        $srcName = basename($srcFile);
//        $extName = substr($srcName,  strrpos($srcName, '.'));//后缀
//        $srcName = substr($srcName, 0,strrpos($srcName, '.')-1);//文件名
//        $targetFile = 
//        
        $imageInfo = getimagesize($srcFile);
        if(!$imageInfo){
            return false;
        }
        $mime = $imageInfo['mime'];
        //1.创建画布资源
//        $src = imagecreatefromjpeg($srcFile);
//        var_dump(self::$createFunc[$mime]);
//        exit;
        $createFunc = self::$createFunc[$mime];
        $src = $createFunc($srcFile);
        $width = $width;
        $height = $height;
        $target = imagecreatetruecolor($width, $height);

        //计算缩略图的名字
        $pathInfo = pathinfo($srcFile);
        if (!$path) {
            $path = $pathInfo['dirname'];
        }
        //将缩略图放置到的完整路径是用path拼接的
        if (substr($path, strrpos($path, '/') != '/')) {
            $path .= '/';
        }
        if(!is_dir($path)){
            mkdir($path,0777,true);
        }
        $srcName = $pathInfo['filename'];
        $extName = $pathInfo['extension'];
        $targetFile = $path . $srcName . '-' . $width . '_' . $height . '.' . $extName;

//1.2将缩略图画布填充白色底色
        $color = imagecolorallocate($target, 255, 255, 255);
        imagefill($target, 0, 0, $color);
//2.获取原图尺寸
        $imageInfo = getimagesize($srcFile);
        $src_w = $imageInfo[0];
        $src_h = $imageInfo[1];

//3.计算各方向的缩放比例，确定最大比例
        $suofang_x = $src_w / $width;
        $suofang_y = $src_h / $height;
        $suofang = max($suofang_x, $suofang_y); //取得最大比例
//4.确定缩略图内容的实际宽高
        $target_w = $src_w / $suofang;
        $target_h = $src_h / $suofang;
        $suofang_x = ($width - $target_w) / 2; //缩略图所在的画布x起始位置
        $suofang_y = ($height - $target_h) / 2; //缩略图所在的画布y起始位置
//5.采样，缩放
        imagecopyresampled($target, $src, $suofang_x, $suofang_y, 0, 0, $target_w, $target_h, $src_w, $src_h);
//6.生成缩略图图片
//        imagejpeg($target, $targetFile);
        $outputFunc = self::$outputFunc[$mime];
        $outputFunc($target, $targetFile);
//7.销毁画布
        imagedestroy($src);
        imagedestroy($target);
        return $targetFile;
    }

}
