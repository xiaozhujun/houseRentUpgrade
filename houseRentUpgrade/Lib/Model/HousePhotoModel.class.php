<?php
class HousePhotoModel extends Model{
	protected $trueTableName = 'house_photo';

    /*
     * 根据houseId查询房屋所有照片
     */
    function getHousePhotos($houseId){

    	if($houseId<=0){
			$photos=null;
			return $photos;
    	}
    		 
    	$querySQL = "select photoURL from house_photo where houseId=".$houseId;
    	$photos= $this->query($querySQL);
		return $photos;
    	
    }

    //将照片添加到房源
    function addPhotoToHouse($houseId,$userId,$photos)
    {
    	if(is_null($photos)) return false;
    	$map["id"] = array("in",$photos);
    	$map["userId"] = array("eq",$userId);
    	
    	return $this->where($map)->setField("houseId",$houseId);
    }
    
}