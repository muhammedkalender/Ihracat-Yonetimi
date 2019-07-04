<?php



include "../include.php";

$lang=$session->userinfo["dil"];



/* cron olarak kurulamayan ama arada çalışması gereken kodlar */























/* */



















	



































































	

include "../inc.header.php";

include "../inc.menu.php";

 



// Önce şifrelenmiş linkten değerleri al

foreach($_REQUEST as $input=>$value) {

	 $_REQUEST[$input] = $value;

}

// Aldığın değerleri tanımın adına döşe

foreach ($_REQUEST AS $k=>$v) $$k=$v;

 

?>

<div class="page-title">

                <h5>Novasta<small>İhracat Yönetimi</small></h5>

                <div class="btn-group">

                    

                </div>

            </div>

            <!-- /page title -->



<?

if(isset($_POST["aciklama"]))
{

	MailGonder("ihracat@novasta.com.tr","İhracat - FeedBack",htmlspecialchars(strip_tags($aciklama)));

	echo $uyari->Basarili("Görüşünüz başarıyla gönderilmiştir. İlginiz için teşekkür ederiz.");

}else{

	

echo '

<form method="post" class="form-horizontal form-bordered" role="form">
    <div class="panel panel-default">
		<div class="panel-heading"><h6 class="panel-title">Geri Bildirim Formu</h6></div>
            <div class="panel-body">
				<p>İhracat yönetimi programında ki amacımız sizlerinde katkılarıyla daha <strong>kolay</strong>, daha <strong>hızlı</strong> ve daha <strong>doğru</strong> çalışan bir yazılım yapmaktır. Programı bire bir kullanan olarak sizlerden gelecek ve programın gelişimine katkı sağlayacak tüm olumlu/olumsuz görüşleriniz bizim için çok değerli olacaktır.</p>
				<p>Aşağıda ki form vasıtası ile bize görüşlerinizi bildirmenizi rica ederiz.</p>
					<div class="form-group">

							<label class="col-sm-2 control-label"><b>Görüşleriniz / Önerileriniz</b> </label>

									<div class="col-sm-10">
<textarea rows="8" name="aciklama" class="form-control"></textarea>
									</div>
 
                        </div>
					
						<button type="submit" class="btn btn-primary dropdown-toggle  ">Gönder</button>
				</div>

		</div>
</form>

		';

}

?>



 



<?php





include "../inc.footer.php";

?>