<?php
define('MENU_TITLE', "List Film");
include "../../header.php";
?>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= MENU_TITLE ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Layout</a></div>
                <div class="breadcrumb-item">Default Layout</div>
            </div>
        </div>

        <div class="section-body">
            <?php
            if (!empty($_GET['id'])) {
                $id = urlencode((int)$_GET['id']);
                $response = getDetailFilm($id);
            ?>
                <div class="card">
                    <div class="card-header">
                        <h4>Tambah Film</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= BASE_URL ?>proses/tambah-film" method="POST">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Judul</label>
                                        <input type="text" class="form-control" value="<?= $response->original_title ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Durasi</label>
                                        <input type="text" class="form-control" value="<?= convertToTime($response->runtime) ?>" name="durasi" id="durasi" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Ringkasan</label>
                                        <textarea type="text" class="form-control" readonly><?= $response->overview ?></textarea>
                                    </div>
                                    <input type="hidden" value="<?= $response->id ?>" name="id" id="id">
                                    <div class="text-center mb-3">
                                        <button class="btn btn-primary col-6" type="submit">Tambah</button>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="gallery gallery-fw" data-item-height="300">
                                        <div class="gallery-item" data-image="https://image.tmdb.org/t/p/w600_and_h900_bestv2/<?= $response->poster_path ?>" data-title="<?= $response->original_title ?>"></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
            <style>
                .film-card {
                    border-radius: 10px;
                    overflow: hidden;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                    transition: transform 0.3s ease;
                    margin-bottom: 15px;
                }

                .film-card:hover {
                    transform: scale(1.05);
                }
            </style>

            <div class="row">
                <?php
                $query = "SELECT UUID FROM FILM";
                $parse = oci_parse($con, $query);
                oci_execute($parse);

                while ($res = oci_fetch_assoc($parse)) {
                    $fetch = getDetailFilm($res['UUID']);
                ?>
                    <div class="col-12 col-lg-4 mb-5">
                        <div class="card film-card h-100">
                            <img src="https://image.tmdb.org/t/p/w600_and_h900_bestv2/<?= $fetch->poster_path ?>" class="card-img-top" alt="Film 1">
                            <div class="card-body">
                                <h5 class="card-title"><?= $fetch->original_title ?></h5>
                                <p class="card-text"><?= substr($fetch->overview, 0, 200) ?></p>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary"><?= $fetch->release_date ?></button>
                                <button class="btn btn-success"><?= convertToTime($fetch->runtime) ?></button>
                            </div>
                        </div>
                    </div>
                <?php
                }
                oci_free_statement($parse);
                ?>
            </div>
        </div>
    </section>
</div>
<?php
include "../../footer.php";
?>