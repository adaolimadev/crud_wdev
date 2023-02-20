<main>

    <section>
        <a href="index.php">
            <button class="btn btn-success">Voltar</button>
        </a>
    </section>

    <h2 class="mt-3"><?=TITTLE?></h2>

    <form method="post">
        <div class="form-group">
            <label>Título</label>
            <input type="text" name="inputTitulo" class="form-control" value="<?=$ObVaga->titulo?>">
        </div>

        <div class="form-group">
            <label>Descrição</label>
            <textarea type="text" name="inputDescricao" class="form-control" rows="5" ><?=$ObVaga->descricao?></textarea>
        </div>

        <div class="form-group">
            <label>Status</label>
            <div>
                <div class="form-check form-check-inline">
                    <label class="form-control">
                        <input type="radio" name="inputAtivo" value="s" checked>Ativo
                    </label>
                </div>
            
                <div class="form-check form-check-inline">
                    <label class="form-control">
                         <input type="radio" name="inputAtivo" value="n" <?=$ObVaga->ativo == 'n' ? 'checked' : ' '?>>Inativo
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group mt-3">
        <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
    </form>

</main>