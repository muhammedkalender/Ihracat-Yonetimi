<script>
$( ".datepicker" ).datepicker({
  dateFormat: "dd/mm/yy",
  dayNamesMin: [ "Pzr", "Pts", "Sl", "Çrş", "Prş", "Cm", "Cmt" ],
  monthNames: [ "Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık" ],
 beforeShow: function() {
        setTimeout(function(){
            $('.ui-datepicker').css('z-index', 99999999999999);
        }, 0);
    }

});
$('.table').dataTable( {
	"order": [ 0, "desc" ],
	"lengthMenu": [ 100, 50, 25, 10 ]
});
</script><!-- Footer -->
 <style>
 .sidebar ul.navigation li{
	 display:block;
 }
 </style>
            <div class="footer">

               <!--<p> &copy; Copyright <?php echo date("Y"); ?>. Tüm hakları <strong>İhracat Yönetimi</strong>'ne aittir. Bu programın altyapı hizmetleri <a href="https://www.novasta.com.tr" title="Novasta Web Tasarım">Novasta Web Tasarım ve Yazılım</a> tarafından icra edilmektedir.</p>--></div>
            <!-- /footer -->

        </div>
    </div>

</body>
</html>
