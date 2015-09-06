<?php defined('InShopNC') or exit('Access Invalid!');?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $output['seo_title'];?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="/wifi/css/reset.css">
    <link rel="stylesheet" type="text/css" href="/wifi/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/wifi/css/main.css">
    <link rel="stylesheet" type="text/css" href="/wifi/css/member.css">
</head>
<body>
    <header id="header"></header>
    <?php
    require_once($tpl_file);
    ?>
    <div class="footer" id="footer"></div>
    <input type="hidden" name="referurl">
    <script type="text/javascript" src="/wifi/js/config.js"></script>
    <script type="text/javascript" src="/wifi/js/zepto.min.js"></script>
    <script type="text/javascript" src="/wifi/js/template.js"></script>
    <script type="text/javascript" src="/wifi/js/common.js"></script>
    <script type="text/javascript" src="/wifi/js/tmpl/common-top.js"></script>
    <script type="text/javascript" src="/wifi/js/simple-plugin.js"></script>
    <script type="text/javascript" src="/wifi/js/tmpl/login.js"></script>
</body>
</html>