<?php 
error_reporting(E_ALL);
ini_set("display_errors", 1);
$sourceFile = "./aabb.tar.zip"; //要下载的临时文件名
$outFile = "lll.zip"; //下载保存到客户端的文件名

$down = new Download();
$down->down($sourceFile, $outFile);

class Download {
    //断点续传的range
    private $range = 0;
    //允许下载的类型,空时任何文件都可下载
    private $allowType = array('zip', 'txt', 'rar', 'pdf', 'doc', 'dmg', 'tar');
    //是否告诉浏览器下载类型
    private $downType = true;
    
    public function down($sourceFile, $outFileName) {
        
        if(!$outFileName) $outFileName = basename($sourceFile);
        
        if(false === $this->fileLegal($sourceFile)) exit('非法下载');
        $this->sendHeader($sourceFile, $outFileName);
        $this->readFlushFile($sourceFile);
    }
    
    public function sendHeader($sourceFile, $outFile) {
        $outFileExt = $this->getExt($outFile); //获取文件扩展名
        //根据扩展名 指出输出浏览器格式
        $ctype = $this->contentType($outFileExt);
        //Begin writing headers
        header("Cache-Control: public");
        header("Content-Type: $ctype");//设置输出浏览器格式
        header("Content-Disposition: attachment; filename=" . $outFile);
        header("Accept-Ranges: bytes");
    
        $size = filesize($sourceFile);
        $size2 = $size -1; //文件总字节数
        //如果有$_SERVER['HTTP_RANGE']参数
        if (isset ($_SERVER['HTTP_RANGE'])) {
            /*Range头域 　　Range头域可以请求实体的一个或者多个子范围。
             例如，
             表示头500个字节：bytes=0-499
             表示第二个500字节：bytes=500-999
             表示最后500个字节：bytes=-500
             表示500字节以后的范围：bytes=500- 　　
             第一个和最后一个字节：bytes=0-0,-1 　　
             同时指定几个范围：bytes=500-600,601-999 　　
             但是服务器可以忽略此请求头，如果无条件GET包含Range请求头，响应会以状态码206（PartialContent）返回而不是以200 （OK）。
             */
            // 断点后再次连接 $_SERVER['HTTP_RANGE'] 的值 bytes=4390912-
            list ($a, $this->range) = explode("=", $_SERVER['HTTP_RANGE']);
            //if yes, download missing part
            $newLength = $size2 - $this->range; //获取下次下载的长度
            header("HTTP/1.1 206 Partial Content");
            header("Content-Length: $newLength"); //输入总长
            header("Content-Range: bytes {$this->range}-{$size2}/{$size}"); //Content-Range: bytes 4908618-4988927/4988928   95%的时候
        } else {
            header("Content-Range: bytes 0-$size2/$size"); //Content-Range: bytes 0-4988927/4988928
            header("Content-Length: " . $size); //输出总长
        }
    }
    public function readFlushFile ($file) {
        //打开文件
        $fp = fopen($file, "rb");
        //设置指针位置
        fseek($fp, $this->range);
        //虚幻输出
        while (!feof($fp)) {
            //设置文件最长执行时间
            set_time_limit(0);
            print (fread($fp, 1024 * 8)); //输出文件
            flush(); //输出缓冲
            ob_flush();
        }
        fclose($fp);
        exit ();
    }
    
    public function contentType($ext) {
        if(!$this->downType) return "application/force-download";
        switch ($ext) {
            case "exe" :
                return "application/octet-stream";
            case "zip" :
                return "application/zip";
            case "mp3" :
                return "audio/mpeg";
            case "mpg" :
                return "video/mpeg";
            case "avi" :
                return "video/x-msvideo";
            default :
                return "application/force-download";
        }
    }
    //判断下载文件是否是非法的
    public function fileLegal($srcFile) {
        $ext = $this->getExt($srcFile);
        if(!$this->allowType) return true;
        if(!in_array($ext, $this->allowType)) return false;
        if(!file_exists($srcFile)) return false;
        return true;
    }
    //获取扩展名
    public function getExt($filename) {
        return strtolower(substr(strrchr($filename, "."), 1));
    }
}

