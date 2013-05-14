<?php 
  require_once('../simple_template.class.php');
  $template = simple_template::extendTemplate('parent.php');
?>
<?php $template->startBlock("content");?>
  <p>New Content Within the Child Template<p>
<?php $template->endBlock();?>