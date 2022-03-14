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
	
	$category = new Category();
	$category->get((int)$idcategory);
	$page = new Page();
	$page->setTpl("category", array(
		'category'=>$category->getValues(),
		'products'=>Product::checkList($category->getProducts(true))
	));
});

?>