<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
    	$this->display("index");
	}
	public function f(){
		F('name','success');
		dump(F('name'));
	}
	public function s(){
		$name=s('name');
		if(!$name){
			s('name','success',10);
			$this->show('S缓存已过期，现在已经重新设置了值，请重新刷新浏览器');	
		}else{
			dump(s('name'));
			$this->show('缓存过期时间是10秒，请10秒后查看是否过期');
		}
	}
	public function upload(){
		    if (!empty($_FILES)) {
            import("@.ORG.UploadFile");
            $config=array(
                'allowExts'=>array('jpg','gif','png'),
                'savePath'=>'/Index/upload/',
                'saveRule'=>'time',
            );
            $upload = new UploadFile($config);
            $upload->thumb=true;
            $upload->thumbMaxHeight=100;
            $upload->thumbMaxWidth=100;
            if (!$upload->upload()) {
                $this->error($upload->getErrorMsg());
            } else {
                $info = $upload->getUploadFileInfo();
				$this->assign('filename',$info[0]['savename']);
            }
		}
		$this->display("upload");

	}
	
	public function delete($filename){
		if(file_delete('/Index/upload/'.$filename) && file_delete('/Index/upload/thumb_'.$filename)){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}
	public function log(){
		Log::write('一条测试日志');
		$this->show('日志已记录，请查看日志是否生成');
	}
}
