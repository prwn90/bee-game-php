<?php

class BeesSlap {
	
	private $log = array();

	
	private $bees = array(
		'queen' => array(
			'number'		=> 1,
			'initialPoints'	=> 100,
			'hitPoints'		=> 8,
		),
		'workers' => array(
			'number'		=> 5,
			'initialPoints' => 75,
			'hitPoints'		=> 10,
		),
		'drone' => array(
			'number'		=> 8,
			'initialPoints' => 50,
			'hitPoints'		=> 12,
		),
	);

	
	public function __construct($bees = null)
	{
		if ( is_array($bees) ) {
			$this->rowLineUps($bees);
		} else {
			$this->rowLineUps($this->bees);
		}
	}

	
	public function rowLineUps(array $bees)
	{
		foreach($bees as &$bee) {
			if (isset($bee['lineUp'])) {
				break;
			}

			unset($bee['lineUp']);

			for($i=1; $i <= $bee['number']; $i++) {
				$bee['lineUp'][$i] = $bee['initialPoints'];
			}
		}
		
		$this->bees = $bees;
		
		return $this->bees;
	}


	public function recoverBeeKindToHit()
	{
		return array_rand($this->bees);
	}

	
	public function recoverBeeNumber($beeKind)
	{
		if ( !isset($this->bees[$beeKind]) ) {
			throw new \InvalidArgumentException($beeKind.' is not a valid bee kind');
		}
		
		return rand(1, $this->bees[$beeKind]['number']);
	}

	
	public function deductHitPoints($beeKind, $number, $hitPoints = null)
	{
		if ( is_numeric($hitPoints) ) {
			$this->bees[$beeKind]['lineUp'][$number] -= $hitPoints;
		} else {
			$this->bees[$beeKind]['lineUp'][$number] -= $this->bees[$beeKind]['hitPoints'];
		}

		return $this->bees[$beeKind]['lineUp'][$number];
	}

	public function areAllQueeensDead()
	{
		foreach($this->bees['queen']['lineUp'] as $key => $value) {
			if ($value > $this->bees['queen']['hitPoints']) {
				return false;
			}
		}

		return true;
	}

	
	public function isBeeDead($beeKind, $number)
	{
		if ($this->bees[$beeKind]['lineUp'][$number] < $this->bees[$beeKind]['hitPoints']) {
			return true;
		}

		return false;
	}


	public function removeBee($beeKind, $number)
	{
		$this->bees[$beeKind]['number'] -= 1;
		if ($this->bees[$beeKind]['number'] <= 0) {
			unset($this->bees[$beeKind]);
		} else {
			unset($this->bees[$beeKind]['lineUp'][$number]);
			
			sort($this->bees[$beeKind]['lineUp'][$number]);
		}
	}
	

	public function getBees()
	{
		return $this->bees;
	}
	
	public function addLog($array)
	{
		$this->log[] = $array;
	}
	
	public function getLog($log)
	{
		return $this->log;
	}
	
	public function resetLog()
	{
		$this->log = [];
	}
}
