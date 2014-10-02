<?php
	
	/*
	*	A program to "Print an associative array as an ASCII table" with Unit Testing
	*	
	*	@author: Abdullah Yousuf <dabdullahy@gmail.com>
	*/
	
	class PrintAsciiTableUnitTest extends PHPUnit_Framework_TestCase {
		
		private $data;
		private $colors;
		private $headers;
		private $tmp_h;
		private $colsLength;
		
		public function __construct() {
			return $this;
		}
		
		private function _setData() {
			$this->assertEmpty($this->data);
			$this->assertEmpty($this->colors);
			
			$this->data = array(
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
		
			$this->colors = array(
				'Name' => '#751919',
				'Color' => '#EB6EEB',
				'Element' => '#6fe550',
				'Likes' => '#000000'
			);
			
			return $this;
		}

		/**
		* @depends _setData
		*/
		private function _getHeaders() {
			$this->headers = array_keys($this->data[0]);
			return $this;
		}

		/**
		* @depends _getHeaders
		*/
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
		
		/**
		* @depends _getColsLength
		*/
		private function _horizontalSeperator() {
			$this->assertNotEmpty($this->colsLength);
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
				$this->assertRegExp('/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/', $this->colors[$h]);
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
		
		/**
		 * @test
		 */
		public function printTable() {
			$this->_setData();
			
			$this->assertNotEmpty($this->data[0]);
			$this->_getHeaders();
			
			$this->assertNotEmpty($this->headers);
			$this->assertEmpty($this->colsLength);
			$this->_getColsLength();	
			
			$this->_makeTableHeaderRow();
			$this->_makeTableDataRows();
		}
	}
?>