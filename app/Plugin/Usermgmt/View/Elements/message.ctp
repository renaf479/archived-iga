<?php if($this->Session->check('Message.flash')) {
	$msgClass = ($this->Session->check('Message.flash.params.class')) ? $this->Session->read('Message.flash.params.class') : 'success'; ?>
	<div class='messageHolder'><div class="<?php echo $msgClass; ?>" id="flashMessage"><?php echo $this->Session->read('Message.flash.message'); ?></div></div>
<?php CakeSession::delete('Message.flash'); } ?>