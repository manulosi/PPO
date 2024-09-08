<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca de Ônibus</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('img/onibus.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .navbar {
            background-color: #000;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: #fff;
        }
        .navbar-nav .nav-link:hover {
            color: #d3d3d3;
        }
        .navbar-toggler-icon {
            background-color: #fff;
        }
        .navbar-nav {
            margin-left: auto;
        }
        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            width: 100%;
            margin-top: 70px; /* Adjusted to avoid overlap with the navbar */
        }
        .header {
            margin-bottom: 20px;
        }
        .header h1 {
            color: #000;
            font-size: 24px;
            animation: fadeIn 2s;
        }
        .autocomplete input {
            width: 100%;
            padding: 15px;
            margin: 0;
            border-radius: 8px;
            border: 2px solid #333;
            font-size: 16px;
            background-color: #f9f9f9;
            color: #333;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        .autocomplete input:focus {
            border-color: #555;
            outline: none;
        }
        select, input[type="time"] {
            width: calc(50% - 10px);
            padding: 15px;
            margin: 10px 5px;
            border-radius: 8px;
            border: 2px solid #333;
            font-size: 16px;
            background-color: #f9f9f9;
            color: #333;
            transition: border-color 0.3s;
        }
        select:focus, input[type="time"]:focus {
            border-color: #555;
            outline: none;
        }
        button {
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            background-color: #333;
            color: white;
            cursor: pointer;
            font-size: 18px;
            width: 100%;
            margin-top: 20px;
            transition: background-color 0.3s, transform 0.2s;
        }
        button:hover {
            background-color: #555;
            transform: scale(1.05);
        }
        button:active {
            transform: scale(1);
        }
        .autocomplete-items {
            position: absolute;
            border: 1px solid #ddd;
            border-radius: 8px;
            z-index: 9999;
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }
        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
        }
        .autocomplete-items div:hover {
            background-color: #ddd;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        /* Estilo para o menu hambúrguer */
        #checkbox-menu {
            position: absolute;
            opacity: 0;
        }

        label {
            cursor: pointer;
            position: absolute;
            left: 10px; /* Ajuste conforme necessário */
            top: 50%;
            transform: translateY(-50%);
            height: 22px;
            width: 30px;
            background: #000;
            padding: 5px;
        }

        label span {
            position: absolute;
            display: block;
            height: 5px;
            width: 100%;
            border-radius: 30px;
            background: #fff;
            transition: 0.25s ease-in-out;
        }

        label span:nth-child(1) {
            top: 0;
        }

        label span:nth-child(2) {
            top: 8px;
        }

        label span:nth-child(3) {
            top: 16px;
        }

        #checkbox-menu:checked + label span:nth-child(1) {
            transform: rotate(-45deg);
            top: 8px;
        }

        #checkbox-menu:checked + label span:nth-child(2) {
            opacity: 0;
        }

        #checkbox-menu:checked + label span:nth-child(3) {
            transform: rotate(45deg);
            top: 8px;
        }

        .menu {
            display: none;
            position: absolute;
            top: 60px;
            left: 0;
            background: #000;
            width: 200px;
            text-align: center;
            z-index: 1000;
        }

        .menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .menu ul li {
            border-bottom: 1px solid #444;
        }

        .menu ul li a {
            display: block;
            padding: 10px;
            color: #fff;
            text-decoration: none;
            transition: background 0.3s;
        }

        .menu ul li a:hover {
            background: #333;
        }

        #checkbox-menu:checked ~ .menu {
            display: block;
        }

        /* Estilo para o ajuste do logo */
        .navbar-brand {
            margin-left: 50px; /* Ajuste a margem conforme necessário */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <input type="checkbox" id="checkbox-menu">
    <label for="checkbox-menu">
        <span></span>
        <span></span>
        <span></span>
    </label>
    <a class="navbar-brand" href="paginaprincipal.php">SmartBus</a>
    <div class="menu">
    <ul>
    <li><a href="paginaprincipal.php">Início</a></li>
            <li><a href="teste.php">Formulário</a></li>
            <li><a href="local.php">Lista de Pontos</a></li>
           
            <li><a href="linhas.php">Linhas</a></li>
            <li><a href="mapas.php">Rota</a></li>
            </ul>
    </div>
</nav>

<div class="container mt-5">
    <div class="header text-center">
        <h1>Encontre Seu Ônibus</h1>
    </div>
    <form action="pag8.php" method="get">
        <div class="autocomplete mb-3">
            <input id="currentLocation" type="text" placeholder="Local atual" name="localAtual" required>
        </div>
        <div class="autocomplete mb-3">
            <input id="destination" type="text" placeholder="Local de destino" name="localDestino" required>
        </div>
        <div class="d-flex justify-content-between mb-3">
            <input type="time" name="horario" required>
            <select name="dia" required>
                <option value="" disabled selected>Dias da semana</option>
                <option value="Segunda">Segunda</option>
                <option value="Terça">Terça</option>
                <option value="Quarta">Quarta</option>
                <option value="Quinta">Quinta</option>
            </select>
        </div>
        <button type="submit">Buscar</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    const neighborhoods = [
        "Barragem", "Bela Aliança", "Bremer", "Budag", "Canta Galo", 
        "Centro","Laranjeiras", "Lomba", "Pamplona", 
        "Progresso", "Rainha", "Santana", "Santa Rita", "Navegantes", 
        "Sumaré", "Taboão", "Jardim America"
    ];

    function autocomplete(input, arr) {
        let currentFocus;
        input.addEventListener("input", function(e) {
            let a, b, i, val = this.value;
            closeAllLists();
            if (!val) { return false; }
            currentFocus = -1;
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            this.parentNode.appendChild(a);
            for (i = 0; i < arr.length; i++) {
                if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                    b = document.createElement("DIV");
                    b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                    b.innerHTML += arr[i].substr(val.length);
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                    b.addEventListener("click", function(e) {
                        input.value = this.getElementsByTagName("input")[0].value;
                        closeAllLists();
                    });
                    a.appendChild(b);
                }
            }
        });
        input.addEventListener("keydown", function(e) {
            let x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                currentFocus++;
                addActive(x);
            } else if (e.keyCode == 38) {
                currentFocus--;
                addActive(x);
            } else if (e.keyCode == 13) {
                e.preventDefault();
                if (currentFocus > -1) {
                    if (x) x[currentFocus].click();
                }
            }
        });
        function addActive(x) {
            if (!x) return false;
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            x[currentFocus].classList.add("autocomplete-active");
        }
        function removeActive(x) {
            for (let i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
            }
        }
        function closeAllLists(elmnt) {
            let x = document.getElementsByClassName("autocomplete-items");
            for (let i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != input) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }
        document.addEventListener("click", function (e) {
            closeAllLists(e.target);
        });
    }

    autocomplete(document.getElementById("currentLocation"), neighborhoods);
    autocomplete(document.getElementById("destination"), neighborhoods);
</script>
</body>
</html>
