<?php
class MeetingModel extends RelationModel{
      protected $_link=array(
	    "yuyuemeeting"=>array(
		        'mapping_type'=>BELONGS_TO,
          	    'class_name'=>'Yuyuemeeting',
          		'foreign_key'=>'m_yuyue_id',
				'mapping_fields'=>'y_room_id',
				'as_fields'=>'y_room_id'
		),   
		"meetingroom"=>array(
				'mapping_type'=>BELONGS_TO,
          	    'class_name'=>'Meetingroom',
          		'foreign_key'=>'y_room_id',
		        'mapping_fields'=>'r_name',
				'as_fields'=>'r_name'		
		) 
	  );
}
?>