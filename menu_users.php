<html>


	<head>
		<!-- Bootstrap core CSS -->
    	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	</head>


	<body style='background-image: url("img/bginicio2.jpg");'>


	  <!-- Page Content -->
    <div class="container" style="margin-top: 60px">
      <div class="row">
        <div class="col-lg-12 text-center">
        	<div class="jumbotron" style=" border:5px solid; border-color:#32bdca">
	         
	          <img src="img/logoagenda.png" style="width: 400px; height: 200px"><br>
	           <h1>Menu de Gestion de Usuarios</h1>

	           <br >
	           <form action="manage_users.php" method="post">
                                
                                	 <input type="submit" name="register_user" class="btn btn-primary" value="Agregar Usuario" style="color: white"><br><br>
                                	 
                                   <input type="submit" name="delete_user" class="btn btn-primary" value="Eliminar Usuario" style="color: white">
                </form>
	          
	          <a  class="btn btn-secondary" href="/AgendaCUCSH" style="color: white">Regresar a la agenda</a>
	         
        </div>
      </div>
    </div>






	</body>


 <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


</html>