<?php
	class EmployeesModel extends RelationModel{
		  //查询员工表以及员工所在的部门表和职位表
		  protected $_link=array(
			'Department'=> array(  
     			'mapping_type'=>BELONGS_TO,
          		'class_name'=>'Department',
          		'foreign_key'=>'u_department',
				'mapping_fields'=>'d_name',
				'as_fields'=>'d_name',
			),	
			
			'Position'=>array(
			    'mapping_type'=>BELONGS_TO,
          		'class_name'=>'Position',
          		'foreign_key'=>'u_position',
				'mapping_fields'=>'p_name',
				'as_fields'=>'p_name',			
			),
		);		
	}
?>