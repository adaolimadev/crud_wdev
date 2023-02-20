<?php 
    require __DIR__.'/vendor/autoload.php';

    define('TITTLE', 'Cadastrar Vaga');

    use \App\Entity\Vaga;

    $ObVaga = new Vaga;

    if(isset($_POST['inputTitulo'], $_POST['inputDescricao'], $_POST['inputAtivo'])){
        
        $ObVaga->titulo = $_POST['inputTitulo'];
        $ObVaga->descricao = $_POST['inputDescricao'];
        $ObVaga->ativo = $_POST['inputAtivo'];
     
        $ObVaga->cadastrar();

        header('location: index.php?status=success');
        
        exit;
    
    }

    include __DIR__.'/includes/header.php';
    include __DIR__.'/includes/formulario.php';
    include __DIR__.'/includes/footer.php';
?>