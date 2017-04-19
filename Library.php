<?php 
ini_set('memory_limit', '18192M');
function permute($items, $perms = array()) {
	global $lst;
	if (empty($items)) { 
		$str = join('', $perms);
		checkHash($str);
	} else {
		for ($i = count($items) - 1; $i >= 0; --$i) {
			$newitems = $items;
			$newperms = $perms;
			list($foo) = array_splice($newitems, $i, 1);
			array_unshift($newperms, $foo);
			permute($newitems, $newperms);
		}
	}
}
function combine($variables, $separadores){
	for($i=1; $i<=sizeof($variables); $i++){
		foreach(new Combinations($variables, $i) as $substring){
			foreach($separadores as $separador){
				$vars = $substring;
				for($x=1; $x<=($i-1);$x++){
					$vars[] = $separador;
					permute($vars);
				}
			}
		}
		$combinations = $GLOBALS['counter'];
		echo $i." variables done ".$combinations." combinations\n";
	}
}
function checkHash($str){
	global $counter;
	global $hash;
	foreach (hash_algos() as $v) {
		$counter++;
		$r = hash($v, $str, false);
		if($r == $hash){
			printf("%-12s %3d %s\n", $v, strlen($r), $r); 
			echo "Found MATCH with ".$v." algorithm: ".$str;
			die;
		}
	} 
}
class Combinations implements Iterator
{
	protected $c = null;
	protected $s = null;
	protected $n = 0;
	protected $k = 0;
	protected $pos = 0;

	function __construct($s, $k) {
		if(is_array($s)) {
			$this->s = array_values($s);
			$this->n = count($this->s);
		} else {
			$this->s = (string) $s;
			$this->n = strlen($this->s);
		}
		$this->k = $k;
		$this->rewind();
	}
	function key() {
		return $this->pos;
	}
	function current() {
		$r = array();
		for($i = 0; $i < $this->k; $i++)
			$r[] = $this->s[$this->c[$i]];
		return is_array($this->s) ? $r : implode('', $r);
	}
	function next() {
		if($this->_next())
			$this->pos++;
		else
			$this->pos = -1;
	}
	function rewind() {
		$this->c = range(0, $this->k);
		$this->pos = 0;
	}
	function valid() {
		return $this->pos >= 0;
	}

	protected function _next() {
		$i = $this->k - 1;
		while ($i >= 0 && $this->c[$i] == $this->n - $this->k + $i)
			$i--;
		if($i < 0)
			return false;
		$this->c[$i]++;
		while($i++ < $this->k - 1)
			$this->c[$i] = $this->c[$i - 1] + 1;
		return true;
	}
}

?>