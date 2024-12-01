<?php
// Incluir el archivo de conexión
require 'conexion.php';

// Consulta SQL para seleccionar todos los estudiantes
$sql = "SELECT * FROM estudiantes LEFT JOIN informacion_educativa ON id = estudiante_id ";

try {
    // Preparar la consulta
    $stmt = $conn->prepare($sql);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Obtener los resultados como un array asociativo
    $estudiantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error al recuperar la lista de estudiantes: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PIAR</title>

    <script>
        // Función para mostrar la alerta de éxito
        function showAlert() {
            alert("Intervención registrada exitosamente.");
        }
    </script>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

<?php
    // Verificar si hay un parámetro de éxito en la URL
    if (isset($_GET['status']) && $_GET['status'] == 'success') {
        echo "<script>showAlert();</script>";
    }
    ?>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">PROYECTO PIAR </div>
                <!-- <div class="sidebar-brand-text mx-3">PROYECTO PIAR <sup>2</sup></div>-->
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <!-- <li class="nav-item active">
                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>-->

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading 
            <div class="sidebar-heading">
                Interface
            </div>-->

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Estudiante</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <!--<h6 class="collapse-header">Custom Components:</h6>-->
                        <a class="collapse-item" href="registro_estudiantes.php">Registrar Estudiante Nuevo</a>
                        <a class="collapse-item" href="listar_estudiantes.php">Lista de estudiantes</a>
                        <a class="collapse-item" href="registro_intervencion.php">Registrar Intervenciónes</a>
                    </div>
                </div>
            </li>


            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>



        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

 
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Administrador</span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                
                                <a class="dropdown-item" href="cerrar_sesion.php">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cerrar sesión
                                </a>
                                
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                <h1>Lista de Estudiantes</h1>
                        <p>Selecciona un estudiante para ver su información detallada.</p>
                        <div class="perfil-info">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Grado</th>
                                        <th scope="col">Jornada</th>
                                        <th scope="col">Sede</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($estudiantes as $estudiante): ?>
                                    <tr>

                                        <th scope="row"><?php echo $estudiante['id']; ?></th>
                                        <td><?php echo htmlspecialchars($estudiante['primer_nombre']. ' ' .$estudiante['segundo_nombre']. ' ' .$estudiante['primer_apellido']. ' ' .$estudiante['segundo_apellido']); ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($estudiante['grado']);?></td>
                                        <td><?php echo htmlspecialchars($estudiante['jornada']);?></td>
                                        <td><?php echo htmlspecialchars($estudiante['sede']);?></td>
                                        <td><a href="buscar_estudiante.php?id=<?php echo $estudiante['id']; ?> "
                                                class="btn-acceder">Ver</a></td>






                                    </tr>
                                </tbody>
                                <?php endforeach; ?>
                            </table>

                        </div>


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Piar Website 2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

   

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>