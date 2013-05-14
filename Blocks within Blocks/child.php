<?php 
require_once('../simple_template.class.php');
$template = simple_template::extendTemplate('parent.php');
?>
<?php $template->startBlock("additional_javascript");?>
<script type="text/javascript">
$(document).ready(function() {
alert("Here");
});
</script>
<?php $template->endBlock();?>