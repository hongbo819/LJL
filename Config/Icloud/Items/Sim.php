<?php
/**
* @version  v1.0
* @todo Icloud配置 相似度
*/
return array(
    'Base.Sim.getLcs' => array(
        'name' => '计算俩字串最长公共子序列',
        'param'=> array(
            array('str1', '字串1', 1),
            array('str2', '字串2', 1),
            array('code', '编码', 0, 'utf-8/gbk 默认utf-8'),
        ), 
    ),
    'Base.Sim.maxSeq' => array(
        'name' => '计算俩字串最长公共字串',
        'param'=> array(
            array('str1', '字串1', 1),
            array('str2', '字串2', 1),
            array('code', '编码', 0, 'utf-8/gbk 默认utf-8'),
        ), 
    ),
    'Base.Sim.getTextSim' => array(
        'name' => '计算俩文本相似度',
        'param'=> array(
            array('str1', '字串1', 1),
            array('str2', '字串2', 1),
            array('lcs', '0 or 1', 0, '是否返回最长公共子序列'),
        ), 
    ),
    'Base.Sim.simText' => array(
        'name' => '文本相似度判断',
        'param'=> array(
            array('str1', '字串1', 1),
            array('str2', '字串2', 1),
            array('lcs', '0 or 1', 0, '是否返回最长公共子序列'),
            array('diff', '0 or 1', 0, '显示差异'),
        ), 
    ),
);