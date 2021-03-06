<?php header("Content-Type: text/html;charset=UTF-8"); ?>
<?php 
	require_once("modelCategory.php");
	require_once("modelArticle.php");
	require_once 'modelTag.php';
	$url = $_GET["url"];
	$catModel = new CategoryModel();
	$artModel = new ArticleModel();

	$category = $catModel->getCategory($url);
	$articles = $catModel->getArticles($category);
	$content = "";
	$tags = array();
	
	/////////////////////////////////Список всех тегов
	$modelTAG = new TagModel();
	$alltags = $modelTAG->getAllTags();

	for ($i=0; $i < count($alltags); $i++) { 
		$aside .= "<li><a href='/tags/{$alltags[$i]->getUrl()}'>".$alltags[$i]->getName()."</a></li>";
	}

	/////////////////////////////////Хедер со всеми категориями
	$categModel = new CategoryModel();
	$allCat = $categModel->getAllCategories();
	$header = "<li><a href='/'>Main</a></li>";

	for ($i=0; $i < count($allCat); $i++) { 
		$header .= "<li><a href='/categories/{$allCat[$i]->getUrl()}'>".$allCat[$i]->getTitle()."</a></li>";
	}

	////////////////////////////////////Список новостей по данной категории
	foreach ($articles as $key => $value) {
		foreach ($artModel->getTags($value) as $k => $v) {
			$tags[] = "<a href='/tags/{$v}'>".$v."</a>";
			$t = implode("; ", $tags);
		}
		$content .= "<div><img src='/{$value->getimg()}'><h2><a href='/articles/{$value->getUrl()}'>".$value->getName()."</a></h2><p>Tags: <i>".$t."</i></p><p>Views: ".$value->getViews()."</p><p>Date: ".$value->getdate()."</p></div>";
		$tags = array();
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="/style.css">
</head>
<body>
	<header>
		<ul class="header">
			<?=$header ?>
		</ul>
	</header>
	<aside>
		<ul class="aside">
			<?=$aside ?>			
		</ul>
	</aside>
	<main>
		<?=$content ?>
	</main>
</body>
</html>