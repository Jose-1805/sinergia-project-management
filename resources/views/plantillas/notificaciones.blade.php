<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
$datos = "";
if(count($notificaciones)){
    foreach ($notificaciones as $notificacion)
    {
        $ruta = "#";
        if($notificacion->not_url != ""){
            $ruta = $notificacion->not_url;
        }
        $datos .= "<a class='".$notificacion->per_not_estado." notificacion' href='".$ruta."'>".$notificacion->not_descripcion."<i>".date("Y-m-d",strtotime($notificacion->created_at))."</i></a>";
    }
}else{
   $datos = "<p>No hay notificaciones.</p>";
}
echo "data: ".$datos." \n\n";
flush();