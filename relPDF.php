<?php
require 'vendor/autoload.php';

$host='locahost';
$dbname= 'biblioteca';
$username = 'root';
$password = '';

try{
   $pdo = new PDO('mysql:host='.$hostname.';dbname='.$dbname.';charset=utf8',
   $username,$password);
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = "SELECT titulo, autor, ano_publicacao, resumo FROM livros";
$stmt = $pdo->prepare(query: $query);
$stmt->execute();

$livros = $stmt->fetchall(PDO::FETCH_ASSOC);

$mpdf = new \Mpdf\Mpdf();

$html - '<h1>Biblioteca - Lista de livros <h1>';
$html .= '<table border-"1" cellpadding-"10" cellspacing-"0" width-"100%">';
$html.= '<tr>
           <th>Tiltulo</th>
           <th>Autor</th>
           <th>Ano de Publicação</th>
           <th>Resumo</th> 
        </tr>';

 foreach ($livros as $livro){
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($livro['titulo']). '</td>';
    $html .= '<td>' . htmlspecialchars($livro['autor']). '</td>';
    $html .= '<td>' . htmlspecialchars($livro['ano_publicação']). '</td>';
    $html .= '<td>' . htmlspecialchars($livro['resumo']). '</td>';
    $html .= '</tr>';
 } 
 
 $html .= '</table>';

 $mpdf->WriteHTML(html: $html);

 $mpdf->Output(name: 'lista_de_livros.pdf', dest: \Mpdf\Output\Destination::DOWNLOAD);

}catch (PDOException $e){
    echo "Erro na conexão com o banco de dados: " . $e->getMessage();
}catch (\Mpdf\MpdfException $e){
      echo "Erro ao gerar o PDF:" . $e->getMessage();
}