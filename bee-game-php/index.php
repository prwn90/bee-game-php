<?php

session_start();

unset($_SESSION['beeHit']);

include_once("class/BeesHit.php");

function printRowHeader()
{
	?>
	<tr class="info">
		<th>BEE 🐝</th>
		<th>Points</th>
		<th>Live or dead?</th>
	</tr>
	<?php
}

function printRow($bees, $beeKind)
{
	foreach($bees[$beeKind]['lineUp'] as $key => $value):
	?>
		<tr class="highlightable-row-<?php echo $key ?>">

			<td id="<?php echo "bee-".$beeKind."-".$key."-numbers"; ?>"><?php echo $key ?></td>
			<td id="<?php echo "bee-".$beeKind."-".$key."-points"; ?>"><?php echo $value ?></td>
			<td id="<?php echo "bee-".$beeKind."-".$key."-status"; ?>">
				<?php echo ($value < $bees['queen']['hitPoints']) ? 'Dead' : '<span style="color: green">Live</span>'; ?>
			</td>
			
		</tr>
	<?php
	endforeach;
}

$beesSplap = new BeesSlap();

$bees = $beesSplap->getBees();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Bee slap game">
	<meta name="keywords" content="bee, slap, game, browser, php, bootstrap">


	<title>BEE GAME! 🐝</title>


	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/toastr.min.css" rel="stylesheet">
	<style>

	body 
	{
		padding-top: 20px;
		padding-bottom: 20px;
	}

	.header,
	.marketing,
	.footer 
	{
		padding-right: 15px;
		padding-left: 15px;
	}

	.header 
	{
		padding-bottom: 22px;
		border-bottom: 4px solid #a5a4a4;
	}

	.header h3 {
		margin-top: 0;
		margin-bottom: 0;
		line-height: 40px;
	}

	img
	{
		
		display: inline-block;
	}

	#hit-button 
	{
		box-shadow:  0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
		color: black;
	}

	#hit-button:hover
	{
		background-color: #f44336;
  		color: black;
	}
	</style>
</head>
<body>

