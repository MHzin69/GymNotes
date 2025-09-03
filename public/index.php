<!DOCTYPE html>
<html lang="pt-br">


    
    <main>
    <?php
        $pagina = $_GET["param"] ?? "home";

        $pagina = "pages/{$pagina}.php";
        if (file_exists($pagina)) {
            include $pagina;
        } else {
            include "pages/erro.php";
        }

    ?>
    </main>


    
</body>

</html>