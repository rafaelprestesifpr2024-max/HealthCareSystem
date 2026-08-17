<?php

include "conexao.php";

// Verifica se a requisição veio através de POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: pacientes.php");
    exit;
}

// Verifica se recebeu o ID
if (!isset($_POST['id'])) {
    header("Location: pacientes.php?erro=1");
    exit;
}

$id = (int) $_POST['id'];

// Verifica se o ID é válido
if ($id <= 0) {
    header("Location: pacientes.php?erro=1");
    exit;
}

// Prepara a atualização para ocultar paciente
$stmt = $conn->prepare(
    "UPDATE pacientes SET exibir = 0 WHERE id = ?"
);

// Coloca o ID na consulta
$stmt->bind_param("i", $id);

// Executa
if ($stmt->execute()) {
    $stmt->close();
    $conn->close();

    header("Location: pacientes.php?ocultado=1");
    exit;
}

// Caso dê erro
$stmt->close();
$conn->close();

header("Location: pacientes.php?erro=1");
exit;

?>
