<form action="" method="post" enctype="multipart/form-data"><input type="file" name="files[]"/><input name="" value="上传" type="submit" /></form>
<notempty name="filename">
	<img src="/Index/upload/{$filename}" /> <a href="/Index/delete/filename/{$filename}">删除图片</a>
</notempty>