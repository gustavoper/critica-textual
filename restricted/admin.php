<?php
require "../parameters.php";

if(empty($_SESSION['user'])) {
	header("location: ../index.php?error=notAllowed");
	exit;
}

$users = $database->query('select * from user')->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--Import materialize.css-->
  <link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>

  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta charset="utf-8"/>
</head>

<body>

  <script type="text/javascript" src="../js/jquery-2.1.min.js"></script>
  <script type="text/javascript" src="../js/materialize.min.js"></script>
  <style type="text/css">
    body {
      display: flex;
      min-height: 100vh;
      flex-direction: column;
    }

    main {
      flex: 1 0 auto;
    }

    #modal-new-user {
      width:500px;
    }

    #modal-new-user .btn {
      margin-right:30px;
    }
  </style>

<main>
	<nav>
      <div class="nav-wrapper">
        <a href="#" class="brand-logo center">Área Restrita</a>
        <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
          <li><a href="../index.php" class="login">Sair <i class="material-icons right">arrow_back</i></a></li>
        </ul>
        <ul class="side-nav" id="mobile-demo">
          <li><a href="../index.php" class="login">Sair <i class="material-icons right">arrow_back</i></a></li>
        </ul>
      </div>
    </nav>

    <div class="container">
    	<div class="row">
    		<div class="col s6">
    			<h5>Gerenciamento de usuários</h5>
    			<table class="highlight">
    				<thead>
    					<tr>
    						<th>Nome</th>
    						<th>Login</th>
    						<th><a href="#" id="new-user"><i class="material-icons right" style="color:green;">person_add</i></a></th>
    					</tr>
    				</thead>
    				<tbody>
    					<?php foreach($users as $user) { ?>
    					<tr>
    						<td><?=$user->name?></td>
    						<td><?=$user->login?></td>
    						<td id="<?=base64_encode($user->id)?>"><a href="#"><i class="material-icons right remove-user" style="color:red;">remove</i></a></td>
    					</tr>
    					<?php } ?>
    				</tbody>
    			</table>
    		</div>
    		<div class="col s4 offset-s2">
    			<h5>Atualização da base</h5>
    			<form action="update.php" method="post" enctype="multipart/form-data">
    				<input type="hidden" name="_token" value="<?=$_SESSION['token']?>">
    				<select name="tipo">
      				<option value="0">-- Selecione --</option>
      				<option value="papiros">Papiros</option>
  						<option value="unciais">Unciais</option>
  						<option value="minusculos">Minúsculos</option>
  						<option value="lecionarios">Lecionários</option>
  						<option value="versoes">Versões</option>
  						<option value="pais">Pais da Igreja</option>
    				</select>
    				<label>Item</label>
    				<input type="file" name="planilha">
    				<button class="btn waves-effect waves-light left" type="submit" style="margin-top:5px;">Enviar
        				<i class="material-icons right">send</i>
    				</button>
    			</form>
    		</div>
    	</div>
    </div>

</main>

<footer class="page-footer">
	  <div class="footer-copyright">
	    <div class="container">
	      © 2017 Copyright STBL
	      <a class="grey-text text-lighten-4 right" href="https://www.stblitoral.com.br/" target="_blank">Saiba mais</a>
	    </div>
	  </div>
</footer>

<div class="modal" id="modal-new-user">
  <form action="new_user.php" method="post">
    <input type="hidden" name="_token" value="<?=$_SESSION['token']?>">
    <div class="modal-content">
      <h4 class="center-align">Novo Usuário</h4>
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">style</i>
          <input id="icon_prefix" type="text" class="validate" name="name">
          <label for="icon_prefix">Nome</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">account_circle</i>
          <input id="icon_prefix" type="text" class="validate" name="login">
          <label for="icon_prefix">Login</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">https</i>
          <input id="icon_telephone" type="password" class="validate" name="password">
          <label for="icon_telephone">Senha</label>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn waves-effect waves-light" type="submit">Cadastrar
        <i class="material-icons right">send</i>
      </button>
    </div>
  </form>
</div>

<div class="modal" id="modal-remove-user">
  <form method="post" action="remove_user.php">
    <input type="hidden" name="userId">
    <input type="hidden" name="_token" value="<?=$_SESSION['token']?>">
    <div class="modal-content">
      <h4>Aviso</h4>
      <p>Tem certeza de que deseja excluir esse usuário?</p>
    </div>
    <div class="modal-footer">
      <button class="btn waves-effect waves-light" type="submit">Ok
        <i class="material-icons right">send</i>
      </button>
      <a href="#" class="modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
    </div>
  </form>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('select').material_select();
    $('.modal').modal();
    $(".button-collapse").sideNav();

    <?php if(!empty($_GET['status']) and $_GET['status'] == 'planilhaSucesso') { ?>
      Materialize.toast('Planilha importada com sucesso <i class="material-icons right">check</i>', 4000);
    <?php } ?>

    <?php if(!empty($_GET['status']) and $_GET['status'] == 'novoUsuarioSucesso') { ?>
      Materialize.toast('Usuário criado com sucesso <i class="material-icons right">check</i>', 4000);
    <?php } ?>

    <?php if(!empty($_GET['status']) and $_GET['status'] == 'novoUsuarioErro') { ?>
      Materialize.toast('Erro ao criar usuário <i class="material-icons right">clear</i>', 4000);
    <?php } ?>

    <?php if(!empty($_GET['status']) and $_GET['status'] == 'excluirUsuarioSucesso') { ?>
      Materialize.toast('Usuário excluído com sucesso <i class="material-icons right">clear</i>', 4000);
    <?php } ?>

    <?php if(!empty($_GET['status']) and $_GET['status'] == 'excluirUsuarioErro') { ?>
      Materialize.toast('Não foi possível excluir o usuário <i class="material-icons right">clear</i>', 4000);
    <?php } ?>

    $("#new-user").click( function() {
      $("#modal-new-user").modal('open');
    });

    $(".remove-user").click( function() {
      $("input[name='userId']").val($(this).parent().parent().attr('id'));
      $("#modal-remove-user").modal('open');
    });
	});
</script>

</body>
</html>