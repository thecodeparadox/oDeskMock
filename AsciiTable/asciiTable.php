<?php
	
	/*
	*	A program to "Print an associative array as an ASCII table"
	*	
	*	@author: Abdullah Yousuf <dabdullahy@gmail.com>
	*/
	
	class PrintAsciiTable {
		
		private $data;
		private $colors;
		private $headers;
		private $tmp_h;
		private $colsLength;
		
		public function __construct() {
			return $this;
		}
		
		public function setData($data) {
			$this->data = $data;
			return $this;
		}
		
		public function setColors($colors) {
			$this->colors = $colors;
			return $this;
		}
		
		private function _getHeaders() {
			$this->headers = array_keys($this->data[0]);
			return $this;
		}
		
		private function _getColsLength() {
			foreach($this->headers as $h) {
				$hLen = strlen($h);
				$this->tmp_h = $h;
				$mLen = max(array_merge(array_map('strlen', array_map(function($i) { 
					return $i[$this->tmp_h]; 
				}, $this->data)),[$hLen]));
				$this->colsLength[$h] = $mLen + (int) ($mLen != $hLen);
			}
		}
		
		private function _horizontalSeperator() {
			$hs = '';
			foreach($this->colsLength as $len) {
				$hs .= chr(43) . str_repeat(chr(45), $len);
			}
			$hs .= chr(43);
			return $hs;
		}

		private function _makeHeaderCells() {
			$c = '';
			foreach($this->headers as $h) {
				$str =  str_pad($h, $this->colsLength[$h], chr(32), STR_PAD_RIGHT);
				$c .= chr(124) . '<span style="color: '. $this->colors[$h] .'">'. $str . '</span>';
			}
			$c .= chr(124);
			return $c;
		}
		
		private function _makeTableHeaderRow() {
			$hRow = '';
			$hRow .= $this->_horizontalSeperator() . PHP_EOL
					. $this->_makeHeaderCells() . PHP_EOL
					. $this->_horizontalSeperator() . PHP_EOL;
			return $hRow;
		}
		
		private function _makeTableDataRows() {
			$dRows = '';
			foreach( $this->data as $data) {
				foreach( $this->headers as $h ) {
					$d = $data[$h];
					$str = str_pad($d, $this->colsLength[$h], chr(32), STR_PAD_RIGHT);
					$dRows .= chr(124) . '<span style="color: '. $this->colors[$h] .'">'. $str . '</span>';;
				}
				$dRows .= chr(124) . PHP_EOL;
			}
			$dRows .= $this->_horizontalSeperator() . PHP_EOL;
			return $dRows;
		}
		
		private function _printTable() {
			echo "<pre>" . PHP_EOL
				. $this->_makeTableHeaderRow()
				. $this->_makeTableDataRows()
				. "</pre>";
		}
		
		public function printTable() {
			$this->_getHeaders()->_getColsLength();
			$this->_printTable();
		}
	}
	
	//	Data
	$arr = array(
		array(
			'Name' => 'Trixie',
			'Color' => 'Green',
			'Element' => 'Earth',
			'Likes' => 'Flowers'
		),
		array(
			'Name' => 'Tinkerbell',
			'Element' => 'Air',
			'Likes' => 'Singning',
			'Color' => 'Blue'
		), 
		array(
			'Element' => 'Water',
			'Likes' => 'Dancing',
			'Name' => 'Blum',
			'Color' => 'Pink'
		),
	);
	
	$colors = array(
		'Name' => '#751919',
		'Color' => '#EB6EEB',
		'Element' => '#6fe550',
		'Likes' => '#000000'
	);
	
	//	Class Instance
	$Table = new PrintAsciiTable();
	$Table->setData($arr)->setColors($colors)->printTable();
?>