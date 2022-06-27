	<?php
		if (isset($title))
		{
	?>
<nav class="navbar navbar-default ">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">SIG-Farmacia</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="<?php echo $active_facturas;?>"><a href="facturas.php"><i class='fa fa-list-alt'></i> Faturas <span class="sr-only">(current)</span></a></li>
        <li class="<?php echo $active_productos;?>"><a href="productos.php"><i class='fa fa-barcode'></i> Produtos</a></li>
		    <li class="<?php echo $active_clientes;?>"><a href="clientes.php"><i class='fa fa-user'></i> Clientes</a></li>
		    <li class="<?php echo $active_usuarios;?>"><a href="usuarios.php"><i  class='fa fa-lock'></i> Usuarios</a></li>
		    <li class="<?php if(isset($active_perfil)){echo $active_perfil;}?>"><a href="perfil.php"><i  class='fa fa-cog'></i> Configuração</a></li>
       </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="https://novadev.org/" target='_blank'><i class='fa fa-envelope'></i> Suporte</a></li>
		<li><a href="login.php?logout"><i class='fa fa-off'></i> Sair</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
	<?php
		}
	?>