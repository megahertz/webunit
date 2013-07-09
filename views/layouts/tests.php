<?php
/**
 * @var WuController $this
 */
?>
<?php $this->beginContent('webunit.views.layouts.main') ?>
<div class="container">
	<div class="span-4">
		<div id="sidebar">
			<?php $this->beginWidget('zii.widgets.CPortlet', array('title' => 'Unit tests')) ?>
				<ul>
					<?php foreach(WuHelpers::findTestFiles() as $file): ?>
					<li>
						<?php echo CHtml::link(
							CHtml::encode($file->getClassName()),
							array('/webunit/default/unit?test=' . $file->getRelativePathName())
						) ?>
					</li>
					<?php endforeach ?>
				</ul>
			<?php $this->endWidget() ?>
			<?php $this->beginWidget('zii.widgets.CPortlet', array('title' => 'Functional tests')) ?>
				<ul>
					<?php foreach(WuHelpers::findTestFiles(WuHelpers::TEST_TYPE_WEB) as $file): ?>
						<li>
							<?php echo CHtml::link(
								CHtml::encode($file->getClassName()),
								array('/webunit/default/web?test=' . $file->getRelativePathName())
							) ?>
						</li>
					<?php endforeach ?>
				</ul>
			<?php $this->endWidget() ?>
		</div>
	</div>
	<div class="span-19">
		<div id="content">
			<?php echo $content ?>
		</div>
	</div>
</div>
<?php $this->endContent() ?>