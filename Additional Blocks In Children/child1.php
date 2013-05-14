<?php 
require_once('../simple_template.class.php');
$template = simple_template::extendTemplate('child.php');
?>
<?php $template->startBlock("department");?>
Human Resources
<?php $template->endBlock();?>
<?php $template->startBlock("information");?>
HR Info.
<?php $template->endBlock();?>