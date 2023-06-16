<?php /** @var SimpleXMLElement $table */ ?>
<html>
<head>
	<link href="../default.css" type="text/css" rel="stylesheet" />
</head>
<body>
<nav>
	<h1><a href="../index.html">テーブル一覧</a></h1>
	<?php foreach ($tblList as $dbName => $database) { ?>
		<label for="chk_<?= $dbName ?>"><?= $dbName ?></label>
		<input type="checkbox" id="chk_<?= $dbName ?>"/>
		<ul id="list__<?= $dbName ?>" class="accordion">
			<?php foreach ($database as $name) { ?>
				<li><a href="../<?= $dbName ?>/<?= $name ?>.html"><?= $name ?></a></li>
			<?php } ?>
		</ul>
	<?php } ?>
</nav>

<article>
	<h1><?= $table->attributes()['name'] ?></h1>
	<h2>基本情報</h2>
	<!--	<options Name="tbl_kpi_active_user" Engine="InnoDB" Version="10" Row_format="Dynamic" Rows="0"-->
	<!--			 Avg_row_length="0" Data_length="16384" Max_data_length="0" Index_length="16384" Data_free="0"-->
	<!--			 Auto_increment="1" Create_time="2018-06-27 14:07:21" Collation="utf8mb4_general_ci"-->
	<!--			 Create_options="" Comment="アクティブユーザー集計"/>-->
	<table id="basic">
		<tr>
			<th>Engine</th>
			<th>Collation</th>
			<th>Comment</th>
		</tr>
		<tr>
			<td><?= $table->options->attributes()['Engine'] ?></td>
			<td><?= $table->options->attributes()['Collation'] ?></td>
			<td><?= $table->options->attributes()['Comment'] ?></td>

		</tr>
	</table>

	<h2>列</h2>
	<!--	<field Field="created" Type="datetime" Null="NO" Key="" Default="CURRENT_TIMESTAMP" Extra=""-->
	<!--		   Comment="作成日時"/>-->
	<table id="field">
		<thead>
		<tr>
			<th>列名</th>
			<th>型</th>
			<th>AI</th>
			<th>null</th>
			<th>default</th>
			<th>コメント</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($table->field as $field) { ?>
			<tr>
				<td><?= $field->attributes()['Field'] ?></td>
				<td><?= $field->attributes()['Type'] ?></td>
				<td><?= strpos($field->attributes()['Extra'], 'auto_increment') !== false ? '〇' : '-' ?></td>
				<td><?= (string)$field->attributes()['Null']==='NO'?'-':'〇' ?></td>
				<td><?= $field->attributes()['Default'] ?></td>
				<td><?= $field->attributes()['Comment'] ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<h2>キー</h2>
	<!--	<key Table="tbl_kpi_active_user" Non_unique="1" Key_name="idx_tbl_kpi_sales_platform_type" Seq_in_index="1"-->
	<!--		 Column_name="platform_type" Collation="A" Cardinality="0" Null="" Index_type="BTREE" Comment=""-->
	<!--		 Index_comment=""/>-->
	<table id="key">
		<thead>
		<tr>
			<th>キー名</th>
			<th>列名</th>
			<th>index順</th>
			<th>一意制約</th>
			<th>null</th>
			<th>Index_type</th>
			<th>Comment</th>
			<th>Index_comment</th>
		</tr>
		</thead>
		<tbody>
		<?php $keySeq = 0;
		$keyName = '';
		foreach ($table->key as $key) {
			if ($keyName !== (string)$key->attributes()['Key_name']) {
				$keyName = (string)$key->attributes()['Key_name'];
				$keySeq++;
			} ?>
			<tr class="key_seq_<?=$keySeq?>">
				<td><?= $key->attributes()['Key_name'] ?></td>
				<td><?= $key->attributes()['Column_name'] ?></td>
				<td><?= $key->attributes()['Seq_in_index'] ?></td>
				<td><?= (string)$key->attributes()['Non_unique'] === '0' ? '〇' : '-' ?></td>
				<td><?= $key->attributes()['Null'] ?></td>
				<td><?= $key->attributes()['Index_type'] ?></td>
				<td><?= $key->attributes()['Comment'] ?></td>
				<td><?= $key->attributes()['Index_comment'] ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</article>
</body>
</html>
