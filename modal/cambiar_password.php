	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='fa fa-edit'></i>Alterar Senha</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_password" name="editar_password">
			<div id="resultados_ajax3"></div>
			 
			 
			 
			 
			  <div class="form-group">
				<label for="user_password_new3" class="col-sm-4 control-label">Nova Senha</label>
				<div class="col-sm-8">
				  <input type="password" class="form-control" id="user_password_new3" name="user_password_new3" placeholder="Nova Senha" pattern=".{6,}" title="Contraseña ( min . 6 caracteres)" required>
					<input type="hidden" id="user_id_mod" name="user_id_mod">
				</div>
			  </div>
			  <div class="form-group">
				<label for="user_password_repeat3" class="col-sm-4 control-label">Confirmar Senha</label>
				<div class="col-sm-8">
				  <input type="password" class="form-control" id="user_password_repeat3" name="user_password_repeat3" placeholder="Confirmar Senha" pattern=".{6,}" required>
				</div>
			  </div>
			 
			  

			 
			 
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
			<button type="submit" class="btn btn-primary" id="actualizar_datos3">Alterar Senha</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>	