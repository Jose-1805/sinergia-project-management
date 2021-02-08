/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function msjErrorIngreso(){
    lanzarMensaje('Error','La información de usuario registrada es incorrecta',5000,2);
}

function msjPerfilRegistrado(){
    lanzarMensaje('Perfil registrado','Se ha enviado un correo a la dirección ingresada, en el encontrará los pasos a seguir',10000,1);
}

function msjContraseñaIncorrecta(){
    lanzarMensaje('Error','La contraseña ingresada es incorrecta',5000,2);
}

