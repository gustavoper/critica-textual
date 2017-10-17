<?php 

require "parameters.php"; 
session_destroy();

$papiros = $database->query('select * from papiro where is_active = 1')->fetchAll();
$unciais = $database->query('select * from uncial where is_active = 1')->fetchAll();
$minusculos = $database->query('select * from minusculo where is_active = 1 limit 100')->fetchAll();
$lecionarios = $database->query('select * from lecionario where is_active = 1')->fetchAll();
$versoes = $database->query('select * from versao where is_active = 1')->fetchAll();
$pais = $database->query('select * from pai where is_active = 1')->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--Import materialize.css-->
  <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta charset="utf-8"/>
</head>

<body>
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-43746831-3', 'auto');
  ga('send', 'pageview');
  </script>
  <!--Import jQuery before materialize.js-->
  <script type="text/javascript" src="js/jquery-2.1.min.js"></script>
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <style type="text/css">
    body {
      display: flex;
      min-height: 100vh;
      flex-direction: column;
    }

    main {
      flex: 1 0 auto;
    }

    .chips
    {
      border-bottom:1px solid white;
    }

    #search
    {
      margin:0px !important;
      height: 60px;
    }

    #modal-login {
      width:500px;
    }

    #modal-login .btn {
      margin-right:30px;
    }
  </style>
  <!--
  http://www.estudantesdabiblia.com.br/biblia/livros-biblia.html
