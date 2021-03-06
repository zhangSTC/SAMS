<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>安全风险评估管理系统</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="format-detection" content="telephone=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="alternate icon" type="image/png" href="assets/i/favicon.png">
  <link rel="alternate icon" type="image/png" href="/assets/i/favicon.png">
  <link rel="stylesheet" href="/assets/css/amazeui.min.css"/>
  <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>

<?php include_once 'app/views/static/header.php'; ?>

<div class="am-g">
  <div class="am-u-lg-10 am-u-md-10 am-u-sm-centered">
  <!--title-->
  <div class="am-cf am-padding">
    <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">帮助页面</strong> / <small>Help Page</small></div>
  </div>
  <hr/>
  <!--title end-->

  <br/>
  <?php include 'app/views/help/asset_level.php';?>

  <br/>
  <?php include 'app/views/help/asset_cfd.php';?>

  <br/>
  <?php include 'app/views/help/asset_avl.php';?>

  <br/>
  <?php include 'app/views/help/asset_itg.php';?>

  </div>
</div>

<?php include_once 'app/views/static/footer.php'; ?>

</body>
</html>
