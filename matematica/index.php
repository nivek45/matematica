<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Determinante de Matrizes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    
    <script>
        function ajustarTamanhoMatriz() {
            var tamanho = document.getElementById("tamanho").value;
            var inputs = document.querySelectorAll(".matrix-input input");

            inputs.forEach(function(input) {
                input.style.display = "none";
            });

            for (var i = 1; i <= tamanho; i++) {
                for (var j = 1; j <= tamanho; j++) {
                    document.getElementById("a" + i + j).style.display = "inline-block";
                }
            }
        }
    </script>
</head>
<body onload="ajustarTamanhoMatriz()">

    <header>
        <h1>Calculadora de Determinante de Matrizes</h1>
    </header>

    <main>
        <form method="POST" class="form">
            <fieldset>
                <legend>Escolha o tamanho da matriz:</legend>
                <select name="tamanho" id="tamanho" class="form-select w-50 mx-auto" onchange="ajustarTamanhoMatriz()">
                    <option value="2">2x2</option>
                    <option value="3" selected>3x3</option>
                    <option value="4">4x4</option>
                    <option value="5">5x5</option>
                </select>
            </fieldset>

            <fieldset>
                <legend>Insira os valores da matriz:</legend>
                <div class="matrix-input d-grid gap-2">
                    <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo "<div class='row justify-content-center'>";
                            for ($j = 1; $j <= 5; $j++) {
                                echo "<input type='number' name='a$i$j' id='a$i$j' class='form-control col-2' style='display:none'>";
                            }
                            echo "</div>";
                        }
                    ?>
                </div>
            </fieldset>

            <button type="submit" class="btn w-100">Calcular Determinante</button>
        </form>

        <?php
        function calcularDeterminante($matriz) {
            $n = count($matriz);

            if ($n == 2) {
                // Passo 1: Produto da diagonal principal
                $p = $matriz[0][0] * $matriz[1][1];
                // Passo 2: Produto da diagonal secundária
                $s = $matriz[0][1] * $matriz[1][0];
                // Passo 3: Diferença entre p e s
                return $p - $s;

            } elseif ($n == 3) {
                // Mantendo o cálculo para 3x3
                return $matriz[0][0] * ($matriz[1][1] * $matriz[2][2] - $matriz[2][1] * $matriz[1][2]) 
                     - $matriz[0][1] * ($matriz[1][0] * $matriz[2][2] - $matriz[2][0] * $matriz[1][2])
                     + $matriz[0][2] * ($matriz[1][0] * $matriz[2][1] - $matriz[2][0] * $matriz[1][1]);
            } else {
                // Cálculo para matrizes maiores
                $det = 0;
                for ($i = 0; $i < $n; $i++) {
                    $submatriz = [];
                    for ($j = 1; $j < $n; $j++) {
                        $submatriz[] = array_merge(array_slice($matriz[$j], 0, $i), array_slice($matriz[$j], $i + 1));
                    }
                    $det += ($i % 2 == 0 ? 1 : -1) * $matriz[0][$i] * calcularDeterminante($submatriz);
                }
                return $det;
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $tamanho = $_POST['tamanho'];
            $matriz = [];

            for ($i = 1; $i <= $tamanho; $i++) {
                $linha = [];
                for ($j = 1; $j <= $tamanho; $j++) {
                    $linha[] = isset($_POST["a$i$j"]) ? (float)$_POST["a$i$j"] : 0;
                }
                $matriz[] = $linha;
            }

            $determinante = calcularDeterminante($matriz);
            echo "<div class='resultado'>O determinante da matriz é: $determinante</div>";
        }
        ?>
    </main>

    <footer>
        <p>Calculadora de matrizes - Feito com PHP, HTML e CSS - Grupo: Kevin</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
