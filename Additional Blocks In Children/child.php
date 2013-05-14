<?php 
require_once('../simple_template.class.php');
$template = simple_template::extendTemplate('parent.php');
?>
<?php $template->startBlock("content");?>
<header>
<?php $template->startBlock("department");?>
<?php $template->endBlock();?>
</header>
<article>
<?php $template->startBlock("information");?>
Default Information
<?php $template->endBlock();?>
</article>
<?php $template->endBlock();?>