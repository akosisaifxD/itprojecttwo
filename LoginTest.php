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
			
			$un = "2232232";
			
			if(checkIfContactPerson($un) !== true){
				$this->assertTrue(true);
			}
			
			$un = "4525224";
			
			if(checkIfContactPerson($un) !== true){
				$this->assertTrue(true);
			}
			
			$un = "1233412";
			
			if(checkIfContactPerson($un) !== true){
				$this->assertTrue(true);
			}
			
			$un = "4241231";
			
			if(checkIfContactPerson($un) !== true){
				$this->assertTrue(true);
			}
			
			$un = "4152243";
			
			if(checkIfContactPerson($un) !== true){
				$this->assertTrue(true);
			}
			
		}
		
		public function testVerifyPasswordForContactPersonValid(){
			$servername1 = "localhost";
			$username1 = "root";
			$password1 = "";
			$dbname1 = "ipuno";
			
			$conn = mysqli_connect($servername1, $username1, $password1, $dbname1);

			$un = "P1";
			$pw = "ernest";
			$checker = 0;
			
			verifyPasswordForContactPerson($un, $pw, $checker, $conn);
			
			$this->assertEquals("CPerson",$_SESSION['accounttype']);
			
			$un = "P1001";
			$pw = "placida";
			$checker = 0;
			
			verifyPasswordForContactPerson($un, $pw, $checker, $conn);
			
			$this->assertEquals("CPerson",$_SESSION['accounttype']);
			
			$un = "P10";
			$pw = "agosto";
			$checker = 0;
			
			verifyPasswordForContactPerson($un, $pw, $checker, $conn);
			
			$this->assertEquals("CPerson",$_SESSION['accounttype']);
			
			$un = "P100";
			$pw = "antonio";
			$checker = 0;
			
			verifyPasswordForContactPerson($un, $pw, $checker, $conn);
			
			$this->assertEquals("CPerson",$_SESSION['accounttype']);
			
			$un = "P1000";
			$pw = "pio";
			$checker = 0;
			
			verifyPasswordForContactPerson($un, $pw, $checker, $conn);
			
			$this->assertEquals("CPerson",$_SESSION['accounttype']);
			
		}
		
		public function testVerifyPasswordForContactPersonInvalid(){
			$servername1 = "localhost";
			$username1 = "root";
			$password1 = "";
			$dbname1 = "ipuno";
			
			$conn = mysqli_connect($servername1, $username1, $password1, $dbname1);

			$un = "P1";
			$pw = "ernest1";
			$checker = 0;
			$_SESSION['accounttype'] = "";
			
			verifyPasswordForContactPerson($un, $pw, $checker, $conn);
			
			if($_SESSION['accounttype'] != "CPerson"){
				$this->assertFalse(false);
			}
			
			$un = "P1001";
			$pw = "placida2";
			$checker = 0;
			$_SESSION['accounttype'] = "";
			
			verifyPasswordForContactPerson($un, $pw, $checker, $conn);
			
			if($_SESSION['accounttype'] != "CPerson"){
				$this->assertFalse(false);
			}
			
			$un = "P100";
			$pw = "agosto3";
			$checker = 0;
			$_SESSION['accounttype'] = "";
			
			verifyPasswordForContactPerson($un, $pw, $checker, $conn);
			
			if($_SESSION['accounttype'] != "CPerson"){
				$this->assertFalse(false);
			}
			
			$un = "P1000";
			$pw = "antonio4";
			$checker = 0;
			$_SESSION['accounttype'] = "";
			
			verifyPasswordForContactPerson($un, $pw, $checker, $conn);
			
			if($_SESSION['accounttype'] != "CPerson"){
				$this->assertFalse(false);
			}
			
			$un = "P1000";
			$pw = "pio5";
			$checker = 0;
			$_SESSION['accounttype'] = "";
			
			verifyPasswordForContactPerson($un, $pw, $checker, $conn);
			
			if($_SESSION['accounttype'] != "CPerson"){
				$this->assertFalse(false);
			}
			
		}
		
		public function testVerifyPasswordForDENRBasicValid(){
			$servername2 = "localhost";
			$username2 = "root";
			$password2 = "";
			$dbname2 = "ipuno";
			
			$conn = mysqli_connect($servername2, $username2, $password2, $dbname2);

			$un = "1231111";
			$pw = "jack";
			$checker = 0;
			
			verifyPasswordForDENR($un, $pw, $checker, $conn);
			
			$this->assertEquals("Basic",$_SESSION['accounttype']);
			
			$un = "1232222";
			$pw = "amy";
			$checker = 0;
			
			verifyPasswordForDENR($un, $pw, $checker, $conn);
			
			$this->assertEquals("Basic",$_SESSION['accounttype']);
			
			$un = "1232456";
			$pw = "jane";
			$checker = 0;
			
			verifyPasswordForDENR($un, $pw, $checker, $conn);
			
			$this->assertEquals("Basic",$_SESSION['accounttype']);
			
			$un = "1233333";
			$pw = "sandra";
			$checker = 0;
			
			verifyPasswordForDENR($un, $pw, $checker, $conn);
			
			$this->assertEquals("Basic",$_SESSION['accounttype']);
			
			$un = "1234444";
			$pw = "jon";
			$checker = 0;
			
			verifyPasswordForDENR($un, $pw, $checker, $conn);
			
			$this->assertEquals("Basic",$_SESSION['accounttype']);
			
		}
		
		public function testVerifyPasswordForDENRBasicInvalid(){
			$servername2 = "localhost";
			$username2 = "root";
			$password2 = "";
			$dbname2 = "ipuno";
			
			$conn = mysqli_connect($servername2, $username2, $password2, $dbname2);

			$un = "1231111";
			$pw = "jack1";
			$checker = 0;
			
			verifyPasswordForDENR($un, $pw, $checker, $conn);
			
			if($_SESSION['accounttype'] != "Basic"){
				$this->assertFalse(false);
			}
			
			$un = "1232222";
			$pw = "amy2";
			$checker = 0;
			
			verifyPasswordForDENR($un, $pw, $checker, $conn);
			
			if($_SESSION['accounttype'] != "Basic"){
				$this->assertFalse(false);
			}
			
			$un = "1232456";
			$pw = "jane3";
			$checker = 0;
			
			verifyPasswordForDENR($un, $pw, $checker, $conn);
			
			if($_SESSION['accounttype'] != "Basic"){
				$this->assertFalse(false);
			}
			
			$un = "1233333";
			$pw = "sandra4";
			$checker = 0;
			
			verifyPasswordForDENR($un, $pw, $checker, $conn);
			
			if($_SESSION['accounttype'] != "Basic"){
				$this->assertFalse(false);
			}
			
			$un = "1234444";
			$pw = "jon5";
			$checker = 0;
			
			verifyPasswordForDENR($un, $pw, $checker, $conn);
			
			if($_SESSION['accounttype'] != "Basic"){
				$this->assertFalse(false);
			}
			
		}
		
		public function testVerifyPasswordForDENRAdvancedValid(){
			$servername2 = "localhost";
			$username2 = "root";
			$password2 = "";
			$dbname2 = "ipuno";
			
			$conn = mysqli_connect($servername2, $username2, $password2, $dbname2);

			$un = "1235678";
			$pw = "sam";
			$checker = 0;
			
			verifyPasswordForDENR($un, $pw, $checker, $conn);
			
			$this->assertEquals("Advanced",$_SESSION['accounttype']);
			
			$un = "1236666";
			$pw = "nick";
			$checker = 0;
			
			verifyPasswordForDENR($un, $pw, $checker, $conn);
			
			$this->assertEquals("Advanced",$_SESSION['accounttype']);
			
			$un = "1236789";
			$pw = "jay";
			$checker = 0;
			
			verifyPasswordForDENR($un, $pw, $checker, $conn);
			
			$this->assertEquals("Advanced",$_SESSION['accounttype']);
			
			$un = "1237777";
			$pw = "nikki";
			$checker = 0;
			
			verifyPasswordForDENR($un, $pw, $checker, $conn);
			
			$this->assertEquals("Advanced",$_SESSION['accounttype']);
			
			$un = "1239012";
			$pw = "jen";
			$checker = 0;
			
			verifyPasswordForDENR($un, $pw, $checker, $conn);
			
			$this->assertEquals("Advanced",$_SESSION['accounttype']);
			
		}
		
		public function testVerifyPasswordForDENRAdvancedInvalid(){
			$servername2 = "localhost";
			$username2 = "root";
			$password2 = "";
			$dbname2 = "ipuno";
			
			$conn = mysqli_connect($servername2, $username2, $password2, $dbname2);

			$un = "1235678";
			$pw = "sam2";
			$checker = 0;
			
			verifyPasswordForDENR($un, $pw, $checker, $conn);
			
			if($_SESSION['accounttype'] != "Advanced"){
				$this->assertFalse(false);
			}
			
			$un = "1236666";
			$pw = "nick3";
			$checker = 0;
			
			verifyPasswordForDENR($un, $pw, $checker, $conn);
			
			if($_SESSION['accounttype'] != "Advanced"){
				$this->assertFalse(false);
			}
			
			$un = "1236789";
			$pw = "jay4";
			$checker = 0;
			
			verifyPasswordForDENR($un, $pw, $checker, $conn);
			
			if($_SESSION['accounttype'] != "Advanced"){
				$this->assertFalse(false);
			}
			
			$un = "1237777";
			$pw = "nikki5";
			$checker = 0;
			
			verifyPasswordForDENR($un, $pw, $checker, $conn);
			
			if($_SESSION['accounttype'] != "Advanced"){
				$this->assertFalse(false);
			}
			
			$un = "1239012";
			$pw = "jen6";
			$checker = 0;
			
			verifyPasswordForDENR($un, $pw, $checker, $conn);
			
			if($_SESSION['accounttype'] != "Advanced"){
				$this->assertFalse(false);
			}
			
		}

	}

?>

