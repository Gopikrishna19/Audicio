
<?php foreach($this->css as $c): ?>
<link href="/Assets/css/<?php echo $c; ?>.min.css" rel="stylesheet" type="text/css">
<?php endforeach; ?>

<?php foreach($this->js as $j): ?>
<script src="/Assets/js/<?php echo $j; ?>.js"></script>
<?php endforeach; ?>

<title>Audicio<?php echo isset($this->title) ? " - ".$this->title : ""; ?></title>