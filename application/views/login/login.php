<div class="login-content">
	<div class="row">
		<div class="col s12 m12">
            <div class="img-log" >
                <img  src="<?php echo base_url();?>assets/images/Logo.png" width="220px" style="margin-bottom: 22px;">
            </div>
            <div class="form-login">
                <form class="form" method="post" action="<?php echo base_url('index.php/acreditando')?>">
                    <div  class="row">
                        <div class="col s12 m12 ">
                            <input type="text"  id="usuario" name="usuario"  placeholder="Usuario"class="validate" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m12">
                            <input type="password" id="password" name="password" placeholder="*******" class="validate" value="">
                        </div>
                    </div>
                    <div class="row" style="color: #B2B2B2; font-size: 10px">
                        <?php echo $appVersion?>
                    </div>
                    <div class="row center">
                        <input style="width: 40%; height: 44px; margin-top: 10px; background-color: #009FE3;" class="Btnadd modal-action modal-close btn" type="submit" name="submit" value="Iniciar Sesión">
                    </div>

                </form><br>
            </div>

		</div>
	</div>	
</div>


