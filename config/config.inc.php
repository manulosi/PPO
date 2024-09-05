<?php
// Configurações de conexão
$servername = "localhost";
$username = "root"; // Altere conforme sua configuração
$password = ""; // Altere conforme sua configuração
$dbname = "transporte_publico";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta para buscar os horários
$sql = "SELECT * FROM horarios_onibus WHERE rota = 'Centro - Bairro X'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='schedule-table'>";
    echo "<thead><tr><th>Horário de Partida</th><th>Horário de Chegada</th><th>Dias da Semana</th></tr></thead>";
    echo "<tbody>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["horario_partida"]. "</td><td>" . $row["horario_chegada"]. "</td><td>" . $row["dias_semana"]. "</td></tr>";
    }
    echo "</tbody></table>";
} else {
    echo "0 results";
}

$conn->close();
?>
