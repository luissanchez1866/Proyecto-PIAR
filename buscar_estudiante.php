<?php
// Incluir el archivo de conexión
require 'conexion.php';

// Verificar si se ha pasado un ID de estudiante a través de la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta SQL para seleccionar el estudiante por su ID
    $sql = "SELECT * FROM estudiantes LEFT JOIN informacion_educativa ON id = estudiante_id WHERE id = :id";

    try {
        // Preparar la consulta
        $stmt = $conn->prepare($sql);
        
        // Vincular el parámetro
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        // Obtener el resultado
        $estudiante = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Error al recuperar la información del estudiante: " . $e->getMessage();
    }
} else {
    echo "No se ha proporcionado un ID de estudiante.";
    exit();
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
            alert("Información actualizada exitosamente.");
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
                        <a class="collapse-item" href="registro_estudiantes.php">Registrar</a>
                        <a class="collapse-item" href="listar_estudiantes.php">Lista de estudiantes</a>
                        <a class="collapse-item" href="registro_intervencion.php">Registrar Intervenció</a>
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
                <h1>Perfil de Estudiante</h1>
                        <?php if ($estudiante): ?>
                        <div class="perfil-estudiante-form">
                            <div class="perfil-info">
                                <h2>Información Personal</h2>
                                <p><strong>Nombre:</strong>
                                    <?php echo htmlspecialchars($estudiante['primer_nombre']. ' ' .$estudiante['segundo_nombre']. ' ' .$estudiante['primer_apellido']. ' ' .$estudiante['segundo_apellido']); ?>
                                </p>
                                <p><strong>No Identificación:</strong>
                                    <?php echo htmlspecialchars($estudiante['num_id']); ?></p>
                                <p><strong>Fecha de Nacimiento:</strong>
                                    <?php echo htmlspecialchars($estudiante['fecha_nacimiento']); ?></p>
                                <p><strong>Dirección:</strong> <?php echo htmlspecialchars($estudiante['direccion']); ?>
                                </p>
                                <p><strong>Telefono:</strong> <?php echo htmlspecialchars($estudiante['telefono']); ?>
                                </p>
                                <p><strong>Email:</strong> <?php echo htmlspecialchars($estudiante['email']); ?></p>
                            </div>
                            <div class="perfil-info">
                                <h2>Información Médica</h2>
                                <p><strong>Diagnóstico:</strong> Diagnóstico </p>
                                <p><strong>Medicación:</strong> Medicación </p>
                                <p><strong>Alergias:</strong> Alergias </p>
                            </div>
                            <div class="perfil-info">
                                <h2>Información Educativa</h2>
                                <p><strong>Jornada:</strong><?php echo htmlspecialchars($estudiante['jornada']); ?></p>
                                <p><strong>Grado:</strong><?php echo htmlspecialchars($estudiante['grado']); ?></p>
                                <p><strong>Sede:</strong><?php echo htmlspecialchars($estudiante['sede']); ?></p>
                            </div>
                        </div>
                        <a href="listar_estudiantes.php" class="btn btn-primary">Volver a la Lista de Estudiantes</a>
                        <!--<button onclick="generarInformes()" class="btn-acceder">Generar Informes</button>-->
                        <a href="editar_estudiante.php?id=<?php echo $estudiante['id']; ?>"
                            class="btn btn-primary">Editar Info Personal</a>
                        <a href="informe_piar.php?id=<?php echo $estudiante['id']; ?>" class="btn btn-primary">Generar
                            PDF</a>
                        <a href="generar_word2.php?id=<?php echo $estudiante['id']; ?>" class="btn btn-warning">Generar
                            Word</a>

                        <!--<button onclick="generarPDF()" class="btn-acceder">Registrar Intervenciones</button>-->

                        <?php else: ?>
                        <p>No se encontró información para el estudiante con ID: <?php echo htmlspecialchars($id); ?>
                        </p>
                        <?php endif; ?>

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