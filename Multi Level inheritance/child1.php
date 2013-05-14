<?php 
require_once('../simple_template.class.php');
$template = simple_template::extendTemplate('child.php');
?>
<?php $template->startBlock("content");?>
  <p>Content Within Grandchild<p>
<?php $template->endBlock();?>