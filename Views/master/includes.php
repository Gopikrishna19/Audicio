<link href="Assets/css/master.min.css" rel="stylesheet" type="text/css">
<?php foreach($this->css as $c): ?>
<link href="Assets/css/<?php echo $c; ?>.min.css" rel="stylesheet" type="text/css">
<?php endforeach; ?>

<script src="Assets/js/jquery.js"></script>
<?php foreach($this->js as $j): ?>
<script src="Assets/js/<?php echo $j; ?>.js"></script>
<?php endforeach; ?>

<title>Audicio<?php echo isset($this->title) ? " - ".$this->title : ""; ?></title>