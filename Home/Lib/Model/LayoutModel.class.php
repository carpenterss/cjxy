<?php
	class LayoutModel extends RelationModel{
		  //查询员工表以及员工所在的部门表和职位表
		  protected $_link=array(
			'Element'=> array(  
     			'mapping_type'=>BELONGS_TO,
          		'class_name'=>'Element',
          		'foreign_key'=>'cl_eid',
				'mapping_fields'=>'e_path,e_width,e_height',
				'as_fields'=>'e_path,e_width,e_height',
			),	
		);		
	}
?>