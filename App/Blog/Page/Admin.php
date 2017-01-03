<?php
    /**
     * 后台管理
     * @author cuihb
     * @since 2015-09
     */
	class Blog_Page_Admin extends Blog_Page_Abstract{
	    private $pageSize=10;
		public function __construct(LJL_Request $input, LJL_Response $output)
		{
		    parent::__construct($input, $output);
		}
		public function validate(LJL_Request $input, LJL_Response $output)
		{
			$output->pageType = 'Admin';
	        
	        if (!parent::baseValidate($input, $output)) {
	            return false;
	        }
	        //判断是否是管理员
	        if(!Helper_Blogconfig::getAdminInfo(array(
	            'username'=>urldecode($input->cookie('blog_username')), 
	            'ckid'=>$input->cookie('blog_ckid'), 
	            'website'=>APP_BLOG_NAME,
	            //'status'   => 0,
	        ))){
	            die('sorry hack~');
	        }
	
			return true;
		}
        public function doDefault(LJL_Request $input, LJL_Response $output){
            $articleId = $input->get('articleid');
            
            $articleInfo = Helper_Blog::getArticleInfo(array(
		        'articleId'     => $articleId, #文章id
		        'fileds'        =>  array('cate', 'title', 'source', 'tags', 'content'), #要查询的字段
		    ));
            
            $picInfo = Helper_Blog::getPicInfo(array('articleId'=>$articleId));
            $picArr = array();
            if(is_array($picInfo)){
                foreach($picInfo as $key=>$val){
                    $picArr[$key] = Helper_Blog::getPicWebPath(array(
                        'imgName' => $val['picName'],
                        'imgExt' => $val['picExt'],
                        'time'    => $val['time'],
                        'rootdir' => UPLOAD_IMG_PATH.'blog_'.APP_BLOG_NAME.'/',
                    ));
                }
            }
            
            
            $output->cate = LJL_Config::get('Blog_'.ucfirst(APP_BLOG_NAME).'_Cate', 'CATE');
            $output->articleId   = $articleId;
            $output->articleInfo = $articleInfo;
            $output->picArr      = $picArr;
			$output->setTemplate('Admin');
		}
		/**
		 * 设置首图地址与文章链接
		 */
		public function doImgshow(LJL_Request $input, LJL_Response $output) {
		    $data = $input->post('imgArr');
		    if(!$data) exit('error');
		    $data = explode("\n", $data);
		    $putDir = '/tmp/'.APP_BLOG_NAME.'.php';
		    if(file_put_contents($putDir, json_encode($data))){
		        exit('ok');
		    } else {
		        exit('error');
		    }
		}
		/**
		 * 发布文章
		 * @param LJL_Request $input
		 * @param LJL_Response $output
		 */
		public function doPublish(LJL_Request $input, LJL_Response $output){
		    $isPublish = intval($input->post('ispublish'));//0:预览，1：发布
		    $articleId = intval($input->post('articleId'));//0:插入，否则：修改
		    $cate      = $input->post('cate');
		    $title     = $input->post('title');
		    $source      = $input->post('source');
		    $tags      = $input->post('tags');
		    $content   = htmlspecialchars(addslashes(($input->post('content', 1))));
		    
		    $imgArr    = $input->post('imgArr', 1);
		    
		    //首图id
		    $firstImgUrl =  $this->matchFirstPic($input->post('content', 1));
		    $firstImgName = $this->getFirtstPicName($firstImgUrl);
		    $firstImgId   = Helper_Blog::getPicId(array('picName'=>$firstImgName));
		    
		    //有无首图截取的是不一样的
		    $desc = $firstImgId ? API_Item_Base_String::getShort(array('str'=>$input->post('content'),'length'=>120,)) : API_Item_Base_String::getShort(array('str'=>$input->post('content'),'length'=>125,));
		    
		    //数据集
		    $insertData = array(
		        'isPublished' => $isPublish,
		        'firstImgId'  => $firstImgId,
		        'cate' => $cate,
		        'title' => $title,
		        'descript' => $desc,
		        'source' => $source,
		        'tags' => $tags,
		        'content' => $content,
		        'imgArr' => $imgArr,
		        'updateTime' => SYSTEM_TIME,
		    );
		    //update
		    if($articleId){
		        $insertData['updateTime'] = SYSTEM_TIME;
		        Helper_Blog::updateArticleInfo(array(
		            'articleId' => $articleId,
		            'updateData'=> $insertData
		        ));
		    //insert
		    }else{
		        //先查看下数据库中是否已经有该文章的题目了（分类也要一致才是）
		        if(Helper_Blog::ishasArticle($cate, $title)){
		            echo 'error';die;
		        }
		        $insertData['insertTime'] = SYSTEM_TIME;
		        $articleId = Helper_Blog::insertArticleInfo(array(
		            'insertData' => $insertData,
		        ));
		    }
		    echo $articleId;die;
		}
		//后台文章列表
		public function DoList(LJL_Request $input, LJL_Response $output){
		    $page = $input->get('page');
		    $articleId = $input->get('articleid');
		    
		    if($page <= 1) $page = 1;
		    $articleList = Helper_Blog::getArticleList(array(
		        'page'     => $page,//当前页
		        'pageSize' => $this->pageSize,//limit
		        'fields'   => array(),//要查询的字段
		        'isPublished'   => 0,//要查询的字段
		        'articleid' => $articleId,
		    ));
		    
		    $articleCount = Helper_Blog::getArticleList(array(
		        'isCount' => 1,
		        'isPublished'   => 0,//要查询的字段
		        'articleid' => $articleId,
		    ));
		    
		    //分页相关
		    $totalPage = ceil($articleCount/$this->pageSize);
		    $pageStr   = Libs_Global_Page::getPageString(array(
		        'page'      => $page,//当前页
		        'pageTotal' => $totalPage,//总页数
		        'urlClass'  => 'Blog_Plugin_Urls',//获取url的类
		        'urlFunc'   => 'getAdminListUrl',//url方法
		        'args'      => array('page'=>$page),//传参
		    ));
		    
            //默认showimg
		    $putDir = '/tmp/'.APP_BLOG_NAME.'.php';
		    $outimg = '';
		    if(file_exists($putDir)) {
		        $imgArr = json_decode(file_get_contents($putDir));
		        foreach((array)$imgArr as $img) {
		            $outimg .= "\n".$img;
		        }
		    }
		    $output->imgStr = $outimg;
		    $output->articleid = $articleId;
		    $output->pageStr = $pageStr;
		    $output->articleList = $articleList;
		    $output->setTemplate('AdminList');
		}
		
		//上传图片
		public function DoUploadImg(LJL_Request $input, LJL_Response $output){
		    $upfile = $input->files('uppic');//客户端传过来的文件
		    $pos = strpos($upfile['name'],'.')+1;
		    $ext = substr($upfile['name'],$pos);//获取后缀名
		    $typelist = array("gif","jpg","png");//限制图片类型
		    
		    $imgInfo = LJL_Api::run("Image.DFS.imgStorage" , array(
		        'rootdir'      => UPLOAD_IMG_PATH.'blog_'.APP_BLOG_NAME.'/'
		    ));
		    $path = $imgInfo[2];//上传到该文件夹
		    $webPath = Helper_Blog::getImgWebPath($imgInfo[2]);
		    	
		    if(!is_dir($path)){
		        LJL_File::mkdir($path);
		    } 
		    	
		    	
		    //获取图片名
		    $picName = $imgInfo[0];
		    $result = $this->uploadFile($upfile,$path,$picName,$webPath,$typelist);//图片上传函数
		    
		    if($result['status']){
		        //图片表中插入数据
		        $imgid = Helper_Blog::insertPic(array('picName'=>$picName,'picExt'=>$ext,'time'=>$imgInfo[1]));
		        echo '<script language="javascript">window.parent.addPic("'.$result['info'].'","'.$imgid.'");</script>';
		    }else{
		        echo '<script language="javascript">window.parent.addPic("error","0");</script>';
		    }
		    
		}
		
		private function uploadFile($upfile,$path,$picName,$web_path,$typelist=array(),$maxsize=2000000){
		    $path = rtrim($path,"/")."/"; //处理上传路径的右侧斜线。
		    //定义返回值信息
		    $res = array('status'=>false,'info'=>"");
		    //1. 判断上传的错误信息
		    if($upfile['error']>0){
		        $res['info']="error";
		        return $res;
		    }
		    //2. 过滤上传文件的类型
		    $pos = strpos($upfile['name'],'.')+1;
		    $ext = substr($upfile['name'],$pos);//获取后缀名
		    if(count($typelist)>0){ //判断是否执行类型过滤
		        if(!in_array($ext,$typelist)){
		            $res['info']="error";
		            return $res;
		        }
		    }
		    //3. 过滤上传文件的大小
		    if($maxsize>0){
		        if($upfile['size']>$maxsize){//最大2M
		            $res['info']="error".$maxsize;
		            return $res;
		        }
		    }
		    $newname=$picName.'.'.pathinfo($upfile['name'],PATHINFO_EXTENSION);
		    //5. 判断并执行文件上传。
		    if(is_uploaded_file($upfile['tmp_name'])){
		        if(move_uploaded_file($upfile['tmp_name'],$path.$newname)){
		            @chmod($path.$newname, 0777);
		            
		            //加边框以及加网址
		            //边框,暂时隐去
// 		            API_Item_Image_IM::border(array(
// 		                'srcPath'       => $path.$newname, #源文件路径
// 		                'desPath'       => $path.$newname, #目标文件路径
// 		                'borderColor'   => '#40AA53', #边框颜色，默认红色, 支持red、yellow颜色单词
// 		                'borderWidth'   => 1,  #左右边框宽度,默认2px
// 		                'borderHeight'  => 1,  #上下边框高度，默认2px
// 		            ));
		            API_Item_Image_IM::zoom(array(
					           'srcPath'       => $path.$newname, #源文件路径
					           'desPath'       => $path.$newname, #目标文件路径
					           'size'          => '800x800', #要缩放的图片尺寸 如120x90
					           'progressive'   => 0,  #是否进行渐进式渲染
					           'quality'       => 90,  #图片品质
					           'stripExif'     => true, #是否去掉Exif信息 拍摄相机信息等，除非显示拍摄相机的需求，否则无用
								));
		            API_Item_Image_IM::addText(array(
		                'srcPath'       => $path.$newname, #源文件路径
		                'desPath'       => $path.$newname, #目标文件路径
		                'text'          => str_replace('http://', '', trim(WWW_WEB, '/')), #文本内容
		                'font'          => 'helvetica', #文本字体
		                'txtColor'      => '#21AD39', #文本颜色, 默认黑色
		                'fontSize'      => 15,  #文本字号
		                'leftOffset'    => 7,  #文本距左边偏移量
		                'topOffset'     => 15, #文本距上边偏移量
		            ));
		            
		            $res['info']=rtrim($web_path,'/')."/".$newname;
		            $res['status']=true;
		        }else{
		            $res['info']='error';
		        }
		    }else{
		        $res['info']='error';
		    }
		    return $res;
		}
		private function matchFirstPic($content){
		    if(preg_match("/<img src=\"(.*?)\"/", $content, $matches))
		       return $matches[1];
		}
		private function getFirtstPicName($picUrl){
		    if(!$picUrl) return false;
		    $end = substr($picUrl, strrpos($picUrl, '/')+1);
		    return substr($end, 0, strrpos($end, '.'));
		}
		
	}
?>