<?php

// tmp klasörünü sil
function DeleteTmpFolder() {
	$tmp_directory = "tmp/";
	$png_files = glob($tmp_directory."*.png");
	foreach($png_files as $image) {
		$thetime = filemtime(BASE_DIR."/".$image."");
		if ($thetime < (time()-86400)) {
			unlink($image);
		}
	}
}


?>