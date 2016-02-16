<?php
/**
* @version v1.0
* @todo 从csdn抓取文章
*/

class Auto_Blog_Page_Curlarticle extends Auto_Blog_Page_Abstract {
    /**
     * @var 循环的个大类下的标签
     */
    private $dataArr = array(
        'prolan'=>array('PHP','Ruby','C++','python','C语言','Node.js','Objective-C','Swift','Perl',
            'C#','Java','Pascal','PL/SQL','Go语言','Lua','Erlang','Visual Basic','R语言','MATLAB',
            'COBOL','ABAP','VBScript','Awk','LISP','Django','Ruby on Rails','JSP','Spring','Struts',
            'Hibernate','Java EE','JVM','EJB','Scala','php apc',
            ),
    	'dbms'=>array('MySQL索引','HBase','Memcached','SQL Server','MySQL','Oracle','MongoDB','PostgreSQL',
    		'SQLite','DB2','Cassandra','数据库优化','Redis','Sybas ASE','索引','索引优化','Teradata',
    		),
        'linux'=>array('Nginx','Apache','linux命令','shell','linux安全','linux文件系统','用户与用户组','linux进程管理',
            'linux内存管理','鸟哥私房菜','linux kernel','TCP/IP',
            ),
        'jscss'=>array('HTML5','CSS','ECMAScript','JavaScript','CoffeeScript',
            'jQuery','Bootstrap','JS','UI设计',
            ),
        'fm'=>array('Storm','Docker','Lighttpd','HAProxy','MapReduce','OpenStack','RabbitMQ','ZooKeeper','软件架构','Kafka','Spark','分布式','缓存系统','大数据','大型架构','CDN','HDFS','Hadoop','云计算','高并发','数据分析',
            '消息队列','负载均衡','任务分发','FastDFS','容灾备份','主从部署','数据挖掘',
            ),
        'math'=>array('数据结构','经典算法','排序算法','时间复杂度','空间复杂度','算法效率','图像算法','人工智能','算法导论',
            '面向对象','设计模式'
            ),
    );
    //开始段
    private $startFrom = array(
        'cate' => 'fm',
        'tags' => 'CDN',
        'page' => 5,
    );
    private $maxPage = 10;
    
    
    private $tags = '';  //当前跑的标签
    private $cate = ''; //当前跑的编程语言分类
    //项目
    private $website = 'blog_share';
    
    //都是标志位、无需修改
    private $page = 1;
    private $failtime = 0;
    
    //图片上传地址
    private $uploadRootdir = '/www/img/';
    //图片服务器
    private $imgWeb = 'http://img.cuihongbo.com/';
    /**
     * 文章抓取程序
     * 执行方式: php index.php server --c=Curlarticle --a=Catcharticle
     */
    public function doCatcharticle(LJL_Request $input){
        //循环跑数据
        foreach($this->dataArr as $cate=>$tagsArr){
            //非起始cate 继续
            if($this->startFrom && $this->startFrom['cate'] !== $cate)
                continue;
            $this->cate = $cate;
            foreach($tagsArr as $tags){
                //非起始tags 继续
                if($this->startFrom && $this->startFrom['tags'] !== $tags)
                    continue;
                $this->tags = $tags;
                $this->catchArticle();
                sleep(3);
            }
            sleep(5);
        }
        exit();
    }
    /**
     * 根据页码循环抓取列表页
     */
    private function catchArticle() {
        //http://so.csdn.net/so/search/s.do?p=3&q=php&t=blog&domain=&o=&s=&u=null
        //一个列表页一个列表页进行抓取
        for ($page = 1; $page <= $this->maxPage; $page++) {
            
            if($this->startFrom){
                if($this->startFrom['page'] !== $page)//如果不是开始page 继续 只要继续了 那么startFrom肯定要空
                    continue;
                $this->startFrom = false;
            }
            $this->page=$page;
            echo 'cate '.$this->cate.' tags '.$this->tags.' page '.$page.' start...'.PHP_EOL;
            $this->dealListPage(LJL_Http::curlPage(array(
                'url'      => 'http://so.csdn.net/so/search/s.do?p='.$page.'&q='.urlencode($this->tags).'&t=blog&domain=&o=&s=&u=null',//cnblog url
                'timeout'  => 4,
            )));
            file_put_contents('/www/LJL/Auto/Blog/Page/curl.log', 'now cate is '.$this->cate.' tags is '.$this->tags.' now page is '.$page." end \n", FILE_APPEND);
            sleep(1);
        }
    }
    /**
     * 根据列表页内容抓取详情页
     * @param unknown $content
     */
    private function dealListPage($content){
        preg_match_all("/<dt><a href=\"(.*?)\"/m", $content, $matches, PREG_SET_ORDER);
        foreach((array)$matches as $url){
            $this->dealDetailPage(LJL_Http::curlPage(array(
                'url'      => $url[1],
                'timeout'  => 6,
            )),$url[1]);
        }
    }
    //单页面测试效果 执行方式: php index.php server --c=Curlarticle --a=Testdetail
    public function doTestdetail(LJL_Request $input){
        $url = 'http://blog.csdn.net/erwin2012/article/details/46124639';
        $this->dealDetailPage(LJL_Http::curlPage(array(
            'url'      => $url,
            'timeout'  => 6,
        )),$url);
        exit();
    }
    
