<?php
include_once "conexao.php";
    if(isset($_POST['submit']))    
    {                     

        $idContratoItem = 'idContratoItem';  
        $situacao = 'situacao'; 

        // "UPDATE ContratoItem SET situacao = $situacao WHERE idContratoItem=1";        
        
        // $consulta = "SELECT situacao FROM ContratoItem   and situacao  == 1";
        $situacao = $_POST['situacao'];

        $consulta = "UPDATE ContratoItem SET situacao = $situacao WHERE idContratoItem=$idContratoItem";

        $res=mysqli_query($conexao,$consulta); 
        // if($res){
        //     echo "Sucesso";
        // }  
    }
?>

<?php
include_once "conn.php";
    if(isset($_POST['submit']))    
    {                      

        $id = 'id';       
 
        $consulta = "SELECT situacao FROM produtoxml   and situacao  == 1";
        $situacao = $_POST['situacao'];

        $consulta = "UPDATE produtoxml SET situacao = $situacao WHERE id=$id";

        $resul=mysqli_query($mysqli,$consulta); 
        // if($resul){
        //     echo "Sucesso";
        // }        
    }
?>


<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Incluir a conexao com BD
include_once "conexao.php";
?>
<?php
include_once("conn.php");
?>
<?php
include('protect.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Grid</title>
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="shortcut icon" href="img/logo-cinzaClaro.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">   -->
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <!-- Boxiocns CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

    <div id="wrapper">        
        <h3>Grid</h3>
        <form action="" method="post">        
        <table cellpadding=10 id="tabela1"  >
            <thead>
                <h4 class="h4contrato">Contrato</h4>
                <tr>
                    <th>teste</th>
                    <th>ID</th>
                    <th>N. Contrato</th>
                    <th>Responsável</th>
                    <th>Descrição do produto</th>
                    <th>Valor</th>
                    <th>Valor Fixo</th>
                    <th>Percentual</th>
                </tr>
            </thead>
            <tbody id='tboby'>
                <?php                                
                $consulta =  "select  c.numContrato, c.responsavel , ci.descProd, ci.valor, ci.idContratoItem, ci.valorFixo , ci.percent  from ContratoItem ci 
                join Contrato c  on c.idContrato = ci.idContrato";
                $sql = "SELECT SUM(percent + valorFixo + valor) AS 'valor' FROM ContratoItem";
                $resultado2 = mysqli_query($conexao, $sql);
                $valor = mysqli_fetch_array($resultado2);
                $conexao = $conexao->query($consulta);
                // or die($conexao->error)
                while ($dado = $conexao->fetch_array()) { ?>             
                        <tr onclick="CliqueLinha(this, 'tabela1')" data-value="<?php echo ($dado['valor'] + $dado['valorFixo']) * (1+$dado['percent']*.01);  ?>">
                        <td>
                            <input type="radio" name="situacao"  value="1">
                        </td>
                        <td><?php echo $dado["idContratoItem"]; ?></td>
                        <td> <?php echo $dado["numContrato"]; ?></td>                        
                        <td><?php echo $dado["responsavel"]; ?></td>
                        <td><?php echo $dado["descProd"]; ?></td>                        
                        <?php
                        echo "<td>" . number_format($dado['valor'], 2, ",", ".") . "</td>";
                        ?>
                        <?php
                        echo "<td>" . number_format($dado['valorFixo'], 2, ",", ".") . "</td>";
                        ?>
                        <?php 
                        echo "<td>" .number_format($dado['percent'], 2, ",", ".") . " %</td>";
                        ?>                                             
                    </tr>                                       
                <?php var_dump($dado["idContratoItem"]); } ?>
            </tbody>
            <tfoot>
                <tr>
                    <?php
                    echo "<th colspan='7' scope='row'>Total R$ " . number_format($valor['valor'], 2, ",", ".") . "</th>";
                    ?>
                </tr>
            </tfoot>
            <tfoot>
                <tr>
                    <th th="" colspan="7" scope="row">
                        <span class="resultado">R$ 0.00</span>
                        <button id="btn" type="submit" onclick="LimparSomatoria('tabela1')"> Limpar somatoria </button>
                    </th>
                </tr>
            </tfoot>
        </table>
        <table>     
        <!-- <input type="hidden" name="situacao" value="1">             -->
        </form>
            
        




        <form action="" method="post">  
        <table class="tabela2" cellpadding=10 id="tabela2">
            <thead>
                <h4 class="h4nota">Nota</h4>
                <tr>
                    <th>ID</th>
                    <th>N. Documento Fiscal</th>
                    <th>Código Produto</th>
                    <th>Descrição do produto</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody id='tboby'>
                <?php
                $query =
                // "SELECT id FROM produtoxml";
                "select i.id,nNF,cProd,xProd,vProd from produtoxml p join idenotaxml  i on i.id = p.idnota";
                //Fazer calculo no banco
                "SELECT SUM(vProd) as soma FROM produtoxml WHERE vProd = vProd";
                //Fazer o calculo
                $conn = "SELECT SUM(vProd) AS 'total' FROM produtoxml";
                $resultado = mysqli_query($mysqli, $conn);
                $total = mysqli_fetch_array($resultado);
                $conn = $mysqli->query($query) or die($mysqli->error);
                while ($dado = $conn->fetch_array()) {
                    $row = $conn->fetch_assoc();
                ?>
                    <!-- <tr onclick="CliqueLinha(this, 57.00, 'tabela2')"> -->
                    <tr onclick="CliqueLinha(this, 'tabela2')" data-value="<?php echo $dado['vProd']; ?>">
                        <td><?php  echo $dado["id"]; ?></td>  
                        <td><?php  echo $dado["nNF"]; ?></td>                                                
                        <td><?php echo $dado["cProd"]; ?></td>
                        <td><?php echo $dado["xProd"]; ?></td>
                        <td><?php  echo $dado["vProd"]; ?></td> 
                        
                    </tr>
                <?php   } ?>
            </tbody>
            <tfoot>
                <tr>
                    <?php
                    echo "<th colspan='5' scope='row'>Total R$ " . number_format($total['total'], 2, ",", ".") . "</th>";
                    ?>
                </tr>
            </tfoot>
            <tfoot>
                <tr>
                    <th th="" colspan="6" scope="row">
                        <span class="resultado">R$ 0.00</span>
                        <button id="btn1" onclick="LimparSomatoria('tabela2')"> Limpar somatoria </button>
                    </th>
                </tr>
            </tfoot>
        </table>
    </form>

        <button id="submit" type="submit" name="submit" onclick="teste(this,'tabela1', 'tabela2')">Conciliar</button>   

 
        <script src="Script.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js" integrity="sha512-WFN04846sdKMIP5LKNphMaWzU7YpMyCU245etK3g/2ARYbPK9Ub18eG+ljU96qKRCWh+quCY7yefSmlkQw1ANQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>


</body>
</html>