<ul id="webticker" >	
	
<?php
//get the q parameter from URL

//find out which feed was selected

  

$rss = simplexml_load_file("https://ihracatyonetimi.com/feed/");
/*
echo "<pre>";
var_dump($rss);
echo "</pre>";*/
for($i=0; $i<count($rss->channel->item);$i++)
{
	if(trim($rss->channel->item[$i]->title)!="")
	echo "<li><a href='".$rss->channel->item[$i]->link."' target='blank_'>" .trim($rss->channel->item[$i]->title). "</a></li>";	
}

?>
</ul>

