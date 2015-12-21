<?php
/**
 * 生成sitemap
 * @author cuihb
 * 每个sitemap文件最好控制在5000条以内，因为是一次写入的
 */
class Libs_Global_Sitemap {
    //单例模式
    protected static $_instance = null;
    
    private $xmlHeader = '<?xml version="1.0" encoding="utf-8"?>';
    //url
    private $urlItem = '';
    //sitemap索引文件
    private $sitemapItem = '';
    
    
    public static function instance(){
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    /**
     * 这是生成sitemap的第一步
     * @param $url
     * @param string $changefreq
     */
    public function urlItem($url, $priority='1.0', $changefreq='weekly'){
        $this->urlItem .= '<url>
           <loc>'.$url.'</loc>
           <lastmod>'.date('Y-m-d').'</lastmod>
           <changefreq>'.$changefreq.'</changefreq>
           <priority>'.$priority.'</priority>
       </url>';
    }
    
    /**
     * 这是生成sitemapindex的第一步
     */
    public function sitemapItem($sitemapAddr){
        $this->sitemapItem .= '<sitemap>
            <loc>'.$sitemapAddr.'</loc>
            <lastmod>'.date('Y-m-d').'</lastmod>
            </sitemap>';
    }
    
    /**
     * 这是生成sitemap的第二步
     * @param $filename 要写入的文件
     */
    public function sitemap($filename){
        $sitemapStr = $this->xmlHeader;
        $sitemapStr .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.$this->urlItem.'</urlset>';
        if(!file_exists(dirname($filename))){
            LJL_File::mkdir(dirname($filename));
        }
        
        file_put_contents($filename, $sitemapStr);
        //unset处理
        $this->urlItem = '';
        unset($sitemapStr);
    }
    /**
     * 这是生成sitemapindex的第二部
     */
    public function sitemapIndex($filename){
        $indexStr = $this->xmlHeader;
        $indexStr .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.$this->sitemapItem.'</sitemapindex>';
        if(!file_exists(dirname($filename))){
            LJL_File::mkdir(dirname($filename));
        }
        file_put_contents($filename, $indexStr);
        $this->sitemapItem = '';
        unset($indexStr);
    }
}
?>