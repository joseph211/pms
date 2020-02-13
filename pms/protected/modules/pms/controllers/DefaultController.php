<?php

class DefaultController extends Controller
{
	public $layout = '..//layouts/pms';
	
	public function actionIndex()
	{
		$this->render('index');
	}
	
}