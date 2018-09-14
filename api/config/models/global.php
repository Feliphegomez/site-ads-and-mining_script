<?php

Class JobInfo{
	var $id = 0;
	var $wallet_id = 0;
	var $blob = '';
	var $job_id = '';
	var $target = '';
	var $throttle = 0;
	var $create = 0;
	
	function __construct($args) {
		if(isset($args['id'])){ $this->id = (int) $args['id']; }
		if(isset($args['wallet_id'])){ $this->wallet_id = (int) $args['wallet_id']; }
		if(isset($args['blob'])){ $this->blob = $args['blob']; }
		if(isset($args['job_id'])){ $this->job_id = $args['job_id']; }
		if(isset($args['target'])){ $this->target = $args['target']; }
		if(isset($args['throttle'])){ $this->throttle = (float) $args['throttle']; }
		if(isset($args['create'])){ $this->create = $args['create']; }
	}
	
}

Class FoundInfo{
	var $id = 0;
	var $wallet_id = 0;
	var $job_id = '';
	var $hashes = 0;
	var $hashesPerSecond = 0;
	var $nonce = '';
	var $result = '';
	var $create = 0;
	
	function __construct($args) {
		if(isset($args['id'])){ $this->id = (int) $args['id']; }
		if(isset($args['wallet_id'])){ $this->wallet_id = (int) $args['wallet_id']; }
		if(isset($args['job_id'])){ $this->job_id = $args['job_id']; }
		if(isset($args['hashes'])){ $this->hashes = (float) $args['hashes']; }
		if(isset($args['hashesPerSecond'])){ $this->hashesPerSecond = (float) $args['hashesPerSecond']; }
		if(isset($args['nonce'])){ $this->nonce = $args['nonce']; }
		if(isset($args['result'])){ $this->result = $args['result']; }
		if(isset($args['create'])){ $this->create = $args['create']; }
	}
	
}

Class BalanceInfo{
	var $id = 0;
	var $wallet_id = 0;
	var $value = 0;
	var $hashes = 0;
	var $update = 0;
	
	function __construct($args) {
		if(isset($args['id'])){ $this->id = (int) $args['id']; }
		if(isset($args['wallet_id'])){ $this->wallet_id = (int) $args['wallet_id']; }
		if(isset($args['value'])){ $this->value = (float) $args['value']; }
		if(isset($args['hashes'])){ $this->hashes = (float) $args['hashes']; }
		if(isset($args['update'])){ $this->update = $args['update']; }
	}
}

Class WalletInfo{
	var $id = 0;
	var $address = '';
	var $coin = '';
	var $balance = 0;
	var $fee = 0;
	var $minPay = 0;
	var $banned = 0;
	var $activated = 0;
	var $token = '';
	
	function __construct($args) {
		if(isset($args['id'])){ $this->id = (int) $args['id']; }
		if(isset($args['address'])){ $this->address = $args['address']; }
		if(isset($args['coin'])){ $this->coin = $args['coin']; }
		if(isset($args['banned'])){ $this->banned = (boolean) $args['banned']; }
		if(isset($args['activated'])){ $this->activated = (boolean) $args['activated']; }
		if(isset($args['token'])){ $this->token = $args['token']; }
		if(isset($args['balance'])){ $this->balance = (float) $args['balance']; }
		
		if(isset($args['coin']) && $args['coin'] == 'WEB'){
			 $this->minPay = 1.00000000;
			 $this->fee = 0.05;
		}
		else if(isset($args['coin']) && $args['coin'] == 'XMR'){
			 $this->minPay = 0.00500000;
			 $this->fee = 0.02;
		}
	}
	
}

Class PaymentInfo{
	private $wallet;
	var $id = 0;
	var $wallet_id = 0;
	var $wallet_address = "";
	var $wallet_coin = "";
	var $request = 0;
	var $fee = 0;
	var $totalPaid = 0;
	var $status = 0;
	var $tx = '';
	var $create = 0;
	var $update = 0;
	
	function __construct($args) {
		if(isset($args['id'])){ $this->id = (int) $args['id']; }
		if(isset($args['wallet_id'])){ $this->wallet_id = (int) $args['wallet_id']; }
		if(isset($args['request'])){ $this->request = (float) $args['request']; }
		if(isset($args['fee'])){ $this->fee = (float) $args['fee']; }
		if(isset($args['totalPaid'])){ $this->totalPaid = (float) $args['totalPaid']; }
		if(isset($args['status'])){ $this->status = (int) $args['status']; }
		if(isset($args['tx'])){ $this->tx = (string) $args['tx']; }
		if(isset($args['create'])){ $this->create = $args['create']; }
		if(isset($args['update'])){ $this->update = $args['update']; }
		
		$wallet = walletForId($args['wallet_id']);
		if(isset($wallet->coin)){ $this->wallet_coin = $wallet->coin; }
		if(isset($wallet->address)){ $this->wallet_address = $wallet->address; }
	}
}


