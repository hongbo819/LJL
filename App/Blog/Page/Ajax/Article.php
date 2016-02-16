<?php 
/**
 * 博客文章相关的ajax
 * @author cuihb
 * @since 2015-08-04
 */
class Blog_Page_Ajax_Article extends Blog_Page_Abstract{
    public function __construct(LJL_Request $input, LJL_Response $output)
    {
        
    }
    public function validate(LJL_Request $input, LJL_Response $output)	{
    
        if (!parent::baseValidate($input, $output)) {
            return false;
        }
        return true;
    }
    //文章浏览数浏览数加1
    public function doAddview(LJL_Request $input, LJL_Response $output){
        $articleId = (int)$input->get('articleid');
        Helper_Blog::addArticleView($articleId);
        exit();
    }
    //标签浏览数加1
    public function doAddtagview(LJL_Request $input, LJL_Response $output){
        $tag  = $input->get('tag');
        $cate = $input->get('cate');
        //搜索
        if(!$cate){
            Helper_Blogconfig::searchRecord(APP_BLOG_NAME, $tag);
        //标签
        }else{
            Helper_Blog::addTagView($tag, $cate);
        }
        exit();
    }
}
?>