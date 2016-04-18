<?php
class MeetingnoticeModel extends RelationModel{
      protected $_link=array(
	    "Department"=>array(
		        'mapping_type'=>BELONGS_TO,
          	    'class_name'=>'Department',
          		'foreign_key'=>'n_department',
				'mapping_fields'=>'d_name',
				'as_fields'=>'d_name'
		),
	  "Employees"=>array(
				'mapping_type'=>BELONGS_TO,
          	    'class_name'=>'Employees',
          		'foreign_key'=>'n_uid',
		        'mapping_fields'=>'u_name',
				'as_fields'=>'u_name'		
		) 
	  );
}
?>