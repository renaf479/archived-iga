<?php

class IgaController extends AppController {
	public $components 	= array('Session', 'RequestHandler');
	public $uses		= array('Game');
/*
	public $helpers 	= array('Form', 'Html', 'Session', 'Js', 'Usermgmt.UserAuth', 'Minify.Minify');
	
	public $uses		= array('OriginAd', 
								'OriginComponent',
								'OriginDemo',
								'OriginSite',
								'OriginTemplate',
								'OriginAdSchedule', 
								'OriginAdDesktopInitialContent', 
								'OriginAdDesktopTriggeredContent',
								'OriginAdTabetInitialContent', 
								'OriginAdTabletTriggeredContent',
								'OriginAdMobileInitialContent', 
								'OriginAdMobileTriggeredContent',
								'Usermgmt.User',
								'Usermgmt.UserGroup', 
								'Usermgmt.LoginToken');
*/

	public function beforeFilter() {
		parent::beforeFilter();
	}
	
	/**
	* POST router
	*/
	public function platformPost() {
		$this->autoRender = false;
		if($this->request->data['route']) {
			$route		= $this->request->data['route'];
			unset($this->request->data['route']);
			$response	= $this->$route($this->request->data);
			$this->set('post', $response);
		}
	}
	
	/**
	* GET router
	*/
	public function platformGet() {
		$this->autoRender = false;
		if($this->request->params['feed']) {
			$route		= $this->request->params['feed'];
			$this->$route();
		}
	}
	
	/**
	* Loads the complete listing of games
	*/
	private function games() {
		$this->layout = 'ajax';
		$games	= $this->Game->find('all');
		$games	= Set::extract('/Game/.', $games);
		$this->set('games', $games);
		$this->render('json/games');
	}
	
	/** 
	* Logs vote
	*/
	private function vote($data) {
		//print_r($data);
		$save['id']		= $data['id'];
		$save['votes']	= $data['votes']+1;
		if($this->Game->save($save)) {
			$this->games();
			return $this->render('json/games');
		}
	}
}