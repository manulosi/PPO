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
            background-color: #333;
        }
        .navbar a {
            color: #fff;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 18px;
        }
        .navbar a:hover {
            background-color: #555;
        }
        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            width: 100%;
        }
        .header {
            margin-bottom: 20px;
        }
        .header h1 {
            color: #000;
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
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <a class="navbar-brand" href="paginaprincipal.php">Busca de Ônibus</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="local.php">Local</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pag8.php">Pontos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="linhas.php">Linhas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="mapas.php">Rota</a>
                </li>
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
            "Centro", "Distrito Industrial", "Laranjeiras", "Lomba", "Pamplona", 
            "Progresso", "Rainha", "Santana", "Santa Rita", "Sargentos", 
            "Sumaré", "Taboão"
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
