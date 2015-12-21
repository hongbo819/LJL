<?php
/**
* @version  v1.0
* @todo helper配置
*/
return array(
    'MANAGE' => array(
        '文章信息接口' => array(
            'Blog::getArticleList' => array(
                'name' => '获得文章列表',
                'param'=> array(
                    array('page', '第几页', 0, '默认是第一页开始'),
                    array('pageSize', '每页条数', 0, '默认是10条'),
                    array('fields', '所需查询字段', 0, '以英文‘,’号分割，如title,tags'),
                    array('cate', '分类', 0, '某分类下文章'),
                    array('tag', '标签', 0, '某标签下文章'),
                    array('isPublished', '是否已发布', 0, '0:所有 1：已发布'),
                    array('articleid', '文章id', 0, '查询一篇文章也可用此方法'),
                    array('updateTime', '时间戳', 0, '大于某个时间戳'),
                    array('isCount', '是否查询总数', 0, '0:不要 1：要'),
                    array('order', 'order条件', 0, '如：order by id desc'),
                ), 
            ),
            'Blog::getArticleInfo' => array(
                'name' => '获取单个文章信息',
                'param'=> array(
                    array('articleId', '文章id', 1, '文章id'),
                    array('fileds', '所需查询字段', 0, '以英文‘,’号分割，如title,tags'),
                ),
            ),
        ),
        '博客配置管理信息接口' => array(
            'Blogconfig::getAdminInfo' => array(
                'name' => '查询管理员信息',
                'param'=> array(
                    array('username', '用户名', 0, '管理员用户名'),
                    array('website', '博客前缀', 0, '例如：cui、laura'),
                    array('webname', '博客中文昵称', 0, '例如：时空蚂蚁'),
                ),
            ),
            'Blogconfig::getAdminList' => array(
                'name' => '查询管理员列表',
                'param'=> array(
                    array('page', '第几页', 0, '默认第一页开始'),
                    array('pageSize', '每页条数', 0, '默认10条'),
                    array('fields', '所需查询字段', 0, '以英文逗号分隔'),
                    array('isCount', '是否查询总数', 0, '0不是 1是'),
                    array('status', '是否上线状态', 0, '默认1。0不是 1是'),
                    array('order', '排序方式', 0, '例如：order by id desc'),
                ),
            ),
        ),
    ),
);
