<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<div>
    <div><span>此次登陆IP:</span><span><?php echo ($loginInfo["ip"]); ?></span></div>
    <div><span>登陆系统的时间:</span><span><?php echo ($loginInfo["time"]); ?></span></div>
</div>
</body>
</html>