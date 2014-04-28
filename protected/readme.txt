创建本地配置目录

/usr/local/webapp/ecard/config
/usr/local/webapp/ecard/runtime

将main.php配置文件拷入

Yii目录：
/usr/local/webapp/libs/yii-1.1.8

修改 /usr/local/webapp/libs/yii-1.1.8/db/schema/oci/COciSchema.php

修改函数 findColumns()：


	/**
	 * Collects the table column metadata.
	 * @param COciTableSchema $table the table metadata
	 * @return boolean whether the table exists in the database
	 */
	protected function findColumns($table)
	{
		$schemaName=$table->schemaName;
		$tableName=$table->name;

		$sql=<<<EOD
SELECT (a.column_name), a.data_type ||
    case
        when data_precision is not null
            then '(' || a.data_precision ||
                    case when a.data_scale > 0 then ',' || a.data_scale else '' end
                || ')'
        when data_type = 'DATE' then ''
        when data_type = 'NUMBER' then ''
        else '(' || to_char(a.data_length) || ')'
    end as data_type,
    a.nullable, a.data_default,
    (   SELECT D.constraint_type
        FROM ALL_CONS_COLUMNS C
        inner join ALL_constraints D on D.OWNER = C.OWNER and D.constraint_name = C.constraint_name
        WHERE C.OWNER = B.OWNER
           and C.table_name = B.object_name
           and C.column_name = A.column_name
           and D.constraint_type = 'P') as Key
FROM ALL_TAB_COLUMNS A
inner join ALL_OBJECTS B ON b.owner = a.owner and ltrim(B.OBJECT_NAME) = ltrim(A.TABLE_NAME)
WHERE
    a.owner = '{$schemaName}'
	and (b.object_type = 'TABLE' or b.object_type = 'VIEW')
	and b.object_name = '{$tableName}'
ORDER by a.column_id
EOD;

        $GLOBALS['g_oci_fetchcolumns_lower'] = false;
		$command=$this->getDbConnection()->createCommand($sql);

		if(($columns=$command->queryAll())===array()){
            $GLOBALS['g_oci_fetchcolumns_lower'] = true;
			return false;
		}

		foreach($columns as $column)
		{
			$c=$this->createColumn($column);
            $c->name = strtolower($c->name);
			$table->columns[$c->name]=$c;
			if($c->isPrimaryKey)
			{
				if($table->primaryKey===null)
					$table->primaryKey=$c->name;
				else if(is_string($table->primaryKey))
					$table->primaryKey=array($table->primaryKey,$c->name);
				else
					$table->primaryKey[]=$c->name;
				$table->sequenceName='';
				$c->autoIncrement=true;
			}
		}
        $GLOBALS['g_oci_fetchcolumns_lower'] = true;
		return true;
	}
