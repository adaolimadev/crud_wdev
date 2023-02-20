<main>

    <section>
        <a href="index.php">
            <button class="btn btn-success">Voltar</button>
        </a>
    </section>

    <h2 class="mt-3">Excluir vaga</h2>

    <div class="form-group">
            <p>Você deseja realmente excluir a vaga <strong><?=$ObVaga->titulo?></strong>?</p>
        </div>

    <form method="post">
    <div class="form-group mt-3">
        <a href="index.php">
            <button type="button" class="btn btn-success">Cancelar</button>
        </a>

        <button type="submit" name="excluir" class="btn btn-danger">Excluir</button>
        </div>
    </form>

</main>