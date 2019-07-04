
	<?php
	
	$GirisYapan = GirisYapan();
	?>
			<div class="sidebar collapse">
        	<ul class="navigation">
            	
				 <li  class="active">
					<a href="javascript:;" class="expand" id="third-level"><i class="fa fa-flag-checkered"></i> Ülkeler</a>
					<ul style="max-height:400px; overflow-y: auto;"><? 
					
				/*echo' <select data-placeholder="Ülke seçin..." onchange="UlkeFirmaList(this.value);" name="ulke" class="select-search" tabindex="2">
                                            <option value=""></option> ';
                                           */
											$query = $dbpdo->query("SELECT (select count(*) as sayi from firma where ulke=a.id and sahibi='".$session->username."') as firmaSayi, a.* FROM Ulke a", PDO::FETCH_ASSOC);
											if ( $query->rowCount() ){
												$d=mysql_query("select * from users_Ulke where username='".$session->username."'");
										   $u=mysql_fetch_object($d);
										   $ulkeList=explode(", ",$u->ulke);
											
												 foreach( $query as $row ){
													 
													 $bolge = explode(", ",$u->bolge);
													 
													  if(in_array("9999",$ulkeList) || in_array($row["id"],$ulkeList) || in_array($row["bolge"],$bolge))
													  {
														 
														if(intval($row["firmaSayi"])>0)
														{
															 echo '<li><a href="?'.URL::encode("?ulke=".$row["id"]).'">'.$row["ulke"];
															echo " (".$row["firmaSayi"].")";
															echo '</a></li>';  
														}
													
														
													  }
													  
													  
												 }
											}
											
											
                                      ?></ul></li>
									  <br>
									  <li class="active">
									  <a href="javascript:;" class="expand" id="second-level"><i class="fa fa-user"></i> Kullanıcılar</a>
										<ul>
											<?
												$d=mysql_query("select (select timestamp from active_users where username=a.username) as timestamp, a.* from users a");
												while($ou=mysql_fetch_object($d))
												{
													if((time()-intval($ou->timestamp))/60<15)
													{
														$eks='<span class="green"><i class="fa fa-circle" title="En son '.date("d.m.Y h:i:s",$ou->timestamp).' görüldü."></i></span>';
													}else
														$eks="";
														if($session->userlevel>=5)
															$linki=URL::encode("?username=".$ou->username);
														else
															$linki="";
														if($session->username==$ou->username)
															$e='class="active"';
														else
															$e="";
													echo '<li ><a '.$e.' href="?'.$linki.'">'.$ou->adi." ".$ou->soyadi.'  '.$eks.'</a>
</li>';
												}
												
											?>
										</ul>
									  </li>
					 
									  <br>
									  <li ><a href="?<?=URL::encode("?gizlifirma")?>"><i class="fa fa-archive"></i> İlgilenmeyen Firmalar</a>
										
									  </li>
            </ul>
			
        </div>
        <!-- Page header -->

    
        <!-- Page content -->
        <div class="page-content">
 <!-- /sidebar -->
		
        	
		
		
<script>
function UlkeFirmaList(ulke)
{
	$.post("?",{islem: "ulkeLinkGetir", ulke: ulke, ajax: 'true'},function(result)
		{
			window.location.href=result;
		});
}
	
</script>		