# tphack
# Thinkphp3/5 Log文件泄漏利用工具

## 介绍

很多时候配置不当，导致Log文件泄漏，泄漏的文件可能包含了登录密码查询的SQL等敏感信息。

程序自动遍历所有的Log文件，配合整合、筛选，找出可以利用的地方。

## 使用

### 下载脚本

修改php文件中的$url地址及年份。

```
php tp3.php
 
php tp5.php
```

### 数据处理

先肉眼看，搜passord、admin等关键词，或者用一些正则匹配敏感信息。给个参考：

```
<?php

system("cat *.log > all.log");//所有日志写到一个文件all.log里

$file = file_get_contents("all.log");

preg_match_all("/\[.*\].*(\d+\.\d+\.\d+\.\d+)\s(\/.*)/", $file, $matches);//写正则

file_put_contents("res.txt", implode("\n", $matches[2]));//正则结果，需调试

system("sort res.txt | uniq>res.txt");//去重
```
  
## 注意

Log文件的路径，建议手工测试。比如默认的Application可能会修改为App等。

## 其他

漏洞很古老，按理说如果吧Runtime暴露给web服务，而且没有权限限制，是不符合Thinkphp开发规范的，但实际上，还是很多人、很多开源程序这么干。

另玩有的是配置了.htaccess限制目录权限，可用的IIS无效导致泄漏。

之际往往与得到，一个常用脚本。
