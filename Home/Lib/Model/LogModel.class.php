<?php
	class LogModel extends RelationModel{
		  //查询员工表以及员工所在的部门表和职位表
		  protected $_link=array(
			'Employees'=> array(  
     			'mapping_type'=>BELONGS_TO,
          		'class_name'=>'Employees',
          		'foreign_key'=>'l_uid',
				'mapping_fields'=>'u_name',
				'as_fields'=>'u_name',
			),	
		);		
	}
?>