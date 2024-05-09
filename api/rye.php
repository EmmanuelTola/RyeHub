<?php 
include("hex.php");
$con = "q2goAPe9YRLIWeWI75Iw"; 
$db = "ryehub"; 
$id = $_GET['id']; 
$tab = $_GET['tab']; 
$data = QUERY($con, $db, "SELECT $tab WHERE id = '$id'"); 
$row = $data[0];
$name = $row['name'];
$bio = $row['bio']; 
$pic = $xqlurl ."/files/" .$con ."/".$row['pic']; 
$link = "seller.html";
if($tab == "products"){
$link = "item.html"; 
}
?>

<!DOCTYPE html>
<head>
<meta property="og:image" content="<?php echo $pic; ?>" />
<link rel="shortcut icon" type="image/jpg" href="<?php echo $pic; ?>">
<meta data-react-helmet="true" name="description" content="<?php echo $bio; ?>"/>
<meta name="twitter:card" content="summary_large_image">
<meta property="twitter:title" content="<?php echo $name; ?>">
<meta property="twitter:description" content="<?php echo $bio; ?>">
<meta property="twitter:image" content="<?php echo $pic; ?>">	
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta property="og:type" content="website"/>


 <title><?php echo $name; ?></title>
</head>
<script>
location.href = "https://ryehub.vercel.app/<?php echo $link; ?>?id=<?php echo $id; ?>";
</script>
