<?php

  /********************************************************************************/
  /*                                Model                                         */
  /********************************************************************************/
  
  // Incluindo o bando de dados
     $con = new \PDO("mysql:host=localhost;dbname=paginacao", "root", "");

  // query listar todos os registros
     $registros = "SELECT nome FROM contatos";
     $registros = $con->query($registros);
     $registros->execute();
     $result = $registros->fetchAll(\PDO::FETCH_ASSOC);
     $total_de_registros = count($result);
  
  /********************************************************************************/
  /*                                Controller                                    */
  /********************************************************************************/
     
  // verificar se está sendo passado na URL a página atual se não atribua a página 1
    // $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
     
     if(isset($_GET['pagina']))
     {
        $pagina = $_GET['pagina']; //página atual 1,2,3,4,5,6...
     }
     else
     {
        $pagina = 1; //página inicial
     }
     
  // exibindo a página atual na tela   
     echo "Página -".$pagina;
  

  // quantidade de registros por página
     $quantidade_de_paginas = 4;

  // calcular o inicio de cada página visualizada
     $offset = ($pagina * $quantidade_de_paginas ) - $quantidade_de_paginas;
        #           1    *    4     -   4     = 0   <- a página 1 começa em 0
        #           2    *    4     -   4     = 4   <- a página 2 começa em 4
        #           3    *    4     -   4     = 8   <- a página 3 começa em 8
        #           4    *    4     -   4     = 12  <- a página 4 começa em 12
        # todo array começa no índice 0
     
  
  echo "<br><hr>";
  
     $paginar = array_slice($result, $offset, $quantidade_de_paginas );
  
  // total de páginas 
    $total_paginas = ceil($total_de_registros / $quantidade_de_paginas );
  
  /********************************************************************************/
  /*                                 View                                         */
  /********************************************************************************/


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paginação</title>
</head>
<body>
      <?php
        
       // Listando todos os registros do banco
          foreach($paginar as $resultados)
          {
             echo $resultados['nome'] ."<br>";
          }
              
       // Total de páginas
          echo "<hr>";
          echo "Página ". $pagina. " de " .$total_paginas;  
          echo "<br><br>";

       // Link de navegação das página dinâmicamente
          if($pagina > 1)
          {
              echo ' <a href="?pagina= '.$pagina - 1 .' ">Anterior</a>  ';
          }
             

             //Aredondamento
               $inicio = max(1, $pagina - 2); //pega da página atual menos 2 números
               $fim = min($total_paginas, $pagina + 2);
               
              //Exibir os numeros 
              //for($i = 1; $i <= $total_paginas; $i++)
                for($i = $inicio; $i <= $fim; $i++)
                {
                   //echo $i; 
                    if($i == $pagina) // ex: $i = 2 e $pagina = 2 entra no if
                    {
                        echo $i;  // exibir o que não é link
                    }
                    else
                    {
                      echo ' <a href="?pagina=' .$i . '">'.$i.'</a>  '; // exibir os links
                    }
                }
         
          if($pagina < $total_paginas)
          {
              echo ' <a href="?pagina= '.$pagina + 1 .' "> Próxima </a>';
          }
      
          

      ?> 
      
</body>
</html>