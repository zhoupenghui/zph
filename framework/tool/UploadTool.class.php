<?php

class UploadTool {

    private $errorInfo = ''; //错误信息
    private $uploadDir = '/upload/'; //保存路径
    private $maxSize = 2097152; //允许上传的最大尺寸是2M
//    public $maxSize = 1024; //允许上传的最大尺寸是2M
    //允许上传的文件类型
    private $allowType = array(
        'image/jpeg', 'image/png', 'image/gif'
    );

    /**
     * 根据配置文件设定上传属性。
     */
    public function __construct() {
        if(isset($GLOBALS['config']['upload'])){
            foreach($GLOBALS['config']['upload'] as $key =>$value){
                $this->$key = $value;
            }
        }
    }
    /**
     * 文件上传的具体方法。
     * @param array $info 上传的文件详细信息。
     * @return boolean|string
     */
    public function upload(array $info) {
        $this->errorInfo = '';
        //0.整体上传机制是否失败
//        var_dump($info);
        if ($info['error']) {
            $this->errorInfo = '上传失败';
            return false;
        }
        //1.判断文件尺寸是否合法
        if ($info['size'] > $this->maxSize) {
            $this->errorInfo = '文件尺寸过大，最大允许' . ($this->maxSize / 1024) . 'KB';
            return false;
        }
        //2.判断文件类型是否允许
        if (!in_array($info['type'], $this->allowType)) {
            $this->errorInfo = '文件类型不合法！';
            return false;
        }
        //3.移动文件
        //3.1计算新的文件路径
        //3.1.1获取源文件扩展名
        $extName = substr($info['name'], strrpos($info['name'], '.'));

        if (substr($this->uploadDir, -1) != '/') {
            $this->uploadDir .= '/';
        }
        $targetFile = $this->uploadDir . uniqid() . $extName;
        
//        echo $info['tmp_name'];
//        var_dump($targetFile);
//        exit;
//        
        //3.2移动文件
        if (move_uploaded_file($info['tmp_name'], $targetFile)) {
            return $targetFile;
        } else {//4.返回文件路径或者false
            $this->errorInfo = '文件移动失败';
            return false;
        }
    }
    
    public function setMaxSize($maxSize){
        $this->maxSize = $maxSize;
    }
    public function setUploadDir($uploadDir){
        $this->uploadDir = $uploadDir;
    }
    public function setAllowType($allowType){
        $this->allowType = $allowType;
    }

    /**
     * 批量上传。
     * @param array $infos
     * @return type
     */
//    public function multiUpload(array $infos){
//        //形成符合结构的二维数组，结构为
//        //array(array('name'=>'','error'=>''...))
//        $list = array();
//        foreach($infos['tmp_name'] as $key=>$value){
//            $list[] = array(
//                'name'=>$infos['name'][$key],
//                'tmp_name'=>$value,
//                'error'=>$infos['error'][$key],
//                'size'=>$infos['size'][$key],
//                'type'=>$infos['type'][$key],
//            );
//        }
//        //将一个二维数组，遍历每个元素都执行一次upload
//        //组织数据
////        $files = array();
//        $return = array();
//        foreach($list as $info){
//            $file = $this->upload($info);
//            if($file){
//                $return[] = array(
//                    'file'=>$file,
//                    'errorInfo'=>$this->errorInfo,
//                );
//            }
//        }
//        return $return;
//    }
    /**
     * 批量上传。
     * @param array $infos
     * @return type
     */
    public function multiUpload(array $infos) {
        foreach ($infos['tmp_name'] as $key => $value) {
            $info = array(
                'name' => $infos['name'][$key],
                'tmp_name' => $value,
                'error' => $infos['error'][$key],
                'size' => $infos['size'][$key],
                'type' => $infos['type'][$key],
            );
            

            $file = $this->upload($info);
            $return[] = array(
                'file' => $file,
                'errorInfo' => $this->errorInfo,
            );
        }
        return $return;
    }

}
