<?php
    use \Hcode\PageAdmin;
    use \Hcode\Model\User;
    //Rota para password de usuários
	$app->get("/admin/users/:iduser/password", function($iduser){

		User::verifyLogin();
	
		$user = new User();
	
		$user->get((int)$iduser);
	
		$page = new PageAdmin();
	
		$page->setTpl("users-password", [
			"user"=>$user->getValues(),
			"msgError"=>User::getError(),
			"msgSuccess"=>User::getSuccess()
		]);
	
	});
	
	$app->post("/admin/users/:iduser/password", function($iduser){
	
		User::verifyLogin();
	
		if (!isset($_POST['despassword']) || $_POST['despassword']==='') {
	
			User::setError("Preencha a nova senha.");
			header("Location: /admin/users/$iduser/password");
			exit;
	
		}
	
		if (!isset($_POST['despassword-confirm']) || $_POST['despassword-confirm']==='') {
	
			User::setError("Preencha a confirmação da nova senha.");
			header("Location: /admin/users/$iduser/password");
			exit;
	
		}
	
		if ($_POST['despassword'] !== $_POST['despassword-confirm']) {
	
			User::setError("Confirme corretamente as senhas.");
			header("Location: /admin/users/$iduser/password");
			exit;
	
		}
	
		$user = new User();
	
		$user->get((int)$iduser);
	
		$user->setPassword(User::getPasswordHash($_POST['despassword']));
	
		User::setSuccess("Senha alterada com sucesso.");
	
		header("Location: /admin/users/$iduser/password");
		exit;
	
	});
	

    //Rota para página de usuários
	$app->get("/admin/users", function() {

		User::verifyLogin();
	
		$search = (isset($_GET['search'])) ? $_GET['search'] : "";
		$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	
		if ($search != '') {
	
			$pagination = User::getPageSearch($search, $page);
	
		} else {
	
			$pagination = User::getPage($page);
	
		}
	
		$pages = [];
	
		for ($x = 0; $x < $pagination['pages']; $x++)
		{
	
			array_push($pages, [
				'href'=>'/admin/users?'.http_build_query([
					'page'=>$x+1,
					'search'=>$search
				]),
				'text'=>$x+1
			]);
	
		}
	
		$page = new PageAdmin();
	
		$page->setTpl("users", array(
			"users"=>$pagination['data'],
			"search"=>$search,
			"pages"=>$pages
		));
	
	});
//Rota para página de criar usuário
$app->get("/admin/users/create", function(){ //Pra criar a tela
	User::verifyLogin();
	$page = new PageAdmin();
	$page->setTpl("users-create");
});

//Rota para deletar um usuário
$app->get("/admin/users/:iduser/delete", function($iduser) {
	User::verifyLogin();	
	$user = new User();
	$user->get((int)$iduser);
	$user->delete();
	header("Location: /admin/users");
	exit;
});

//Rota para página alterar usuário
$app->get("/admin/users/:iduser", function($iduser){
	User::verifyLogin();
  $user = new User();
  $user->get((int)$iduser);
	$page = new PageAdmin();
	$page->setTpl("users-update", array(
    'user'=>$user->getValues()
  ));
});
//Para salvar a criação informação no banco de dados
$app->post("/admin/users/create", function(){
	User::verifyLogin();
	$user = new User();
 	$_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;
 	$_POST['despassword'] = password_hash($_POST["despassword"], PASSWORD_DEFAULT, [
 		"cost"=>12
 	]);
 	$user->setData($_POST);
	$user->save();
	header("Location: /admin/users");
 	exit;
});
//Para alterar no banco de dados
$app->post("/admin/users/:iduser", function($iduser){
	User::verifyLogin();
  $user = new user();
  $_POST["inadmin"]=(isset($_POST["inadmin"]))?1:0;
  $user->get((int)$iduser);
  $user->setData($_POST);
  $user->update();
  header("Location: /admin/users");
  exit;
});

$app->get("/setasenha",function() {
	$user = new User();
	$_POST['inadmin']=1;
	$_POST['deslogin']='ruan';
	$_POST['despassword'] = password_hash('admin', PASSWORD_DEFAULT, [
		"cost"=>12
	]);
	$user->setData($_POST);
   $user->save();	
})

?>