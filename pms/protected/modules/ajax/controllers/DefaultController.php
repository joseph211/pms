<?php

class DefaultController extends Controller
{
	public $layout = '..//layouts/ajax';
	
	public function actionIndex()
	{
		$this->render('index');
	}
	
}