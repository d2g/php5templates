<?php 
require_once('../simple_template.class.php');
$template = new simple_template(); 
?>
<html>
<head>
<title>Pure PHP5 Templates Example</title>
<?php $template->startBlock("javascript");?>
<script src="jquery.min.js" type="text/javascript"></script>

<?php $template->startBlock("additional_javascript");?>
<?php $template->endBlock();?>

<?php $template->endBlock();?>
</head>

<body>
<div>
<?php $template->startBlock("content");?>
<p>Basic Content<p>
<?php $template->endBlock();?>
</div>
</body>
</html>