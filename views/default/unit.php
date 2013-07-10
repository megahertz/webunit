<?php
/**
 * @var WuController                 $this
 * @var WuSuitesCollection|WuSuite[] $data
 * @var string                       $testName
 *
 * @var WuTest $test
 */
Yii::app()->getClientScript()->registerCssFile(
	$this->module->getAssetsUrl() . '/css/unit.css'
);
Yii::app()->getClientScript()->registerScriptFile(
	$this->module->getAssetsUrl() . '/js/unit.js'
);
?>

<h1><?php echo CHtml::encode($testName) ?></h1>

<div class="test-runner">
	<?php foreach ($data as $suite): ?>
		<div class="test-suite <?php echo $suite->getStatus() ?>">
			<div class="suite-title">
				<a class="expand"></a>
				<span class="icon"></span>
				<span class="text"><?php echo CHtml::encode($suite->name) ?></span>
				<span class="count">
					<?php echo $suite->getCountPassed() ?> / <?php echo $suite->getTestsCount() ?>
				</span>
			</div>
			<div class="tests" style="display:none">
				<?php foreach ($suite as $test): ?>
					<div class="test <?php echo $test->status ?>">
						<div class="test-title">
							<span class="buttons">
								<?php if ($test->trace): ?>
									<a class="trace"></a>
								<?php endif ?>
								<?php if ($test->output): ?>
									<a class="output"></a>
								<?php endif ?>
							</span>
							<span class="text"><?php echo CHtml::encode($test->getTestName()) ?></span>
							<?php if ($test->message): ?>
								<span class="message">
									<?php echo CHtml::encode($test->message) ?>
								</span>
							<?php endif ?>
						</div>

						<div class="details">

							<?php if ($test->trace): ?>
								<div class="trace-panel panel" style="display:none">
									<?php $count = 0 ?>
									<?php foreach($test->trace as $n => $trace): ?>
										<?php
											if($this->__isCoreCode($trace))
												$cssClass='core collapsed';
											elseif(++$count>3)
												$cssClass='app collapsed';
											else
												$cssClass='app expanded';
											$hasCode=$trace['file']!=='unknown' && is_file($trace['file']);
										?>
										<div class="trace <?php echo $cssClass ?>">
											<span class="number">#<?php echo $n ?></span>
											<div class="content">
												<div class="trace-file">
													<?php if($hasCode): ?>
														<span class="plus">+</span>
														<span class="minus">–</span>
													<?php endif; ?>
													<?php
													echo '&nbsp;';
													echo htmlspecialchars($trace['file'],ENT_QUOTES,Yii::app()->charset)."(".$trace['line'].")";
													echo ': ';
													if(!empty($trace['class']))
														echo "<strong>{$trace['class']}</strong>{$trace['type']}";
													if (isset($trace['function'])) {
														echo "<strong>{$trace['function']}</strong>(";
														if(!empty($trace['args']))
															echo htmlspecialchars($this->argumentsToString($trace['args']),ENT_QUOTES,Yii::app()->charset);
														echo ')';
													}

													?>
												</div>

												<?php if($hasCode) echo $this->renderSourceCode($trace['file'],$trace['line'],Yii::app()->errorHandler->maxSourceLines); ?>
											</div>
										</div>
									<?php endforeach ?>
								</div>
							<?php endif ?>

							<?php if ($test->output): ?>
								<div class="output-panel panel" style="display:none">
									<div class="output">
										<pre>
											<?php echo $test->output ?>
										</pre>
									</div>
								</div>
							<?php endif ?>
						</div>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	<?php endforeach ?>
</div>