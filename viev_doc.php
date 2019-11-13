<?php 
	session_start(); 

	if (!isset($_SESSION['auth']) or empty($_SESSION['auth']) or ($_SESSION['auth'] === false)){
		header("Location: main.php");
	}

	if(isset($_REQUEST['docname'])){
		$DocName = $_REQUEST['docname'];
		try {
			ini_set("soap.wsdl_cache_enabled", "0" );
			$client = new SoapClient("http://metroservice.somee.com/WebService/MetroService.asmx?wsdl", array("exceptions" => false));
			$params = array( "sekret_key" => "rye3firbvlvjsne3n25123m2n1", "login" => $_SESSION['login'], "password" => $_SESSION['password']); 
			$response_main = $client->__soapCall("GetNotFamiliarDocuments", array($params));
			//var_dump($response_main);
			if(isset($response_main->GetNotFamiliarDocumentsResult)){
				$obj_start = json_decode($response_main->GetNotFamiliarDocumentsResult);
				if(!isset($obj_start->{"docNotFamiliarLst"}))
				{
					header("Location: doc_queue.php");
				}else $obj_json = $obj_start->{"docNotFamiliarLst"}; 
			} 
			else echo "Неверный логин или пароль";
		}
		catch (SoapFault $exc) {
			print_r($exc->getMessage());
		}
		
		$iter = 0;
		while(isset($obj_json[$iter]))
		{
			if(!($obj_json[$iter]->{"Name"} == $DocName))
			{
				$iter=$iter+1;
			}
			else break;
		}
		
		if(!($obj_json[$iter]->{"Name"} == $DocName))
			header("Location: doc_queue.php");
		
		if(isset($_REQUEST['confirm']))
		{
			$confirm = $_REQUEST['confirm'];
			if($confirm == 1)
			{
				try {
					$params = array( "sekret_key" => "rye3firbvlvjsne3n25123m2n1", "login" => $_SESSION['login'], "password" => $_SESSION['password'], "docFamiliarLst" => $DocName); 
					$response_confirm = $client->__soapCall("UpdateListNotFamiliarDoc", array($params));
					//var_dump($response_confirm);
					if(isset($response_confirm->UpdateListNotFamiliarDocResult)){
						$obj_confirm = json_decode($response_confirm->UpdateListNotFamiliarDocResult);
						if(isset($obj_confirm->{"error"}))
						{
							if($obj_confirm->{"error"} == 0)
								header("Location: doc_queue.php");
							else echo "Error 505 bad gateway";
						}
						else echo "Error 505 bad gateway";
					} 
					else echo "Error 505 bad gateway";
				}
				catch (SoapFault $exc) {
					print_r($exc->getMessage());
				}
			}
		}
		
	}else header("Location: doc_queue.php");
	
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Документ</title>
    <link rel="stylesheet"  type="text/css" href="style.css" >
</head>
<body>
	<div id="header">
		<div id="logo_bar">
			<img src="images/metro_logo.png">
		</div>
		<div id="nav">
			<ul>
				<li><a href="doc_queue.php">Назад</a></li>
				<li><a href="<?php printf('viev_doc.php?docname=%s&confirm=%s',$obj_json[$iter]->{"Name"},1); ?>">Ознакомился</a></li>
			</ul>
		</div>
	</div>
	<div class="wrapper" style="margin-top: 50px">
		<div id="article_doc">
			<h2> <center><strong><?php echo $obj_json[$iter]->{"header"}; ?></strong></center></h2>
			<p> <?php echo $obj_json[$iter]->{"content"}; ?></p>
		</div>
	</div>
	<!-- Нижний блок информации -->
	<div id="footer">
		<p>Contacts: mos_admin@mail.ru</p>
		<p>Copyright © Московский метрополитен, 2019</p>
	</div>
</body>
</html>
