<?php
/* @var $this yii\web\View */
use yii\web\View;
use yii\bootstrap\Dropdown;

$this->registerJsFile('http://cdn.ronghub.com/RongIMLib-2.2.4.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerJs("var rongConfig =" . $rongConfig . ";", View::POS_END);

$this->registerJsFile('@web/js/chat-test.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>
<div class="row">
	<h1>Chat Testing</h1>
</div>

<div class="row">
	<div class="col-md-8">
		<div class="input-group messages">
			<h2>Conversation:</h2>	
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-8">
		<div class="input-group">
			<input id="text-message" type="text" class="form-control" placeholder="Enter You Message Here">
			<span class="input-group-btn">
				<button class="btn btn-default" type="button" id="sendit">Send!</button>
			</span>
		</div>
	</div>
</div>