    //分析详情页
    private function dealDetailPage($content, $url=''){
        preg_match("/link_title\"><a href=\"(.*?)\">([\s\S]*?)<\/a><\/span>[\s\S]*?class=\"article_content\">([\s\S]*?)<div  style/m", $content, $matches);
        if(count($matches)<3){
            preg_match("/link_title\"><a href=\"(.*?)\">([\s\S]*?)<\/a><\/span>[\s\S]*?class=\"article_content\">([\s\S]*?)<\/div>[\s]+<!-- Baidu Butt/m", $content, $matches);
            //var_dump($matches);die;
            if(count($matches)<3){
                if($this->failtime>10){
                    file_put_contents('/www/LJL/Auto/Blog/Page/curl.log', 'curl failtime > 10, now cate is '.$this->cate.' tags is '.$this->tags.' now page is '.$this->page."\n", FILE_APPEND);
                    exit();
                }
                $this->failtime++;
                return;
            }
        }
        //return;//-----------------------
        $url = 'http://blog.csdn.net'.$matches[1];
        $title = trim(str_replace(array('\n', '\r', '\t'), array('', '', ''), $matches[2]));
        //去除文中超链接
        $content = $this->filterHref($matches[3]);
        //echo $content;die;
        $this->insertArticle($url, $title, $content);
        $this->failtime = 1;
    }
    /**
     * 过滤文章超链接
     */
    private function filterHref($content){
        if(!$content) return;
        return preg_replace_callback("/<a[^>]+>([\S\s]+?)<\/a>/i",
                    function($matchs){
                        $str = $matchs[1];
                        if(!$str) return '';
                        $arr = array('www.','http://','https://','.com','.cn','.org','.net','.cc');
                        foreach($arr as $k=>$v){
                            if(stripos($str,$v) !== false) return '';
                        }
                        return $str;
                    },
                    $content
                );
    }
    /**
     * 插入文章
     */
    private function insertArticle($url, $title, $content){
        if(!$title || !$content) return;
        $db = Db_Blog::instance(null, $this->website);
        //已有该文章则退出
        $title = htmlspecialchars(strip_tags(addslashes(str_replace("'", '"', $title))));
        if(Helper_Blog::ishasArticle('', $title))
            return;
        //echo $title;die;
        //对于有图片的文章进行搬运图片处理
        preg_match_all("/<img src=\"(.*?)\"/", $content, $matches, PREG_SET_ORDER);
        $imgidArr = array();
        if($matches){
            if(count($matches) > 10) return;
            foreach((array)$matches as $imgsrc){
                $imgInfo = $this->getImgNameDir();
                if(!$imgsrc[1]) continue;
                //1、移动图片
                exec('wget -q --tries=3 -O '.rtrim($imgInfo[1], '/').'/'.$imgInfo[0].'.jpg '.$imgsrc[1]);
                //2、向自己库中插入图片
                $imgidArr[] = Helper_Blog::insertPic(array(
    		        'picName'       =>  $imgInfo[0], #图片名称
    		        'picExt'    =>  'jpg', #图片扩展名
    		        'time'         =>  $imgInfo[3], #上传时间
    		    ));
                //3、图片地址字符串替换
                $content = str_replace($imgsrc[1], $imgInfo[2].'/'.$imgInfo[0].'.jpg', $content);
            }
        }
        //插入文章
        $firstImgId = $imgidArr ? $imgidArr[0] : 0;
        $desc = $firstImgId 
            ? API_Item_Base_String::getShort(array('str'=>strip_tags($content),'length'=>120,)) 
            : API_Item_Base_String::getShort(array('str'=>strip_tags($content),'length'=>150,));
        $articleId = Helper_Blog::insertArticleInfo(array(
            'insertData' => array(
                'firstImgId'  => $firstImgId,
                'insertTime'  => SYSTEM_TIME,
                'isPublished' => 0,
                'cate'        => $this->cate,
                'tags'        => $this->tags,
                'title'       => $title,
                'descript'    => ' '.strip_tags(addslashes(str_replace("'", '"', $desc))).' ',
                'source'      => $url,
                'content'     => ' '.htmlspecialchars(addslashes((preg_replace("/<script[\s]*.*?<\/script>/si", '', $content)))). ' ',
                'imgArr'      => $imgidArr//在此处修改图片的文章id
            ), #array('name'=>'cuihb');
        ));
        echo 'article '.$articleId.' is ok'.PHP_EOL;
    }
    //图片存储相关信息
    private function getImgNameDir(){
        $imgInfo = LJL_Api::run("Image.DFS.imgStorage" , array(
            'rootdir'      => $this->uploadRootdir.$this->website.'/'
        ));
        $picName = $imgInfo[0];// 0/1时间/2
        $path    = $imgInfo[2];//上传到该文件夹
        $webPath = $this->getImgWebPath($imgInfo[2]);
         
        if(!is_dir($path)){
            LJL_File::mkdir($path);
        }
        return array($picName, $path, $webPath, $imgInfo[1]);
    }
    private function getImgWebPath($path){
        return rtrim($this->imgWeb, '/').str_replace(trim($this->uploadRootdir, '/'), '', trim($path, '/'));
    }
}
