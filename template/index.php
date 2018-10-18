<html>
<head>
	<style>
		li {
			display: inline-block;
			margin: 10px;
		}
	</style>
</head>
<body>
<h1>テーブル定義書</h1>
<?php foreach ($tblList as $dbName => $database) { ?>
	<div>
		<h2><?= $dbName ?></h2>
		<ul>
			<?php foreach ($database as $name) { ?>
				<li><a href="<?= $dbName ?>/<?= $name ?>.html"><?= $name ?></a></li>
			<?php } ?>
		</ul>

	</div>
<?php } ?>

</body>
</html>
