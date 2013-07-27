<?php if (!defined('THINK_PATH')) exit();?>
<form action="" method="post" enctype="multipart/form-data"><input type="file" name="files[]"/><input name="" value="上传" type="submit" /></form>
<?php if(!empty($filename)): ?><img src="__PUBLIC__/upload/<?php echo ($filename); ?>" /> <a href="__URL__/delete/filename/<?php echo ($filename); ?>">删除图片</a><?php endif; ?>