<h1 class="text-success">Les catégories</h1>


<table class="table table-hover">
    <thead>
    <tr>
        <th scope="col">Nom de la catégorie</th>
    </tr>
    </thead>
    <tbody>

    <?php foreach (\App\Entity\Category::getAll() as $category) { ?>

        <tr>
            <td><?= $category->categoryName; ?></td>
            <td>
                <button type="button" class="btn btn-success" data-toggle="modal"
                        data-target="#modalUpdate-<?= $category->idCategory?>">Modifier
                </button>
            </td>
        </tr>


        <!--Fentre modale de modification-->
        <div class="modal fade" id="modalUpdate-<?= $category->idCategory?>" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <!--                    croix de fermeture-->
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="post" id="tes-<?= $category->idCategory ?>">
                            <p>
                                <label>Nom de la catégorie : </label>
                                <input name="categoryName" maxlength="50" type="text" placeholder="<?= $category->categoryName; ?>">
                            </p>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>

    </tbody>
</table>

