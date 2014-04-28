<?php
class ExcelDown {
	public static function run($file, $data = array(), $fieldsDesc = array(), $title = "") {
		set_time_limit(0);  //解决导出超时问题
		spl_autoload_unregister ( array ('YiiBase', 'autoload' ) ); //关闭yii的自动加载功能
		Yii::import ( 'application.extensions.php_excel.PHPExcel', true );
		$filename = iconv ( 'utf-8', 'gbk', $file . date ( 'Y-m-d' ) . '.xls' );
		
		$totalSheet = ceil ( count ( $data ) / 65535);
		$sheetData = array();
		for($s = 0;$s<$totalSheet;$s++){
			$sheetData[$s] = array_slice($data,$s*65535,65535);
		}
		/** PHPExcel */
		//设置单元格缓存方式,默认为内存缓存
		$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;   
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod);  
		
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel ();
		
		// Set properties
		$objPHPExcel->getProperties ()->setCreator ( "TrunkBow" )
		                              ->setLastModifiedBy ( "TrunkBow" )
		                              ->setTitle ( "Office 2003 XLS Document" )
		                              ->setSubject ( "Office 2003 XLS Document" )
		                              ->setDescription ( "TrunkBow" )
		                              ->setKeywords ( "TrunkBow" )
		                              ->setCategory ( "TrunkBow" );
		
		//set cell style
		foreach($sheetData as $sheet => $rows) {
			$t = ord ( 'A' );
			if($sheet!=0)
				$objPHPExcel->createSheet();
			$objPHPExcel->setActiveSheetIndex($sheet);
			foreach ( $fieldsDesc as $desc ) {
				$objPHPExcel->getActiveSheet() ->setCellValue ( chr ( $t ) . '1', $desc );
				$objPHPExcel->getActiveSheet() ->getStyle ( chr ( $t ) . '1' )->getFont ()->setBold ( true );
				$objPHPExcel->getActiveSheet() ->getStyle ( chr ( $t ) . '1' )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
				$objPHPExcel->getActiveSheet() ->getStyle ( chr ( $t ) )->getNumberFormat()->setFormatCode ( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$objPHPExcel->getActiveSheet() ->getColumnDimension ( chr ( $t ) )->setWidth(15);
				$t ++;
			}
			
		
		}
		if ($sheetData) {
			foreach ( $sheetData as $sheet =>$rows ) {
				$i = 2;
				$j = ord ( 'A' );
				$objPHPExcel->setActiveSheetIndex($sheet)->setTitle('sheet'.($sheet+1));
				foreach($rows as $row){
					foreach($fieldsDesc as $k =>$v ){
						$objPHPExcel->getActiveSheet() ->
							setCellValue ( chr ( $j ++ ) . $i," ".$row[$k]);
					}
					$j = ord ( 'A' );
					$i ++;
				}
				
			}
		}
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex ( 0 );
		
		$objWriter = PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel5' );
		header ( 'Content-Type: application/vnd.ms-excel' );
		header ( "Content-Disposition: attachment;filename=$filename" ); 
		header ( 'Cache-Control: max-age=0' );
		$objWriter->save ( 'php://output' );
		Yii::app()->end();
		spl_autoload_register ( array ('YiiBase', 'autoload' ) ); //打开yii的自动加载功能
//		exit();
	
	}
	
}