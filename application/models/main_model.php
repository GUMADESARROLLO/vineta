<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class main_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('persona');

        require(APPPATH.'libraries\PHPMailer\Exception.php');
        require(APPPATH.'libraries\PHPMailer\PHPMailer.php');
        require(APPPATH.'libraries\PHPMailer\SMTP.php');
    }

    function isDB(){


        $Instancia = $this->load->database('db_remota', TRUE);
        //$Instancia = $this->db;

        return $Instancia;


    }




    public function getResumen() {
       /* $query = $this->sqlsrv->fetchArray("SELECT FACTURA,NOMBRE_CLIENTE,FECHA,DIRECCION_FACTURA,TELEFONO1 FROM PRODUN_HOLDINGS_FACTURAS T0 WHERE T0.CLIENTE='CL011242' AND T0.FECHA = GETDATE() GROUP BY FACTURA,NOMBRE_CLIENTE,FECHA,DIRECCION_FACTURA,TELEFONO1",SQLSRV_FETCH_ASSOC);*/

         $query = $this->sqlsrv->fetchArray("SELECT FACTURA,NOMBRE_CLIENTE,FECHA,DIRECCION_FACTURA,TELEFONO1 FROM PRODUN_HOLDINGS_FACTURAS T0 WHERE T0.CLIENTE='CL011242' GROUP BY FACTURA,NOMBRE_CLIENTE,FECHA,DIRECCION_FACTURA,TELEFONO1",SQLSRV_FETCH_ASSOC);
        $i=0;
        $data = array();
        $icon_cong  = array();



        $data['data'][$i]['N']          = "-";
        $data['data'][$i]['CUENTA']     = "-";
        $data['data'][$i]['CLIENTE']    = "-";
        $data['data'][$i]['REMITIDO']   = "-";
        $data['data'][$i]['FUENTE']     = "-";
        $data['data'][$i]['APTO']       = "-";

        foreach($query as $fila){

            $this->db->where('Factura', $fila["FACTURA"]);
            $this->db->where('Stado', 1);
            $this->db->where('Acction', "UP");

            $qResultado = $this->db->get('log_factura_cargadas');

            $icon_cong[$i] = ($qResultado->num_rows()>=1) ? array("Icon" => "clear","Color" => "red-text") : array("Icon" => "check","Color" => "green-text");

            $data['data'][$i]['N']         = "<a href='#' onclick='getTransac(".'"'.$fila["FACTURA"].'"'.")'>".$fila["FACTURA"]."</a>";
            $data['data'][$i]['CUENTA']    = $fila["NOMBRE_CLIENTE"];
            $data['data'][$i]['CLIENTE']   = $fila['FECHA']->format('d-m-Y');
            $data['data'][$i]['REMITIDO']  = $fila["DIRECCION_FACTURA"];
            $data['data'][$i]['FUENTE']    = $fila["TELEFONO1"];
            $data['data'][$i]["APTO"]      = '<i class="material-icons '.$icon_cong[$i]["Color"].'" >'.$icon_cong[$i]["Icon"].'</i>';

            $i++;
        }
        echo json_encode($data);
        $this->sqlsrv->close();



    }
    public function getInweb() {

        $Ids_Post = $this->isDB()->get('view_info_sku');

        $i=0;
        $data = array();

        $data['data'][$i]['CUENTA']     = "";
        $data['data'][$i]['CLIENTE']     = "";
        $data['data'][$i]['REMITIDO']   = "";
        $data['data'][$i]['FUENTE']     = "";

        foreach($Ids_Post->result_array() as $fila){


            $data['data'][$i]['CUENTA']     = $fila["Codigo"];
            $data['data'][$i]['CLIENTE']    = $fila['Nombre'];
            $data['data'][$i]['REMITIDO']   = number_format($fila["stock_quantity"],2);
            $data['data'][$i]['FUENTE']     = "C$ " . number_format($fila["Precio"],2);
            $i++;
        }
        echo json_encode($data);



    }
    public function BuscarSolicitud($f1 = "",$f2 = "") {
        $codigo ='CL011242';

        $query_search = "SELECT FACTURA,NOMBRE_CLIENTE,FECHA,DIRECCION_FACTURA,TELEFONO1 FROM PRODUN_HOLDINGS_FACTURAS T0 WHERE CLIENTE='".$codigo."'
                    AND FECHA BETWEEN '".date('d-m-Y',strtotime($f1))."' AND '".date('d-m-Y',strtotime($f2))."' GROUP BY FACTURA,NOMBRE_CLIENTE,FECHA,DIRECCION_FACTURA,TELEFONO1";




        $query = $this->sqlsrv->fetchArray($query_search,SQLSRV_FETCH_ASSOC);

        $i=0;
        $data = array();
        $icon_cong  = array();

        $data['data'][$i]['N']          = "-";
        $data['data'][$i]['CUENTA']     = "-";
        $data['data'][$i]['CLIENTE']    = "-";
        $data['data'][$i]['REMITIDO']   = "-";
        $data['data'][$i]['FUENTE']     = "-";
        $data['data'][$i]['APTO']       = "-";

        foreach($query as $fila){
            $this->db->where('Factura', $fila["FACTURA"]);
            $this->db->where('Stado', 1);
            $this->db->where('Acction', 'UP');
            $qResultado = $this->db->get('log_factura_cargadas');

            $icon_cong[$i] = ($qResultado->num_rows()>=1) ? array("Icon" => "clear","Color" => "red-text") : array("Icon" => "check","Color" => "green-text");


            $data['data'][$i]['N']          = "<a href='#' onclick='getTransac(".'"'.$fila["FACTURA"].'"'.")'>".$fila["FACTURA"]."</a>";
            $data['data'][$i]['CUENTA']     = $fila["NOMBRE_CLIENTE"];
            $data['data'][$i]['CLIENTE']    = $fila['FECHA']->format('d-m-Y');
            $data['data'][$i]['REMITIDO']   = $fila["DIRECCION_FACTURA"];
            $data['data'][$i]['FUENTE']     = $fila["TELEFONO1"];
            $data['data'][$i]["APTO"]       = '<i class="material-icons '.$icon_cong[$i]["Color"].'" >'.$icon_cong[$i]["Icon"].'</i>';
            $i++;
        }
        echo json_encode($data);
        $this->sqlsrv->close();
    }
    public function reset_sku() {

        $Coneciondb = $this->isDB();

        $Ids_Post = $Coneciondb->get('view_info_sku');

        $Sku_update_batch_wp_wc_product = array();
        $Sku_update_batch               = array();

        foreach($Ids_Post->result_array() as $fila){

            $Sku_update_batch[] = array(
                'post_id'   => $fila["ID"],
                'meta_value' => 0
            );

            $Sku_update_batch_wp_wc_product[] = array(
                'product_id' => $fila["ID"],
                'stock_quantity' => 0
            );
        }
        $Coneciondb->where('meta_key','_stock');
        $Coneciondb->update_batch('wp_postmeta',$Sku_update_batch,'post_id');

        $Coneciondb->update_batch('wp_wc_product_meta_lookup',$Sku_update_batch_wp_wc_product,'product_id');

        $Coneciondb->truncate('log_factura_cargadas');
    }
    public function Load_factura($Id,$Accion) {

        $Coneciondb = $this->isDB();

        $Ids_Post = $Coneciondb->get('view_info_sku');

        $qLineaFactura = "SELECT ARTICULO,CANTIDAD FROM PRODUN_HOLDINGS_FACTURAS T0 where FACTURA = ".$Id."";
        $resultado_Factura_linea = $this->sqlsrv->fetchArray($qLineaFactura,SQLSRV_FETCH_ASSOC);

        $Sku_update_batch_wp_wc_product = array();
        $Sku_update_batch               = array();


        foreach ($resultado_Factura_linea as $key){
            $found_key = array_search($key['ARTICULO'], array_column($Ids_Post->result_array(), 'Codigo'));
            $Post_ID = $Ids_Post->result_array()[$found_key]['ID'];
            $Post_CN = $Ids_Post->result_array()[$found_key]['stock_quantity'];


            if($Accion=="UP"){
                $Total = number_format($Post_CN,0, '.', '')  + number_format($key['CANTIDAD'],0, '.', '');
            }elseif($Accion=="DOWN"){
                $Total = number_format($Post_CN,0, '.', '')  - number_format($key['CANTIDAD'],0, '.', '');
            }


            $Sku_update_batch[] = array(
                'post_id'   => $Post_ID,
                'meta_value' => $Total
            );


            $Sku_update_batch_wp_wc_product[] = array(
                'product_id' => $Post_ID,
                'stock_quantity' => $Total
            );


        }
        $Coneciondb->where('meta_key','_stock');
        $Coneciondb->update_batch('wp_postmeta',$Sku_update_batch,'post_id');

        $Coneciondb->update_batch('wp_wc_product_meta_lookup',$Sku_update_batch_wp_wc_product,'product_id');


    }
    public function save_log_factura($Factura,$Accion,$Razon) {

        if ($Accion=="UP"){
            $this->db->where('Factura', $Factura);
            $this->db->where('Acction', "DOWN");
            $this->db->where('Stado', 1);
            $this->db->update('log_factura_cargadas', array(
                'Stado' => 0
            ));
        }elseif ($Accion=="DOWN"){
            $this->db->where('Factura', $Factura);
            $this->db->where('Acction', "UP");
            $this->db->where('Stado', 1);
            $this->db->update('log_factura_cargadas', array(
                'Stado' => 0
            ));
            $this->db->insert('anulacion',array(
                'Factura' => $Factura,
                'Razon' => $Razon,
                'Usuario' => $this->session->userdata('idUser'),
                'Fecha' => date('Y-m-d H:i:s')
            ));

        }

        $this->db->insert('log_factura_cargadas',array(
            'Factura' => $Factura,
            'Acction' => $Accion,
            'Stado' => 1,
            'Usuario' => $this->session->userdata('idUser'),
            'Fecha' => date('Y-m-d H:i:s')
        ));



    }
    public function getInfoCuenta($Id) {
        $json       = array();
        $Detalles   = array();

        $icon_cong  = array();
        $i=0;

        $Ids_Post = $this->isDB()->get('view_info_sku');


        $qRemitidos = "SELECT * FROM PRODUN_HOLDINGS_FACTURAS T0 WHERE FACTURA='".$Id."'";
        $query = $this->sqlsrv->fetchArray($qRemitidos,SQLSRV_FETCH_ASSOC);

        foreach ($query as $key){
            $iFound = array_search($key['ARTICULO'], array_column($Ids_Post->result_array(), 'Codigo'));

            $icon_cong[$i] = (is_numeric($iFound)) ? array("Icon" => "check","Color" => "green-text") : array("Icon" => "clear","Color" => "red-text");


            $Detalles[$i]["LINEA"]              = $key["LINEA"];
            $Detalles[$i]["CLIENTE"]            = $key["CLIENTE"];
            $Detalles[$i]["NOMBRE_CLIENTE"]     = $key["NOMBRE_CLIENTE"];
            $Detalles[$i]["DIRECCION_FACTURA"]  = $key["DIRECCION_FACTURA"];
            $Detalles[$i]["TELEFONO1"]          = $key["TELEFONO1"];
            $Detalles[$i]["FACTURA"]            = $key["FACTURA"];
            $Detalles[$i]["FECHA"]              = $key["FECHA"]->format('d-m-Y');;
            $Detalles[$i]["DESCRIPCION"]        = $key["DESCRIPCION"];
            $Detalles[$i]["UNID_MEDIDA"]        = $key["UNID_MEDIDA"];
            $Detalles[$i]["ARTICULO"]           = $key["ARTICULO"];
            $Detalles[$i]["CANTIDAD"]           = $key["CANTIDAD"];
            $Detalles[$i]["TOTAL_FACTURA"]      = $key["TOTAL_FACTURA"];
            $Detalles[$i]["TOTAL_FACTURA"]      = $key["TOTAL_FACTURA"];
            $Detalles[$i]["PRECIO_TOTAL"]       = $key["PRECIO_TOTAL"];
            $Detalles[$i]["PRECIO_TOTAL"]       = $key["PRECIO_TOTAL"];
            $Detalles[$i]["FOUND"]              = '<i class="material-icons '.$icon_cong[$i]["Color"].'" >'.$icon_cong[$i]["Icon"].'</i>';
            $i++;
        }


        $qResultado = $this->db->query('SELECT T0.Acction,sum(Stado) as Stado FROM log_factura_cargadas T0 WHERE T0.Factura='.$Id.' GROUP BY T0.Acction');


        $Btn = array("Btn_Load" => "On","Btn_Down" => "Off");

        foreach ($qResultado->result_array() as $row)
        {
            if($row['Acction']=='UP'){
                if ($row['Stado']>=1){
                    $Btn = array("Btn_Load" => "Off","Btn_Down" => "On");
                }
            }elseif($row['Acction']=='DOWN'){
                if ($row['Stado']>=1){
                    $Btn = array("Btn_Load" => "On","Btn_Down" => "Off");
                }
            }
        }
        $json[] = array(
            'array_detalles'       => $Detalles,
            'array_isViable'       => ($this->find_children($icon_cong, "red-text") >=1 )? "N" : "S",
            'array_BtnAccition'    => $Btn,


        );
       echo json_encode($json);
    }
    function find_children($array, $parent) {
        return count(array_filter($array, function ($e) use ($parent) {
            return $e['Color'] === $parent;
        }));
    }

}