<div class="container"><br><br>


    <div class="row">

        <div class="col s12 m11 container-button">
            <div class="container-button">
                <input type="text" id="SearchCasos" class="form-control" placeholder="Buscar..." >
                <span class="input-group-btn">
					<button class="button1 btn-secondary waves-effect" type="button" onclick="Buscar()"><i class="material-icons">refresh</i></button>
				</span>
            </div>
        </div>
        <div class="col s12 m1">
            <select id="frm_lab_row">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="-1">*</option>
            </select>
        </div>
    </div>
	<div class="row" id="data-reporte">
        <div class="col s12 m12">
             <table id="tblReportes" class="display DrawBorder" cellspacing="0" width="100%">
                 <thead>
                    <tr style="background: #199719;">
                         <th style="color: white">ARTICULO</th>
                         <th style="color: white">DESCRIPCION</th>
                         <th style="color: white">SKUs</th>
                         <th style="color: white">PRECIO</th>

                     </tr>
                 </thead>
             </table>
		</div>
	</div>
</div>
<div id="mdlRemitidos" class="modal modal-fixed-footer">
    <div class="modal-content" >
        <div class="img-perfil" style="width: 100px">
            <img  src="<?php echo base_url();?>assets/images/Logo.png" width="220px" style="margin-bottom: 22px;">
        </div>
        <div class="row">
            <br>
            <div class="col s6 offset-s6 right-align">
                Factura : <span id="id_factura_cliente"></span><br>
                Fecha : <span id="id_factura_fecha_cliente"></span><br>
            </div>
        </div>
        <br><br>


        <div class="row DrawBorder">
            <div class="col s12 center" style="background: gray; color: white">Datos del Cliente</div>

            <div class="col s6">
                Cliente : <span id="id_lbl_cod_cliente"></span><br>
                Nombre : <span id="id_lbl_name_cliente"></span><br>
                Direacción : <span id="id_lbl_dir_cliente"></span><br>
            </div>
            <div class="col s6">
                Telefono : <span id="id_lbl_telefono_cliente"></span><br>
            </div>
        </div>

        <table id="tblRemitente" class="display DrawBorder" style="width:100%">
            <thead>
            <tr style="background: #199719;">
                <th style="color: white"></th>
                <th style="color: white">Und. M</th>
                <th style="color: white">ARTICULO</th>
                <th style="color: white">DESCRIPCION</th>
                <th style="color: white">CANTIDAD</th>
                <th style="color: white">TOTAL FACTURA</th>
                <th style="color: white"></th>
            </tr>
            </thead>

        </table>

        <div class="row DrawBorder">
            <div class="col s12" style="background: gray"><br></div>

            <div class="col s4 offset-s8 right-align">
                SubTotal: C$ 00.00<br>
                IVA: C$ 00.00<br>
                DESCUENTO: C$ 00.00<br>
                TOTAL: C$ <span id="id_total_factura"></span><br>
            </div>
        </div>
    </div>
    <div class="modal-footer">

        <div class="row valign-wrapper center">
            <div class="col s10">
                <span id="lbl_load_factura" class="red-text"></span>
            </div>
            <div class="col s2">
                <a href="#!" class="modal-close waves-effect waves-green btn-flat" ID="btn_load_factura">
                    <i class="material-icons">backup</i>
                </a>
            </div>
        </div>



    </div>
</div>