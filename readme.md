# tableDefinitionGenerator

テーブル定義書作成スクリプト

# 実行要件

+ PHP 7.1~ 

#usage

ex) `mysqldump --all-database --xml -d | php tableDefinitionGenerator.php output/`

+ 標準入力:mysqldump で取得したxml形式のダンプデータ
+ 引数:ファイルの出力先

# 制限事項

+ table以外のオブジェクトは未対応
+ 最大単位はmysqlサーバー単位
+ mysql以外のDBは未対応
