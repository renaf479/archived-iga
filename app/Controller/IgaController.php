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
	* GET router
	*/
	public function platformGet() {
		//print_r($this->request->params['feed']);
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
		$this->set('games', $games);
		$this->render('json/games');
	}
	
	
	
	
	
	
	
	/*
	
		public function jsonAdUnit($originAd_id = '') {
		$originAd_id 	= ($originAd_id)? $originAd_id: $this->request->params['originAd_id'];
		$origin_ad		= $this->OriginAd->find('first', 
			array(
				'recursive'=>2,
				'conditions'=>array(
					'OriginAd.id'=>$originAd_id
				)
			)
		);
		$this->set('origin_ad', $origin_ad);
		return $origin_ad;
	}
	*/
	
	
	/**
	* POST data router
	* Permissions: Logged in
	*/
/*
	public function platformPost() {
		$this->autoRender = false;
		if($this->request->data['route']) {
			$route		= $this->request->data['route'];
			unset($this->request->data['route']);
			$response	= $this->$route($this->request->data);
			$this->set('post', $response);
		}
	}
*/
}