<div id='div_olddb'>
<legend>Früheren Zustand wiederherstellen (max. <?php echo $maxUploadSizeString; ?>)</legend>
<?php
echo $this->Form->create(null, array('type' => 'file', 'url' => array('controller' => 'backup', 'action' => 'index')));
echo $this->Form->input('MAX', array('type' => 'hidden', 'name' => 'MAX_FILE_SIZE', 'value' => $maxUploadSizeBytes));
echo $this->Form->file('File', array('required' => true, 'accept' => 'application/sql'));
echo $this->Form->end('Wiederherstellen');
?></div>