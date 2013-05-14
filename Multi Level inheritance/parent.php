<?php 
require_once('../simple_template.class.php');
$template = new simple_template(); 
?>
<html>
  <head>
    <title>Pure PHP5 Templates Example</title>
  </head>

<body>
  <div>
    <?php $template->startBlock("content");?>
    <p>Basic Content<p>
    <?php $template->endBlock();?>
  </div>
</body>
</html>