-->
<main>
  <form action="exportar.php" method="POST" id="exportar-form">
    <nav class="nav-extended">
      <div class="nav-wrapper">
        <ul class="hide-on-med-and-down">
          <li>
            <div class="input-field">
              <input id="search" type="search" required>
              <label class="label-icon" for="search"><i class="material-icons">search</i></label>
              <i class="material-icons">close</i>
            </div>
          </li>
        </ul>
        <a href="#" class="brand-logo center">Crítica Textual</a>
        <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
          <li><a href="#" class="login">Área restrita <i class="material-icons right">lock</i></a></li>
          <li><a href="#" class="submit">Gerar Planilha <i class="material-icons right">send</i></a></li>
        </ul>
        <ul class="side-nav" id="mobile-demo">
          <li><a href="#" class="login">Área restrita <i class="material-icons right">lock</i></a></li>
          <li><a href="#" class="submit">Gerar Planilha <i class="material-icons right">send</i></a></li>
        </ul>
      </div>
      <div class="nav-content">
        <ul class="tabs tabs-transparent tabs-fixed-width z-depth-1">
          <li class="tab"><a href="#texto" class="active" prev="limit">Texto</a></li>
          <li class="tab"><a href="#papiros" next="#unciais" prev="#texto">Papiros</a></li>
          <li class="tab"><a href="#unciais" next="#minusculos" prev="#papiros">Unciais</a></li>
          <li class="tab"><a href="#minusculos" next="#lecionarios" prev="#unciais">Minúsculos</a></li>
          <li class="tab"><a href="#lecionarios" next="#versoes" prev="#minusculos">Lecionários</a></li>
          <li class="tab"><a href="#versoes" next="#pais" prev="#lecionarios">Versões</a></li>
          <li class="tab"><a href="#pais" next="limit" prev="#versoes">Pais da Igreja</a></li>
        </ul>
      </div>
    </nav>

    <div id="texto" class="col s12">
      <br>
      <div class="container">
        <div class="row">
          <div class="input-field col s6">
            <input id="last_name" type="text" class="validate" name="variante">
            <label for="last_name">Variante Textual</label>
          </div>
          <div class="input-field col s6">
            <input id="last_name" type="text" class="validate" name="traducao">
            <label for="last_name">Tradução</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s6">
            <select name="livro">
              <option value="Mateus">Mt - Mateus</option>
              <option value="Marcos">Mc - Marcos</option>
              <option value="Lucas">Lc - Lucas</option>
              <option value="João">Jo - João</option>
              <option value="Atos dos Apóstolos">At - Atos dos Apóstolos</option>
              <option value="Romanos">Rm - Romanos</option>
              <option value="1 Coríntios">1Co - 1 Coríntios</option>
              <option value="2 Coríntios">2Co - 2 Coríntios</option>
              <option value="Gálatas">Gl - Gálatas</option>
              <option value="Efésios">Ef - Efésios</option>
              <option value="Filipenses">Fp - Filipenses</option>
              <option value="Colossenses">Cl - Colossenses</option>
              <option value="1 Tessalonicenses">1Ts - 1 Tessalonicenses</option>
              <option value="2 Tessalonicenses">2Ts - 2 Tessalonicenses</option>
              <option value="1 Timóteo">1Tm - 1 Timóteo</option>
              <option value="2 Timóteo">2Tm - 2 Timóteo</option>
              <option value="Tito">Tt - Tito</option>
              <option value="Filemom">Fm - Filemom</option>
              <option value="Hebreus">Hb - Hebreus</option>
              <option value="Tiago">Tg - Tiago</option>
              <option value="1 Pedro">1Pe - 1 Pedro</option>
              <option value="2 Pedro">2Pe - 2 Pedro</option>
              <option value="1 João">1Jo - 1 João</option>
              <option value="2 João">2Jo - 2 João</option>
              <option value="3 João">3Jo - 3 João</option>
              <option value="Judas">Jd - Judas</option>
              <option value="Apocalipse">Ap - Apocalipse</option>
            </select>
            <label>Livro</label>
          </div>
          <div class="input-field col s3">
            <input id="last_name" type="text" class="validate" name="capitulo">
            <label>Capítulo</label>
          </div>
          <div class="input-field col s3">
            <input id="last_name" type="text" class="validate" name="versiculo">
            <label>Versículo</label>
          </div>
        </div>
      </div>
    </div>
    <div id="papiros" class="col s12">
      <br>
      <div class="container">
        <div class="row">
          <?php foreach($papiros as $item) { ?>
          <p class="col s2">
            <input type="checkbox" id="papiros[<?=$item->id?>]" value="<?=$item->id?>" name="papiros[]"/>
            <label for="papiros[<?=$item->id?>]"><?=$item->ds?></label>
          </p>
          <?php } ?>
        </div>
      </div>
    </div>
    <div id="unciais" class="col s12">
      <br>
      <div class="container">
        <div class="row">
          <?php foreach($unciais as $item) { ?>
          <p class="col s2">
            <input type="checkbox" id="unciais[<?=$item->id?>]" value="<?=$item->id?>" name="unciais[]"/>
            <label for="unciais[<?=$item->id?>]"><?=$item->ds?></label>
          </p>
          <?php } ?>
        </div>
      </div>
    </div>
    <div id="minusculos" class="col s12">
      <br>
      <div class="container">
        <div class="row">
          <?php foreach($minusculos as $item) { ?>
          <p class="col s2">
            <input type="checkbox" id="minusculos[<?=$item->id?>]" value="<?=$item->id?>" name="minusculos[]"/>
            <label for="minusculos[<?=$item->id?>]"><?=$item->ds?></label>
          </p>
          <?php } ?>
        </div>
      </div>
    </div>
    <div id="lecionarios" class="col s12">
      <br>
      <div class="container">
        <div class="row">
          <?php foreach($lecionarios as $item) { ?>
          <p class="col s2">
            <input type="checkbox" id="lecionarios[<?=$item->id?>]" value="<?=$item->id?>" name="lecionarios[]"/>
            <label for="lecionarios[<?=$item->id?>]"><?=$item->ds?></label>
          </p>
          <?php } ?>
        </div>
      </div>
    </div>
    <div id="versoes" class="col s12">
      <br>
      <div class="container">
        <div class="row">
          <?php foreach($versoes as $item) { ?>
          <p class="col s2">
            <input type="checkbox" id="versoes[<?=$item->id?>]" value="<?=$item->id?>" name="versoes[]"/>
            <label for="versoes[<?=$item->id?>]"><?=$item->ds?> <small><?=$item->sub?></small></label>
          </p>
          <?php } ?>
        </div>
      </div>
    </div>
    <div id="pais" class="col s12">
      <br>
      <div class="container">
        <div class="row">
          <?php foreach($pais as $item) { ?>
          <p class="col s3">
            <input type="checkbox" id="pais[<?=$item->id?>]" value="<?=$item->id?>" name="pais[]"/>
            <label for="pais[<?=$item->id?>]"><?=$item->ds?></label>
          </p>
          <?php } ?>
        </div>
      </div>
    </div>
  </form>
