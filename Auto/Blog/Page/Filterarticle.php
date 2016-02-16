<?php
/**
* @version v1.0
* @todo 自动运行程序
* 抓取的文件进行去重处理
*/

class Auto_Blog_Page_Filterarticle extends Auto_Blog_Page_Abstract {
    private $website = 'blog_share';
    //过滤题目
    private $filterArr = array(
        'from'=>array(''),
        'to'=>array(''),
    );
    //重复字段
    private $refield = 'source'; //也可选择title，如果是抓取的文章，只要source就可以了
    private $isrepeat = true;//是否还有重复数据的标志
    /**
     * 去重
     * 执行方式: php index.php server --c=Filterarticle --a=Quchong
     */
    public function doQuchong(LJL_Request $input){
        while($this->isrepeat){
            $this->quchongexec($input);
        }
        exit();
    }
    public function quchongexec($input) {
        $db = Db_Blog::instance(null, $this->website);
        $sql = "SELECT id,source FROM `blog_article_info` GROUP BY {$this->refield} HAVING COUNT(id)>1";
        $res = $db->getAll($sql);
        if(!$res){
            $this->isrepeat = false;
            return;
        }
        foreach((array)$res as $artInfo){
            //$sql = "delete from blog_img where articleId='{$artInfo['id']}'";
            //$db->query($sql);
            $sql = "update `blog_article_info` set isPublished=-1 where id='{$artInfo['id']}'";
            $db->query($sql);
            $sql = "delete from `blog_article_content` where articleId='{$artInfo['id']}'";
            $db->query($sql);
            echo $artInfo['id'].' del'.PHP_EOL;
        }
        //var_dump($res);die;
    }
}
