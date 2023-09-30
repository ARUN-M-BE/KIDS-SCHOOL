<?php
$currency_symbol = $global_config['currency_symbol'];
$extINTL = extension_loaded('intl');
if ($extINTL == true) {
	$spellout = new NumberFormatter("en", NumberFormatter::SPELLOUT);
}
?>
<div class="row">
	<div class="col-lg-5 pull-right">
		<ul class="amounts">
			<li><strong><?=translate('grand_total')?> :</strong> <?=$currency_symbol . number_format($total_amount, 2, '.', ''); ?></li>
			<li><strong><?=translate('discount')?> :</strong> <?=$currency_symbol . number_format($total_discount, 2, '.', ''); ?></li>
			<li><strong><?=translate('paid')?> :</strong> <?=$currency_symbol . number_format($total_paid, 2, '.', ''); ?></li>
			<li><strong><?=translate('fine')?> :</strong> <?=$currency_symbol . number_format($total_fine, 2, '.', ''); ?></li>
			<?php if ($total_balance != 0): ?>
			<li><strong><?=translate('total_paid')?> (<?=translate('with_fine')?>) :</strong> <?=$currency_symbol . number_format($total_paid + $total_fine, 2, '.', ''); ?></li>
			<li>
				<strong><?=translate('balance')?> : </strong> 
				<?php
				$numberSPELL = "";
				$total_balance = number_format($total_balance, 2, '.', '');
				if ($extINTL == true) {
					$numberSPELL = ' </br>( ' . ucwords($spellout->format($total_balance)) . ' )';
				}
				echo $currency_symbol . $total_balance . $numberSPELL;
				?>
			</li>
			<?php else:
				$paidWithFine = number_format(($total_paid + $total_fine), 2, '.', '');
				?>
			<li>
				<strong><?=translate('total_paid')?> (with fine) : </strong> 
				<?php
				$numberSPELL = "";
				if ($extINTL == true) {
					$numberSPELL = ' </br>( ' . ucwords($spellout->format($paidWithFine)) . ' )';
				}
				echo $currency_symbol . $paidWithFine . $numberSPELL;
				?>
			</li>
			<?php endif; ?>
		</ul>
	</div>
</div>
