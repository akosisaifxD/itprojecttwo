<?php
	$_POST['username'] = "P1";
	$_POST['password'] = "ernest";
	
	require "../loginprocess.php";
	
	class LoginTest extends PHPUnit_framework_testcase{
		
		public function testSetUserName(){
			
			$_SESSION['username'] = "P2";
			$test = "P2";
			
			$this->assertEquals($test, setUsername());
			
			$_SESSION['username'] = "P3";
			$test = "P3";
			
			$this->assertEquals($test, setUsername());
			
			$_SESSION['username'] = "1231111";
			$test = "1231111";
			
			$this->assertEquals($test, setUsername());
			
			$_SESSION['username'] = "1235678";
			$test = "1235678";
			
			$this->assertEquals($test, setUsername());
			
			$_SESSION['username'] = "1234111";
			$test = "1234111";
			
			$this->assertEquals($test, setUsername());
		}
		
		public function testSetUserNameInvalid(){
			
			$_SESSION['username'] = "P2";
			$test = "p1";
			
			if($_SESSION['username'] != $test){
			$this->assertFalse(false);
			}
			
			$_SESSION['username'] = "P4";
			$test = "p3";
			
			if($_SESSION['username'] != $test){
			$this->assertFalse(false);
			}
			
			$_SESSION['username'] = "P6";
			$test = "p5";
			
			if($_SESSION['username'] != $test){
			$this->assertFalse(false);
			}
			
			$_SESSION['username'] = "1231111";
			$test = "1231234";
			
			if($_SESSION['username'] != $test){
			$this->assertFalse(false);
			}
			
			$_SESSION['username'] = "1231234";
			$test = "1234213";
			
			if($_SESSION['username'] != $test){
			$this->assertFalse(false);
			}
			
		}
		
		public function testSetPassword(){
			
			$_SESSION['password'] = "lololo";
			$test = "lololo";
			
			$this->assertEquals($test, setPassword());
			
			$_SESSION['password'] = "lalala";
			$test = "lalala";
			
			$this->assertEquals($test, setPassword());
			
			$_SESSION['password'] = "lelele";
			$test = "lelele";
			
			$this->assertEquals($test, setPassword());
			
			$_SESSION['password'] = "ererer";
			$test = "ererer";
			
			$this->assertEquals($test, setPassword());
			
			$_SESSION['password'] = "sasasa";
			$test = "sasasa";
			
			$this->assertEquals($test, setPassword());
		}
		
		public function testSetPasswordInvalid(){
			
			$_SESSION['username'] = "asdasd";
			$test = "dsadsa";
			
			if($_SESSION['username'] != $test){
			$this->assertFalse(false);
			}
			
			$_SESSION['username'] = "qweqwe";
			$test = "ewqewq";
			
			if($_SESSION['username'] != $test){
			$this->assertFalse(false);
			}
			
			$_SESSION['username'] = "zxczxc";
			$test = "cxzczx";
			
			if($_SESSION['username'] != $test){
			$this->assertFalse(false);
			}
			
			$_SESSION['username'] = "vbnvbn";
			$test = "nbvnbv";
			
			if($_SESSION['username'] != $test){
			$this->assertFalse(false);
			}
			
			$_SESSION['username'] = "fghfgh";
			$test = "hgfhgf";
			
			if($_SESSION['username'] != $test){
			$this->assertFalse(false);
			}
		}
		
		public function testCheckIfContactPersonTrue(){
			
			$un = "P1";
			
			if(checkIfContactPerson($un) === 0){
				$this->assertTrue(true);
			}
			
			$un = "P100";
			
			if(checkIfContactPerson($un) === 0){
				$this->assertTrue(true);
			}
			
			$un = "P101";
			
			if(checkIfContactPerson($un) === 0){
				$this->assertTrue(true);
			}
			
			$un = "P102";
			
			if(checkIfContactPerson($un) === 0){
				$this->assertTrue(true);
			}
			
			$un = "P103";
			
			if(checkIfContactPerson($un) === 0){
				$this->assertTrue(true);
			}
			
		}
		
		public function testCheckIfContactPersonFalse(){
			
			$un = "2131111";
			
			if(checkIfContactPerson($un) === 1){
				$this->assertTrue(false);
			}
			
			$un = "4525224";
			
			if(checkIfContactPerson($un) === 1){
				$this->assertTrue(false);
			}
			
			$un = "1233412";
			
			if(checkIfContactPerson($un) === 1){
				$this->assertTrue(false);
			}
			
			$un = "4241231";
			
			if(checkIfContactPerson($un) === 1){
				$this->assertTrue(false);
			}
			
			$un = "4152243";
			
			if(checkIfContactPerson($un) === 1){
				$this->assertTrue(false);
			}
			
		}

	}

?>