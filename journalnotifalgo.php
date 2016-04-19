<?php
	$ujcount = 0;
	
	if($_SESSION['accounttype'] === 'Advanced'){
		if(isset($_SESSION['prevll'])){
			$checkid = $_SESSION['username'];
			$sendertypefs = $_SESSION['sendertype'];
			
			$lastlogin = "";
			
			$lastloginsplit = explode(" ", $_SESSION['prevll']);
			$lldatesplit = explode("-", $lastloginsplit[0]);
			$lltimesplit = explode(":", $lastloginsplit[1]);
			
			$lldateyear = $lldatesplit[0];
			$lldatemonth = $lldatesplit[1];
			$lldateday = $lldatesplit[2];
			
			$lltimehour = $lltimesplit[0];
			$lltimemins = $lltimesplit[1];
			$lltimesecs = $lltimesplit[2];
			
			$jrnsitecodes = array();
			
			$sql = "SELECT journalDate, siteCode FROM journal WHERE sender != '" . $checkid . "'";
			$result = mysqli_query($conn, $sql);
			
			if (mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) {
					$jdatesplit = explode(" ", $row['journalDate']);
					$jddatesplit = explode("-", $jdatesplit[0]);
					$jdtimesplit = explode(":", $jdatesplit[1]);
					
					$jddateyear = $jddatesplit[0];
					$jddatemonth = $jddatesplit[1];
					$jddateday = $jddatesplit[2];
					
					$jdtimehour = $jdtimesplit[0];
					$jdtimemins = $jdtimesplit[1];
					$jdtimesecs = $jdtimesplit[2];
					
					$ujcheck;
					
					if(floatval($jddateyear) >= floatval($lldateyear)){
						if(floatval($jddatemonth) >= floatval($lldatemonth) || floatval($jddateyear) > floatval($lldateyear)){
							if(floatval($jddateday) >= floatval($lldateday) || floatval($jddatemonth) > floatval($lldatemonth)){
								if(floatval($jdtimehour) >= floatval($lltimehour) || floatval($jddateday) > floatval($lldateday)){
									if(floatval($jdtimemins) >= floatval($lltimemins) || floatval($jdtimehour) > floatval($lltimehour)){
										if(floatval($jdtimesecs) > floatval($lltimesecs) || floatval($jdtimemins) > floatval($lltimemins)){
											$ujcheck = true;
										}else{
											$ujcheck = false;
										}
									}else{
										$ujcheck = false;
									}
								}else{
									$ujcheck = false;
								}
							}else{
								$ujcheck = false;
							}
						}else{
							$ujcheck = false;
						}
					}else{
						$ujcheck = false;
					}
					
					if($ujcheck === true){
						if (!in_array($row['siteCode'], $jrnsitecodes)) {
							$jrnsitecodes[$ujcount] = $row['siteCode'];
							$ujcount++;
						}
					}else{
					}
				}
			} else {
			}
			
			if($ujcount > 0){
				$_SESSION['ujcount'] = $ujcount;
			}	
		}
	}else{
		if(isset($_SESSION['prevll'])){
			
			$senderid = $_SESSION['username'];
			
			$cenroid = "";
			
			$sites = array();
			$arrcount = 0;
			
			$sql = "SELECT cenroID FROM denr WHERE denrID = '" . $senderid . "'";
			$result = mysqli_query($conn, $sql);
			
			if (mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) {
					$cenroid = $row['cenroID'];
				}
			}
			
			$municipalities = array();
			$municount = 0;
			
			$sql = "SELECT municipalityID FROM cenromunicipality WHERE cenroID = '" . $cenroid . "'";
			$result = mysqli_query($conn, $sql);
			
			if (mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) {
					$municipalities[$municount] = $row['municipalityID'];
					$municount++;
				}
			}
			
			for($i = 0; $i < sizeof($municipalities); $i++){
				$sql = "SELECT siteCode FROM site WHERE municipalityID = '" . $municipalities[$i] . "'";
				$result = mysqli_query($conn, $sql);
				
				if (mysqli_num_rows($result) > 0) {
					while($row = mysqli_fetch_assoc($result)) {
						$sites[$arrcount] = $row['siteCode'];
						$arrcount++;
					}
				}	
			}
			
			$checkid = $_SESSION['username'];
			$sendertypefs = $_SESSION['sendertype'];
			
			$lastlogin = "";
			
			$lastloginsplit = explode(" ", $_SESSION['prevll']);
			$lldatesplit = explode("-", $lastloginsplit[0]);
			$lltimesplit = explode(":", $lastloginsplit[1]);
			
			$lldateyear = $lldatesplit[0];
			$lldatemonth = $lldatesplit[1];
			$lldateday = $lldatesplit[2];
			
			$lltimehour = $lltimesplit[0];
			$lltimemins = $lltimesplit[1];
			$lltimesecs = $lltimesplit[2];
			
			$jrnsitecodes = array();
			
			$sql = "SELECT journalDate, siteCode FROM journal WHERE sender != '" . $checkid . "'";
			$result = mysqli_query($conn, $sql);
			
			if (mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) {
					if(in_array($row['siteCode'], $sites)){
						$jdatesplit = explode(" ", $row['journalDate']);
						$jddatesplit = explode("-", $jdatesplit[0]);
						$jdtimesplit = explode(":", $jdatesplit[1]);
						
						$jddateyear = $jddatesplit[0];
						$jddatemonth = $jddatesplit[1];
						$jddateday = $jddatesplit[2];
						
						$jdtimehour = $jdtimesplit[0];
						$jdtimemins = $jdtimesplit[1];
						$jdtimesecs = $jdtimesplit[2];
						
						$ujcheck;
						
						if(floatval($jddateyear) >= floatval($lldateyear)){
							if(floatval($jddatemonth) >= floatval($lldatemonth) || floatval($jddateyear) > floatval($lldateyear)){
								if(floatval($jddateday) >= floatval($lldateday) || floatval($jddatemonth) > floatval($lldatemonth)){
									if(floatval($jdtimehour) >= floatval($lltimehour) || floatval($jddateday) > floatval($lldateday)){
										if(floatval($jdtimemins) >= floatval($lltimemins) || floatval($jdtimehour) > floatval($lltimehour)){
											if(floatval($jdtimesecs) > floatval($lltimesecs) || floatval($jdtimemins) > floatval($lltimemins)){
												$ujcheck = true;
											}else{
												$ujcheck = false;
											}
										}else{
											$ujcheck = false;
										}
									}else{
										$ujcheck = false;
									}
								}else{
									$ujcheck = false;
								}
							}else{
								$ujcheck = false;
							}
						}else{
							$ujcheck = false;
						}
						
						if($ujcheck === true){
							if (!in_array($row['siteCode'], $jrnsitecodes)) {
								$jrnsitecodes[$ujcount] = $row['siteCode'];
								$ujcount++;
							}
						}else{
						}	
					}
				}
			} else {
			}
			
			if($ujcount > 0){
				$_SESSION['ujcount'] = $ujcount;
			}	
		}
	}
?>