<div class="container">
	
	<div class="header clearfix">
		<nav>
			<ul class="nav nav-pills pull-right">

				<li role="presentation"><a href="javascript:void(0)" id="hit-button" class="btn btn-warning">RANDOM HIT! </a></li>
				
				<li role="presentation" class="active">
					<a style="cursor: pointer" data-toggle="modal" data-target="#modalNewGame">NEW Game!</a>
				</li>

				<li role="presentation">
					<a href="#" data-toggle="modal" data-target="#modalRules">Rules game</a>
				</li>
			</ul>
		</nav>
		<h2 class="text-muted">BEE HIT GAME 🐝</h2>
		
	</div>

	<div class="row">
		
		<img src="bee.png" alt="bee"  style="width:90px;height:70px;">
		<img src="bee.png" alt="bee"  style="width:90px;height:70px;">
		<img src="bee.png" alt="bee"  style="width:90px;height:70px;">
		<img src="bee.png" alt="bee"  style="width:90px;height:70px;">
		<img src="bee.png" alt="bee"  style="width:90px;height:70px;">
		<img src="bee.png" alt="bee"  style="width:90px;height:70px;">
		<img src="bee.png" alt="bee"  style="width:90px;height:70px;">
		<img src="bee.png" alt="bee"  style="width:90px;height:70px;">
		<img src="bee.png" alt="bee"  style="width:90px;height:70px;">
		<img src="bee.png" alt="bee"  style="width:90px;height:70px;">
		<img src="bee.png" alt="bee"  style="width:90px;height:70px;">
		<img src="bee.png" alt="bee"  style="width:90px;height:70px;">
		
		<div class="col-md-12 col-md-12 col-lg-4">
			<h3 class="text-center">Drones Bee</h3>
			<table class="table table-bordered table-responsive" width="100%" id="table-drone">
			<?php printRowHeader(); ?>
			<?php printRow($bees, 'drone'); ?>
			</table>
		</div>

		<div class="col-md-12 col-md-12 col-lg-4">
			<h3 class="text-center">Workers Bee</h3>
			<table class="table table-bordered table-responsive" width="100%" id="table-workers">
			<?php printRowHeader(); ?>
			<?php printRow($bees, 'workers'); ?>
			</table>
		</div>

		<div class="col-md-12 col-md-12 col-lg-4">
			<h3 class="text-center">Queen</h3>
			<table class="table table-bordered table-responsive" width="100%" id="table-queen">
			<?php printRowHeader(); ?>
			<?php printRow($bees, 'queen'); ?>
			</table>
		</div>

	</div>

	<br>

	<div id="result"></div>
	
	<!-- rules -->
	<div class="modal fade bs-example-modal-lg" id="modalRules" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Rules game</h4>
				</div>
				<div class="modal-body">

					<h2>The Bee Game Objective</h2>

					<p>You have 14 Bees. 1 Queen Bee, 5 are Worker Bees and 8 are Drone Bees.</p>
					<p>Bees: There are three types of bees in this game:</p>

					<div class="row">
						<div class="col-md-4">
							<h3>Queen </h3>
							<p>Queen Bee. The Queen Bee has a lifespan of 100 Hit Points. When the Queen Bee is hit, 8
							Hit Points are deducted from her lifespan. If/When the Queen Bee has run out of Hit Points,
							All remaining alive Bees automatically run out of hit points. There is only 1 Queen Bee.</p>
						</div>
						<div class="col-md-4">
							<h3>Worker Bees</h3>
							<p>Worker Bee. Worker Bees have a lifespan of 75 Hit Points. When a Worker Bee is hit, 10 Hit
							Points are deducted from his lifespan. There are 5 Worker Bees.</p>
						</div>
						<div class="col-md-4">
							<h3>Drone Bees</h3>
							<p>Drone Bee. Drone Bees have a lifespan of 50 Hit Points. When a Drone Bee is hit, 12 Hit
							Points are deducted from his lifespan. There are 8 Drone Bees.</p>
						</div>
					</div>

					<h3>Gameplay</h3>

					<p>To play, there must be a button that enables a user to HIT a random bee. The selection of a bee must
					be random. When the bees are all dead, the game must be able to reset itself with full life bees for
					another round. Constraints:.</p>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!-- start new game -->
	<div class="modal fade bs-example-modal-lg" id="modalNewGame" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">

					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

					<h4 class="modal-title" id="myModalLabel">New game</h4>
				</div>

				<div class="modal-body">
					<p>New game will be start. Are you sure?</p>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-info reset-button" data-dismiss="modal">Yes</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>

			</div>
		</div>
	</div>

	<!-- game over -->
	<div class="modal fade bs-example-modal-lg" id="modalGameOver" tabindex="-1" role="dialog" aria-labelledby="myGameOverModalLabel">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">

					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">The game is over!</h4>
				</div>
				<div class="modal-body">

					<h2>GAME OVER!</h2>

					<p>You killed QUEEN. GAME OVER!</p>

					<div class="modal-footer">
						<button type="button" class="btn btn-info reset-button" data-dismiss="modal">New game</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
<!-- scripts -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>




	$(document).ready(function() {
		$("#hit-button").click(function(event) {
			$.post("hit.php", function(data) {
				$('#result').html(data);
			});
		});

		$(".hitItButton").click(function(event) {
			event.preventDefault();

			var form = $(this).parents('form:first');

			$.ajax({
				type: $(form).attr('method'),
				url: $(form).attr('action'),
				data: $(form).serialize()
			})
			.done(function (data) {
				$("#result").empty().append(data);
			});
		});

		$(".reset-button").click(function(event) {
			$.post("reset.php", function(data) {
				window.location.reload(true);
			});
		});
	});
</script>




</body>
</html>
