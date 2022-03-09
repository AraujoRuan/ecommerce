<?php
    use \Hcode\PageAdmin;
    use \Hcode\Model\User;
	use \Hcode\Model\Category;
	use \Hcode\Model\Product;
	

    //Rota que redireiona para página de categorias
$app->get("/admin/categories", function(){
	User::verifyLogin();
	$categories = Category::ListAll();
	$page = new PageAdmin();
	$page->setTpl("categories", [
		'categories'=>$categories
	]);
});

//Rota que redireciona para página de criaação de categoria
$app->get("/admin/categories/create", function(){
	User::verifyLogin();
	$page = new PageAdmin();
	$page->setTpl("categories-create");
});

//Rota que envia os dados do formulário para a criaação da categoria
$app->post("/admin/categories/create", function(){
	User::verifyLogin();
	$category = new Category();
	$category->setData($_POST);
	$category->save();
	header("Location: /admin/categories");
	exit;
});

//Rota que deleta categoria
$app->get("/admin/categories/:idcategory/delete", function($idcategory){
	User::verifyLogin();
	$category = new Category();
	$category->get((int)$idcategory);
	$category->delete();
	header("Location: /admin/categories");
	exit;
});

//Rota que redireciona para a página de edição de categoria

$app->get("/admin/categories/:idcategory", function($idcategory){
	User::verifyLogin();
	$category = new Category();
	$category->get((int)$idcategory);
	$page = new PageAdmin();
	$page->setTpl("categories-update", [
		'category'=>$category->getValues()
	]);	
});

//Rota que envia o formulário da edição
$app->post("/admin/categories/:idcategory", function($idcategory){
	User::verifyLogin();
	$category = new Category();
	$category->get((int)$idcategory);
	$category->setData($_POST);
	$category->save();	
	header('Location: /admin/categories');
	exit;
});


//Rota que redireciona até a página de produtos por categoria
$app->get("/admin/categories/:idcategory/products", function($idcategory){
	User::verifyLogin();
	$category = new Category();
	$category->get((int)$idcategory);

	$page = new PageAdmin();
	$page->setTpl("categories-products", array(
		'category'=>$category->getValues(),
		'productsRelated'=>$category->getProducts(true),
		'productsNotRelated'=>$category->getProducts(false)
	));
});

$app->get("/admin/categories/:idcategory/products/:idproduct/add", function($idcategory, $idproduct){
	User::VerifyLogin();
	$category = new Category();
	$category->get((int)$idcategory);
	$product = new Product();
	$product->get((int)$idproduct);
	$category->addProduct($product);
	header("Location: /admin/categories/".$idcategory."/products");
	exit;
});
$app->get("/admin/categories/:idcategory/products/:idproduct/remove", function($idcategory, $idproduct){
	User::VerifyLogin();
	$category = new Category();
	$category->get((int)$idcategory);
	$product = new Product();
	$product->get((int)$idproduct);
	$category->removeProduct($product);
	header("Location: /admin/categories/".$idcategory."/products");
	exit;
});

?>