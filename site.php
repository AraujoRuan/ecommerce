<?php
    use \Hcode\Page;
	use \Hcode\Model\Category;
	use \Hcode\Model\Product;
//Rota homepage site
$app->get('/', function() { // Define a rota

	$products = Product::ListAll();

	$page = new Page();		//Cria uma pagina de acordo com o conteúdo indicado

	$page->setTpl("index", [
		'products'=>Product::checkList($products)
	]);
});

$app->get("/categories/:idcategory", function($idcategory){

	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	$category = new Category();

	$category->get((int)$idcategory);

	$pagination = $category->getProductsPage($page);

	$pages = [];

	for ($i=1; $i <= $pagination['pages']; $i++) { 
		array_push($pages, [
			'link'=>'/categories/'.$category->getidcategory().'?page='.$i,
			'page'=>$i
		]);
	}

	$page = new Page();

	$page->setTpl("category", array(
		'category'=>$category->getValues(),
		'products'=>$pagination["data"],
		'pages'=>$pages
	));
});

?>