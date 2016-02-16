<?php
/**
* @version  v1.0
* @todo Icloud配置 新浪微博开放平台
*/
return array(
    'Open.Sina.getAuthorizeURL' => array(
        'name' => '获取AuthorizeURL用于 微博登录 按钮',
        'param'=> array(
            array('redirect_uri', 'redirect_uri', 1, '回调url'),
        ), 
    ),
    'Open.Sina.getLoginTokens' => array(
        'name' => '同意授权后获取用户信息',
        'param'=> array(
            array('code', 'code', 1, '用户点击同意按钮后 会生成'),
            array('redirect_uri', 'redirect_uri', 1, '回调url'),
        ), 
    ),
    'Open.Sina.getWeiboObj' => array(
        'name' => '获得微博的操作对象，可执行所有SDK方法',
        'param'=> array(
            array('appuid', 'appuid', 0, '站内用户uid appuid,apiuid,name任填一个'),
            array('apiuid', 'apiuid', 0, '新浪平台用户ID'),
            array('name', '用户名', 0, '新浪平台用户名'),
        ),
    ),
    'Open.Sina.getUserApiId' => array(
        'name' => '映射后获得app用户的的weiboId',
        'param'=> array(
            array('appuid', 'appuid', 1, '站内用户uid'),
        ),
    ),
    'Open.Sina.getAccessToken' => array(
        'name' => '获得用户的accessToken',
        'param'=> array(
            array('appuid', 'appuid', 0, '站内用户uid appuid,apiuid,name任填一个'),
            array('apiuid', 'apiuid', 0, '新浪平台用户ID'),
            array('name', '用户名', 0, '新浪平台用户名'),
        ),
    ),
    'Open.Sina.getRdmAccessToken' => array(
        'name' => '获得一个随机的AccessToken',
        'param'=> array(
        ),
    ),
    'Open.Sina.getUserInfo' => array(
        'name' => '获得用户的信息',
        'param'=> array(
            array('appuid', 'appuid', 0, '站内用户uid appuid,apiuid,name任填一个'),
            array('apiuid', 'apiuid', 0, '新浪平台用户ID'),
            array('name', '用户名', 0, '新浪平台用户名'),
            array('accessToken', 'accessToken', 0, 'accessToken'),
        ),
    ),
    'Open.Sina.getUserFriends' => array(
        'name' => '获得用户的好友列表',
        'param'=> array(
            array('appuid', 'appuid', 0, '站内用户uid appuid,apiuid,name任填一个'),
            array('apiuid', 'apiuid', 0, '新浪平台用户ID'),
            array('name', '用户名', 0, '新浪平台用户名'),
            array('accessToken', 'accessToken', 0, 'accessToken'),
            array('offset', 'offset', 0, '游标值，返回 的next_cursor的值指下一页'),
            array('num', 'num', 0, '获得关注数量'),
        ),
    ),
    'Open.Sina.getUserFollowers' => array(
        'name' => '获得用户的好友列表',
        'param'=> array(
            array('appuid', 'appuid', 0, '站内用户uid appuid,apiuid,name任填一个'),
            array('apiuid', 'apiuid', 0, '新浪平台用户ID'),
            array('name', '用户名', 0, '新浪平台用户名'),
            array('accessToken', 'accessToken', 0, 'accessToken'),
            array('offset', 'offset', 0, '游标值，返回 的next_cursor的值指下一页'),
            array('num', 'num', 0, '获得粉丝数'),
        ),
    ),
    'Open.Sina.getUserTimeLine' => array(
        'name' => '获得当前用户的微博列表',
        'param'=> array(
            array('appuid', 'appuid', 0, '站内用户uid appuid,apiuid,name任填一个'),
            array('apiuid', 'apiuid', 0, '新浪平台用户ID'),
            array('name', '用户名', 0, '新浪平台用户名'),
            array('accessToken', 'accessToken', 0, 'accessToken'),
            array('page', 'page', 0, '第几页，默认1'),
            array('num', 'num', 0, '数量'),
            array('sinceId', 'ID比since_id大的微博消息', 0, '即比since_id发表时间晚的微博消息'),
            array('maxId', 'maxId', 0, 'ID小于或等于max_id的提到当前登录用户微博消息'),
            array('feature', '类型ID', 0, '0：全部、1：原创、2：图片、3：视频、4：音乐，默认为0'),
            array('trimUser', '回值中user信息开关', 0, '0：返回完整的user信息、1：user字段仅返回uid，默认为1。'),
            array('baseApp', '是否只获取当前应用的数据', 0, '0为否（所有数据），1为是（仅当前应用）'),
        ),
    ),
    'Open.Sina.getPublicTimeLine' => array(
        'name' => '获得新浪微博的最新微博',
        'param'=> array(
            array('accessToken', 'accessToken', 0, 'accessToken'),
            array('page', 'page', 0, '页'),
            array('num', 'num', 0, '数量'),
            array('baseApp', '是否只获取当前应用的数据', 0, '0为否（所有数据），1为是（仅当前应用）'),
        ),
    ),
    'Open.Sina.getHomeTimeLine' => array(
        'name' => '获得用户首页的最新微博',
        'param'=> array(
            array('appuid', 'appuid', 0, '站内用户uid appuid,apiuid,name任填一个'),
            array('apiuid', 'apiuid', 0, '新浪平台用户ID'),
            array('name', '用户名', 0, '新浪平台用户名'),
            array('page', 'page', 0, '第几页，默认1'),
            array('num', 'num', 0, '数量'),
            array('sinceId', 'ID比since_id大的微博消息', 0, '即比since_id发表时间晚的微博消息'),
            array('maxId', 'maxId', 0, 'ID小于或等于max_id的提到当前登录用户微博消息'),
            array('feature', '类型ID', 0, '0：全部、1：原创、2：图片、3：视频、4：音乐，默认为0'),
            array('baseApp', '是否只获取当前应用的数据', 0, '0为否（所有数据），1为是（仅当前应用）'),
        ),
    ),
    'Open.Sina.getRepost' => array(
        'name' => '获得当前用户的转发的微博',
        'param'=> array(
            array('appuid', 'appuid', 0, '站内用户uid appuid,apiuid,name任填一个'),
            array('apiuid', 'apiuid', 0, '新浪平台用户ID'),
            array('name', '用户名', 0, '新浪平台用户名'),
            array('page', 'page', 0, '第几页，默认1'),
            array('num', 'num', 0, '数量'),
            array('sinceId', 'ID比since_id大的微博消息', 0, '即比since_id发表时间晚的微博消息'),
            array('maxId', 'maxId', 0, 'ID小于或等于max_id的提到当前登录用户微博消息'),
        ),
    ),
    'Open.Sina.getAtmeList' => array(
        'name' => '获得@当前用户的微博',
        'param'=> array(
            array('appuid', 'appuid', 0, '站内用户uid appuid,apiuid,name任填一个'),
            array('apiuid', 'apiuid', 0, '新浪平台用户ID'),
            array('name', '用户名', 0, '新浪平台用户名'),
            array('page', 'page', 0, '第几页，默认1'),
            array('num', 'num', 0, '数量'),
            array('sinceId', 'ID比since_id大的微博消息', 0, '即比since_id发表时间晚的微博消息'),
            array('maxId', 'maxId', 0, 'ID小于或等于max_id的提到当前登录用户微博消息'),
            array('byAuthor', '作者筛选类型', 0, '0：全部、1：我关注的人、2：陌生人，默认为0。'),
            array('bySource', '来源筛选类型', 0, '0：全部、1：来自微博、2：来自微群，默认为0。'),
            array('byType', '原创筛选类型', 0, '0：全部微博、1：原创的微博，默认为0。'),
        ),
    ),
    'Open.Sina.getUserTags' => array(
        'name' => '获得@当前用户的微博收藏标签',
        'param'=> array(
            array('appuid', 'appuid', 0, '站内用户uid appuid,apiuid,name任填一个'),
            array('apiuid', 'apiuid', 0, '新浪平台用户ID'),
            array('name', '用户名', 0, '新浪平台用户名'),
            array('page', 'page', 0, '第几页，默认1'),
            array('num', 'num', 0, '数量'),
        ),
    ),
    'Open.Sina.getShortUrl' => array(
        'name' => '获取对应的短链接',
        'param'=> array(
            array('url', 'url', 1, '源URL地址 http开头'),
        ),
    ),
    'Open.Sina.getWeiboByUrl' => array(
        'name' => '获取包含该链接的微博',
        'param'=> array(
            array('url', 'url', 1, '源URL地址 http开头 sina锚点结尾'),
            array('num', 'num', 0, '返回的条数'),
            array('type', '抓取类型 ', 0, ' 1-微博 2-评论 '),
        ),
    ),
);