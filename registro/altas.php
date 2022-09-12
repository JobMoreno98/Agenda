<?PHP 
#Nombre
#codigo
#contraseña
#permiso
#area
#centro univ
?>
<link href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css' rel='stylesheet' id='bootstrap-css'>
<script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>
<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js'></script>

<!------ Include the above in your HEAD tag ---------->

<section class='testimonial py-5' id='testimonial'>
    <div class='container'>
        <div class='row '>
            <div class='col-md-4 py-5 text-white text-center ' style='background-color: #283b42'>
                <div class=' '>
                    <div class='card-body'>
                        <img src='http://www.ansonika.com/mavia/img/registration_bg.svg' style='width:30%;'>
                        <h2 class='py-3'>Registro</h2>
                        <p>
                          Tation argumentum et usu, dicit viderer evertitur te has. Eu dictas concludaturque usu, facete detracto patrioque an per, lucilius pertinacia eu vel.
                        </p>
                    </div>
                </div>
            </div>
            <div class='col-md-8 py-5 border'>
                <h4 class='pb-4'>Llena los campos con la informacion requerida</h4>
                <form>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                          <input id='Nombre' name='Full Name' placeholder='Nombre Completo' class='form-control' type='text' required='required'>
                        </div>
                        <div class='form-group col-md-6'>
                          <input type='text' class='form-control' id='inputEmail4' placeholder='Codigo' required='required'>
                        </div>
                      </div>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <input id='password' name='Mobile No.' placeholder='Contraseña' class='form-control' required='required' type='password'>
                        </div> 
                         <div class='form-group col-md-6'>
                         <input id='confirmPass' name='Mobile No.' placeholder='Confirma Contraseña' class='form-control' required='required' type='password'>
                        </div> 
                        <div class='form-group col-md-6'>
                                  
                                  <select id='centroUnive' class='form-control'>
                                    <option selected>Centro Universitario</option>
                                    <option> La normal</option>
                                    <option> Belenes</option>
                                  </select>
                        </div>
                        <div class='form-group col-md-6'>
                                   <select id='permisos' class='form-control'>
                                    <option selected>Permisos</option>
                                    <option> Administrador</option>
                                    <option> Usuario</option>
                                  </select>
                        </div>
                         <div class='form-group col-md-12'>
                                   <select id='inputState' class='form-control'>
                                    <option selected>Area</option>
                                    <option> CTA</option>
                                    <option> Servicios Generales</option>
                                  </select>
                        </div>
                    </div>
                  
                    
                    <div class='form-row'>
                        <button type='submit' class='btn btn-danger'>Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