</main>
<footer class="page-footer">
  <div class="container">
    <div class="divider"></div>
    <div class="section">
      <a disabled class="btn waves-effect waves-light previous-tab" type="button">Anterior
        <i class="material-icons left">skip_previous</i>
      </a>
      <a href="#papiros" class="btn waves-effect waves-light right next-tab" type="button">Próximo
        <i class="material-icons right">skip_next</i>
      </a>
    </div>
  </div>
  <div class="footer-copyright">
    <div class="container">
      © 2017 Copyright STBL
      <a class="grey-text text-lighten-4 right" href="https://www.stblitoral.com.br/" target="_blank">Saiba mais</a>
    </div>
  </div>
</footer>

<div class="modal" id="modal-planilha-pronta">
  <div class="modal-content">
    <h4>Pronto</h4>
    <p>Crítica gerada com sucesso!</p>
  </div>
  <div class="modal-footer">
    <a href="#" class="modal-action modal-close waves-effect waves-green btn-flat">Ok</a>
  </div>
</div>

<div class="modal" id="modal-login">
  <form action="restricted/auth.php" method="post">
    <div class="modal-content">
      <h4 class="center-align">Credenciais</h4>
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
      <button class="btn waves-effect waves-light" type="submit">Entrar
        <i class="material-icons right">send</i>
      </button>
    </div>
  </form>
</div>

<script type="text/javascript">
  $(document).ready(function () {
    $('ul.tabs').tabs();
    $('select').material_select();
    $(".button-collapse").sideNav();
    $('.modal').modal();

    $(".next-tab").click( function() {
      var next = $('ul.tabs a[href$="' + $(this).attr('href') + '"]').attr('next');
      var now = $(this).attr('href');
      var prev = $('.tab').find('.active').attr('href');

      $('.previous-tab').removeAttr('disabled').attr('href', prev);

      if(next == 'limit')
        $('.next-tab').removeAttr('href');
      else
        $('.next-tab').attr('href', next);

      $("#search").val('');
      $('ul.tabs').tabs('select_tab', now.substr(1));
    });

    $(".previous-tab").click( function() {
      var next = $('.tab').find('.active').attr('href');
      var now = $(this).attr('href');
      var prev = $('ul.tabs a[href$="' + $(this).attr('href') + '"]').attr('prev');

      if(prev == 'limit')
        $('.previous-tab').attr('disabled', 'disabled').removeAttr('href');
      else 
        $('.previous-tab').removeAttr('disabled').attr('href', prev);
      $('.next-tab').attr('href', next);

      $("#search").val('');
      $('ul.tabs').tabs('select_tab', now.substr(1));
    });

    $("ul.tabs a").click( function() {
      var prev = $(this).attr('prev');
      var next = $(this).attr('next');

      $("#search").val('');

      if(prev == 'limit')
        $('.previous-tab').attr('disabled', 'disabled').removeAttr('href');
      else 
        $('.previous-tab').removeAttr('disabled').attr('href', prev);

      if(next == 'limit')
        $('.next-tab').removeAttr('href');
      else
        $('.next-tab').attr('href', next);
    });

    $(".submit").click( function() {
      $("#exportar-form").submit();
      $('#modal-planilha-pronta').modal('open');
    });

    $("#search").keyup( function() {
      var current = $('.tab').find('.active').attr('href');
      var $rows = $(current + ' .col');

      var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

      $rows.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
      }).hide();
    });

    $(".login").click( function() {
      $("#modal-login").modal('open');
    });

    <?php if(!empty($_GET['error']) and $_GET['error'] == 'invalidCredentials') { ?>
      Materialize.toast('Credenciais Inválidas <i class="material-icons right">clear</i>', 4000);
    <?php } ?>

    <?php if(!empty($_GET['error']) and $_GET['error'] == 'notAllowed') { ?>
      Materialize.toast('Acesso não permitido <i class="material-icons right">clear</i>', 4000);
    <?php } ?>
  });
</script>
</body>
</html>
