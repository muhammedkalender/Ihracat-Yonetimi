<?php
include "../../include.php";
$lang=$session->userinfo["dil"];
unset($sayfaActive);
$sayfaActive["musterilerim"]="page-header-active";
include "../../inc.header.php";
include "../../inc.menu.php";

// Önce şifrelenmiş linkten değerleri al
foreach($_REQUEST as $input=>$value) {
	 $_REQUEST[$input] = $value;
}
// Aldığın değerleri tanımın adına döşe
foreach ($_REQUEST AS $k=>$v) $$k=$v;
?>
<div class="page-title">
    <h5 class="alert">İhracat Haberleri :</h5>
 <?php   
include "../../inc.news.php"
?>
</div>


            <!-- Calendar inside panel -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-calendar2"></i> Calendar inside panel</h6>
                </div>
                <div id='calendar'></div>
            </div>
            <!-- /calendar inside panel -->
 


			
<script>
	$('#calendar').fullCalendar({
     events: [
        {
            title: 'Event1',
            start: '2016-08-04'
        },
        {
            title: 'Event2',
            start: '2016-08-05'
        }
        // etc...
    ],
    color: 'yellow',   // an option!
    textColor: 'black' // an option!
});

</script>
<?



include "../../inc.footer.php";

?>