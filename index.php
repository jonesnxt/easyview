<?php
function nxtapi($type, $attr)
{
	return json_decode(file_get_contents("http://127.0.0.1:7876/nxt?requestType=".$type."&".$attr));
}

$items = nxtapi("getDGSGoods", "");


?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="../jquery.js"></script>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"/>
<script type="text/javascript" src="ZeroClipboard.min.js"></script>
<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
<title>NXT Marketplace</title>
</head>
<body>
<div class="container container-fluid" role="main">
	<?php include_once("../topbar.php"); ?>
	
	
	<div class="col-md-12">	
			<div class="row">
				<div class="page-header text-center"><h2>NXT Marketplace....<small> Easy View</small><form class="form-inline" action="./" method="get"><div style="margin-bottom: 30px;" class="form-group pull-right"><input placeholder="Search Tags" type="text" class="form-control" name="search"> <button class="btn btn-large btn-primary">Search</button></div></form></h2></div>
			</div>
			
			<?php
			$swch = true;
			$cnt = 0;
			foreach($items->goods as $good)
				{
					if(isset($_GET["search"]) && $_GET['search'] != "all" && strpos($good->tags, $_GET['search']) === false) continue;
					if($swch) echo "<div class='row'>";
					$swch = !$swch;
					?>
				<div class="col-md-6">
					<div class="panel panel-primary">
						<div class="panel-heading">
					<?php
					echo "<h3 class='panel-title'><strong>".strip_tags($good->name)."</strong><button style='color: #31708F;' data-toggle='modal' data-target='#modal-popup-".$cnt."' class='pull-right' type='button'>More</button></h3>";
					 ?>
					 </div>
						<div class="panel-body">
					<?php 
						//echo "<p>".strip_tags($good->description)."</p>";
						
						echo "<div class='alert alert-info'><span>".$good->sellerRS."</span><button type='button' class='pull-right btn-clip'>Copy</button> </div>";
						echo "<div class='badge'>".number_format($good->priceNQT/100000000, 2, ".", "'") ." NXT</div>&nbsp;&nbsp;";
						
						//split tags
						$tags = explode(",",$good->tags);
						foreach($tags as $tag)
						{
							echo "<span style='font-size: 12pt;' class='label label-success'> ". $tag ." </span> &nbsp;";
						}
						
						echo "<div style='font-size: 12pt;' class='label label-warning'>".number_format($good->quantity, 0, ".", "'") ." left</div>&nbsp;&nbsp;";

					 ?>
					</div>
					</div>
				</div>
				
<div class="modal fade" <?php echo "id='modal-popup-".$cnt."'"; ?> tabindex="-1" role="dialog" aria-labelledby="description" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><?php echo strip_tags($good->name); ?></h4>
      </div>
      <div class="modal-body">
        <p><?php echo strip_tags($good->description); ?></p>
        <?php echo "<div class='alert alert-info clearfix'><span class='pull-left'>".$good->sellerRS."</span><button type='button' class='pull-right btn-clip'>Copy</button> </div>"; ?>

      </div>
      <div class="modal-footer">
        <?php echo "<div class='badge'>".number_format($good->priceNQT/100000000, 2, ".", "'") ." NXT</div>&nbsp;&nbsp;";
						
		//split tags
		$tags = explode(",",$good->tags);
		foreach($tags as $tag)
		{
			echo "<span style='font-size: 12pt;' class='label label-success'> ". $tag ." </span> &nbsp;";
		}
		echo "<div style='font-size: 12pt;' class='label label-warning'>".number_format($good->quantity, 0, ".", "'") ." left</div>&nbsp;&nbsp;";
?>

      </div>
    </div>
  </div>
</div>
				<?php
					if($swch) echo "</div>";
					$cnt ++;
				}

				
			?>
		</div>
	</div>

    <script type="text/javascript">
      var client = new ZeroClipboard( $('.btn-clip') );

      client.on( 'ready', function(event) {
        // console.log( 'movie is loaded' );

        client.on( 'copy', function(event) {
          event.clipboardData.setData('text/plain', event.target.parentNode.getElementsByTagName("span")[0].innerHTML);
        } );

        client.on( 'aftercopy', function(event) {
          console.log('Copied text to clipboard: ' + event.data['text/plain']);
          event.target.innerHTML = "Copied...";
        } );
      } );

      client.on( 'error', function(event) {
        // console.log( 'ZeroClipboard error of type "' + event.name + '": ' + event.message );
        ZeroClipboard.destroy();
      } );
    </script>


		
<?php include_once("../closing.php") ?>
</div>

</body>
</html>
