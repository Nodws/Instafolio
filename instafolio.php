<?
 //SETUP

//Your username
$u = "nodws";

//API key
$key = "YOUR APP KEY"

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Instafolio</title>
	<link rel="stylesheet" href="https://cdn.rawgit.com/jackmoore/colorbox/540e4064/example2/colorbox.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<style>
		.pop{
			position: relative;
			width: 33%;
			display: inline-block;
		}
		.pop img{
			width: 100%;
			height:auto;
			outline:0 !important;
		}
		.pop h2{
			position:absolute;
			bottom:40%;
			margin:0;
			left:0%;
			width: 100%;
			text-align: center;
			background: rgba(0,0,0,0.5);
			color: #fff;
			padding: 5px 0;
			opacity: 0;
			transition: all 0.4s
		}
		.pop:hover h2{
			opacity: 1;
		}
		#cboxLoadedContent {
   			 background: #ffffff;
		}
		@media (max-width: 830px){
			.pop{
				width: 49.6%
			}
		}		
		@media (max-width: 530px){
			.pop{
				width: 100%
			}
		}
	</style>
</head>
<?
if($_GET[p])
{

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://www.behance.net/v2/projects/".$_GET[p]."?client_id=".$key);
curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$json = curl_exec($ch);
$o = json_decode($json);
curl_close($ch); 
echo "<h2>{$o->project->name}</h2>";
foreach ($o->project->modules as $v) {
	$v->src = str_replace('/disp/','/max_1200/', $v->src);
	echo $v->text ? "<p>$v->text</p>" : "<img src='$v->src' width=100%>";	
}
exit;
}

?>
<body>
<?
$json = 'http://www.behance.net/v2/users/'.$u.'/projects?client_id='.$key;

echo "<h2>@$u</h2>";
$ch = curl_init();


curl_setopt($ch, CURLOPT_URL, $json);
curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$json = curl_exec($ch);

$o = json_decode($json);

curl_close($ch); 

foreach ($o->projects as $v) {
	$c = $v->covers->{'404'} ? $v->covers->{'404'} : $v->covers->{'202'};
	?>
		<a class="pop" href="?p=<?=$v->id?>"><img src="<?=$c?>" width="404"  alt="<?=$v->name?>"><h2><?=$v->name?></h2></a>
	<?
}
?>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.6.4/jquery.colorbox.js"></script>
	<script>
	$(document).ready(function(){
		$(".pop").colorbox({iframe:true, width:"80%", height:"80%", maxWidth:"900px"});
	});
	</script>
