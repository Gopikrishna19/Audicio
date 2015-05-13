<?php foreach($this->css as $c): ?>
<link href="/Assets/css/<?php echo $c; ?>.min.css" rel="stylesheet" type="text/css">
<?php endforeach; ?>

<script>
<?php foreach($this->jsVar as $k => $j) {
    echo "window.$k = '$j';\n";
} ?>
</script>

<?php foreach($this->js as $j): ?>
<script src="/Assets/js/<?php echo $j; ?>.js"></script>
<?php endforeach; ?>