<?php

class IgaController extends AppController {
	public $components 	= array('Session', 'RequestHandler');
	public $uses		= array('Game', 'Newsletter');
	
	public $settings = array(
		'oauth_access_token'=>'14945792-rxT37AopLDO1USJDckQXNBRpxR3LhklcClFKSVroJ',
		'oauth_access_token_secret'=>'69zSk1Eu2YNPrKxSlVOVCTGs2KI81mZ4W7eJYZnCNSjpg',
		'consumer_key'=>'uHa2k1FflFmrwg5VMkNg',
		'consumer_secret'=>'Vjdy2jex0xNHMBkDSA85g7qdKcWTNpZONpgdZHXLp4',
		'username'=>'machinima_com'
	);
	
/*
	public $helpers 	= array('Form', 'Html', 'Session', 'Js', 'Usermgmt.UserAuth', 'Minify.Minify');
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
	
	/**
	*
	*/
	private function newsletter($data) {
		if($this->Newsletter->save($data)) {
			return true;
		}
	}
	
	/**
	* Load Twitter feed
	*/
	private function twitter() {
		App::import('vendor', 'Twitter/twitterApiExchange');
		
		$this->layout = 'ajax';
		
		$url 			= 'https://api.twitter.com/1.1/statuses/user_timeline.json';
		$getfield 		= '?screen_name='.$this->settings['username'].'&count=20';
		$requestMethod 	= 'GET';
			
		$twitter 	= new TwitterAPIExchange($this->settings);
		$response	=  $twitter->setGetfield($getfield)
			             ->buildOauth($url, $requestMethod)
			             ->performRequest();
			             
		$this->set('twitter', $response);
		$this->render('json/twitter');
	}
}