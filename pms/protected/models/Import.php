<?php
class Import extends CFormModel
{
	public $list;
	public $dir;
	
	public function rules()
	{
		return array(
		array('list', 'file', 'types'=>'xls'),
		);
	}
	
	
}