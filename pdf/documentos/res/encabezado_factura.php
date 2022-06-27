<?php 
	if ($con){
?>
    <table cellspacing="0" style="width: 100%; display: flex">
        <tr>

            <td style="width: 25%; color: #444444;">
                <img style="width: 40px;" src="../../<?php echo get_row('perfil','logo_url', 'id_perfil', 1);?>" alt="Logo"><br>
                
            </td>
			<td style="width: 50%; color: #34495e;font-size:12px;text-align:center; font-size: 11pt;">
                <span style="color: #34495e;font-size:13px;font-weight:bold"><?php echo get_row('perfil','nombre_empresa', 'id_perfil', 1);?></span>
				<br><?php echo get_row('perfil','direccion', 'id_perfil', 1).", ". get_row('perfil','ciudad', 'id_perfil', 1)." ".get_row('perfil','estado', 'id_perfil', 1);?><br> 
				Telefone: <?php echo get_row('perfil','telefono', 'id_perfil', 1);?><br>
				Email: <?php echo get_row('perfil','email', 'id_perfil', 1);?>
                
            </td>
			<td style="width: 25%;text-align:right">
			    FATURA Nº <?php echo $numero_factura;?>
			</td>
			
        </tr>
    </table>
	<?php }?>	