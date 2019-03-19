<?php

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

	session_start();

	include_once("class/BeesHit.php");

	$beesSplap = new BeesSlap( !empty($_SESSION['beeHit']) ? $_SESSION['beeHit'] : null );

	$kind = isset($_POST['beeKind']) ? $_POST['beeKind'] : $beesSplap->recoverBeeKindToHit();
	$number = isset($_POST['beeNumber']) ? $_POST['beeNumber'] : $beesSplap->recoverBeeNumber($kind);
	$points = $beesSplap->deductHitPoints($kind, $number);
	$status = ($beesSplap->isBeeDead($kind, $number)) ? '<span style="color: red">Dead!</span>' : '<span style="color: green">Still live!</span>';

	$_SESSION['beeHit'] = $beesSplap->getBees();

	?>
	

	<script>
		<?php if ($beesSplap->areAllQueeensDead()): ?>
		$('#modalGameOver').modal({
			backdrop: 'static',
			keyboard: false
		}); 
		<?php endif; ?>
	
		
		$('#table-<?php echo $kind ?> .highlightable-row-<?php echo $number ?>').addClass('bg-danger').siblings().removeClass('bg-danger');
		$('#<?php echo "bee-".$kind."-".$number."-points"; ?>').html('<span><?php echo $points ?></span>');
		$('#<?php echo "bee-".$kind."-".$number."-status"; ?>').html('<span><?php echo $status ?></span>');



		<?php if ($beesSplap->isBeeDead($kind, $number)): ?>
			$('#<?php echo "bee-".$kind."-".$number."-hitit"; ?>').find('.hitItButton').prop('disabled', true);
		<?php endif; ?>



		<?php if ($beesSplap->areAllQueeensDead()): ?>
		$('#hit-button').prop("disabled", true);
		$('.hitItButton').prop("disabled", true);
		<?php endif; ?>
	</script>
	<?php
}
