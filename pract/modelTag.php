<?php 
	require_once("tag.php");
	require_once("article.php");
	class TagModel
	{
		public function getTag($url)
		{
			$link = mysqli_connect("localhost","host1316886_u1","g62YH9nn","host1316886_db1");
			$data = mysqli_query($link, "SELECT * FROM tags WHERE url=\"$url\"");
			$results = array();
			while ($temp = mysqli_fetch_assoc($data)) {
				$results[] = new tag\Tag($temp['id'], $temp['name'], $temp['url']);
			}
			return $results[0];
		}

		public function getAllTags()
		{
			$link = mysqli_connect("localhost","host1316886_u1","g62YH9nn","host1316886_db1");
			$data = mysqli_query($link, "SELECT * FROM tags");
			$results = array();
			while ($temp = mysqli_fetch_assoc($data)) {
				$results[] = new tag\Tag($temp['id'], $temp['name'], $temp['url']);
			}
			return $results;
		}

		public function getArticleForTag($t)
		{
			$link = mysqli_connect("localhost","host1316886_u1","g62YH9nn","host1316886_db1");
			$id= $t->getId();
			$articles_id = array();
			$results = array();
			$data = mysqli_query($link, "SELECT DISTINCT articles_id FROM articles_has_tags WHERE tags_id=$id");
			while ($temp = mysqli_fetch_assoc($data)) {
				$articles_id[] =  $temp['articles_id'];
			}
			foreach ($articles_id as $key => $value) {
				$data = mysqli_query($link, "SELECT * FROM articles WHERE id=$value ORDER BY date");
				while ($temp = mysqli_fetch_assoc($data)) {
					$results[] = new article\Article($temp['id'], $temp['categories_id'], $temp['content'], $temp['date'], $temp['views'], $temp['img'], $temp['url'], $temp['name']);
				}
			}
			return $results;
		}

	}
?>