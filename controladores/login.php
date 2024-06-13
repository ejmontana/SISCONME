<?php
include 'conex.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['usuario']) && isset($_POST['clave'])) {
        $usuario = $_POST['usuario'];
        $clave = $_POST['clave'];

        $sql = "SELECT * FROM usuarios WHERE USUARIO = ? AND Password = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }
        $stmt->bind_param("ss", $usuario, $clave);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Iniciar sesión y redirigir a la página de inicio
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['user'] = $clave;
            header("Location: ../paginas/home.php");
        } else {
            // Mostrar mensaje de error
            echo "Usuario o contraseña incorrectos";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Usuario o contraseña no proporcionados";
    }
}
